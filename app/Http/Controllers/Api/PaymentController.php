<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\BakongService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function show(Order $order)
    {
        if ($order->payment_method !== 'khqr') {
            return response()->json(['message' => 'Not a KHQR payment.'], 422);
        }

        $bakong = app(BakongService::class);
        $qrData = $bakong->generateQR(
            (float) $order->total,
            $order->order_number,
            "Payment for order {$order->order_number}"
        );

        return response()->json([
            'order' => [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'total' => (float) $order->total,
                'status' => $order->status,
                'payment_status' => $order->payment_status,
            ],
            'qr_data' => $qrData,
            'merchant_name' => config('bakong.merchant_name'),
            'merchant_id' => config('bakong.merchant_id'),
        ]);
    }

    public function callback(Request $request)
    {
        // Handle Bakong callback
        return response()->json(['message' => 'Callback received']);
    }

    public function webhook(Request $request)
    {
        // Handle Bakong webhook for payment confirmation
        return response()->json(['message' => 'Webhook received']);
    }
}
