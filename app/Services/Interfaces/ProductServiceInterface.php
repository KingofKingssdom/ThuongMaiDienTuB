<?php

namespace App\Services\Interfaces;

interface ProductServiceInterface
{
    public function addAsync(array $request): mixed;
    public function getByIdAsync(int $id): mixed;
    public function getAllAsync(): mixed;
    public function getAllByIsOnPromotion(): mixed;
    public function getAllIsFeatured(int $categoryId): mixed;
    public function getAllByNameAsync(string $productName): mixed;
    public function GetAllByCategoryIdAndBrandId(int $categoryId, ?int $brandId): mixed;
    public function updateAsync(int $id, array $request): mixed;
    public function deleteAsync(int $id): mixed;
}