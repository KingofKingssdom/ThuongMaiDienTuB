<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ProductName'     => 'required|string|max:255',
            'UrlImageProduct' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'Description'     => 'nullable|string',
            'IsFeatured'      => 'nullable|boolean',
            'IsOnPromotion'   => 'nullable|boolean',
            'BrandId'         => 'required|integer|exists:brands,id',
            'CategoryId'      => 'required|integer|exists:categories,id',
        ];
    }
}