<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Services\Interfaces\CategoryServiceInterface;
use App\Helpers\ApiResponse;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    protected CategoryServiceInterface $categoryService;

    public function __construct(CategoryServiceInterface $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    // [HttpPost] - Yêu cầu đăng nhập (Admin, User)
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $result = $this->categoryService->addAsync($request->all());

        if (!$result) {
            return ApiResponse::error("Failed to create category.", 400);
        }

        return ApiResponse::success($result, "Data is created successfully", 201);
    }

    // [HttpGet] - Yêu cầu đăng nhập (Admin, User)
    public function index(): JsonResponse
    {
        $result = $this->categoryService->getAllAsync();

        if (!$result) {
            return ApiResponse::error("Not found", 404);
        }

        return ApiResponse::success($result, "Data retrieved successfully");
    }

    // [HttpGet("{id}")] - Lấy chi tiết danh mục theo ID
    public function show(int $id): JsonResponse
    {
        $result = $this->categoryService->getByIdAsync($id);

        if (!$result) {
            return ApiResponse::error("Not found", 404);
        }

        return ApiResponse::success($result, "Data retrieved successfully");
    }

    // [HttpPatch("update/{id}")] - Chỉ dành cho Admin
    public function update(StoreCategoryRequest $request, int $id): JsonResponse
    {
        $result = $this->categoryService->updateAsync($id, $request->all());

        if (!$result) {
            return ApiResponse::error("Not found or failed to update.", 404);
        }

        return ApiResponse::success($result, "Data updated successfully");
    }

    // [HttpPut("delete/{id}")] - Chỉ dành cho Admin
    public function destroy(int $id): JsonResponse
    {
        $result = $this->categoryService->deleteAsync($id);

        if (!$result) {
            return ApiResponse::error("Not found", 404);
        }

        return ApiResponse::success($result, "Data deleted successfully");
    }
}