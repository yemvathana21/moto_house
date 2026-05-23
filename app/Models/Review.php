<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Review extends Model
{
    protected $fillable = [
        'product_id', 'customer_name', 'customer_email',
        'rating', 'comment', 'is_approved', 'parent_id',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'is_approved' => 'boolean',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Review::class, 'parent_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Review::class, 'parent_id');
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopeParentOnly($query)
    {
        return $query->whereNull('parent_id');
    }
}
