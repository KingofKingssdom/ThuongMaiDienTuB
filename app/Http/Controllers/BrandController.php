<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBrandRequest;
use App\Services\Interfaces\BrandServiceInterface;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BrandController extends Controller
{
    protected BrandServiceInterface $brandService;

    public function __construct(BrandServiceInterface $brandService)
    {
        $this->brandService = $brandService;
    }

    // [HttpPost] - Yêu cầu đăng nhập và quyền Admin
    public function store(StoreBrandRequest $request): JsonResponse
    {
        $result = $this->brandService->addAsync($request->all());

        if (!$result) {
            return ApiResponse::error("Failed to create brand.", 400);
        }

        return ApiResponse::success($result, "Data is created successfully", 201);
    }

    // [HttpGet("{id}")] - Công khai
    public function show(int $id): JsonResponse
    {
        $result = $this->brandService->getByIdAsync($id);

        if (!$result) {
            return ApiResponse::error("Not found", 404);
        }

        return ApiResponse::success($result, "Data retrieved successfully");
    }

    // [HttpGet] - Công khai
    public function index(): JsonResponse
    {
        $result = $this->brandService->getAllAsync();

        if (!$result) {
            return ApiResponse::error("No brands found.", 404);
        }

        return ApiResponse::success($result, "Data retrieved successfully");
    }

    // [HttpGet("category")] - Công khai
    public function getByCategoryId(Request $request): JsonResponse
    {
        $categoryId = $request->input('categoryId', 0);
        $result = $this->brandService->GetAllByCategoryId((int)$categoryId);

        if (!$result) {
            return ApiResponse::error("No brands found for this category.", 404);
        }

        return ApiResponse::success($result, "Data retrieved successfully");
    }

    // [HttpPatch("update/{id}")] - Yêu cầu Admin
    public function update(StoreBrandRequest $request, int $id): JsonResponse
    {
        $result = $this->brandService->updateAsync($id, $request->all());

        if (!$result) {
            return ApiResponse::error("Not found or failed to update.", 404);
        }

        return ApiResponse::success($result, "Data updated successfully");
    }

    // [HttpPut("delete/{id}")] - Yêu cầu Admin
    public function destroy(int $id): JsonResponse
    {
        $result = $this->brandService->deleteAsync($id);

        if (!$result) {
            return ApiResponse::error("Not found", 404);
        }

        return ApiResponse::success($result, "Data deleted successfully");
    }
}