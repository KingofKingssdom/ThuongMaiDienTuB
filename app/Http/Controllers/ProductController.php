<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\Interfaces\ProductServiceInterface;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    protected ProductServiceInterface $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    // [HttpPost] - Chỉ dành cho Admin (Tạo sản phẩm kèm upload ảnh)
    public function store(StoreProductRequest $request): JsonResponse
    {
        $result = $this->productService->addAsync($request->all());

        if (!$result) {
            return ApiResponse::error("Failed to create product.", 400);
        }

        return ApiResponse::success($result, "Data is created successfully", 201);
    }

    // [HttpGet("{id}")] - Công khai
    public function show(int $id): JsonResponse
    {
        $result = $this->productService->getByIdAsync($id);

        if (!$result) {
            return ApiResponse::error("Not Found", 404);
        }

        return ApiResponse::success($result, "Data is retrieved successfully");
    }

    // [HttpGet] - Công khai
    public function index(): JsonResponse
    {
        $result = $this->productService->getAllAsync();

        if (!$result) {
            return ApiResponse::error("Not Found", 404);
        }

        return ApiResponse::success($result, "Data retrieved successfully");
    }

    // [HttpGet("promotion")] - Công khai
    public function getByIsOnPromotion(): JsonResponse
    {
        $result = $this->productService->getAllByIsOnPromotion();

        if (!$result) {
            return ApiResponse::error("Not Found", 404);
        }

        return ApiResponse::success($result, "Data retrieved successfully");
    }

    // [HttpGet("isfeature")] - Công khai (Lọc sản phẩm nổi bật theo categoryId)
    public function getIsFeature(Request $request): JsonResponse
    {
        $categoryId = $request->input('categoryId', 0);
        $result = $this->productService->getAllIsFeatured((int)$categoryId);

        if (!$result) {
            return ApiResponse::error("Not Found", 404);
        }

        return ApiResponse::success($result, "Data retrieved successfully");
    }

    // [HttpGet("search")] - Công khai (Tìm kiếm theo tên sản phẩm)
    public function getByName(Request $request): JsonResponse
    {
        $productName = $request->input('productName', '');
        $result = $this->productService->getAllByNameAsync($productName);

        if (!$result) {
            return ApiResponse::error("Not Found", 404);
        }

        return ApiResponse::success($result, "Data retrieved successfully");
    }

    // [HttpGet("filter")] - Công khai (Lọc theo Category và Brand)
    public function filter(Request $request): JsonResponse
    {
        $categoryId = (int) $request->input('categoryId', 0);
        $brandId = $request->has('brandId') ? (int) $request->input('brandId') : null;

        $result = $this->productService->GetAllByCategoryIdAndBrandId($categoryId, $brandId);

        if (!$result) {
            return ApiResponse::error("Not Found", 404);
        }

        return ApiResponse::success($result, "Data retrieved successfully");
    }

    // [HttpPatch("update/{id}")] - Chỉ dành cho Admin
    public function update(UpdateProductRequest $request, int $id): JsonResponse
    {
        $result = $this->productService->updateAsync($id, $request->all());

        if (!$result) {
            return ApiResponse::error("Not Found", 404);
        }

        return ApiResponse::success($result, "Data updated successfully");
    }

    // [HttpPut("delete/{id}")] - Chỉ dành cho Admin
    public function destroy(int $id): JsonResponse
    {
        $result = $this->productService->deleteAsync($id);

        if (!$result) {
            return ApiResponse::error("Not Found", 404);
        }

        return ApiResponse::success($result, "Data deleted successfully");
    }
}
