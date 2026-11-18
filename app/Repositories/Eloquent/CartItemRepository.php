<?php

namespace App\Repositories\Eloquent;

use App\Models\CartItem;
use App\Repositories\Contracts\CartItemRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CartItemRepository implements CartItemRepositoryInterface
{
    public function addAsync(array $data): CartItem
    {
        return CartItem::create($data);
    }

    public function findCartItemExisting(int $productVariantId, int $cartId): ?CartItem
    {
        return CartItem::where('product_variant_id', $productVariantId)
            ->where('cart_id', $cartId)
            ->first();
    }

    public function updateAsync(CartItem $cartItem, array $data): CartItem
    {
        $cartItem->update($data);
        return $cartItem;
    }

    public function getAllByCartIdAsync(int $cartId): Collection
    {
        
        return CartItem::where('cart_id', $cartId)
            ->with(['productVariant.product'])
            ->get();
    }

    public function updatePriceAtTimeAsync(): void
    {
        
    }

    public function getAllCartItemByIdsAsync(array $cartItemIds, int $cartId): Collection
    {
        return CartItem::whereIn('id', $cartItemIds)
            ->where('cart_id', $cartId)
            ->with(['productVariant.product'])
            ->get();
    }

    public function deleteCartItemByIdsAsync(array $cartItemIds): void
    {
       
        CartItem::whereIn('id', $cartItemIds)->delete();
    }
}