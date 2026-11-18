<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSpecificationGroupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'SpecificationName' => 'required|string|max:255',
            'CategoryId'        => 'required|integer|exists:categories,id',
        ];
    }
}