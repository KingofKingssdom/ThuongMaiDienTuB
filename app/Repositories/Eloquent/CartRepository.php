<?php

namespace App\Repositories\Eloquent;

use App\Models\Cart;
use App\Repositories\Contracts\CartRepositoryInterface;

class CartRepository implements CartRepositoryInterface
{
    public function addAsync(array $data): Cart
    {
        return Cart::create($data);
    }

    public function getByUserId(int $userId): ?Cart
    {
        return Cart::where('user_id', $userId)->first();
    }
}