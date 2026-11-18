<?php

namespace App\Repositories\Contracts;

use App\Models\SpecificationAttribute;
use Illuminate\Database\Eloquent\Collection;

interface SpecificationAttributeRepositoryInterface
{
    public function addAsync(array $data): SpecificationAttribute;
    public function getByIdAsync(int $id): ?SpecificationAttribute;
    public function getAllAsync(): Collection;
}