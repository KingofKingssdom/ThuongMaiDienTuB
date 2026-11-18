<?php

namespace App\Services\Implementations;

use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Services\Interfaces\CategoryServiceInterface;
use App\Http\Resources\CategoryResource;
use Carbon\Carbon;

class CategoryService implements CategoryServiceInterface
{
    protected CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function addAsync(array $request): ?CategoryResource
    {
        $category = $this->categoryRepository->addCategoryAsync([
            'category_name' => $request['CategoryName'] ?? $request['category_name'] ?? ''
        ]);

        return new CategoryResource($category);
    }

    public function getAllAsync(): mixed
    {
        $categoriesExisting = $this->categoryRepository->getAllCategories();

        if ($categoriesExisting->isEmpty()) {
            return null;
        }

        return CategoryResource::collection($categoriesExisting);
    }

    public function getByIdAsync(int $id): ?CategoryResource
    {
        $categoryExisting = $this->categoryRepository->getById($id);

        if (!$categoryExisting) {
            return null;
        }

        return new CategoryResource($categoryExisting);
    }

    public function updateAsync(int $id, array $request): ?CategoryResource
    {
        $categoryExisting = $this->categoryRepository->getById($id);

        if (!$categoryExisting) {
            return null;
        }

        $updatedCategory = $this->categoryRepository->updateAsync($categoryExisting, [
            'category_name' => $request['CategoryName'] ?? $request['category_name'] ?? $categoryExisting->category_name
        ]);

        return new CategoryResource($updatedCategory);
    }

    public function deleteAsync(int $id): ?CategoryResource
    {
        $categoryExisting = $this->categoryRepository->getById($id);

        if (!$categoryExisting) {
            return null;
        }

        
        $this->categoryRepository->updateAsync($categoryExisting, [
            'deleted_at' => Carbon::now()
        ]);

        return new CategoryResource($categoryExisting);
    }
}