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
        // Tương đương với .Include(r => r.User) và điều kiện lọc token hợp lệ, chưa thu hồi, chưa hết hạn
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
        // Tương đương với Where, OrderByDescending(x => x.CreatedDay) và ToListAsync
        return RefreshToken::where('user_id', $userId)
            ->orderBy('created_at', 'desc') // Nếu dùng chuẩn created_at của Laravel, hoặc đổi thành 'CreatedDay' nếu dùng tên cột cũ
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