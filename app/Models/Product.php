<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'product_name',
        'description',
        'url_image_product',
        'is_featured',
        'is_on_promotion',
        'brand_id',
        'category_id',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_on_promotion' => 'boolean',
    ];

    // Thuộc về Brand
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    // Thuộc về Category
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Có nhiều ProductVariant
    public function productVariants(): HasMany
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }
}