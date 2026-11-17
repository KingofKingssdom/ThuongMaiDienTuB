<?php

namespace App\Repositories\Contracts;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Collection;

interface BrandRepositoryInterface
{
    public function addAsync(array $data): Brand;
    public function getByIdAsync(int $id): ?Brand;
    public function getAllAsync(): Collection;
    public function getByCategoryIdAsync(int $categoryId): Collection;
    public function updateAsync(Brand $brand, array $data): Brand;
}