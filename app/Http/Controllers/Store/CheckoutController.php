<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Mail\OrderConfirmation;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect('/cart')->with('error', 'Your cart is empty');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        $tax = round($subtotal * 0.1, 2);
        $total = $subtotal + $tax;

        return view('store.checkout', compact('cart', 'subtotal', 'tax', 'total'));
    }

    public function store()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'Your cart is empty');
        }

        $data = request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'coupon_code' => 'nullable|string|max:50',
            'payment_method' => 'required|in:cod,khqr',
        ]);

        $customer = Customer::firstOrCreate(
            ['email' => $data['email']],
            [
                'name' => $data['name'],
                'phone' => $data['phone'] ?? '',
                'address' => $data['address'],
                'city' => $data['city'],
                'state' => $data['state'] ?? '',
                'postal_code' => $data['postal_code'] ?? '',
                'country' => $data['country'] ?? '',
            ]
        );

        session()->put('customer_id', $customer->id);

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        $tax = round($subtotal * 0.1, 2);
        $discount = 0;

        if (!empty($data['coupon_code'])) {
            $coupon = Coupon::where('code', strtoupper($data['coupon_code']))
                ->where('is_active', true)
                ->where(function ($q) {
                    $q->whereNull('starts_at')->orWhere('starts_at', '<=', now());
                })
                ->where(function ($q) {
                    $q->whereNull('expires_at')->orWhere('expires_at', '>=', now());
                })
                ->first();

            if ($coupon && ($coupon->max_uses === null || $coupon->used_count < $coupon->max_uses)) {
                if ($coupon->min_order_amount === null || $subtotal >= $coupon->min_order_amount) {
                    $discount = $coupon->type === 'percentage'
                        ? round($subtotal * $coupon->value / 100, 2)
                        : min($coupon->value, $subtotal);

                    $coupon->increment('used_count');
                }
            }
        }

        $total = $subtotal + $tax - $discount;

        $order = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'customer_id' => $customer->id,
            'status' => 'pending',
            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping' => 0,
            'discount' => $discount,
            'total' => $total,
            'shipping_address' => $data['address'],
            'shipping_city' => $data['city'],
            'shipping_state' => $data['state'] ?? '',
            'shipping_postal_code' => $data['postal_code'] ?? '',
            'shipping_country' => $data['country'] ?? '',
            'payment_method' => $data['payment_method'],
            'payment_status' => $data['payment_method'] === 'khqr' ? 'pending' : 'pending',
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'product_name' => $item['name'],
                'unit_price' => $item['price'],
                'quantity' => $item['quantity'],
                'subtotal' => $item['price'] * $item['quantity'],
            ]);

            Product::where('id', $item['id'])->decrement('stock_quantity', $item['quantity']);
        }

        session()->forget('cart');

        try {
            if ($customer->email) {
                Mail::to($customer->email)->send(new OrderConfirmation($order));
            }
        } catch (\Exception $e) {
        }

        if (class_exists(\Livewire\Livewire::class)) {
            // \Livewire\Livewire::dispatch('cart-updated');
            session()->flash('success', 'Order placed successfully!');
        }

        if ($data['payment_method'] === 'khqr') {
            return redirect('/payment/' . $order->id);
        }

        return redirect('/')->with('success', __('Order placed! Your order #:number has been confirmed.', ['number' => $order->order_number]));
    }
}
