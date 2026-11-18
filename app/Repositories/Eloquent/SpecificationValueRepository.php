<?php

namespace App\Repositories\Eloquent;

use App\Models\SpecificationValue;
use App\Repositories\Contracts\SpecificationValueRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class SpecificationValueRepository implements SpecificationValueRepositoryInterface
{
    public function addAsync(array $data): SpecificationValue
    {
        return SpecificationValue::create($data);
    }

    public function getByIdAsync(int $id): ?SpecificationValue
    {
        return SpecificationValue::find($id);
    }

    public function getAllAsync(): Collection
    {
        return SpecificationValue::all();
    }
}