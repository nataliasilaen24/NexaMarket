<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'is_promo',
        'promo_price',
        'stock',
    ];

    protected function casts(): array
    {
        return [
            'is_promo' => 'boolean',
            'promo_price' => 'decimal:2',
        ];
    }

    public function getEffectivePriceAttribute(): string
    {
        if (
            $this->is_promo
            && $this->promo_price !== null
            && (float) $this->promo_price < (float) $this->price
        ) {
            return $this->promo_price;
        }

        return (string) $this->price;
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
