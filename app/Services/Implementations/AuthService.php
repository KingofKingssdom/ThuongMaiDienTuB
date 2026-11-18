<?php

namespace App\Services\Implementations;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\RefreshTokenRepositoryInterface;
use App\Repositories\Contracts\CartRepositoryInterface;
use App\Services\Interfaces\AuthServiceInterface;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\RefreshToken;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService implements AuthServiceInterface
{
    protected UserRepositoryInterface $userRepository;
    protected CartRepositoryInterface $cartRepository;
    protected RefreshTokenRepositoryInterface $refreshTokenRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        CartRepositoryInterface $cartRepository,
        RefreshTokenRepositoryInterface $refreshTokenRepository
    ) {
        $this->userRepository = $userRepository;
        $this->cartRepository = $cartRepository;
        $this->refreshTokenRepository = $refreshTokenRepository;
    }

    public function registerAsync(array $request): ?UserResource
    {
        // Kiểm tra email đã tồn tại chưa
        if ($this->userRepository->existsByEmailAsync(trim($request['email']))) {
            return null; // Trả về null nếu conflict, xử lý ở controller
        }

        // Tạo user mới (Mã hóa password bằng Hash của Laravel tương đương BCrypt)
        $user = $this->userRepository->addAsync([
            'FullName'   => trim($request['fullName']),
            'email'      => strtolower(trim($request['email'])),
            'password'   => Hash::make($request['password']),
            'IsActive'   => true
        ]);

        Log::info("User registered: " . $user->email);

        
        $this->cartRepository->addAsync([
            'user_id' => $user->id
        ]);

        return new UserResource($user);
    }

    public function loginAsync(array $request): ?array
    {
        $email = $request['email'];
        $password = $request['password'];

        $user = $this->userRepository->getByEmailAsync($email);

        if (!$user || !Hash::check($password, $user->password)) {
            return null; // Đăng nhập thất bại
        }

        // Tạo Access Token bằng JWTAuth
        $accessToken = JWTAuth::fromUser($user);

        // Tạo Refresh Token ngẫu nhiên
        $refreshToken = bin2hex(random_bytes(40));

        // Lưu Refresh Token vào database
        $this->refreshTokenRepository->addAsync([
            'user_id'   => $user->id,
            'Token'     => $refreshToken,
            'ExpiresAt' => Carbon::now()->addDays(7),
            'IsRevoked' => false
        ]);

        return [
            'AccessToken'  => $accessToken,
            'RefreshToken' => $refreshToken,
            'User'         => new UserResource($user)
        ];
    }

    public function refreshTokenAsync(array $request): ?array
    {
        $token = $request['refreshToken'];

        $existingToken = $this->refreshTokenRepository->getValidAsync($token);

        if (!$existingToken) {
            return null; // Refresh token không hợp lệ hoặc hết hạn
        }

        // Thu hồi token cũ (Rotate Refresh Token)
        $this->refreshTokenRepository->update($existingToken, [
            'IsRevoked' => true,
            'RevokedAt' => Carbon::now()
        ]);

        $user = $this->userRepository->getByEmailAsync($existingToken->user->email);

        if (!$user) {
            return null;
        }

        // Sinh cặp token mới
        $accessToken = JWTAuth::fromUser($user);
        $newRefreshToken = bin2hex(random_bytes(40));

        $this->refreshTokenRepository->addAsync([
            'user_id'   => $user->id,
            'Token'     => $newRefreshToken,
            'ExpiresAt' => Carbon::now()->addDays(7),
            'IsRevoked' => false
        ]);

        return [
            'AccessToken'  => $accessToken,
            'RefreshToken' => $newRefreshToken
        ];
    }

    public function logoutAsync(array $request): bool
    {
        $token = $request['refreshToken'];

        $existingToken = $this->refreshTokenRepository->getValidAsync($token);

        if (!$existingToken || $existingToken->IsRevoked) {
            return false;
        }

        // Thu hồi token
        $this->refreshTokenRepository->update($existingToken, [
            'IsRevoked' => true,
            'RevokedAt' => Carbon::now()
        ]);

        Log::info("User {$existingToken->user_id} logged out.");

        return true;
    }
}