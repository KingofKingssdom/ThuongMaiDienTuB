<?php

namespace App\Repositories\Eloquent;

use App\Models\ProductVariant;
use App\Repositories\Contracts\ProductVariantRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ProductVariantRepository implements ProductVariantRepositoryInterface
{
    public function addAsync(array $data): ProductVariant
    {
        return ProductVariant::create($data);
    }

    public function getByIdAsync(int $id): ?ProductVariant
    {
        return ProductVariant::with(['product.brand', 'product.category'])->find($id);
    }

    public function getAllAsync(): Collection
    {
        return ProductVariant::with(['product'])->get();
    }

    public function updateStockAsync(): void
    {
    
    }

    public function updateAsync(ProductVariant $productVariant, array $data): ProductVariant
    {
        $productVariant->update($data);
        return $productVariant;
    }

    public function getByProductId(int $productId): Collection
    {
        return ProductVariant::where('product_id', $productId)->get();
    }
}