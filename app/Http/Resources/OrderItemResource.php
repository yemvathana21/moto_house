<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'product_name' => $this->product?->name,
            'product_image' => $this->product?->images[0] ?? null,
            'quantity' => $this->quantity,
            'price' => (float) $this->price,
            'total' => (float) ($this->price * $this->quantity),
        ];
    }
}
