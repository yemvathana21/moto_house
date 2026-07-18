<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\CustomerVoucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index()
    {
        $coupons = Coupon::where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('starts_at')->orWhere('starts_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>=', now());
            })
            ->where(function ($q) {
                $q->whereNull('max_uses')->orWhereRaw('used_count < max_uses');
            })
            ->orderByDesc('created_at')
            ->get()
            ->map(fn ($c) => [
                'id' => $c->id,
                'code' => $c->code,
                'type' => $c->type,
                'value' => (float) $c->value,
                'description' => $c->description,
                'min_order_amount' => $c->min_order_amount ? (float) $c->min_order_amount : null,
                'discount_label' => $c->discountLabel(),
                'expires_at' => $c->expires_at?->toDateTimeString(),
            ]);

        return response()->json(['vouchers' => $coupons]);
    }

    public function collect(Request $request)
    {
        $data = $request->validate([
            'coupon_id' => 'required|exists:coupons,id',
        ]);

        $coupon = Coupon::find($data['coupon_id']);

        if (!$coupon->isValid()) {
            return response()->json(['message' => 'This voucher is no longer available.'], 422);
        }

        $exists = CustomerVoucher::where('customer_id', $request->user()->id)
            ->where('coupon_id', $coupon->id)
            ->first();

        if ($exists) {
            return response()->json(['message' => 'You already have this voucher.'], 422);
        }

        CustomerVoucher::create([
            'customer_id' => $request->user()->id,
            'coupon_id' => $coupon->id,
        ]);

        return response()->json(['message' => 'Voucher collected!']);
    }

    public function myVouchers(Request $request)
    {
        $vouchers = CustomerVoucher::where('customer_id', $request->user()->id)
            ->with('coupon')
            ->orderByDesc('created_at')
            ->get()
            ->filter(fn ($cv) => $cv->coupon && $cv->coupon->isValid())
            ->map(fn ($cv) => [
                'id' => $cv->id,
                'coupon_id' => $cv->coupon_id,
                'code' => $cv->coupon->code,
                'type' => $cv->coupon->type,
                'value' => (float) $cv->coupon->value,
                'description' => $cv->coupon->description,
                'min_order_amount' => $cv->coupon->min_order_amount ? (float) $cv->coupon->min_order_amount : null,
                'discount_label' => $cv->coupon->discountLabel(),
                'expires_at' => $cv->coupon->expires_at?->toDateTimeString(),
                'is_used' => $cv->is_used,
            ]);

        return response()->json(['vouchers' => $vouchers]);
    }
}
