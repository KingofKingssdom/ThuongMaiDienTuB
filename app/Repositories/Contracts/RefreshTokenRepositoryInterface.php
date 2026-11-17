<?php

namespace App\Repositories\Contracts;

use App\Models\RefreshToken;
use Illuminate\Database\Eloquent\Collection;

interface RefreshTokenRepositoryInterface
{
    public function getValidAsync(string $token): ?RefreshToken;
    public function addAsync(array $data): RefreshToken;
    public function getByUserIdAsync(int $userId): Collection;
    public function update(RefreshToken $refreshToken, array $data): bool;
    public function delete(RefreshToken $refreshToken): bool;
}