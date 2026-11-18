<?php

namespace App\Services;

use App\Models\Order; 
use Exception;

class VNPayService
{
    /**
     * Tạo URL thanh toán VNPay
     */
    public function createPaymentUrl(int $orderId, string $ipAddr): string
    {
        $order = Order::find($orderId);
        if (!$order) {
            throw new Exception("Đơn hàng không tồn tại.");
        }

        
        $parts = explode('-', $order->order_code);
        $cleanOrderInfo = count($parts) >= 2 ? ($parts[0] . $parts[1]) : $order->order_code;

        $vnp_TmnCode    = config('vnpay.vnp_TmnCode');
        $vnp_HashSecret = config('vnpay.vnp_HashSecret');
        $vnp_PayUrl     = config('vnpay.vnp_PayUrl');
        $vnp_Returnurl  = config('vnpay.vnp_Returnurl');

        // Định dạng thời gian theo giờ Việt Nam (GMT+7)
        $startTime = now()->setTimezone('Asia/Ho_Chi_Minh')->format('YmdHis');

        $vnp_Params = [
            "vnp_Version"    => "2.1.0",
            "vnp_Command"    => "pay",
            "vnp_TmnCode"    => $vnp_TmnCode,
            "vnp_Amount"     => (int) ($order->sub_total * 100), // Số tiền * 100 theo quy định VNPay
            "vnp_CurrCode"   => "VND",
            "vnp_TxnRef"     => (string) $order->id,
            "vnp_OrderInfo"  => "Thanh toan don hang: " . $cleanOrderInfo,
            "vnp_OrderType"  => "other",
            "vnp_Locale"     => "vn",
            "vnp_ReturnUrl"  => $vnp_Returnurl,
            "vnp_IpAddr"     => $ipAddr,
            "vnp_CreateDate" => $startTime,
        ];

        // Sắp xếp các tham số theo bảng chữ cái A-Z
        ksort($vnp_Params);

        $hashData = "";
        $query = "";
        $i = 0;

        foreach ($vnp_Params as $key => $value) {
            if ($i == 1) {
                $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_PayUrl . "?" . rtrim($query, '&');

        if (isset($vnp_HashSecret)) {
           
            $vnpSecureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
            $vnp_Url .= '&vnp_SecureHash=' . $vnpSecureHash;
        }

        return $vnp_Url;
    }

    /**
     * Xử lý kết quả trả về từ VNPay (ReturnUrl / IPN)
     */
    public function processPaymentResponse(array $queryParams): array
    {
        $vnp_HashSecret = config('vnpay.vnp_HashSecret');
        
        $vnp_SecureHash = $queryParams['vnp_SecureHash'] ?? '';
        
        // Loại bỏ các param mã hash trước khi tính toán lại checksum
        unset($queryParams['vnp_SecureHash']);
        unset($queryParams['vnp_SecureHashType']);

        ksort($queryParams);
        $i = 0;
        $hashData = "";
        
        foreach ($queryParams as $key => $value) {
            if ($i == 1) {
                $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        $orderId = (int)($queryParams['vnp_TxnRef'] ?? 0);
        $responseCode = $queryParams['vnp_ResponseCode'] ?? '';

        // Kiểm tra chữ ký bảo mật hợp lệ và mã phản hồi 00 (Thành công)
        if ($secureHash === $vnp_SecureHash) {
            if ($responseCode == "00") {
                return ['success' => true, 'orderId' => $orderId, 'message' => 'Giao dịch thành công'];
            }
            return ['success' => false, 'orderId' => $orderId, 'message' => 'Giao dịch không thành công (Mã lỗi: ' . $responseCode . ')'];
        }

        return ['success' => false, 'orderId' => $orderId, 'message' => 'Sai chữ ký bảo mật (Invalid signature)'];
    }
}