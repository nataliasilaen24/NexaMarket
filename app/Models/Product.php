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
        'image',
        'is_promo',
        'promo_price',
        'stock',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_promo' => 'boolean',
            'promo_price' => 'decimal:2',
            'is_active' => 'boolean',
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

    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image) {
            return null;
        }

        $imagePath = ltrim($this->image, '/');
        $isPublicAsset = str_starts_with($imagePath, 'images/');
        $path = $isPublicAsset ? $imagePath : 'storage/'.$imagePath;
        $encodedPath = implode('/', array_map('rawurlencode', explode('/', $path)));

        return asset($encodedPath);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
