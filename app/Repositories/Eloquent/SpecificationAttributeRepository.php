<?php

namespace App\Repositories\Eloquent;

use App\Models\SpecificationAttribute;
use App\Repositories\Contracts\SpecificationAttributeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class SpecificationAttributeRepository implements SpecificationAttributeRepositoryInterface
{
    public function addAsync(array $data): SpecificationAttribute
    {
        return SpecificationAttribute::create($data);
    }

    public function getByIdAsync(int $id): ?SpecificationAttribute
    {
        return SpecificationAttribute::with('specificationValues')->find($id);
    }

    public function getAllAsync(): Collection
    {
        return SpecificationAttribute::all();
    }
}