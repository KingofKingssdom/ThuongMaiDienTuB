<?php

namespace App\Repositories\Contracts;

interface OrderItemRepositoryInterface
{
    public function addAsync(): void;
}