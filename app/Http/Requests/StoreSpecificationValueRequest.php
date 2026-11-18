<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSpecificationValueRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'Value'                    => 'required|string',
            'ProductId'                => 'required|integer|exists:products,id',
            'SpecificationAttributeId' => 'required|integer|exists:specification_attributes,id',
        ];
    }
}