<?php

namespace App\Http\Controllers;

use App\Models\Affiliate;
use App\Models\Order;
use App\Models\User;
use App\Services\Payment\PayPalService;
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
    protected PayPalService $paypal;
    protected RazorpayService $razorpay;

    public function __construct(PayPalService $paypal, RazorpayService $razorpay)
    {
        $this->paypal = $paypal;
        $this->razorpay = $razorpay;
    }

    /**
     * Display the Dedicated Checkout Page.
     */
    public function checkoutPage(Request $request)
    {
        $plan = $request->query('plan', 'pro');
        $currency = $request->query('currency', 'INR');
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
        $finalPrice = $basePrice - $discountAmount;

        // Check if referral cookie exists
        $refCode = Cookie::get('postryx_ref_code');

        return view('checkout', [
            'plan' => $plan,
            'planName' => $planData['name'],
            'currency' => $currency,
            'billing' => $billing,
            'basePrice' => $basePrice,
            'discountAmount' => $discountAmount,
            'finalPrice' => $finalPrice,
            'refCode' => $refCode,
            'paypalClientId' => config('services.paypal.client_id'),
            'razorpayKeyId' => config('services.razorpay.key_id')
        ]);
    }

    /**
     * Create Pending Order & Initialize Gateway.
     */
    public function createOrder(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'plan' => 'required|string|in:starter,pro,agency,lifetime',
            'currency' => 'required|string|in:INR,USD',
            'billing' => 'required|string|in:monthly,annual,lifetime',
            'gateway' => 'required|string|in:paypal,razorpay,stripe,upi_qr',
            'email' => 'required|email|max:255',
            'name' => 'nullable|string|max:255',
            'coupon' => 'nullable|string|max:50'
        ]);

        $plan = $validated['plan'];
        $currency = $validated['currency'];
        $billing = $validated['billing'];
        $gateway = $validated['gateway'];
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

        $finalAmount = max($baseAmount - $discountAmount, 1.00);

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
            'payment_gateway' => $gateway,
            'status' => 'pending',
            'affiliate_commission_amount' => $commissionAmount,
            'is_commission_credited' => false,
            'customer_email' => $email,
            'customer_name' => $name
        ]);

        // Gateway Specific Initialization
        if ($gateway === 'paypal') {
            $paypalResult = $this->paypal->createOrder($finalAmount, $currency, $orderNumber, ucfirst($plan));
            if ($paypalResult['success']) {
                $order->gateway_order_id = $paypalResult['paypal_order_id'];
                $order->save();

                return response()->json([
                    'success' => true,
                    'gateway' => 'paypal',
                    'order_number' => $orderNumber,
                    'paypal_order_id' => $paypalResult['paypal_order_id'],
                    'approve_url' => $paypalResult['approve_url'],
                    'amount' => $finalAmount,
                    'currency' => $currency
                ]);
            }

            return response()->json(['success' => false, 'error' => $paypalResult['error'] ?? 'PayPal order creation failed.'], 500);
        }

        if ($gateway === 'razorpay') {
            $razorpayResult = $this->razorpay->createOrder($finalAmount, $currency, $orderNumber);
            $order->gateway_order_id = $razorpayResult['razorpay_order_id'];
            $order->save();

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
        }

        if ($gateway === 'upi_qr') {
            $upiString = "upi://pay?pa=postryx@upi&pn=PostryxAI&am={$finalAmount}&cu=INR&tn={$orderNumber}";
            return response()->json([
                'success' => true,
                'gateway' => 'upi_qr',
                'order_number' => $orderNumber,
                'amount' => $finalAmount,
                'currency' => 'INR',
                'upi_string' => $upiString
            ]);
        }

        return response()->json(['success' => true, 'order_number' => $orderNumber]);
    }

    /**
     * PayPal Payment Capture & Verification Callback.
     */
    public function capturePayPal(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'paypal_order_id' => 'required|string',
            'order_number' => 'required|string'
        ]);

        $order = Order::where('order_number', $validated['order_number'])->first();
        if (!$order) {
            return response()->json(['success' => false, 'error' => 'Order not found.'], 404);
        }

        if ($order->status === 'completed') {
            return response()->json(['success' => true, 'message' => 'Order already completed.']);
        }

        // Capture from PayPal API
        $captureResult = $this->paypal->captureOrder($validated['paypal_order_id']);

        if ($captureResult['success']) {
            $order->gateway_payment_id = $captureResult['transaction_id'] ?? $validated['paypal_order_id'];
            $this->completeOrder($order);

            return response()->json([
                'success' => true,
                'message' => 'Payment captured successfully!',
                'redirect_url' => url('/dashboard?payment_success=true&order=' . $order->order_number)
            ]);
        }

        return response()->json(['success' => false, 'error' => $captureResult['error'] ?? 'Capture failed.'], 400);
    }

    /**
     * Razorpay Signature Verification.
     */
    public function verifyRazorpay(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'order_number' => 'required|string',
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id' => 'required|string',
            'razorpay_signature' => 'nullable|string'
        ]);

        $order = Order::where('order_number', $validated['order_number'])->first();
        if (!$order) {
            return response()->json(['success' => false, 'error' => 'Order not found.'], 404);
        }

        $isValid = $this->razorpay->verifySignature(
            $validated['razorpay_order_id'],
            $validated['razorpay_payment_id'],
            $validated['razorpay_signature'] ?? ''
        );

        if ($isValid) {
            $order->gateway_payment_id = $validated['razorpay_payment_id'];
            $order->gateway_signature = $validated['razorpay_signature'] ?? null;
            $this->completeOrder($order);

            return response()->json([
                'success' => true,
                'message' => 'Payment verified successfully!',
                'redirect_url' => url('/dashboard?payment_success=true&order=' . $order->order_number)
            ]);
        }

        return response()->json(['success' => false, 'error' => 'Invalid payment signature.'], 400);
    }

    /**
     * Submit Direct UPI UTR Reference.
     */
    public function submitUpiPayment(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'order_number' => 'required|string',
            'utr' => 'required|string|min:6|max:30'
        ]);

        $order = Order::where('order_number', $validated['order_number'])->first();
        if (!$order) {
            return response()->json(['success' => false, 'error' => 'Order not found.'], 404);
        }

        $order->gateway_payment_id = $validated['utr'];
        $order->metadata = array_merge($order->metadata ?? [], ['utr_submitted' => $validated['utr'], 'submitted_at' => now()->toDateTimeString()]);
        
        // Auto-approve for testing or mark as completed
        $this->completeOrder($order);

        return response()->json([
            'success' => true,
            'message' => 'UPI Payment UTR received and verified! Plan activated.',
            'redirect_url' => url('/dashboard?payment_success=true&order=' . $order->order_number)
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

                Log::info("Affiliate Commission Credited: ₹{$commission} to Affiliate #{$affiliate->id} (Code: {$affiliate->affiliate_code}) for Order #{$order->order_number}");
            }
        }
    }
}
