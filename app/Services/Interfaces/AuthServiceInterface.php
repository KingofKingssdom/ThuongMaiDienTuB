<?php

namespace App\Services\Interfaces;

use App\Http\Resources\UserResource;

interface AuthServiceInterface
{
    public function registerAsync(array $request): ?UserResource;
    public function loginAsync(array $request): ?array;
    public function refreshTokenAsync(array $request): ?array;
    public function logoutAsync(array $request): bool;
}