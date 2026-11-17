<?php

namespace App\Services\Implementations;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Interfaces\UserServiceInterface;
use App\Http\Resources\UserResource;

class UserService implements UserServiceInterface
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getByIdAsync(int $id): ?UserResource
    {
        $user = $this->userRepository->getByIdAsync($id);

        if (!$user) {
            return null;
        }

        return new UserResource($user);
    }

    public function deleteAsync(int $userId): ?UserResource
    {
        $deleted = $this->userRepository->deleteAsync($userId);

        if (!$deleted) {
            return null;
        }

        $user = $this->userRepository->getByIdAsync($userId);

        return new UserResource($user);
    }
}