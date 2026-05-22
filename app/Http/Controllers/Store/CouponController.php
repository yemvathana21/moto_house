<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Coupon;

class CouponController extends Controller
{
    public function validate()
    {
        $data = request()->validate([
            'code' => 'required|string|max:50',
            'subtotal' => 'required|numeric|min:0',
        ]);

        $coupon = Coupon::where('code', strtoupper($data['code']))
            ->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('starts_at')->orWhere('starts_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>=', now());
            })
            ->first();

        if (!$coupon) {
            return response()->json(['valid' => false, 'message' => 'Invalid or expired coupon code']);
        }

        if ($coupon->max_uses !== null && $coupon->used_count >= $coupon->max_uses) {
            return response()->json(['valid' => false, 'message' => 'This coupon has reached its usage limit']);
        }

        if ($coupon->min_order_amount !== null && $data['subtotal'] < $coupon->min_order_amount) {
            return response()->json([
                'valid' => false,
                'message' => 'Minimum order amount of $' . number_format($coupon->min_order_amount, 2) . ' required',
            ]);
        }

        $discount = $coupon->type === 'percentage'
            ? round($data['subtotal'] * $coupon->value / 100, 2)
            : min($coupon->value, $data['subtotal']);

        return response()->json([
            'valid' => true,
            'discount' => $discount,
            'message' => 'Coupon applied!',
        ]);
    }
}
