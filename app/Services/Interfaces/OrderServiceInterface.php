<?php

namespace App\Services\Interfaces;

interface OrderServiceInterface
{
    public function addAsync(int $userId, array $request): mixed;
    public function GetAllByUserIdAsync(int $userId): mixed;
}