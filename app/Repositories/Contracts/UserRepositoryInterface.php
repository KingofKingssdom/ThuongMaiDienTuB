<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function getAllAsync(): Collection;
    public function getByIdAsync(int $id): ?User;
    public function getByEmailAsync(string $email): ?User;
    public function existsByEmailAsync(string $email): bool;
    public function addAsync(array $data): User;
    public function update(User $user, array $data): User;
    public function updateUserRoleAsync(int $userId, int $roleId): void;
    public function deleteAsync(int $userId): bool;
    public function getByIdWithRolesAsync(int $id): ?User;
}