<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderTrackingController extends Controller
{
    public function index()
    {
        $orderNumber = request('order_number');

        if ($orderNumber) {
            $order = Order::with(['items', 'customer'])
                ->where('order_number', strtoupper($orderNumber))
                ->first();

            if (!$order) {
                return back()->with('error', 'Order not found. Please check your order number.');
            }

            return view('store.order-detail', compact('order'));
        }

        return view('store.order-tracking');
    }
}
