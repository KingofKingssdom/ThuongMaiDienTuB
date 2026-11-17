<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ProductName'     => 'nullable|string|max:255',
            'UrlImageProduct' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'Description'     => 'nullable|string',
            'IsFeatured'      => 'nullable|boolean',
            'IsOnPromotion'   => 'nullable|boolean',
            'BrandId'         => 'nullable|integer|exists:brands,id',
            'CategoryId'      => 'nullable|integer|exists:categories,id',
        ];
    }
}