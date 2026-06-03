<?php

namespace App\Services;

class ABAPaywayService
{
    public function getCheckoutPage(float $amount, string $orderId, string $description): array
    {
        return [
            'success' => false,
            'error' => 'ABA PayWay not configured',
        ];
    }
}
