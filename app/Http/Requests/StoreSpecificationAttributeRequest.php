<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSpecificationAttributeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'LabelSpecification'   => 'required|string|max:255',
            'SpecificationGroupId' => 'required|integer|exists:specification_groups,id',
        ];
    }
}
