<?php

namespace App\Services\Implementations;

use App\Repositories\Contracts\ProductVariantRepositoryInterface;
use App\Services\Interfaces\ProductVariantServiceInterface;
use App\Helpers\ImageStorageUtil;
use App\Http\Resources\ProductVariantResource;
use Carbon\Carbon;

class ProductVariantService implements ProductVariantServiceInterface
{
    protected ProductVariantRepositoryInterface $productVariantRepository;

    public function __construct(ProductVariantRepositoryInterface $productVariantRepository)
    {
        $this->productVariantRepository = $productVariantRepository;
    }

    public function addAsync(array $request): ?ProductVariantResource
    {
        $productVariantImage = null;
        if (isset($request['UrlProductColor']) && $request['UrlProductColor'] instanceof \Illuminate\Http\UploadedFile) {
            $productVariantImage = ImageStorageUtil::uploadImage($request['UrlProductColor'], 'ProductVariant');
        }

        $productVariant = $this->productVariantRepository->addAsync([
            'storage'           => $request['Storage'] ?? '',
            'color_name'        => $request['ColorName'] ?? '',
            'current_price'     => $request['CurrentPrice'] ?? 0,
            'origin_price'      => $request['OriginPrice'] ?? 0,
            'stock'             => $request['Stock'] ?? 0,
            'url_product_color' => $productVariantImage ?? '',
            'product_id'        => $request['ProductId'] ?? 0,
        ]);

        return new ProductVariantResource($productVariant->load('product'));
    }

    public function getByIdAsync(int $id): ?ProductVariantResource
    {
        $productExisting = $this->productVariantRepository->getByIdAsync($id);
        if (!$productExisting) {
            return null;
        }

        return new ProductVariantResource($productExisting);
    }

    public function getAllAsync(): mixed
    {
        $productVariants = $this->productVariantRepository->getAllAsync();
        if ($productVariants->isEmpty()) {
            return null;
        }

        return ProductVariantResource::collection($productVariants->load('product'));
    }

    public function updateAsync(int $id, array $request): ?ProductVariantResource
    {
        $productExisting = $this->productVariantRepository->getByIdAsync($id);
        if (!$productExisting) {
            return null;
        }

        $data = [
            'color_name'    => $request['ColorName'] ?? $productExisting->color_name,
            'current_price' => $request['CurrentPrice'] ?? $productExisting->current_price,
            'origin_price'  => $request['OriginPrice'] ?? $productExisting->origin_price,
            'stock'         => $request['Stock'] ?? $productExisting->stock,
            'storage'       => $request['Storage'] ?? $productExisting->storage,
        ];

        // Xử lý cập nhật ảnh biến thể và xóa ảnh cũ
        if (isset($request['UrlProductColor']) && $request['UrlProductColor'] instanceof \Illuminate\Http\UploadedFile) {
            $oldImagePath = $productExisting->url_product_color;
            $newImageVariant = ImageStorageUtil::uploadImage($request['UrlProductColor'], 'ProductVariant');

            $data['url_product_color'] = $newImageVariant;

            if (!empty($oldImagePath)) {
                ImageStorageUtil::deleteImage($oldImagePath);
            }
        }

        $updatedVariant = $this->productVariantRepository->updateAsync($productExisting, $data);

        return new ProductVariantResource($updatedVariant->load('product'));
    }

    public function deleteAsync(int $id): ?ProductVariantResource
    {
        $productExisting = $this->productVariantRepository->getByIdAsync($id);
        if (!$productExisting) {
            return null;
        }

        // Xóa mềm bằng cách cập nhật deleted_at
        $updatedVariant = $this->productVariantRepository->updateAsync($productExisting, [
            'deleted_at' => Carbon::now()
        ]);

        return new ProductVariantResource($updatedVariant->load('product'));
    }

    public function getByProductIdAsync(int $productId): mixed
    {
        $productVariants = $this->productVariantRepository->getByProductId($productId);
        if ($productVariants->isEmpty()) {
            return null;
        }

        return ProductVariantResource::collection($productVariants->load('product'));
    }
}