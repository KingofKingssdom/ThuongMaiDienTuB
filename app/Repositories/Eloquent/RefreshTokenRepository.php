<?php

namespace App\Repositories\Eloquent;

use App\Models\RefreshToken;
use App\Repositories\Contracts\RefreshTokenRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

class RefreshTokenRepository implements RefreshTokenRepositoryInterface
{
    public function getValidAsync(string $token): ?RefreshToken
    {
        
        return RefreshToken::with('user')
            ->where('Token', $token)
            ->where('IsRevoked', false)
            ->where('ExpiresAt', '>', Carbon::now())
            ->first();
    }

    public function addAsync(array $data): RefreshToken
    {
        // Eloquent tự động tạo mới và trả về instance kèm id
        return RefreshToken::create($data);
    }

    public function getByUserIdAsync(int $userId): Collection
    {
       
        return RefreshToken::where('user_id', $userId)
            ->orderBy('created_at', 'desc') 
            ->get();
    }

    public function update(RefreshToken $refreshToken, array $data): bool
    {
        // Cập nhật trạng thái của model token hiện tại
        return $refreshToken->update($data);
    }

    public function delete(RefreshToken $refreshToken): bool
    {
        // Xóa bản ghi (hoặc dùng $refreshToken->delete())
        return $refreshToken->delete();
    }
}