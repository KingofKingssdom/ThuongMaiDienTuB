<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\RoleServiceInterface;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RoleController extends Controller
{
    protected RoleServiceInterface $roleService;

    public function __construct(RoleServiceInterface $roleService)
    {
        
    }

    public function store(Request $request): JsonResponse
    {
        $result = $this->roleService->addAsync($request->all());

        if (!$result) {
            return ApiResponse::error("Role name already exists or invalid data.", 409);
        }

        return ApiResponse::success($result, "Role is succeed", 201);
    }

    public function index(): JsonResponse
    {
        $result = $this->roleService->getAllAsync();

        if (!$result) {
            return ApiResponse::error("Roles not found", 404);
        }

        return ApiResponse::success($result, "Successfully retrieved all roles");
    }

    public function show(int $id): JsonResponse
    {
        $result = $this->roleService->getByIdAsync($id);

        if (!$result) {
            return ApiResponse::error("Role not found with Id = {$id}", 404);
        }

        return ApiResponse::success($result, "Get role with ID = {$id} succeed");
    }

    public function getByName(string $name): JsonResponse
    {
        $result = $this->roleService->getByNameAsync($name);

        if (!$result) {
            return ApiResponse::error("Role not found with role name = {$name}", 404);
        }

        return ApiResponse::success($result, "Get role with role name = {$name} succeed");
    }
}