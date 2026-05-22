<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Setting;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class PaymentController extends Controller
{
    public function show(Order $order)
    {
        $merchantName = Setting::getValue('aba_merchant_name', 'Moto House');
        $merchantId = Setting::getValue('aba_merchant_id', '000000');
        $bankName = Setting::getValue('aba_bank', 'ABA Bank');

        $khqrPayload = self::generateKhqr(
            merchantId: $merchantId,
            merchantName: $merchantName,
            amount: $order->total,
            currency: '840',
            country: 'KH',
            merchantCity: 'Phnom Penh',
            storeLabel: 'Moto House',
            billNumber: $order->order_number,
        );

        $qrSvg = QrCode::format('svg')
            ->size(280)
            ->margin(1)
            ->errorCorrection('M')
            ->generate($khqrPayload);

        return view('store.payment', compact('order', 'khqrPayload', 'merchantName', 'bankName', 'qrSvg'));
    }

    public static function generateKhqr(
        string $merchantId,
        string $merchantName,
        float $amount,
        string $currency = '840',
        string $country = 'KH',
        string $merchantCity = 'Phnom Penh',
        string $storeLabel = 'Moto House',
        string $billNumber = '',
    ): string {
        $amountStr = number_format($amount, 2, '.', '');

        $merchantAccount = '0029' . sprintf('%02d', 2 + strlen('KHQRNABAPhnomPenh') + 2 + strlen($merchantId))
            . '00' . sprintf('%02d', strlen('KHQRNABAPhnomPenh')) . 'KHQRNABAPhnomPenh'
            . '01' . sprintf('%02d', strlen($merchantId)) . $merchantId;

        $payload = '000201010212'
            . $merchantAccount
            . '52045999'
            . '5303' . $currency
            . '54' . sprintf('%02d', strlen($amountStr)) . $amountStr
            . '5802' . $country
            . '59' . sprintf('%02d', strlen($merchantName)) . $merchantName
            . '60' . sprintf('%02d', strlen($merchantCity)) . $merchantCity;

        if ($billNumber) {
            $payload .= '62' . sprintf('%02d', 4 + 2 + strlen($storeLabel) + 2 + strlen($billNumber))
                . '01' . sprintf('%02d', strlen($storeLabel)) . $storeLabel
                . '07' . sprintf('%02d', strlen($billNumber)) . $billNumber;
        }

        $payload .= '6304';
        $payload .= self::crc16($payload);

        return $payload;
    }

    private static function crc16(string $data): string
    {
        $crc = 0xFFFF;
        $dataArr = unpack('C*', $data);
        if ($dataArr === false) {
            return '0000';
        }
        foreach ($dataArr as $byte) {
            $crc ^= $byte;
            for ($j = 0; $j < 8; $j++) {
                if ($crc & 0x0001) {
                    $crc = ($crc >> 1) ^ 0x8408;
                } else {
                    $crc >>= 1;
                }
            }
        }
        return strtoupper(dechex($crc));
    }
}
