<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSpecificationAttributeRequest;
use App\Services\Interfaces\SpecificationAttributeServiceInterface;
use App\Helpers\ApiResponse;
use Illuminate\Http\JsonResponse;

class SpecificationAttributeController extends Controller
{
    protected SpecificationAttributeServiceInterface $service;

    public function __construct(SpecificationAttributeServiceInterface $service)
    {
        $this->service = $service;
    }

    // [HttpPost] - Chỉ dành cho Admin
    public function store(StoreSpecificationAttributeRequest $request): JsonResponse
    {
        $result = $this->service->addAsync($request->all());

        if (!$result) {
            return ApiResponse::error("Failed to create specification attribute.", 400);
        }

        return ApiResponse::success($result, "Data is created successfully", 201);
    }

    // [HttpGet("{id}")] - Dành cho Admin và User
    public function show(int $id): JsonResponse
    {
        $result = $this->service->getByIdAsync($id);

        if (!$result) {
            return ApiResponse::error("Not found", 404);
        }

        return ApiResponse::success($result, "Data is retrieved successfully");
    }

    // [HttpGet] - Dành cho Admin và User
    public function index(): JsonResponse
    {
        $result = $this->service->getAllAsync();

        if (!$result) {
            return ApiResponse::error("Not found", 404);
        }

        return ApiResponse::success($result, "Data is retrieved successfully");
    }
}