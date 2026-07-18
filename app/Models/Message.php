<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $fillable = ['conversation_id', 'sender_type', 'sender_id', 'message', 'read_at'];

    protected function casts(): array
    {
        return [
            'read_at' => 'datetime',
        ];
    }

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender()
    {
        return $this->morphTo();
    }

    public function isFromCustomer(): bool
    {
        return $this->sender_type === Customer::class;
    }

    public function isFromAdmin(): bool
    {
        return $this->sender_type === User::class;
    }
}
