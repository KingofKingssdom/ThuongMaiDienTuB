<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends Model
{
    protected $table = 'product_variants';

    protected $fillable = [
        'storage',
        'origin_price',
        'current_price',
        'stock',
        'url_product_color',
        'color_name',
        'product_id',
    ];

    // Thuộc về Product
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}