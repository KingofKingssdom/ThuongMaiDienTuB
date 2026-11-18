<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSpecificationGroupRequest;
use App\Services\Interfaces\SpecificationGroupServiceInterface;
use App\Helpers\ApiResponse;
use Illuminate\Http\JsonResponse;

class SpecificationGroupController extends Controller
{
    protected SpecificationGroupServiceInterface $service;

    public function __construct(SpecificationGroupServiceInterface $service)
    {
        $this->service = $service;
    }

    // [HttpPost] - Chỉ dành cho Admin
    public function store(StoreSpecificationGroupRequest $request): JsonResponse
    {
        $result = $this->service->addAsync($request->all());

        if (!$result) {
            return ApiResponse::error("Failed to create specification group.", 400);
        }

        return ApiResponse::success($result, "Data is created successfully", 201);
    }

    // [HttpGet("{id}")] - Dành cho Admin và User
    public function show(int $id): JsonResponse
    {
        $result = $this->service->getByIdAsync($id);

        if (!$result) {
            return ApiResponse::error("Not Found", 404);
        }

        return ApiResponse::success($result, "Data is retrieved successfully");
    }

    // [HttpGet] - Dành cho Admin và User
    public function index(): JsonResponse
    {
        $result = $this->service->getAllAsync();

        if (!$result) {
            return ApiResponse::error("Not Found", 404);
        }

        return ApiResponse::success($result, "Data is retrieved successfully");
    }
}
