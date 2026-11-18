<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Services\Interfaces\OrderServiceInterface;
use App\Helpers\ApiResponse;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    protected OrderServiceInterface $orderService;

    public function __construct(OrderServiceInterface $orderService)
    {
        $this->orderService = $orderService;
    }

    // [Authorize(Roles = "Admin, User")] - Tạo đơn hàng từ giỏ hàng
    public function store(StoreOrderRequest $request): JsonResponse
    {
       
        $userId = auth()->id();

        if (!$userId) {
            return ApiResponse::error("Unauthorized", 401);
        }

        $result = $this->orderService->addAsync((int) $userId, $request->all());

        // Kiểm tra nếu Service trả về lỗi (ví dụ hết hàng hoặc không tìm thấy giỏ hàng)
        if (is_array($result) && isset($result['error'])) {
            return ApiResponse::error($result['error'], $result['status'] ?? 400);
        }

        return ApiResponse::success($result, "Data is created successfully", 201);
    }

    // [Authorize(Roles = "Admin, User")] - Lấy danh sách đơn hàng của user hiện tại
    public function index(): JsonResponse
    {
        $userId = auth()->id();

        if (!$userId) {
            return ApiResponse::error("Unauthorized", 401);
        }

        $result = $this->orderService->GetAllByUserIdAsync((int) $userId);

        if (!$result) {
            return ApiResponse::error("Not found", 404);
        }

        return ApiResponse::success($result, "Data retrieved successfully");
    }
}
