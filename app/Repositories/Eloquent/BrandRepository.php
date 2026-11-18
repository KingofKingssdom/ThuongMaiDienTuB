<?php

namespace App\Repositories\Eloquent;

use App\Models\Brand;
use App\Repositories\Contracts\BrandRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class BrandRepository implements BrandRepositoryInterface
{
    public function addAsync(array $data): Brand
    {
        return Brand::create($data);
    }

    public function getByIdAsync(int $id): ?Brand
    {
        return Brand::with(['categories', 'products'])->find($id);
    }

    public function getAllAsync(): Collection
    {
        return Brand::all();
    }

    public function getByCategoryIdAsync(int $categoryId): Collection
    {
        
        return Brand::whereHas('categories', function ($query) use ($categoryId) {
            $query->where('categories.id', $categoryId);
        })->get();
    }

    public function updateAsync(Brand $brand, array $data): Brand
    {
        $brand->update($data);
        return $brand;
    }
}