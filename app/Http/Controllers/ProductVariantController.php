<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductVariantRequest;
use App\Http\Requests\UpdateProductVariantRequest;
use App\Services\Interfaces\ProductVariantServiceInterface;
use App\Helpers\ApiResponse;
use Illuminate\Http\JsonResponse;

class ProductVariantController extends Controller
{
    protected ProductVariantServiceInterface $productVariantService;

    public function __construct(ProductVariantServiceInterface $productVariantService)
    {
        $this->productVariantService = $productVariantService;
    }

    // [HttpPost] - Chỉ dành cho Admin (Tạo biến thể kèm ảnh màu sắc)
    public function store(StoreProductVariantRequest $request): JsonResponse
    {
        $result = $this->productVariantService->addAsync($request->all());

        if (!$result) {
            return ApiResponse::error("Failed to create product variant.", 400);
        }

        return ApiResponse::success($result, "Data is created successfully", 201);
    }

    // [HttpGet("{id}")] - Dành cho Admin và User đã đăng nhập
    public function show(int $id): JsonResponse
    {
        $result = $this->productVariantService->getByIdAsync($id);

        if (!$result) {
            return ApiResponse::error("Not found", 404);
        }

        return ApiResponse::success($result, "Data is retrieved successfully");
    }

    // [HttpGet] - Dành cho Admin và User đã đăng nhập
    public function index(): JsonResponse
    {
        $result = $this->productVariantService->getAllAsync();

        if (!$result) {
            return ApiResponse::error("Not found", 404);
        }

        return ApiResponse::success($result, "Data is retrieved successfully");
    }

    // [HttpPatch("update/{id}")] - Chỉ dành cho Admin
    public function update(UpdateProductVariantRequest $request, int $id): JsonResponse
    {
        $result = $this->productVariantService->updateAsync($id, $request->all());

        if (!$result) {
            return ApiResponse::error("Not found or failed to update.", 404);
        }

        return ApiResponse::success($result, "Data is updated successfully");
    }

    // [HttpPut("delete/{id}")] - Chỉ dành cho Admin
    public function destroy(int $id): JsonResponse
    {
        $result = $this->productVariantService->deleteAsync($id);

        if (!$result) {
            return ApiResponse::error("Not found", 404);
        }

        return ApiResponse::success($result, "Data is deleted successfully");
    }

    // [HttpGet("product/{productId}")] - Dành cho Admin và User (Lấy danh sách biến thể theo Product ID)
    public function getByProductId(int $productId): JsonResponse
    {
        $result = $this->productVariantService->getByProductIdAsync($productId);

        if (!$result) {
            return ApiResponse::error("Not found", 404);
        }

        return ApiResponse::success($result, "Data is retrieved successfully");
    }
}