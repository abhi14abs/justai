<?php

namespace App\Http\Controllers;

use App\Services\AiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    protected AiService $aiService;

    public function __construct(AiService $aiService)
    {
        $this->aiService = $aiService;
    }

    /**
     * Generate content for any tool type.
     */
    public function generate(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'tool' => 'required|string|max:50',
            'topic' => 'required|string|max:2000',
            'tone' => 'nullable|string|max:50',
            'params' => 'nullable|array'
        ]);

        $tool = $validated['tool'];
        $topic = $validated['topic'];
        $tone = $validated['tone'] ?? 'engaging';
        $params = $validated['params'] ?? [];

        // Check if API token is provided
        $apiToken = $request->bearerToken() ?? $request->header('X-API-Key') ?? $request->input('api_token');
        $user = null;
        if (!empty($apiToken)) {
            $user = \App\Models\User::where('api_token', $apiToken)->first();
        } elseif (\Illuminate\Support\Facades\Auth::check()) {
            $user = \Illuminate\Support\Facades\Auth::user();
        }

        try {
            $result = $this->aiService->generate($tool, $topic, $tone, $params);
            
            // Log generation to database if user or session is present
            if ($result['success'] ?? false) {
                try {
                    \App\Models\Generation::create([
                        'user_id' => $user?->id,
                        'ip_address' => $request->ip(),
                        'tool' => $tool,
                        'topic' => $topic,
                        'tone' => $tone,
                        'content' => $result['content'] ?? '',
                        'word_count' => str_word_count($result['content'] ?? ''),
                        'char_count' => strlen($result['content'] ?? ''),
                        'provider' => $result['provider'] ?? 'postryx-engine'
                    ]);
                } catch (\Throwable $e) {
                    // Ignore background log error
                }
            }

            return response()->json($result);
        } catch (\Throwable $e) {
            Log::error('Generation API error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'An error occurred during generation. Please try again.'
            ], 500);
        }
    }

    /**
     * Analyze a viral hook or headline.
     */
    public function analyze(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'headline' => 'required|string|max:500'
        ]);

        try {
            $result = $this->aiService->analyzeHook($validated['headline']);
            return response()->json($result);
        } catch (\Throwable $e) {
            Log::error('Hook analysis error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'An error occurred while analyzing the headline.'
            ], 500);
        }
    }

    /**
     * Humanize AI-generated text.
     */
    public function humanize(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'text' => 'required|string|max:5000',
            'style' => 'nullable|string|max:50'
        ]);

        $style = $validated['style'] ?? 'conversational';

        try {
            $result = $this->aiService->humanizeText($validated['text'], $style);
            return response()->json($result);
        } catch (\Throwable $e) {
            Log::error('Humanize API error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'An error occurred during humanization.'
            ], 500);
        }
    }

    /**
     * Repurpose 1 piece of content into 5 multi-platform assets.
     */
    public function repurpose(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'topic' => 'required|string|max:2000'
        ]);

        try {
            $result = $this->aiService->repurposeContent($validated['topic']);
            return response()->json($result);
        } catch (\Throwable $e) {
            Log::error('Repurpose API error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'An error occurred during content repurposing.'
            ], 500);
        }
    }

    /**
     * Newsletter Lead Capture.
     */
    public function newsletter(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255'
        ]);

        Log::info('New Postryx Newsletter subscriber: ' . $validated['email']);

        return response()->json([
            'success' => true,
            'message' => '🎉 Welcome to the Postryx Growth Club! Check your inbox for the Viral Hook Swipe File.',
            'lead_magnet_url' => 'https://postryx.in/assets/postryx-viral-swipe-file-2026.pdf'
        ]);
    }

    /**
     * Validate Launch Coupon Code.
     */
    public function validateCoupon(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50'
        ]);

        $code = strtoupper(trim($validated['code']));

        $coupons = [
            'LAUNCH50' => ['discount' => 50, 'label' => '50% Lifetime Launch Discount Applied!'],
            'VIRAL30' => ['discount' => 30, 'label' => '30% Early Adopter Discount Applied!'],
            'FOUNDER100' => ['discount' => 100, 'label' => '100% Free 14-Day Full Pro Access!'],
            'POSTRYX20' => ['discount' => 20, 'label' => '20% Creator Discount Applied!']
        ];

        if (isset($coupons[$code])) {
            return response()->json([
                'success' => true,
                'valid' => true,
                'code' => $code,
                'discount' => $coupons[$code]['discount'],
                'message' => $coupons[$code]['label']
            ]);
        }

        return response()->json([
            'success' => false,
            'valid' => false,
            'message' => 'Invalid or expired coupon code. Try "LAUNCH50" for 50% off.'
        ], 422);
    }

    /**
     * Initialize Checkout Session (Razorpay / Stripe Ready).
     */
    public function checkout(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'plan' => 'required|string|in:starter,pro,agency,lifetime',
            'currency' => 'nullable|string|in:INR,USD',
            'billing' => 'nullable|string|in:monthly,annual,lifetime',
            'coupon' => 'nullable|string'
        ]);

        $plan = $validated['plan'];
        $currency = $validated['currency'] ?? 'INR';
        $billing = $validated['billing'] ?? 'monthly';

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

        $amount = $pricingTable[$currency][$plan][$billing] ?? 1999;

        // Apply coupon if valid
        $discount = 0;
        if (!empty($validated['coupon']) && strtoupper($validated['coupon']) === 'LAUNCH50') {
            $discount = 50;
            $amount = round($amount * 0.5, 2);
        }

        return response()->json([
            'success' => true,
            'checkout_id' => 'chk_' . bin2hex(random_bytes(8)),
            'plan' => $plan,
            'currency' => $currency,
            'billing' => $billing,
            'amount' => $amount,
            'discount_applied' => $discount . '%',
            'gateway' => $currency === 'INR' ? 'Razorpay' : 'Stripe',
            'message' => 'Checkout initialized successfully. Redirecting to secure gateway...'
        ]);
    }
}
