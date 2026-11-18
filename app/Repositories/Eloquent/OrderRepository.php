<?php

namespace App\Repositories\Eloquent;

use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class OrderRepository implements OrderRepositoryInterface
{
    public function addAsync(array $data): Order
    {
        
        return Order::create($data);
    }

    public function getAllOrderByUserId(int $userId): Collection
    {
       
        return Order::where('user_id', $userId)
            ->with(['orderItems.productVariant'])
            ->get();
    }
}