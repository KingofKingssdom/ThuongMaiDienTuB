<?php

namespace App\Repositories\Contracts;

use App\Models\Cart;

interface CartRepositoryInterface
{
    public function addAsync(array $data): Cart;
    public function getByUserId(int $userId): ?Cart;
}