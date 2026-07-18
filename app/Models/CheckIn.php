<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CheckIn extends Model
{
    protected $fillable = ['customer_id', 'check_in_date', 'streak', 'points'];

    protected function casts(): array
    {
        return [
            'check_in_date' => 'date',
            'streak' => 'integer',
            'points' => 'integer',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
