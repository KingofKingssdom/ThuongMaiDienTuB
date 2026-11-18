<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpecificationValue extends Model
{
    protected $table = 'specification_values';

    protected $fillable = [
        'value',
        'product_id',
        'specification_attribute_id',
    ];

    // Quan hệ thuộc về Product
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Quan hệ thuộc về SpecificationAttribute
    public function specificationAttribute(): BelongsTo
    {
        return $this->belongsTo(SpecificationAttribute::class, 'specification_attribute_id');
    }
}