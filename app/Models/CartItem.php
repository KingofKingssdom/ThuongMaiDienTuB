<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $table = 'cart_items';

    protected $fillable = [
        'cart_id',
        'product_variant_id',
        'quantity',
        'price_at_time',
        'total_price',
    ];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    public function productVariant(): BelongsTo
    {
        // Giả sử bạn có model ProductVariant
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }
}