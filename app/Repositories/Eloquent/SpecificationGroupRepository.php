<?php

namespace App\Repositories\Eloquent;

use App\Models\SpecificationGroup;
use App\Repositories\Contracts\SpecificationGroupRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class SpecificationGroupRepository implements SpecificationGroupRepositoryInterface
{
    public function addAsync(array $data): SpecificationGroup
    {
        return SpecificationGroup::create($data);
    }

    public function getById(int $id): ?SpecificationGroup
    {
        return SpecificationGroup::find($id);
    }

    public function getAllAsync(): Collection
    {
        return SpecificationGroup::with('category')->get();
    }
}