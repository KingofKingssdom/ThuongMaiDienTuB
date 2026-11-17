<?php

namespace App\Services\Implementations;

use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\CartRepositoryInterface;
use App\Repositories\Contracts\CartItemRepositoryInterface;
use App\Repositories\Contracts\ProductVariantRepositoryInterface;
use App\Services\Interfaces\OrderServiceInterface;
use App\Http\Resources\OrderResource;
use Illuminate\Support\Facades\DB;
use Exception;

class OrderService implements OrderServiceInterface
{
    protected OrderRepositoryInterface $orderRepository;
    protected CartRepositoryInterface $cartRepository;
    protected CartItemRepositoryInterface $cartItemRepository;
    protected ProductVariantRepositoryInterface $productVariantRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        CartRepositoryInterface $cartRepository,
        CartItemRepositoryInterface $cartItemRepository,
        ProductVariantRepositoryInterface $productVariantRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->cartRepository = $cartRepository;
        $this->cartItemRepository = $cartItemRepository;
        $this->productVariantRepository = $productVariantRepository;
    }

    private static function generateOrderCode(): string
    {
        $date = date('ymd');
        $random = mt_rand(1000, 9999);
        return "ORD-{$date}-{$random}";
    }

    public function addAsync(int $userId, array $request): mixed
    {
        // Sử dụng Database Transaction để đảm bảo tính ACID tuyệt đối
        return DB::transaction(function () use ($userId, $request) {
            $cartExisting = $this->cartRepository->getByUserId($userId);
            if (!$cartExisting) {
                return ['error' => 'Cart not found', 'status' => 404];
            }

            $selectedCartItemIds = $request['SelectedCartItemIds'] ?? $request['selected_cart_item_ids'] ?? [];
            $cartItemExisting = $this->cartItemRepository->getAllCartItemByIdsAsync($selectedCartItemIds, $cartExisting->id);

            if (!$cartItemExisting || $cartItemExisting->isEmpty()) {
                return ['error' => 'No items selected for checkout', 'status' => 404];
            }

            foreach ($cartItemExisting as $item) {
                $variant = $item->productVariant;
                if (!$variant) {
                    return ['error' => 'Product variant not found.', 'status' => 404];
                }
                if ($item->quantity > $variant->stock) {
                    $productName = $variant->product?->product_name ?? 'Sản phẩm';
                    return [
                        'error' => "Sản phẩm '{$productName} ({$variant->color_name} - {$variant->storage})' chỉ còn lại {$variant->stock} sản phẩm trong kho.",
                        'status' => 422
                    ];
                }
                // Trừ tồn kho
                $variant->stock -= $item->quantity;
                $variant->save();
            }

            $calculatedSubTotal = $cartItemExisting->sum(function ($ci) {
                return $ci->price_at_time * $ci->quantity;
            });

            $discountAmount = $request['DiscountAmount'] ?? $request['discount_amount'] ?? 0;
            $shippingFee = $request['ShippingFee'] ?? $request['shipping_fee'] ?? 0;
            $grandTotal = $calculatedSubTotal - $discountAmount + $shippingFee;

            // Tạo Order
            $orderData = [
                'user_id'          => $userId,
                'order_code'       => self::generateOrderCode(),
                'sub_total'        => $calculatedSubTotal,
                'discount_amount'  => $discountAmount,
                'shipping_fee'     => $shippingFee,
                'grand_total'      => $grandTotal,
                'order_status'     => 0, // Pending
                'payment_method'   => $request['PaymentMethod'] ?? $request['payment_method'] ?? 0,
                'payment_status'   => $request['PaymentStatus'] ?? $request['payment_status'] ?? 0,
                'receiver_name'    => $request['ReceiverName'] ?? $request['receiver_name'] ?? '',
                'receiver_phone'   => $request['ReceiverPhone'] ?? $request['receiver_phone'] ?? '',
                'receiver_address' => $request['ReceiverAddress'] ?? $request['receiver_address'] ?? '',
                'note'             => $request['Note'] ?? $request['note'] ?? '',
            ];

            $order = $this->orderRepository->addAsync($orderData);

            // Tạo OrderItems
            $orderItemsData = [];
            foreach ($cartItemExisting as $c) {
                $orderItemsData[] = [
                    'order_id'           => $order->id,
                    'product_variant_id' => $c->product_variant_id,
                    'quantity'           => $c->quantity,
                    'price_at_time'      => $c->price_at_time,
                    'total_price'        => $c->price_at_time * $c->quantity,
                    'created_at'         => now(),
                    'updated_at'         => now(),
                ];
            }
            
            // Lưu Order Items
            \App\Models\OrderItem::insert($orderItemsData);

            // Xóa các sản phẩm đã mua khỏi giỏ hàng
            $cartItemIds = $cartItemExisting->pluck('id')->toArray();
            $this->cartItemRepository->deleteCartItemByIdsAsync($cartItemIds);

            return new OrderResource($order->load('orderItems.productVariant'));
        });
    }

    public function GetAllByUserIdAsync(int $userId): mixed
    {
        $ordersExisting = $this->orderRepository->getAllOrderByUserId($userId);
        if ($ordersExisting->isEmpty()) {
            return null;
        }

        return OrderResource::collection($ordersExisting);
    }
}