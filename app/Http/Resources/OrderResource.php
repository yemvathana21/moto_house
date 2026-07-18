<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'order_number' => $this->order_number,
            'status' => $this->status,
            'subtotal' => (float) $this->subtotal,
            'tax' => (float) $this->tax,
            'shipping' => (float) $this->shipping,
            'discount' => (float) $this->discount,
            'total' => (float) $this->total,
            'payment_method' => $this->payment_method,
            'payment_status' => $this->payment_status,
            'coupon_code' => $this->coupon_code,
            'shipping_address' => $this->shipping_address,
            'shipping_city' => $this->shipping_city,
            'shipping_state' => $this->shipping_state,
            'shipping_postal_code' => $this->shipping_postal_code,
            'shipping_country' => $this->shipping_country,
            'notes' => $this->notes,
            'items' => OrderItemResource::collection($this->whenLoaded('items')),
            'timeline' => $this->whenLoaded('statusHistory', function () {
                return $this->statusHistory->map(fn ($h) => [
                    'status' => $h->status,
                    'note' => $h->note,
                    'created_at' => $h->created_at->toDateTimeString(),
                ]);
            }),
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
