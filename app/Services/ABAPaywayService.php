<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ABAPaywayService
{
    protected $merchantId;
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->merchantId = config('aba.merchant_id');
        $this->apiKey = config('aba.api_key');
        $this->baseUrl = config('aba.api_url');
    }

    /**
     * Get the hosted checkout page from ABA PayWay
     */
    public function getCheckoutPage($amount, $orderId, $description = null): array
    {
        $tranId = 'MOTO' . $orderId . '_' . random_int(100, 999);

        $payload = [
            'merchant_id' => $this->merchantId,
            'tran_id' => $tranId,
            'amount' => (float) $amount,
            'currency' => 'USD',
            'merchant_ref_no' => (string) $orderId,
            'payment_method' => 'ABA_QR',
            'description' => $description ?? 'Payment for Order #' . $orderId,
            'return_url' => route('payment.callback'),
            'cancel_url' => route('payment.cancel'),
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post($this->baseUrl . '/payments/purchase', $payload);

        if ($response->successful()) {
            return [
                'success' => true,
                'html' => $response->body(),
            ];
        }

        Log::error('ABA Payment Failed', [
            'order_id' => $orderId,
            'response' => $response->body(),
        ]);

        $body = $response->json();
        $error = $body['message'] ?? $body['status']['message'] ?? 'Failed to generate QR code';

        return [
            'success' => false,
            'error' => $error,
        ];
    }
}
