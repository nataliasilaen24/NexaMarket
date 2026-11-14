<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'recipient_name',
        'phone',
        'address',
        'shipping_method',
        'shipping_cost',
        'payment_method',
        'payment_channel',
        'status',
        'payment_status',
        'subtotal',
        'total',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
