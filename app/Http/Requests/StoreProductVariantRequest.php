<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductVariantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'Storage'         => 'required|string|max:100',
            'ColorName'       => 'required|string|max:100',
            'CurrentPrice'    => 'required|numeric|min:0',
            'OriginPrice'     => 'required|numeric|min:0',
            'Stock'           => 'required|integer|min:0',
            'UrlProductColor' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ProductId'       => 'required|integer|exists:products,id',
        ];
    }
}