<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'category_name',
    ];

    // Quan hệ nhiều - nhiều với Brand
    public function brands(): BelongsToMany
    {
        return $this->belongsToMany(Brand::class, 'category_brands', 'category_id', 'brand_id');
    }

    // Quan hệ một - nhiều với Product
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    // Quan hệ một - nhiều với SpecificationGroup (nếu có)
    public function specificationGroups(): HasMany
    {
        return $this->hasMany(SpecificationGroup::class, 'category_id');
    }
}