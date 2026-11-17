<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageStorageUtil
{
    /**
     * Upload hình ảnh vào thư mục chỉ định trong storage/public
     *
     * @param UploadedFile|null $file
     * @param string $folderName Tên thư mục con (ví dụ: 'products', 'categories')
     * @return string|null Trả về đường dẫn tương đối để lưu vào Database
     */
    public static function uploadImage(?UploadedFile $file, string $folderName): ?string
    {
        if (!$file || !$file->isValid()) {
            return null;
        }

        // Sinh tên file ngẫu nhiên dạng UUID / Guid kết hợp phần mở rộng gốc
        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();

        // Lưu file vào thư mục public disk (đường dẫn thực tế: storage/app/public/Images/{folderName})
        $path = $file->storeAs("Images/{$folderName}", $fileName, 'public');

        // Trả về đường dẫn chuẩn để lưu database (ví dụ: Images/products/abc-xyz.jpg)
        // Sau đó bạn chạy lệnh `php artisan storage:link` để public thư mục này ra ngoài trình duyệt.
        return $path ? str_replace('\\', '/', $path) : null;
    }

    /**
     * Xóa hình ảnh dựa vào đường dẫn tương đối đã lưu trong Database
     *
     * @param string|null $relativePath
     * @return void
     */
    public static function deleteImage(?string $relativePath): void
    {
        if (empty($relativePath)) {
            return;
        }

        // Kiểm tra và xóa file khỏi disk 'public' nếu nó tồn tại
        if (Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }
    }
}