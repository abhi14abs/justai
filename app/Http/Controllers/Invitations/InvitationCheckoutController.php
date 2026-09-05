<?php

namespace App\Http\Controllers\Invitations;

use App\Http\Controllers\Controller;
use App\Models\Invitations\Invitation;
use App\Models\Invitations\InvitationOrder;
use App\Models\Invitations\InvitationOrderItem;
use App\Models\Invitations\InvitationPayment;
use App\Services\Invitations\InvitationPricingService;
use App\Services\Payment\RazorpayService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class InvitationCheckoutController extends Controller
{
    protected InvitationPricingService $pricingService;
    protected RazorpayService $razorpay;

    public function __construct(
        InvitationPricingService $pricingService,
        RazorpayService $razorpay
    ) {
        $this->pricingService = $pricingService;
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

        // Default: If in India environment / local default, INR; otherwise INR as standard domestic baseline
        return 'INR';
    }

    /**
     * Display Invitation Checkout View.
     */
    public function checkout(Request $request, int $id)
    {
        $user = Auth::user();
        $invitation = Invitation::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        // Detect currency automatically (INR for India, USD for global)
        $currency = $this->detectOriginCurrency($request);
        $coupon = $request->query('coupon');

        $pricing = $this->pricingService->calculate(
            $invitation->template,
            $invitation->selected_features ?? [],
            $currency,
            null,
            $coupon
        );

        Log::info('[CHECKOUT_PAGE_LOADED]', [
            'user_id' => $user->id,
            'invitation_id' => $invitation->id,
            'template' => $invitation->template?->name,
            'currency' => $currency,
            'coupon' => $coupon,
            'final_amount' => $pricing['final_amount'] ?? 0,
            'detected_cf_country' => $request->header('CF-IPCountry'),
            'ip' => $request->ip(),
        ]);

        return view('invitations.checkout.index', [
            'invitation' => $invitation,
            'pricing' => $pricing,
            'currency' => $currency,
            'razorpayKeyId' => config('services.razorpay.key_id'),
        ]);
    }

    /**
     * Create Pending Order & Initialize Razorpay.
     */
    public function createOrder(Request $request, int $id): JsonResponse
    {
        $user = Auth::user();
        $invitation = Invitation::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $validated = $request->validate([
            'gateway' => 'nullable|string|in:razorpay,free_publish',
            'currency' => 'nullable|string|in:INR,USD',
            'coupon' => 'nullable|string',
        ]);

        $currency = $validated['currency'] ?? $this->detectOriginCurrency($request);
        $gateway = $validated['gateway'] ?? 'razorpay';

        $pricing = $this->pricingService->calculate(
            $invitation->template,
            $invitation->selected_features ?? [],
            $currency,
            null,
            $validated['coupon'] ?? null
        );

        $orderNumber = 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(6));

        Log::info('[PAYMENT_ORDER_INITIATED]', [
            'order_number' => $orderNumber,
            'user_id' => $user->id,
            'user_email' => $user->email,
            'invitation_id' => $invitation->id,
            'gateway' => $gateway,
            'currency' => $currency,
            'subtotal' => $pricing['subtotal'],
            'discount' => $pricing['discount_amount'],
            'final_amount' => $pricing['final_amount'],
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $order = InvitationOrder::create([
            'order_number' => $orderNumber,
            'user_id' => $user->id,
            'invitation_id' => $invitation->id,
            'template_id' => $invitation->template_id,
            'amount' => $pricing['subtotal'],
            'currency' => $currency,
            'discount_amount' => $pricing['discount_amount'],
            'coupon_code' => $pricing['coupon']['code'] ?? null,
            'tax_amount' => $pricing['tax_amount'],
            'final_amount' => $pricing['final_amount'],
            'payment_gateway' => $gateway,
            'status' => $pricing['is_free'] || $gateway === 'free_publish' ? 'completed' : 'pending',
            'metadata' => [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'pricing_breakdown' => $pricing,
            ],
        ]);

        // Record order items
        if ($invitation->template) {
            InvitationOrderItem::create([
                'order_id' => $order->id,
                'item_type' => 'template',
                'item_id' => $invitation->template->id,
                'item_name' => $invitation->template->name,
                'unit_price' => $pricing['template_price'],
                'quantity' => 1,
                'subtotal' => $pricing['template_price'],
            ]);
        }

        foreach ($pricing['features'] as $f) {
            InvitationOrderItem::create([
                'order_id' => $order->id,
                'item_type' => 'feature',
                'item_name' => $f['name'],
                'unit_price' => $f['price'],
                'quantity' => 1,
                'subtotal' => $f['price'],
            ]);
        }

        // If amount is 0 or free_publish, activate immediately
        if ($pricing['is_free'] || $gateway === 'free_publish') {
            $invitation->markAsPublished();

            InvitationPayment::create([
                'order_id' => $order->id,
                'transaction_ref' => 'FREE-' . $orderNumber,
                'gateway' => 'free_publish',
                'amount' => 0.00,
                'currency' => $currency,
                'status' => 'completed',
                'raw_payload' => ['type' => 'free_publish', 'order_number' => $orderNumber],
            ]);

            Log::info('[PAYMENT_FREE_ACTIVATED]', [
                'order_number' => $orderNumber,
                'invitation_id' => $invitation->id,
                'user_id' => $user->id,
            ]);

            return response()->json([
                'success' => true,
                'is_free' => true,
                'order_number' => $orderNumber,
                'redirect_url' => route('invitations.public.show', $invitation->slug),
            ]);
        }

        // Razorpay Gateway - Single exclusive payment provider for INR & USD
        try {
            $razorpayResult = $this->razorpay->createOrder($pricing['final_amount'], $currency, $orderNumber);
            $order->gateway_order_id = $razorpayResult['razorpay_order_id'];
            $order->save();

            Log::info('[RAZORPAY_ORDER_CREATED]', [
                'order_number' => $orderNumber,
                'razorpay_order_id' => $razorpayResult['razorpay_order_id'],
                'amount_units' => $razorpayResult['amount'],
                'currency' => $currency,
            ]);

            return response()->json([
                'success' => true,
                'gateway' => 'razorpay',
                'order_number' => $orderNumber,
                'razorpay_order_id' => $razorpayResult['razorpay_order_id'],
                'key_id' => $razorpayResult['key_id'],
                'amount_paise' => $razorpayResult['amount'],
                'currency' => $currency,
                'customer_email' => $user->email,
                'customer_name' => $user->name,
            ]);
        } catch (\Exception $e) {
            Log::error('[RAZORPAY_ORDER_FAILED]', [
                'order_number' => $orderNumber,
                'error' => $e->getMessage(),
            ]);

            $order->status = 'failed';
            $order->save();

            return response()->json([
                'success' => false,
                'error' => 'Unable to initialize Razorpay checkout: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Verify and Complete Payment via Client Return Signature.
     */
    public function verifyPayment(Request $request, int $id): JsonResponse
    {
        $user = Auth::user();
        $invitation = Invitation::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $validated = $request->validate([
            'order_number' => 'required|string',
            'gateway' => 'nullable|string',
            'gateway_payment_id' => 'nullable|string',
            'gateway_signature' => 'nullable|string',
            'gateway_order_id' => 'nullable|string',
        ]);

        $order = InvitationOrder::where('order_number', $validated['order_number'])->firstOrFail();

        // If already completed, return success immediately
        if ($order->status === 'completed') {
            $invitation->markAsPublished();

            return response()->json([
                'success' => true,
                'message' => 'Payment already verified successfully! Your invitation is live.',
                'order_number' => $order->order_number,
                'transaction_ref' => $order->gateway_payment_id ?? $order->order_number,
                'redirect_url' => route('invitations.public.show', $invitation->slug),
            ]);
        }

        $orderId = $validated['gateway_order_id'] ?? $order->gateway_order_id;

        Log::info('[PAYMENT_VERIFICATION_ATTEMPT]', [
            'order_number' => $order->order_number,
            'gateway' => 'razorpay',
            'gateway_order_id' => $orderId,
            'gateway_payment_id' => $validated['gateway_payment_id'],
            'user_id' => $user->id,
            'ip' => $request->ip(),
        ]);

        $isValid = $this->razorpay->verifySignature(
            $orderId,
            $validated['gateway_payment_id'] ?? '',
            $validated['gateway_signature'] ?? ''
        );

        if (!$isValid) {
            Log::error('[RAZORPAY_SIGNATURE_VERIFICATION_FAILED]', [
                'order_number' => $order->order_number,
                'razorpay_order_id' => $orderId,
                'razorpay_payment_id' => $validated['gateway_payment_id'],
                'signature' => $validated['gateway_signature'],
                'user_id' => $user->id,
            ]);

            // Record Failed Attempt in DB
            InvitationPayment::create([
                'order_id' => $order->id,
                'transaction_ref' => $validated['gateway_payment_id'] ?? 'FAILED-SIG',
                'gateway' => 'razorpay',
                'amount' => $order->final_amount,
                'currency' => $order->currency,
                'status' => 'failed',
                'raw_payload' => [
                    'error' => 'Signature verification mismatch',
                    'request_data' => $request->all(),
                ],
            ]);

            $order->status = 'failed';
            $order->save();

            return response()->json([
                'success' => false,
                'error' => 'Payment signature verification failed. If your account was debited, please contact support with Order Ref: ' . $order->order_number,
            ], 400);
        }

        // Mark Order as Completed
        $order->status = 'completed';
        $order->gateway_payment_id = $validated['gateway_payment_id'] ?? null;
        if (!empty($orderId)) {
            $order->gateway_order_id = $orderId;
        }
        $order->save();

        // Record Completed Payment in DB
        $payment = InvitationPayment::create([
            'order_id' => $order->id,
            'transaction_ref' => $validated['gateway_payment_id'] ?? $order->order_number,
            'gateway' => 'razorpay',
            'amount' => $order->final_amount,
            'currency' => $order->currency,
            'status' => 'completed',
            'raw_payload' => [
                'verification_timestamp' => now()->toIso8601String(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'payload' => $request->all(),
            ],
        ]);

        // Publish and activate invitation
        $invitation->markAsPublished();

        Log::info('[PAYMENT_VERIFIED_SUCCESSFULLY]', [
            'order_number' => $order->order_number,
            'payment_id' => $payment->id,
            'transaction_ref' => $payment->transaction_ref,
            'amount' => $order->final_amount,
            'currency' => $order->currency,
            'invitation_id' => $invitation->id,
            'invitation_slug' => $invitation->slug,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment verified successfully! Your invitation is now live.',
            'order_number' => $order->order_number,
            'transaction_ref' => $payment->transaction_ref,
            'redirect_url' => route('invitations.public.show', $invitation->slug),
        ]);
    }

    /**
     * Razorpay Server-to-Server Webhook Endpoint.
     */
    public function handleWebhook(Request $request): JsonResponse
    {
        $signature = $request->header('X-Razorpay-Signature');
        $rawPayload = $request->getContent();

        Log::info('[RAZORPAY_WEBHOOK_RECEIVED]', [
            'event' => $request->input('event'),
            'has_signature' => !empty($signature),
        ]);

        // Verify webhook signature if configured
        if (!empty($signature)) {
            $isValid = $this->razorpay->verifyWebhookSignature($rawPayload, $signature);
            if (!$isValid) {
                Log::warning('[RAZORPAY_WEBHOOK_SIGNATURE_INVALID]', [
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

            // Find matching order
            $order = null;
            if ($razorpayOrderId) {
                $order = InvitationOrder::where('gateway_order_id', $razorpayOrderId)->first();
            }
            if (!$order && $receipt) {
                $order = InvitationOrder::where('order_number', $receipt)->first();
            }

            if ($order) {
                if ($order->status !== 'completed') {
                    $order->status = 'completed';
                    $order->gateway_payment_id = $paymentId ?? $order->gateway_payment_id;
                    $order->save();

                    InvitationPayment::create([
                        'order_id' => $order->id,
                        'transaction_ref' => $paymentId ?? $order->order_number,
                        'gateway' => 'razorpay',
                        'amount' => $order->final_amount,
                        'currency' => $order->currency,
                        'status' => 'completed',
                        'raw_payload' => [
                            'webhook_event' => $event,
                            'received_at' => now()->toIso8601String(),
                            'payload' => $request->all(),
                        ],
                    ]);

                    if ($order->invitation) {
                        $order->invitation->markAsPublished();
                    }

                    Log::info('[RAZORPAY_WEBHOOK_ORDER_COMPLETED]', [
                        'order_number' => $order->order_number,
                        'invitation_id' => $order->invitation_id,
                        'payment_id' => $paymentId,
                    ]);
                }
            }
        } elseif ($event === 'payment.failed') {
            $paymentEntity = $payload['payment']['entity'] ?? [];
            $razorpayOrderId = $paymentEntity['order_id'] ?? null;
            $paymentId = $paymentEntity['id'] ?? null;

            if ($razorpayOrderId) {
                $order = InvitationOrder::where('gateway_order_id', $razorpayOrderId)->first();
                if ($order && $order->status !== 'completed') {
                    $order->status = 'failed';
                    $order->save();

                    InvitationPayment::create([
                        'order_id' => $order->id,
                        'transaction_ref' => $paymentId ?? ('FAIL-' . strtoupper(Str::random(6))),
                        'gateway' => 'razorpay',
                        'amount' => $order->final_amount,
                        'currency' => $order->currency,
                        'status' => 'failed',
                        'raw_payload' => [
                            'webhook_event' => $event,
                            'received_at' => now()->toIso8601String(),
                            'payload' => $request->all(),
                        ],
                    ]);

                    Log::warning('[RAZORPAY_WEBHOOK_PAYMENT_FAILED]', [
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
    public function recordPaymentFailure(Request $request, int $id): JsonResponse
    {
        $user = Auth::user();
        $invitation = Invitation::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $orderNumber = $request->input('order_number');
        $gateway = $request->input('gateway', 'razorpay');
        $errorCode = $request->input('error_code', 'PAYMENT_FAILED');
        $errorDescription = $request->input('error_description', 'Payment process was cancelled or failed by user/bank.');
        $paymentId = $request->input('payment_id');

        Log::warning('[PAYMENT_FAILURE_REPORTED]', [
            'user_id' => $user->id,
            'invitation_id' => $invitation->id,
            'order_number' => $orderNumber,
            'gateway' => $gateway,
            'error_code' => $errorCode,
            'error_description' => $errorDescription,
            'payment_id' => $paymentId,
            'ip' => $request->ip(),
        ]);

        if ($orderNumber) {
            $order = InvitationOrder::where('order_number', $orderNumber)->first();
            if ($order && $order->status !== 'completed') {
                $order->status = 'failed';
                $order->save();

                InvitationPayment::create([
                    'order_id' => $order->id,
                    'transaction_ref' => $paymentId ?? ('FAIL-' . strtoupper(Str::random(6))),
                    'gateway' => $gateway,
                    'amount' => $order->final_amount,
                    'currency' => $order->currency,
                    'status' => 'failed',
                    'raw_payload' => [
                        'error_code' => $errorCode,
                        'error_description' => $errorDescription,
                        'request_data' => $request->all(),
                        'timestamp' => now()->toIso8601String(),
                    ],
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'logged' => true,
            'message' => 'Payment failure logged successfully.',
        ]);
    }
}
