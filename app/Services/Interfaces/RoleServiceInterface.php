<?php

namespace App\Services\Interfaces;

use App\Http\Resources\RoleResource;

interface RoleServiceInterface
{
    public function addAsync(array $request): ?RoleResource;
    public function getAllAsync(): mixed;
    public function getByIdAsync(int $id): ?RoleResource;
    public function getByNameAsync(string $name): ?RoleResource;
}