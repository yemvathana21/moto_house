<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => (float) $this->price,
            'compare_price' => (float) $this->compare_price,
            'final_price' => $this->final_price,
            'stock_quantity' => $this->stock_quantity,
            'in_stock' => $this->isInStock(),
            'sku' => $this->sku,
            'brand' => $this->brand,
            'images' => $this->images ?? [],
            'specifications' => $this->specifications ?? [],
            'is_featured' => $this->is_featured,
            'avg_rating' => $this->avgRating(),
            'rating_distribution' => $this->ratingDistribution(),
            'category' => new CategoryResource($this->whenLoaded('category')),
            'reviews' => ReviewResource::collection($this->whenLoaded('reviews')),
            'created_at' => $this->created_at,
        ];
    }
}
