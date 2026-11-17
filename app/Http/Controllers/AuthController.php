<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\AuthServiceInterface;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Cookie;

class AuthController extends Controller
{
    protected AuthServiceInterface $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
        
        // Cho phép các api register, login, refresh-token, logout truy cập công khai không cần token (tương đương [AllowAnonymous])
       // $this->middleware('auth:api', ['except' => ['register', 'login', 'refreshToken', 'logout']]);
    }

    public function register(Request $request): JsonResponse
    {
        $result = $this->authService->registerAsync($request->all());

        if (!$result) {
            return ApiResponse::error("Email already exists.", 409);
        }

        return ApiResponse::success($result, "Register is succeed", 201);
    }

    public function login(Request $request): JsonResponse
    {
        $result = $this->authService->loginAsync($request->all());

        if (!$result) {
            return ApiResponse::error("Email or password is incorrect.", 401);
        }

        // Tạo HttpOnly Cookie chứa RefreshToken giống hệt logic C# của bạn
        $cookie = cookie(
            'refreshToken', 
            $result['RefreshToken'], 
            60 * 24 * 7, // Thời gian sống: 7 ngày (tính bằng phút)
            '/', 
            null, 
            true,  // Secure = true
            true,  // HttpOnly = true
            false, 
            'Strict' // SameSite = Strict
        );

        return ApiResponse::success($result, "Login is succeed")->withCookie($cookie);
    }

    public function refreshToken(Request $request): JsonResponse
    {
        // Lấy refresh token từ request body hoặc từ HttpOnly Cookie
        $refreshToken = $request->input('refreshToken') ?? $request->cookie('refreshToken');

        if (!$refreshToken) {
            return ApiResponse::error("Refresh token is required.", 400);
        }

        $result = $this->authService->refreshTokenAsync(['refreshToken' => $refreshToken]);

        if (!$result) {
            return ApiResponse::error("Refresh token is invalid.", 401);
        }

        // Cập nhật lại cookie mới nếu có xoay vòng token (Token Rotation)
        $cookie = cookie(
            'refreshToken', 
            $result['RefreshToken'], 
            60 * 24 * 7, 
            '/', 
            null, 
            true, 
            true, 
            false, 
            'Strict'
        );

        return ApiResponse::success($result, "The token was created successfully")->withCookie($cookie);
    }

    public function logout(Request $request): JsonResponse
    {
        $refreshToken = $request->input('refreshToken') ?? $request->cookie('refreshToken');

        if (!$refreshToken) {
            return ApiResponse::error("Refresh token not found.", 404);
        }

        $success = $this->authService->logoutAsync(['refreshToken' => $refreshToken]);

        if (!$success) {
            return ApiResponse::error("Refresh token has already been revoked or not found.", 409);
        }

        // Xóa cookie khi đăng xuất
        $cookie = \Cookie::forget('refreshToken');

        return ApiResponse::success(null, "Logout successfully.")->withCookie($cookie);
    }
}