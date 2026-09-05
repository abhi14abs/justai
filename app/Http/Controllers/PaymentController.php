<?php

namespace App\Http\Controllers;

use App\Models\Affiliate;
use App\Models\Order;
use App\Models\User;
use App\Services\Payment\RazorpayService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    protected RazorpayService $razorpay;

    public function __construct(RazorpayService $razorpay)
    {
        $this->razorpay = $razorpay;
    }

    /**
     * Detect origin currency based on headers, IP, and query parameters.
     */
    public function detectOriginCurrency(Request $request): string
    {
        // 1. Explicit query or request override
        if ($request->has('currency') && in_array(strtoupper($request->input('currency')), ['INR', 'USD'])) {
            return strtoupper($request->input('currency'));
        }

        // 2. Cloudflare Country header
        $cfCountry = strtoupper($request->header('CF-IPCountry', ''));
        if (!empty($cfCountry)) {
            return $cfCountry === 'IN' ? 'INR' : 'USD';
        }

        // 3. Other common CDN / Proxy Country headers
        $geoHeaders = [
            'X-Country-Code',
            'CloudFront-Viewer-Country',
            'X-GeoIP-Country-Code',
            'X-AppEngine-Country',
        ];
        foreach ($geoHeaders as $hdr) {
            $val = strtoupper($request->header($hdr, ''));
            if (!empty($val)) {
                return $val === 'IN' ? 'INR' : 'USD';
            }
        }

        // 4. Client Timezone header if passed
        $clientTz = $request->header('X-Client-Timezone', $request->input('timezone', ''));
        if (!empty($clientTz)) {
            if (stripos($clientTz, 'Calcutta') !== false || stripos($clientTz, 'Kolkata') !== false || stripos($clientTz, 'India') !== false || stripos($clientTz, 'IST') !== false) {
                return 'INR';
            }
            return 'USD';
        }

        // 5. Check Accept-Language for Indian locales as a hint
        $acceptLang = $request->header('Accept-Language', '');
        if (preg_match('/-(IN)\b/i', $acceptLang)) {
            return 'INR';
        }

        // Default baseline: INR
        return 'INR';
    }

    /**
     * Display the Dedicated Checkout Page.
     */
    public function checkoutPage(Request $request)
    {
        $plan = $request->query('plan', 'pro');
        $currency = $this->detectOriginCurrency($request);
        $billing = $request->query('billing', 'monthly');

        $pricingTable = [
            'INR' => [
                'starter' => ['name' => 'Starter Creator', 'monthly' => 799, 'annual' => 7990],
                'pro' => ['name' => 'Pro Growth', 'monthly' => 1999, 'annual' => 19990],
                'agency' => ['name' => 'Agency & Scale', 'monthly' => 4999, 'annual' => 49990],
                'lifetime' => ['name' => 'Lifetime Founders Pass', 'lifetime' => 9999]
            ],
            'USD' => [
                'starter' => ['name' => 'Starter Creator', 'monthly' => 9.99, 'annual' => 99],
                'pro' => ['name' => 'Pro Growth', 'monthly' => 24.99, 'annual' => 249],
                'agency' => ['name' => 'Agency & Scale', 'monthly' => 59.99, 'annual' => 599],
                'lifetime' => ['name' => 'Lifetime Founders Pass', 'lifetime' => 129]
            ]
        ];

        $planData = $pricingTable[$currency][$plan] ?? $pricingTable['INR']['pro'];
        $basePrice = $plan === 'lifetime' ? $planData['lifetime'] : ($planData[$billing] ?? $planData['monthly']);

        // Default 50% Launch Discount
        $discountAmount = round($basePrice * 0.5, 2);
        $finalPrice = round($basePrice - $discountAmount, 2);

        // Check if referral cookie exists
        $refCode = Cookie::get('postryx_ref_code');

        Log::info('[SAAS_CHECKOUT_PAGE_LOADED]', [
            'plan' => $plan,
            'currency' => $currency,
            'billing' => $billing,
            'basePrice' => $basePrice,
            'finalPrice' => $finalPrice,
            'ip' => $request->ip(),
        ]);

        return view('checkout', [
            'plan' => $plan,
            'planName' => $planData['name'],
            'currency' => $currency,
            'billing' => $billing,
            'basePrice' => $basePrice,
            'discountAmount' => $discountAmount,
            'finalPrice' => $finalPrice,
            'refCode' => $refCode,
            'razorpayKeyId' => config('services.razorpay.key_id')
        ]);
    }

    /**
     * Create Pending Order & Initialize Razorpay Gateway.
     */
    public function createOrder(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'plan' => 'required|string|in:starter,pro,agency,lifetime',
            'currency' => 'nullable|string|in:INR,USD',
            'billing' => 'required|string|in:monthly,annual,lifetime',
            'gateway' => 'nullable|string|in:razorpay',
            'email' => 'required|email|max:255',
            'name' => 'nullable|string|max:255',
            'coupon' => 'nullable|string|max:50',
            'timezone' => 'nullable|string',
        ]);

        $plan = $validated['plan'];
        $currency = $validated['currency'] ?? $this->detectOriginCurrency($request);
        $billing = $validated['billing'];
        $gateway = 'razorpay';
        $email = strtolower(trim($validated['email']));
        $name = trim($validated['name'] ?? explode('@', $email)[0]);

        // Pricing Matrix
        $pricingTable = [
            'INR' => [
                'starter' => ['monthly' => 799, 'annual' => 7990],
                'pro' => ['monthly' => 1999, 'annual' => 19990],
                'agency' => ['monthly' => 4999, 'annual' => 49990],
                'lifetime' => ['lifetime' => 9999]
            ],
            'USD' => [
                'starter' => ['monthly' => 9.99, 'annual' => 99],
                'pro' => ['monthly' => 24.99, 'annual' => 249],
                'agency' => ['monthly' => 59.99, 'annual' => 599],
                'lifetime' => ['lifetime' => 129]
            ]
        ];

        $baseAmount = $plan === 'lifetime'
            ? $pricingTable[$currency][$plan]['lifetime']
            : ($pricingTable[$currency][$plan][$billing] ?? 1999);

        // Apply discount if coupon provided or default launch promo
        $discountAmount = 0.00;
        $couponCode = strtoupper(trim($validated['coupon'] ?? 'LAUNCH50'));

        if ($couponCode === 'LAUNCH50') {
            $discountAmount = round($baseAmount * 0.5, 2);
        } elseif ($couponCode === 'VIRAL30') {
            $discountAmount = round($baseAmount * 0.3, 2);
        }

        $finalAmount = max(round($baseAmount - $discountAmount, 2), 1.00);

        // Find or create customer account
        $user = Auth::user();
        if (!$user) {
            $user = User::where('email', $email)->first();
            if (!$user) {
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make(Str::random(16)),
                    'role' => 'user',
                    'plan' => 'free',
                    'credits_remaining' => 5
                ]);
            }
        }

        // Check Affiliate Attribution from Cookie
        $refCode = Cookie::get('postryx_ref_code');
        $affiliate = null;
        $commissionAmount = 0.00;

        if (!empty($refCode)) {
            $affiliate = Affiliate::whereRaw('LOWER(affiliate_code) = ?', [strtolower($refCode)])->first();
            if ($affiliate && $affiliate->user_id !== $user->id) {
                // Calculate 30% recurring commission
                $rate = $affiliate->commission_rate ?? 30.00;
                $commissionAmount = round($finalAmount * ($rate / 100), 2);
                
                if (empty($user->referred_by_id)) {
                    $user->referred_by_id = $affiliate->user_id;
                    $user->save();
                }
            }
        }

        // Generate Order
        $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(6));

        $order = Order::create([
            'order_number' => $orderNumber,
            'user_id' => $user->id,
            'affiliate_id' => $affiliate?->id,
            'plan' => $plan,
            'billing_cycle' => $billing,
            'amount' => $finalAmount,
            'currency' => $currency,
            'discount_amount' => $discountAmount,
            'coupon_code' => $couponCode,
            'payment_gateway' => 'razorpay',
            'status' => 'pending',
            'affiliate_commission_amount' => $commissionAmount,
            'is_commission_credited' => false,
            'customer_email' => $email,
            'customer_name' => $name,
            'metadata' => [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'base_amount' => $baseAmount,
                'discount_amount' => $discountAmount,
            ]
        ]);

        // Create Razorpay Order
        try {
            $razorpayResult = $this->razorpay->createOrder($finalAmount, $currency, $orderNumber);
            $order->gateway_order_id = $razorpayResult['razorpay_order_id'];
            $order->save();

            Log::info('[SAAS_RAZORPAY_ORDER_CREATED]', [
                'order_number' => $orderNumber,
                'razorpay_order_id' => $razorpayResult['razorpay_order_id'],
                'amount_paise' => $razorpayResult['amount'],
                'currency' => $currency,
                'user_email' => $email,
            ]);

            return response()->json([
                'success' => true,
                'gateway' => 'razorpay',
                'order_number' => $orderNumber,
                'razorpay_order_id' => $razorpayResult['razorpay_order_id'],
                'key_id' => $razorpayResult['key_id'],
                'amount_paise' => $razorpayResult['amount'],
                'currency' => $currency,
                'customer_email' => $email,
                'customer_name' => $name
            ]);
        } catch (\Exception $e) {
            Log::error('[SAAS_RAZORPAY_ORDER_FAILED]', [
                'order_number' => $orderNumber,
                'error' => $e->getMessage(),
            ]);

            $order->status = 'failed';
            $order->save();

            return response()->json([
                'success' => false,
                'error' => 'Unable to initialize Razorpay payment: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Razorpay Signature Verification & Instant Plan Activation.
     */
    public function verifyRazorpay(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'order_number' => 'required|string',
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id' => 'nullable|string',
            'razorpay_signature' => 'nullable|string'
        ]);

        $order = Order::where('order_number', $validated['order_number'])->first();
        if (!$order) {
            return response()->json(['success' => false, 'error' => 'Order not found.'], 404);
        }

        if ($order->status === 'completed') {
            return response()->json([
                'success' => true,
                'message' => 'Payment already completed!',
                'redirect_url' => url('/dashboard?payment_success=true&order=' . $order->order_number)
            ]);
        }

        $orderId = $validated['razorpay_order_id'] ?? $order->gateway_order_id;

        $isValid = $this->razorpay->verifySignature(
            $orderId,
            $validated['razorpay_payment_id'],
            $validated['razorpay_signature'] ?? ''
        );

        if ($isValid) {
            $order->gateway_payment_id = $validated['razorpay_payment_id'];
            $order->gateway_signature = $validated['razorpay_signature'] ?? null;
            if (!empty($orderId)) {
                $order->gateway_order_id = $orderId;
            }
            
            $meta = $order->metadata ?? [];
            $meta['verification'] = [
                'timestamp' => now()->toIso8601String(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ];
            $order->metadata = $meta;

            $this->completeOrder($order);

            Log::info('[SAAS_PAYMENT_VERIFIED]', [
                'order_number' => $order->order_number,
                'payment_id' => $validated['razorpay_payment_id'],
                'plan' => $order->plan,
                'amount' => $order->amount,
                'currency' => $order->currency,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment verified successfully! Your subscription is active.',
                'order_number' => $order->order_number,
                'transaction_ref' => $order->gateway_payment_id,
                'redirect_url' => url('/dashboard?payment_success=true&order=' . $order->order_number)
            ]);
        }

        Log::error('[SAAS_RAZORPAY_SIGNATURE_FAILED]', [
            'order_number' => $order->order_number,
            'razorpay_order_id' => $orderId,
            'razorpay_payment_id' => $validated['razorpay_payment_id'],
        ]);

        $order->status = 'failed';
        $order->save();

        return response()->json(['success' => false, 'error' => 'Payment signature verification failed.'], 400);
    }

    /**
     * Razorpay Server-to-Server Webhook Endpoint for SaaS Subscriptions.
     */
    public function handleWebhook(Request $request): JsonResponse
    {
        $signature = $request->header('X-Razorpay-Signature');
        $rawPayload = $request->getContent();

        Log::info('[SAAS_RAZORPAY_WEBHOOK_RECEIVED]', [
            'event' => $request->input('event'),
            'has_signature' => !empty($signature),
        ]);

        if (!empty($signature)) {
            $isValid = $this->razorpay->verifyWebhookSignature($rawPayload, $signature);
            if (!$isValid) {
                Log::warning('[SAAS_RAZORPAY_WEBHOOK_SIGNATURE_INVALID]', [
                    'signature' => $signature,
                ]);
                return response()->json(['error' => 'Invalid webhook signature'], 400);
            }
        }

        $event = $request->input('event');
        $payload = $request->input('payload', []);

        if (in_array($event, ['payment.captured', 'order.paid'])) {
            $paymentEntity = $payload['payment']['entity'] ?? [];
            $orderEntity = $payload['order']['entity'] ?? [];

            $razorpayOrderId = $paymentEntity['order_id'] ?? ($orderEntity['id'] ?? null);
            $paymentId = $paymentEntity['id'] ?? null;
            $receipt = $orderEntity['receipt'] ?? ($paymentEntity['notes']['order_number'] ?? null);

            $order = null;
            if ($razorpayOrderId) {
                $order = Order::where('gateway_order_id', $razorpayOrderId)->first();
            }
            if (!$order && $receipt) {
                $order = Order::where('order_number', $receipt)->first();
            }

            if ($order && $order->status !== 'completed') {
                $order->gateway_payment_id = $paymentId ?? $order->gateway_payment_id;
                $this->completeOrder($order);

                Log::info('[SAAS_RAZORPAY_WEBHOOK_COMPLETED]', [
                    'order_number' => $order->order_number,
                    'payment_id' => $paymentId,
                ]);
            }
        } elseif ($event === 'payment.failed') {
            $paymentEntity = $payload['payment']['entity'] ?? [];
            $razorpayOrderId = $paymentEntity['order_id'] ?? null;
            $paymentId = $paymentEntity['id'] ?? null;

            if ($razorpayOrderId) {
                $order = Order::where('gateway_order_id', $razorpayOrderId)->first();
                if ($order && $order->status !== 'completed') {
                    $order->status = 'failed';
                    $order->gateway_payment_id = $paymentId ?? $order->gateway_payment_id;
                    $order->save();

                    Log::warning('[SAAS_RAZORPAY_WEBHOOK_FAILED]', [
                        'order_number' => $order->order_number,
                        'payment_id' => $paymentId,
                    ]);
                }
            }
        }

        return response()->json(['status' => 'ok', 'event' => $event]);
    }

    /**
     * Record Client-Side Payment Failure / Dismissal.
     */
    public function recordPaymentFailure(Request $request): JsonResponse
    {
        $orderNumber = $request->input('order_number');
        $errorCode = $request->input('error_code', 'PAYMENT_FAILED');
        $errorDescription = $request->input('error_description', 'Payment process was cancelled or failed by user/bank.');
        $paymentId = $request->input('payment_id');

        Log::warning('[SAAS_PAYMENT_FAILURE_REPORTED]', [
            'order_number' => $orderNumber,
            'error_code' => $errorCode,
            'error_description' => $errorDescription,
            'payment_id' => $paymentId,
            'ip' => $request->ip(),
        ]);

        if ($orderNumber) {
            $order = Order::where('order_number', $orderNumber)->first();
            if ($order && $order->status !== 'completed') {
                $order->status = 'failed';
                $meta = $order->metadata ?? [];
                $meta['failure'] = [
                    'error_code' => $errorCode,
                    'error_description' => $errorDescription,
                    'payment_id' => $paymentId,
                    'timestamp' => now()->toIso8601String(),
                ];
                $order->metadata = $meta;
                $order->save();
            }
        }

        return response()->json([
            'success' => true,
            'logged' => true,
            'message' => 'Payment failure logged successfully.',
        ]);
    }

    /**
     * Complete Order: Upgrade User Plan & Credit 30% Affiliate Commission.
     */
    protected function completeOrder(Order $order): void
    {
        $order->status = 'completed';
        $order->save();

        // 1. Upgrade User Account
        $user = $order->user;
        if ($user) {
            $user->plan = $order->plan;
            
            // Assign credits
            $user->credits_remaining = in_array($order->plan, ['pro', 'agency', 'lifetime']) ? 999999 : 500;

            // Set Expiry
            if ($order->plan === 'lifetime') {
                $user->plan_expires_at = null; // forever
            } elseif ($order->billing_cycle === 'annual') {
                $user->plan_expires_at = now()->addYear();
            } else {
                $user->plan_expires_at = now()->addMonth();
            }

            $user->save();

            // Log user in if not logged in
            if (!Auth::check()) {
                Auth::login($user);
            }
        }

        // 2. Automated 30% Recurring Affiliate Commission Crediting
        if ($order->affiliate_id && !$order->is_commission_credited && $order->affiliate_commission_amount > 0) {
            $affiliate = Affiliate::find($order->affiliate_id);
            if ($affiliate) {
                $commission = $order->affiliate_commission_amount;

                // Credit wallet in DB
                $affiliate->increment('total_earnings', $commission);
                $affiliate->increment('pending_payout', $commission);
                $affiliate->increment('total_referrals');

                $order->is_commission_credited = true;
                $order->save();

                Log::info("Affiliate Commission Credited: {$order->currency} {$commission} to Affiliate #{$affiliate->id} (Code: {$affiliate->affiliate_code}) for Order #{$order->order_number}");
            }
        }
    }
}
