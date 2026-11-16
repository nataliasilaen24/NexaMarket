<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactMessage extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'subject',
        'body',
        'status',
        'admin_reply',
        'read_at',
        'reply_sent_at',
    ];

    protected function casts(): array
    {
        return [
            'read_at' => 'immutable_datetime',
            'reply_sent_at' => 'immutable_datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
