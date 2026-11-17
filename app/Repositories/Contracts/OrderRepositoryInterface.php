<?php

namespace App\Repositories\Contracts;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

interface OrderRepositoryInterface
{
    public function addAsync(array $data): Order;
    public function getAllOrderByUserId(int $userId): Collection;
}