<?php

namespace App\Repositories\Eloquent;

use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class OrderRepository implements OrderRepositoryInterface
{
    public function addAsync(array $data): Order
    {
        // Trong Laravel, Order::create tự động lưu vào database và trả về instance kèm id
        return Order::create($data);
    }

    public function getAllOrderByUserId(int $userId): Collection
    {
        // Eager loading các quan hệ tương đương với .Include().ThenInclude() bên C#
        return Order::where('user_id', $userId)
            ->with(['orderItems.productVariant'])
            ->get();
    }
}