<?php

namespace App\Services\Implementations;

use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Services\Interfaces\ProductServiceInterface;
use App\Helpers\ImageStorageUtil;
use App\Http\Resources\ProductResource;
use Carbon\Carbon;

class ProductService implements ProductServiceInterface
{
    protected ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function addAsync(array $request): ?ProductResource
    {
        $imageProduct = null;
        if (isset($request['UrlImageProduct']) && $request['UrlImageProduct'] instanceof \Illuminate\Http\UploadedFile) {
            $imageProduct = ImageStorageUtil::uploadImage($request['UrlImageProduct'], 'Products');
        }

        $product = $this->productRepository->addAsync([
            'product_name'      => $request['ProductName'] ?? '',
            'url_image_product' => $imageProduct ?? '',
            'description'       => $request['Description'] ?? null,
            'is_featured'       => $request['IsFeatured'] ?? false,
            'is_on_promotion'   => $request['IsOnPromotion'] ?? false,
            'brand_id'          => $request['BrandId'] ?? 0,
            'category_id'       => $request['CategoryId'] ?? 0,
        ]);

        return new ProductResource($product->load(['brand', 'category', 'productVariants']));
    }

    public function getByIdAsync(int $id): ?ProductResource
    {
        $productExisting = $this->productRepository->getByIdAsync($id);
        if (!$productExisting) {
            return null;
        }

        return new ProductResource($productExisting);
    }

    public function getAllAsync(): mixed
    {
        $products = $this->productRepository->getAllAsync();
        if ($products->isEmpty()) {
            return null;
        }

        return ProductResource::collection($products);
    }

    public function getAllByIsOnPromotion(): mixed
    {
        $products = $this->productRepository->getAllByOnPromotion();
        if ($products->isEmpty()) {
            return null;
        }

        return ProductResource::collection($products);
    }

    public function getAllIsFeatured(int $categoryId): mixed
    {
        $products = $this->productRepository->getAllByIsFeatured($categoryId);
        if ($products->isEmpty()) {
            return null;
        }

        return ProductResource::collection($products);
    }

    public function getAllByNameAsync(string $productName): mixed
    {
        $products = $this->productRepository->getAllByName($productName);
        if ($products->isEmpty()) {
            return null;
        }

        return ProductResource::collection($products);
    }

    public function GetAllByCategoryIdAndBrandId(int $categoryId, ?int $brandId): mixed
    {
        $products = $this->productRepository->getAllByCategoryAndBrand($categoryId, $brandId);
        if ($products->isEmpty()) {
            return null;
        }

        return ProductResource::collection($products);
    }

    public function updateAsync(int $id, array $request): ?ProductResource
    {
        $productExisting = $this->productRepository->getByIdAsync($id);
        if (!$productExisting) {
            return null;
        }

        $data = [
            'product_name'    => $request['ProductName'] ?? $productExisting->product_name,
            'brand_id'        => $request['BrandId'] ?? $productExisting->brand_id,
            'category_id'     => $request['CategoryId'] ?? $productExisting->category_id,
            'description'     => $request['Description'] ?? $productExisting->description,
            'is_featured'     => $request['IsFeatured'] ?? $productExisting->is_featured,
            'is_on_promotion' => $request['IsOnPromotion'] ?? $productExisting->is_on_promotion,
        ];

        // Xử lý cập nhật hình ảnh
        if (isset($request['UrlImageProduct']) && $request['UrlImageProduct'] instanceof \Illuminate\Http\UploadedFile) {
            $oldImagePath = $productExisting->url_image_product;
            $newImageProduct = ImageStorageUtil::uploadImage($request['UrlImageProduct'], 'Products');

            $data['url_image_product'] = $newImageProduct;

            if (!empty($oldImagePath)) {
                ImageStorageUtil::deleteImage($oldImagePath);
            }
        }

        $updatedProduct = $this->productRepository->updateAsync($productExisting, $data);

        return new ProductResource($updatedProduct->load(['brand', 'category', 'productVariants']));
    }

    public function deleteAsync(int $id): ?ProductResource
    {
        $productExisting = $this->productRepository->getByIdAsync($id);
        if (!$productExisting) {
            return null;
        }

        
        $this->productRepository->updateAsync($productExisting, [
            'deleted_at' => Carbon::now()
        ]);

        return new ProductResource($productExisting->load(['brand', 'category', 'productVariants']));
    }
}