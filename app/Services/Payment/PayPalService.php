<?php

namespace App\Services\Payment;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PayPalService
{
    protected string $clientId;
    protected string $secret;
    protected string $baseUrl;

    public function __construct()
    {
        $this->clientId = config('services.paypal.client_id', '');
        $this->secret = config('services.paypal.secret', '');
        $mode = config('services.paypal.mode', 'sandbox');
        
        $this->baseUrl = $mode === 'live'
            ? 'https://api-m.paypal.com'
            : 'https://api-m.sandbox.paypal.com';
    }

    /**
     * Get OAuth2 Access Token.
     */
    public function getAccessToken(): ?string
    {
        if (empty($this->clientId) || empty($this->secret)) {
            Log::error('PayPal Client ID or Secret missing in configuration.');
            return null;
        }

        try {
            $response = Http::withoutVerifying()
                ->asForm()
                ->withBasicAuth($this->clientId, $this->secret)
                ->post("{$this->baseUrl}/v1/oauth2/token", [
                    'grant_type' => 'client_credentials'
                ]);

            if ($response->successful()) {
                return $response->json()['access_token'] ?? null;
            }

            Log::error('PayPal Auth Failed: ' . $response->body());
            return null;
        } catch (\Throwable $e) {
            Log::error('PayPal Auth Exception: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Create PayPal Checkout Order.
     */
    public function createOrder(float $amount, string $currency, string $orderNumber, string $planName): array
    {
        $token = $this->getAccessToken();
        if (!$token) {
            return [
                'success' => false,
                'error' => 'Unable to authenticate with PayPal payment gateway.'
            ];
        }

        // Standardize currency for PayPal
        $chargeCurrency = $currency === 'INR' ? 'USD' : $currency;
        $chargeAmount = $currency === 'INR' ? round($amount / 85, 2) : $amount;
        if ($chargeAmount < 1) $chargeAmount = 1.00;

        try {
            $response = Http::withoutVerifying()
                ->withToken($token)
                ->post("{$this->baseUrl}/v2/checkout/orders", [
                    'intent' => 'CAPTURE',
                    'purchase_units' => [
                        [
                            'reference_id' => $orderNumber,
                            'custom_id' => $orderNumber,
                            'description' => "Postryx AI - {$planName} Plan",
                            'amount' => [
                                'currency_code' => $chargeCurrency,
                                'value' => number_format($chargeAmount, 2, '.', '')
                            ]
                        ]
                    ],
                    'application_context' => [
                        'brand_name' => 'Postryx AI',
                        'landing_page' => 'NO_PREFERENCE',
                        'user_action' => 'PAY_NOW',
                        'return_url' => url("/checkout/paypal/success?order={$orderNumber}"),
                        'cancel_url' => url("/pricing?canceled=true")
                    ]
                ]);

            if ($response->successful()) {
                $data = $response->json();
                $approveLink = '';
                foreach ($data['links'] ?? [] as $link) {
                    if ($link['rel'] === 'approve') {
                        $approveLink = $link['href'];
                        break;
                    }
                }

                return [
                    'success' => true,
                    'paypal_order_id' => $data['id'],
                    'approve_url' => $approveLink,
                    'status' => $data['status']
                ];
            }

            Log::error('PayPal Create Order Failed: ' . $response->body());
            return [
                'success' => false,
                'error' => 'PayPal order creation failed: ' . $response->body()
            ];
        } catch (\Throwable $e) {
            Log::error('PayPal Create Order Exception: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Capture PayPal Payment after Buyer Approval.
     */
    public function captureOrder(string $paypalOrderId): array
    {
        $token = $this->getAccessToken();
        if (!$token) {
            return ['success' => false, 'error' => 'Authentication failed.'];
        }

        try {
            $response = Http::withoutVerifying()
                ->withToken($token)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post("{$this->baseUrl}/v2/checkout/orders/{$paypalOrderId}/capture", (object)[]);

            if ($response->successful()) {
                $data = $response->json();
                $status = $data['status'] ?? 'UNKNOWN';

                if ($status === 'COMPLETED') {
                    $capture = $data['purchase_units'][0]['payments']['captures'][0] ?? [];
                    return [
                        'success' => true,
                        'status' => 'COMPLETED',
                        'transaction_id' => $capture['id'] ?? $paypalOrderId,
                        'amount' => $capture['amount']['value'] ?? '0.00',
                        'currency' => $capture['amount']['currency_code'] ?? 'USD',
                        'payer' => $data['payer'] ?? []
                    ];
                }

                return [
                    'success' => false,
                    'status' => $status,
                    'error' => 'Payment status: ' . $status
                ];
            }

            Log::error('PayPal Capture Failed: ' . $response->body());
            return [
                'success' => false,
                'error' => 'Payment capture failed: ' . $response->body()
            ];
        } catch (\Throwable $e) {
            Log::error('PayPal Capture Exception: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}
