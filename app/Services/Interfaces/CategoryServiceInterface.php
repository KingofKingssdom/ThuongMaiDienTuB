<?php

namespace App\Services\Interfaces;

interface CategoryServiceInterface
{
    public function addAsync(array $request): mixed;
    public function getAllAsync(): mixed;
    public function getByIdAsync(int $id): mixed;
    public function updateAsync(int $id, array $request): mixed;
    public function deleteAsync(int $id): mixed;
}