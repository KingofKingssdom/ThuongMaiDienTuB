<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SpecificationAttribute extends Model
{
    protected $table = 'specification_attributes';

    protected $fillable = [
        'label_specification',
        'specification_group_id',
    ];

    // Quan hệ thuộc về SpecificationGroup
    public function specificationGroup(): BelongsTo
    {
        return $this->belongsTo(SpecificationGroup::class, 'specification_group_id');
    }

    // Quan hệ 1 - nhiều với SpecificationValue
    public function specificationValues(): HasMany
    {
        return $this->hasMany(SpecificationValue::class, 'specification_attribute_id');
    }
}