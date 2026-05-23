<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $customer = Customer::firstOrCreate(
            ['email' => $user->email],
            ['name' => $user->name, 'phone' => '']
        );

        $allOrders = collect();
        $orders = collect();
        $totalOrders = 0;
        $deliveredCount = 0;
        $inProgressCount = 0;

        if ($customer) {
            $allOrders = Order::where('customer_id', $customer->id)->latest()->get();

            $totalOrders = $allOrders->count();
            $deliveredCount = $allOrders->where('status', 'delivered')->count();
            $inProgressCount = $allOrders->whereIn('status', ['pending', 'processing'])->count();

            $orders = Order::where('customer_id', $customer->id)
                ->latest()
                ->paginate(10);
        }

        return view('store.account', compact('user', 'customer', 'orders', 'totalOrders', 'deliveredCount', 'inProgressCount'));
    }
}