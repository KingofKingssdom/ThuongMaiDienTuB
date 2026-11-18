<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SpecificationGroup extends Model
{
    protected $table = 'specification_groups';

    protected $fillable = [
        'specification_name',
        'category_id',
    ];

    // Quan hệ thuộc về Category
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Quan hệ 1 - nhiều với SpecificationAttribute
    public function specificationAttributes(): HasMany
    {
        return $this->hasMany(SpecificationAttribute::class, 'specification_group_id');
    }
}