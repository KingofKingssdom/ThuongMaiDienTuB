<?php

namespace App\Services\Implementations;

use App\Repositories\Contracts\BrandRepositoryInterface;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Services\Interfaces\BrandServiceInterface;
use App\Helpers\ImageStorageUtil;
use App\Http\Resources\BrandResource;
use Carbon\Carbon;

class BrandService implements BrandServiceInterface
{
    protected BrandRepositoryInterface $brandRepository;
    protected CategoryRepositoryInterface $categoryRepository;

    public function __construct(
        BrandRepositoryInterface $brandRepository,
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->brandRepository = $brandRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function addAsync(array $request): ?BrandResource
    {
        // Upload ảnh thương hiệu nếu có
        $imageBrand = null;
        if (isset($request['UrlImageBrand']) && $request['UrlImageBrand'] instanceof \Illuminate\Http\UploadedFile) {
            $imageBrand = ImageStorageUtil::uploadImage($request['UrlImageBrand'], 'Brands');
        }

        $brand = $this->brandRepository->addAsync([
            'brand_name' => $request['BrandName'] ?? '',
            'url_image_brand' => $imageBrand,
        ]);

        // Đính kèm các Category liên quan thông qua bảng trung gian category_brands
        if (!empty($request['CategoryIds']) && is_array($request['CategoryIds'])) {
            $brand->categories()->attach($request['CategoryIds']);
        }

        return new BrandResource($brand->load('categories'));
    }

    public function getByIdAsync(int $id): ?BrandResource
    {
        $brandExisting = $this->brandRepository->getByIdAsync($id);
        if (!$brandExisting) {
            return null;
        }

        return new BrandResource($brandExisting);
    }

    public function getAllAsync(): mixed
    {
        $brands = $this->brandRepository->getAllAsync();
        if ($brands->isEmpty()) {
            return null;
        }

        return BrandResource::collection($brands->load('categories'));
    }

    public function GetAllByCategoryId(int $categoryId): mixed
    {
        $brands = $this->brandRepository->getByCategoryIdAsync($categoryId);
        if ($brands->isEmpty()) {
            return null;
        }

        return BrandResource::collection($brands->load('categories'));
    }

    public function updateAsync(int $id, array $request): ?BrandResource
    {
        $brandExisting = $this->brandRepository->getByIdAsync($id);
        if (!$brandExisting) {
            return null;
        }

        $data = [
            'brand_name' => $request['BrandName'] ?? $brandExisting->brand_name,
        ];

        // Xử lý cập nhật ảnh mới và xóa ảnh cũ
        if (isset($request['UrlImageBrand']) && $request['UrlImageBrand'] instanceof \Illuminate\Http\UploadedFile) {
            $oldImagePath = $brandExisting->url_image_brand;
            $newImageBrand = ImageStorageUtil::uploadImage($request['UrlImageBrand'], 'Brands');
            
            $data['url_image_brand'] = $newImageBrand;

            if (!empty($oldImagePath)) {
                ImageStorageUtil::deleteImage($oldImagePath);
            }
        }

        $updatedBrand = $this->brandRepository->updateAsync($brandExisting, $data);

        // Cập nhật lại quan hệ categories nếu có truyền lên
        if (isset($request['CategoryIds']) && is_array($request['CategoryIds'])) {
            $updatedBrand->categories()->sync($request['CategoryIds']);
        }

        return new BrandResource($updatedBrand->load('categories'));
    }

    public function deleteAsync(int $id): ?BrandResource
    {
        $brandExisting = $this->brandRepository->getByIdAsync($id);
        if (!$brandExisting) {
            return null;
        }

        // Nếu database của bạn có cột mềm xóa (deleted_at), hoặc bạn có thể xóa trực tiếp
        $brandExisting->update(['deleted_at' => Carbon::now()]);

        return new BrandResource($brandExisting->load('categories'));
    }
}