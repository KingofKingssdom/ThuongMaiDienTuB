<?php

namespace App\Services\Implementations;

use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Services\Interfaces\RoleServiceInterface;
use App\Http\Resources\RoleResource;

class RoleService implements RoleServiceInterface
{
    protected RoleRepositoryInterface $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function addAsync(array $request): ?RoleResource
    {
        if ($this->roleRepository->existsByName($request['name'])) {
            return null;
        }

        $role = $this->roleRepository->addAsync([
            'name' => $request['name']
        ]);

        return new RoleResource($role);
    }

    public function getAllAsync(): mixed
    {
        $roles = $this->roleRepository->getAllAsync();

        if ($roles->isEmpty()) {
            return null;
        }

        // Trả về Collection resource (tự động map toàn bộ danh sách role)
        return RoleResource::collection($roles);
    }

    public function getByIdAsync(int $id): ?RoleResource
    {
        $role = $this->roleRepository->getByIdAsync($id);

        if (!$role) {
            return null;
        }

        return new RoleResource($role);
    }

    public function getByNameAsync(string $name): ?RoleResource
    {
        $role = $this->roleRepository->getByNameAsync($name);

        if (!$role) {
            return null;
        }

        return new RoleResource($role);
    }
}