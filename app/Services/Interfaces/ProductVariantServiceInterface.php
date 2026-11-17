<?php

namespace App\Services\Interfaces;

interface ProductVariantServiceInterface
{
    public function addAsync(array $request): mixed;
    public function getByIdAsync(int $id): mixed;
    public function getAllAsync(): mixed;
    public function updateAsync(int $id, array $request): mixed;
    public function deleteAsync(int $id): mixed;
    public function getByProductIdAsync(int $productId): mixed;
}