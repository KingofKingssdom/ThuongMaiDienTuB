<?php

namespace App\Http\Controllers;

use App\Services\VNPayService;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PaymentController extends Controller
{
    protected VNPayService $vnpayService;

    public function __construct(VNPayService $vnpayService)
    {
        $this->vnpayService = $vnpayService;
    }

    /**
     * API tạo URL thanh toán VNPay cho đơn hàng
     */
    public function createPayment(Request $request, int $orderId): JsonResponse
    {
        try {
            $ipAddr = $request->ip();
            $paymentUrl = $this->vnpayService->createPaymentUrl($orderId, $ipAddr);

            return ApiResponse::success(['paymentUrl' => $paymentUrl], "Tạo URL thanh toán thành công");
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 400);
        }
    }

    /**
     * API nhận kết quả trả về từ VNPay khi người dùng thanh toán xong
     */
    public function paymentCallback(Request $request): JsonResponse
    {
        $result = $this->vnpayService->processPaymentResponse($request->all());

        if ($result['success']) {
            // TODO: Cập nhật trạng thái đơn hàng (PaymentStatus = Paid, OrderStatus = Processing) vào Database ở đây
            
            return ApiResponse::success($result, "Thanh toán thành công đơn hàng #" . $result['orderId']);
        }

        return ApiResponse::error($result['message'], 400);
    }
}