<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    public function addAsync(array $data): Product
    {
        return Product::create($data);
    }

    public function getAllAsync(): Collection
    {
        return Product::with(['brand', 'category', 'productVariants'])->get();
    }

    public function getByIdAsync(int $id): ?Product
    {
        return Product::with(['brand', 'category', 'productVariants'])->find($id);
    }

    public function getAllByOnPromotion(): Collection
    {
        return Product::where('is_on_promotion', true)
            ->with(['brand', 'category', 'productVariants'])
            ->get();
    }

    public function getAllByIsFeatured(int $categoryId): Collection
    {
        $query = Product::where('is_featured', true)
            ->with(['brand', 'category', 'productVariants']);

        if ($categoryId > 0) {
            $query->where('category_id', $categoryId);
        }

        return $query->get();
    }

    public function getAllByName(string $productName): Collection
    {
        return Product::where('product_name', 'LIKE', "%{$productName}%")
            ->with(['brand', 'category', 'productVariants'])
            ->get();
    }

    public function getAllByCategoryAndBrand(int $categoryId, ?int $brandId = null): Collection
    {
        $query = Product::where('category_id', $categoryId)
            ->with(['brand', 'category', 'productVariants']);

        if (!empty($brandId)) {
            $query->where('brand_id', $brandId);
        }

        return $query->get();
    }

    public function updateAsync(Product $product, array $data): Product
    {
        $product->update($data);
        return $product;
    }
}