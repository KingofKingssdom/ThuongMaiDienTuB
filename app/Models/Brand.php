<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Brand extends Model
{
    protected $table = 'brands';

    protected $fillable = [
        'brand_name',
        'url_image_brand',
    ];

    // Quan hệ nhiều - nhiều với Category thông qua bảng trung gian category_brands
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_brands', 'brand_id', 'category_id');
    }

    // Quan hệ một - nhiều với Product
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'brand_id');
    }
}