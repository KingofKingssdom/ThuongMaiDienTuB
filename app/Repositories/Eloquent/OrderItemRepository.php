<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\OrderItemRepositoryInterface;

class OrderItemRepository implements OrderItemRepositoryInterface
{
    public function addAsync(): void
    {
        // Trong Laravel Eloquent các thao tác lưu/cập nhật được thực thi trực tiếp qua Model,
        // hàm này giữ lại trống để đồng bộ kiến trúc với C# SaveChangesAsync().
    }
}