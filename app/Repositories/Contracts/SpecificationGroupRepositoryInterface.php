<?php

namespace App\Repositories\Contracts;

use App\Models\SpecificationGroup;
use Illuminate\Database\Eloquent\Collection;

interface SpecificationGroupRepositoryInterface
{
    public function addAsync(array $data): SpecificationGroup;
    public function getById(int $id): ?SpecificationGroup;
    public function getAllAsync(): Collection;
}