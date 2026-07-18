<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FlashDeal;
use Illuminate\Http\Request;

class FlashDealController extends Controller
{
    public function index()
    {
        $now = now();

        $deals = FlashDeal::where('is_active', true)
            ->where('starts_at', '<=', $now)
            ->where('ends_at', '>=', $now)
            ->with(['products' => function ($query) {
                $query->wherePivot('stock_limit', '>', 0)
                    ->whereColumn('flash_deal_products.sold_count', '<', 'flash_deal_products.stock_limit');
            }])
            ->get()
            ->filter(fn ($deal) => $deal->products->isNotEmpty())
            ->values()
            ->map(fn ($deal) => [
                'id' => $deal->id,
                'title' => $deal->title,
                'description' => $deal->description,
                'starts_at' => $deal->starts_at->toDateTimeString(),
                'ends_at' => $deal->ends_at->toDateTimeString(),
                'products' => $deal->products->map(fn ($p) => [
                    'id' => $p->id,
                    'name' => $p->name,
                    'slug' => $p->slug,
                    'image' => $p->images->first()?->image ?? null,
                    'original_price' => (float) $p->price,
                    'flash_price' => (float) $p->pivot->flash_price,
                    'discount_percent' => round((1 - $p->pivot->flash_price / max($p->price, 1)) * 100),
                    'stock_limit' => $p->pivot->stock_limit,
                    'sold_count' => $p->pivot->sold_count,
                    'stock_remaining' => $p->pivot->stock_limit - $p->pivot->sold_count,
                ]),
            ]);

        return response()->json(['flash_deals' => $deals]);
    }
}
