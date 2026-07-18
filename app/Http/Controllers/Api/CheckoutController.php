<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusHistory;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
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
            'notes' => 'nullable|string|max:1000',
        ]);

        $customer = $request->user();
        if (!$customer) {
            $customer = Customer::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'phone' => $data['phone'] ?? '',
                    'address' => $data['address'],
                    'city' => $data['city'],
                ]
            );
        }

        $subtotal = 0;
        $productIds = collect($data['items'])->pluck('product_id');
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        foreach ($data['items'] as $item) {
            $product = $products->get($item['product_id']);
            if (!$product || !$product->isInStock() || $product->stock_quantity < $item['quantity']) {
                return response()->json([
                    'message' => "Insufficient stock for {$product?->name}",
                ], 422);
            }
            $subtotal += $product->price * $item['quantity'];
        }

        $tax = round($subtotal * 0.1, 2);
        $discount = 0;
        $couponId = null;
        $couponCode = null;

        if (!empty($data['coupon_code'])) {
            $coupon = Coupon::where('code', strtoupper($data['coupon_code']))->first();
            if ($coupon && $coupon->isValid()) {
                $discount = $coupon->apply($subtotal);
                $couponId = $coupon->id;
                $couponCode = $coupon->code;
            }
        }

        $total = $subtotal + $tax - $discount;

        $order = DB::transaction(function () use ($data, $customer, $products, $subtotal, $tax, $discount, $total, $couponId, $couponCode, $coupon) {
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'customer_id' => $customer->id,
                'coupon_id' => $couponId,
                'coupon_code' => $couponCode,
                'status' => 'pending',
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shipping' => 0,
                'discount' => $discount,
                'total' => max($total, 0),
                'shipping_address' => $data['address'],
                'shipping_city' => $data['city'],
                'shipping_state' => $data['state'] ?? '',
                'shipping_postal_code' => $data['postal_code'] ?? '',
                'shipping_country' => $data['country'] ?? '',
                'payment_method' => $data['payment_method'],
                'payment_status' => 'pending',
                'notes' => $data['notes'] ?? '',
            ]);

            foreach ($data['items'] as $item) {
                $product = $products->get($item['product_id']);
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'unit_price' => $product->price,
                    'quantity' => $item['quantity'],
                    'subtotal' => $product->price * $item['quantity'],
                ]);
                $product->decrement('stock_quantity', $item['quantity']);
            }

            if ($coupon) {
                $coupon->markUsed();
                \App\Models\CustomerVoucher::where('customer_id', $customer->id)
                    ->where('coupon_id', $coupon->id)
                    ->update(['is_used' => true, 'used_at' => now()]);
            }

            return $order;
        });

        OrderStatusHistory::create([
            'order_id' => $order->id,
            'status' => 'pending',
            'note' => 'Order placed',
        ]);

        return response()->json([
            'order' => new OrderResource($order->load('items')),
            'payment_url' => $data['payment_method'] === 'khqr' ? "/api/payment/{$order->id}" : null,
            'message' => 'Order placed successfully!',
        ], 201);
    }
}
