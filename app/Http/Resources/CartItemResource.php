<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'product_id' => $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
            'price' => (float) $this->price,
            'final_price' => $this->final_price,
            'image' => $this->images[0] ?? null,
            'quantity' => $this->pivot?->quantity ?? 1,
            'in_stock' => $this->isInStock(),
            'stock_quantity' => $this->stock_quantity,
        ];
    }
}
