<?php

namespace App\Repositories\Contracts;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

interface CategoryRepositoryInterface
{
    public function addCategoryAsync(array $data): Category;
    public function getAllCategories(): Collection;
    public function getById(int $id): ?Category;
    public function updateAsync(Category $category, array $data): Category;
}