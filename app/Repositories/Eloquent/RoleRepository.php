<?php

namespace App\Repositories\Eloquent;

use App\Models\Role;
use App\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class RoleRepository implements RoleRepositoryInterface
{
    public function addAsync(array $data): Role
    {
        // Eloquent tự động tạo và lưu record vào database
        return Role::create($data);
    }

    public function existsByName(string $name): bool
    {
        return Role::where('name', $name)->exists();
    }

    public function getAllAsync(): Collection
    {
        return Role::all();
    }

    public function getByIdAsync(int $id): ?Role
    {
        return Role::find($id);
    }

    public function getByNameAsync(string $name): ?Role
    {
        
        return Role::where('name', $name)->first();
    }

    public function update(int $id, string $name): ?Role
    {
        $roleExisting = Role::find($id);
        if ($roleExisting) {
            $roleExisting->name = $name;
            $roleExisting->save();
        }
        return $roleExisting;
    }
}