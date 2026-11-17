<?php

namespace App\Services\Interfaces;

use App\Http\Resources\UserResource;

interface UserServiceInterface
{
    public function getByIdAsync(int $id): ?UserResource;
    public function deleteAsync(int $userId): ?UserResource;
}