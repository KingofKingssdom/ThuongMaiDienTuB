<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function addCategoryAsync(array $data): Category
    {
        return Category::create($data);
    }

    public function getAllCategories(): Collection
    {
        return Category::all();
    }

    public function getById(int $id): ?Category
    {
        return Category::with(['brands', 'products'])->find($id);
    }

    public function updateAsync(Category $category, array $data): Category
    {
        $category->update($data);
        return $category;
    }
}