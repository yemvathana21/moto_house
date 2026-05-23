<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Setting;
use App\Services\ABAPaywayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PaymentController extends Controller
{
    public function show(string $id)
    {
        $order = Order::findOrFail($id);

        $merchantName = Setting::getValue('aba_merchant_name', 'Moto House') ?? 'Moto House';
        $merchantId = Setting::getValue('aba_merchant_id', '') ?? '';
        $bakongId = Setting::getValue('aba_bakong_id', '') ?? '';
        $bankName = Setting::getValue('aba_bank', 'ABA Bank') ?? 'ABA Bank';

        try {
            $abaService = app(ABAPaywayService::class);
            $result = $abaService->getCheckoutPage($order->total, $order->id, 'Payment for Order #' . $order->order_number);

            if ($result['success']) {
                return response($result['html'])->header('Content-Type', 'text/html; charset=utf-8');
            }

            Log::warning('ABA PayWay API error, falling back to manual QR', ['error' => $result['error']]);
        } catch (\Exception $e) {
            Log::warning('ABA PayWay API unavailable, falling back to manual QR', ['error' => $e->getMessage()]);
        }

        $amount = number_format($order->total, 2, '.', '');
        $qrString = $this->generateKHQR($amount, $merchantName, $merchantId, $bakongId);

        try {
            $qrSvg = QrCode::size(256)->generate($qrString);
        } catch (\Exception $e) {
            $qrSvg = '<p class="text-red-500">QR generation failed</p>';
        }

        $deepLink = '';

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
