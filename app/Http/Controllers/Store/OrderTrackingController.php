<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class OrderTrackingController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $customer = Customer::where('email', $user->email)->first();

        $orders = collect();


        $order = null;
            if (request('order_number')) {
                $order = Order::where('order_number', request('order_number'))->first();
            }

        if ($customer) {
            $orders = Order::with(['items'])
                ->where('customer_id', $customer->id)
                ->latest()
                ->get();
        }

        return view('store.order-tracking', compact('orders', 'order'));
    }
}