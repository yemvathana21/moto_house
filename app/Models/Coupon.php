<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coupon extends Model
{
    protected $fillable = [
        'code', 'type', 'value', 'min_order_amount', 'description',
        'max_uses', 'used_count', 'starts_at', 'expires_at', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'decimal:2',
            'min_order_amount' => 'decimal:2',
            'max_uses' => 'integer',
            'used_count' => 'integer',
            'starts_at' => 'datetime',
            'expires_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    public function isValid(): bool
    {
        if (!$this->is_active) return false;
        if ($this->max_uses && $this->used_count >= $this->max_uses) return false;
        if ($this->starts_at && Carbon::now()->lt($this->starts_at)) return false;
        if ($this->expires_at && Carbon::now()->gt($this->expires_at)) return false;
        return true;
    }

    public function apply(float $subtotal): float
    {
        if ($this->min_order_amount && $subtotal < $this->min_order_amount) {
            return 0;
        }
        if ($this->type === 'percentage') {
            return round($subtotal * $this->value / 100, 2);
        }
        return min($this->value, $subtotal);
    }

    public function markUsed(): void
    {
        $this->increment('used_count');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function collectedBy(): HasMany
    {
        return $this->hasMany(CustomerVoucher::class);
    }

    public function discountLabel(): string
    {
        return $this->type === 'percentage'
            ? number_format($this->value, 0) . '% OFF'
            : '$' . number_format($this->value, 2) . ' OFF';
    }
}
