<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'Id'             => $this->id,
            'OrderCode'      => $this->order_code,
            'SubTotal'       => $this->sub_total,
            'DiscountAmount' => $this->discount_amount,
            'ShippingFee'    => $this->shipping_fee,
            'GrandTotal'     => $this->grand_total,
            'OrderStatus'    => $this->order_status,
            'PaymentMethod'  => $this->payment_method,
            'PaymentStatus'  => $this->payment_status,
            'ReceiverName'   => $this->receiver_name,
            'ReceiverPhone'  => $this->receiver_phone,
            'ReceiverAddress'=> $this->receiver_address,
            'Note'           => $this->note,
            'OrderItems'     => OrderItemResource::collection($this->whenLoaded('orderItems')),
        ];
    }
}