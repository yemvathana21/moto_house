<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'price', 'compare_price',
        'stock_quantity', 'sku', 'category_id', 'images',
        'is_active', 'is_featured', 'brand', 'specifications',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'compare_price' => 'decimal:2',
            'images' => 'array',
            'specifications' => 'array',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'stock_quantity' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function avgRating(): float
    {
        return round($this->reviews()->approved()->parentOnly()->avg('rating') ?? 0, 1);
    }

    public function ratingDistribution(): array
    {
        $counts = $this->reviews()->approved()->parentOnly()
            ->selectRaw('rating, count(*) as count')
            ->groupBy('rating')
            ->pluck('count', 'rating')
            ->toArray();

        $total = array_sum($counts);
        $distribution = [];
        for ($i = 5; $i >= 1; $i--) {
            $distribution[$i] = [
                'count' => $counts[$i] ?? 0,
                'percentage' => $total > 0 ? round((($counts[$i] ?? 0) / $total) * 100, 1) : 0,
            ];
        }

        return [
            'average' => $this->avgRating(),
            'total' => $total,
            'distribution' => $distribution,
        ];
    }

    public function isInStock(): bool
    {
        return $this->stock_quantity > 0;
    }

    public function getFinalPriceAttribute(): float
    {
        return $this->compare_price ? (float) $this->compare_price : (float) $this->price;
    }
}
