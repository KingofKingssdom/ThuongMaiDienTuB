<?php

namespace App\Repositories\Contracts;

use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Collection;

interface ProductVariantRepositoryInterface
{
    public function addAsync(array $data): ProductVariant;
    public function getByIdAsync(int $id): ?ProductVariant;
    public function getAllAsync(): Collection;
    public function updateStockAsync(): void;
    public function updateAsync(ProductVariant $productVariant, array $data): ProductVariant;
    public function getByProductId(int $productId): Collection;
}