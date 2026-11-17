<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBrandRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'BrandName'     => 'required|string|max:255',
            'UrlImageBrand' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'CategoryIds'   => 'nullable|array',
            'CategoryIds.*' => 'integer|exists:categories,id',
        ];
    }
}