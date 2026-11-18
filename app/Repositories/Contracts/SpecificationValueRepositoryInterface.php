<?php

namespace App\Repositories\Contracts;

use App\Models\SpecificationValue;
use Illuminate\Database\Eloquent\Collection;

interface SpecificationValueRepositoryInterface
{
    public function addAsync(array $data): SpecificationValue;
    public function getByIdAsync(int $id): ?SpecificationValue;
    public function getAllAsync(): Collection;
}