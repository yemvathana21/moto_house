<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FlashDeal extends Model
{
    protected $fillable = [
        'title', 'description', 'starts_at', 'ends_at', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'flash_deal_products')
            ->withPivot('flash_price', 'stock_limit', 'sold_count')
            ->withTimestamps();
    }

    public function isActive(): bool
    {
        if (!$this->is_active) return false;
        $now = now();
        return $this->starts_at->lte($now) && $this->ends_at->gte($now);
    }

    public function isUpcoming(): bool
    {
        return $this->is_active && $this->starts_at->gt(now());
    }
}
