<?php

namespace App\Repositories\Contracts;

use App\Models\CartItem;
use Illuminate\Database\Eloquent\Collection;

interface CartItemRepositoryInterface
{
    public function addAsync(array $data): CartItem;
    public function findCartItemExisting(int $productVariantId, int $cartId): ?CartItem;
    public function updateAsync(CartItem $cartItem, array $data): CartItem;
    public function getAllByCartIdAsync(int $cartId): Collection;
    public function updatePriceAtTimeAsync(): void;
    public function getAllCartItemByIdsAsync(array $cartItemIds, int $cartId): Collection;
    public function deleteCartItemByIdsAsync(array $cartItemIds): void;
}