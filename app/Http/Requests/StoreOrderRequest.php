<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'SelectedCartItemIds' => 'required|array',
            'SelectedCartItemIds.*' => 'integer|exists:cart_items,id',
            'DiscountAmount'      => 'nullable|numeric|min:0',
            'ShippingFee'         => 'nullable|numeric|min:0',
            'PaymentMethod'       => 'required|integer',
            'PaymentStatus'       => 'required|integer',
            'ReceiverName'        => 'required|string|max:255',
            'ReceiverPhone'       => 'required|string|max:20',
            'ReceiverAddress'     => 'required|string',
            'Note'                => 'nullable|string',
        ];
    }
}