<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductVariantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'Storage'         => 'nullable|string|max:100',
            'ColorName'       => 'nullable|string|max:100',
            'CurrentPrice'    => 'nullable|numeric|min:0',
            'OriginPrice'     => 'nullable|numeric|min:0',
            'Stock'           => 'nullable|integer|min:0',
            'UrlProductColor' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}