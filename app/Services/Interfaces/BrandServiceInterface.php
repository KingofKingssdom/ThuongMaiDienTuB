<?php

namespace App\Services\Interfaces;

use App\Http\Resources\BrandResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface BrandServiceInterface
{
    public function addAsync(array $request): ?BrandResource;
    public function getByIdAsync(int $id): ?BrandResource;
    public function getAllAsync(): mixed;
    public function GetAllByCategoryId(int $categoryId): mixed;
    public function updateAsync(int $id, array $request): ?BrandResource;
    public function deleteAsync(int $id): ?BrandResource;
}