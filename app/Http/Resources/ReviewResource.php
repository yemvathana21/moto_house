<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'customer_name' => $this->customer?->name ?? $this->customer_name,
            'replies' => ReviewResource::collection($this->whenLoaded('replies')),
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
