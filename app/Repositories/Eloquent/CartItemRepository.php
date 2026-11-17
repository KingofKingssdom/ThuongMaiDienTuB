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
        // Tương đương .Include(c => c.ProductVariant).ThenInclude(p => p.Product)
        return CartItem::where('cart_id', $cartId)
            ->with(['productVariant.product'])
            ->get();
    }

    public function updatePriceAtTimeAsync(): void
    {
        // Trong Eloquent các thao tác update được lưu thẳng khi gọi save/update,
        // hàm này giữ lại để tương thích kiến trúc.
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
        // Tương đương với .ExecuteDeleteAsync() của EF Core
        CartItem::whereIn('id', $cartItemIds)->delete();
    }
}