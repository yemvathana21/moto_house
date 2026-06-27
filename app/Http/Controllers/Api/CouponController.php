<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function validate(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:50',
            'subtotal' => 'required|numeric|min:0',
        ]);

        $coupon = Coupon::where('code', strtoupper($data['code']))->first();

        if (!$coupon) {
            return response()->json([
                'valid' => false,
                'message' => 'Invalid coupon code.',
            ], 404);
        }

        if (!$coupon->isValid()) {
            return response()->json([
                'valid' => false,
                'message' => 'Coupon is expired or inactive.',
            ], 422);
        }

        if ($coupon->min_order_amount && $data['subtotal'] < $coupon->min_order_amount) {
            return response()->json([
                'valid' => false,
                'message' => "Minimum order amount of \${$coupon->min_order_amount} required.",
            ], 422);
        }

        $discount = $coupon->apply($data['subtotal']);

        return response()->json([
            'valid' => true,
            'coupon' => [
                'code' => $coupon->code,
                'type' => $coupon->type,
                'value' => (float) $coupon->value,
                'discount' => $discount,
            ],
            'message' => 'Coupon applied successfully!',
        ]);
    }
}
