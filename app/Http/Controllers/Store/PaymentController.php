<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Setting;
use App\Services\BakongService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PaymentController extends Controller
{
    public function show(Order $order)
    {
        $merchantName = Setting::getValue('bakong_merchant_name', 'Moto House') ?? 'Moto House';
        $merchantId = Setting::getValue('bakong_merchant_id', '') ?? '';
        $bakongId = Setting::getValue('bakong_bakong_id', '') ?? '';
        $bankName = Setting::getValue('bakong_bank', 'Bakong') ?? 'Bakong';

        $qrString = null;
        $deepLink = null;

        try {
            $bakongService = app(BakongService::class);
            $result = $bakongService->generateQR($order->total, (string) $order->id);

            if ($result['success']) {
                $qrString = $result['khqr'];
                $deepLink = $result['deeplink'] ?? null;
            }
        } catch (\Exception $e) {
            Log::warning('Bakong KHQR generation failed, using fallback', ['error' => $e->getMessage()]);
        }

        if (!$qrString) {
            $qrString = $this->generateKHQR((string) $order->total, $merchantName, $merchantId, $bakongId);
        }

        try {
            $qrSvg = QrCode::size(256)->generate($qrString);
        } catch (\Exception $e) {
            $qrSvg = '<p class="text-red-500">QR generation failed</p>';
        }

        return view('store.payment', compact('order', 'qrSvg', 'qrString', 'deepLink', 'merchantName', 'merchantId', 'bakongId', 'bankName'));
    }

    private function generateKHQR(string $amount, string $merchantName, string $merchantId, string $bakongId): string
    {
        $accountId = $bakongId ?: $merchantId;

        $merchantAccountInfo = '';
        $merchantAccountInfo .= $this->tlv('00', 'BKKHKHKG');
        $merchantAccountInfo .= $this->tlv('01', $accountId);

        $payload = '';
        $payload .= $this->tlv('00', '01');
        $payload .= $this->tlv('01', '11');
        $payload .= $this->tlv('29', $merchantAccountInfo);
        $payload .= $this->tlv('52', '0000');
        $payload .= $this->tlv('53', '840');
        $payload .= $this->tlv('54', $amount);
        $payload .= $this->tlv('58', 'KH');
        $payload .= $this->tlv('59', $merchantName);
        $payload .= $this->tlv('60', 'PHNOM PENH');

        $crc = $this->crc16($payload . '6304');
        $payload .= '6304' . strtoupper(str_pad(dechex($crc), 4, '0', STR_PAD_LEFT));

        return $payload;
    }

    private function tlv(string $tag, string $value): string
    {
        $length = strlen($value);
        return $tag . str_pad((string) $length, 2, '0', STR_PAD_LEFT) . $value;
    }

    private function crc16(string $data): int
    {
        $crc = 0xFFFF;
        $len = strlen($data);
        for ($i = 0; $i < $len; $i++) {
            $crc ^= ord($data[$i]) << 8;
            for ($j = 0; $j < 8; $j++) {
                if ($crc & 0x8000) {
                    $crc = ($crc << 1) ^ 0x1021;
                } else {
                    $crc <<= 1;
                }
            }
        }
        return $crc & 0xFFFF;
    }

    public function callback(Request $request)
    {
        $paymentId = $request->get('payment_id');
        $orderId = $request->get('merchant_ref_no');

        if ($orderId) {
            $order = Order::find($orderId);
            if ($order) {
                $order->update([
                    'payment_status' => 'paid',
                    'transaction_id' => $paymentId,
                    'paid_at' => now(),
                ]);
            }
        }

        return redirect('/')->with('success', 'Payment successful!');
    }

    public function cancel(Request $request)
    {
        return redirect('/')->with('error', 'Payment was cancelled.');
    }

    public function webhook(Request $request)
    {
        return response()->json(['status' => 'ok']);
    }
}
