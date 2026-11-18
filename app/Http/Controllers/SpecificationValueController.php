<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSpecificationValueRequest;
use App\Services\Interfaces\SpecificationValueServiceInterface;
use App\Helpers\ApiResponse;
use Illuminate\Http\JsonResponse;

class SpecificationValueController extends Controller
{
    protected SpecificationValueServiceInterface $service;

    public function __construct(SpecificationValueServiceInterface $service)
    {
        $this->service = $service;
    }

    // [HttpPost] - Chỉ dành cho Admin
    public function store(StoreSpecificationValueRequest $request): JsonResponse
    {
        $result = $this->service->addAsync($request->all());

        if (!$result) {
            return ApiResponse::error("Failed to create specification value.", 400);
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