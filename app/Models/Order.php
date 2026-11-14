<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'recipient_name',
        'phone',
        'address',
        'shipping_method',
        'shipping_cost',
        'payment_method',
        'payment_channel',
        'snap_redirect_url',
        'qris_transaction_id',
        'qris_image_url',
        'qris_expires_at',
        'status',
        'payment_status',
        'subtotal',
        'total',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return [
            'qris_expires_at' => 'immutable_datetime',
        ];
    }
}
