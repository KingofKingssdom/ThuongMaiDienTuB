<?php

namespace App\Repositories\Contracts;

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;

interface RoleRepositoryInterface
{
    public function addAsync(array $data): Role;
    public function existsByName(string $name): bool;
    public function getAllAsync(): Collection;
    public function getByIdAsync(int $id): ?Role;
    public function getByNameAsync(string $name): ?Role;
    public function update(int $id, string $name): ?Role;
}