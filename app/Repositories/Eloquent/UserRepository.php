<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Models\Role;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    public function getAllAsync(): Collection
    {
        // Tương đương với .Include(u => u.UserRoles).ThenInclude(ur => ur.Role)
        return User::with('roles')->get();
    }

    public function getByIdAsync(int $id): ?User
    {
        return User::find($id);
    }

    public function getByEmailAsync(string $email): ?User
    {
        return User::with('roles')->where('email', $email)->first();
    }

    public function existsByEmailAsync(string $email): bool
    {
        return User::where('email', $email)->exists();
    }

    public function addAsync(array $data): User
    {
        // Tạo mới user
        $user = User::create($data);

        // Logic gắn role mặc định là 'USER' giống code C# của bạn
        $role = Role::where('name', 'USER')->first();
        if ($role) {
            // Sử dụng quan hệ belongsToMany (attach) để thêm vào bảng trung gian role_user
            $user->roles()->attach($role->id);
        }

        return $user;
    }

    public function update(User $user, array $data): User
    {
        $user->update($data);
        return $user;
    }

    public function updateUserRoleAsync(int $userId, int $roleId): void
    {
        $user = User::find($userId);
        if ($user) {
            // sync() sẽ xóa các role cũ và gán role mới duy nhất này (tương đương xóa rồi thêm mới trong C#)
            $user->roles()->sync([$roleId]);
        }
    }

    public function deleteAsync(int $userId): bool
    {
        $user = User::find($userId);
        if ($user) {
            // Thay vì xóa cứng, cập nhật IsActive = false hoặc dùng SoftDelete
            $user->IsActive = false;
            $user->save();
            
            // Hoặc nếu bạn muốn dùng soft delete chuẩn Laravel: $user->delete();
            return true;
        }
        return false;
    }

    public function getByIdWithRolesAsync(int $id): ?User
    {
        return User::with('roles')->find($id);
    }
}