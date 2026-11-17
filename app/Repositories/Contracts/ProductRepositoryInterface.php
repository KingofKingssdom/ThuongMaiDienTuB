<?php

namespace App\Repositories\Contracts;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface
{
    public function addAsync(array $data): Product;
    public function getAllAsync(): Collection;
    public function getByIdAsync(int $id): ?Product;
    public function getAllByOnPromotion(): Collection;
    public function getAllByIsFeatured(int $categoryId): Collection;
    public function getAllByName(string $productName): Collection;
    public function getAllByCategoryAndBrand(int $categoryId, ?int $brandId = null): Collection;
    public function updateAsync(Product $product, array $data): Product;
}