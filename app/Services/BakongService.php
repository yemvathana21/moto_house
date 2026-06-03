<?php

namespace App\Services;

use KHQR\BakongKHQR;
use KHQR\Helpers\KHQRData;
use KHQR\Models\IndividualInfo;
use KHQR\Models\SourceInfo;

class BakongService
{
    protected string $merchantName;
    protected string $merchantId;
    protected string $merchantCity;

    public function __construct()
    {
        $this->merchantId = config('bakong.merchant_id', '');
        $this->merchantName = config('bakong.merchant_name', 'Moto House');
        $this->merchantCity = config('bakong.merchant_city', 'PHNOM PENH');
    }

    public function generateQR(float $amount, string $orderId, string $description = null): array
    {
        $info = new IndividualInfo(
            bakongAccountID: $this->merchantId,
            merchantName: mb_substr($this->merchantName, 0, 25),
            merchantCity: mb_substr($this->merchantCity, 0, 15),
            currency: KHQRData::CURRENCY_USD,
            amount: $amount,
        );

        try {
            $response = BakongKHQR::generateIndividual($info);

            if ($response->status->code === 0) {

                $khqr = $response->data->qr;

                $deeplink = '';

                try {
                    $dlResult = BakongKHQR::generateDeepLink($khqr, null, false);

                    if ($dlResult->status->code === 0) {
                        $deeplink = $dlResult->data->shortLink ?? '';
                    }

                } catch (\Exception $e) {
                }

                $md5 = $response->data->md5 ?? md5($khqr);

                return [
                    'success' => true,
                    'khqr' => $khqr,
                    'md5' => $md5,
                    'deeplink' => $deeplink,
                ];
            }

            return [
                'success' => false,
                'error' => $response->status->message ?? 'Failed to generate KHQR',
            ];

        } catch (\Exception $e) {

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
