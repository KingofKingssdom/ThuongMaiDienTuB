<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpecificationValueResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'Id'                         => $this->id,
            'Value'                      => $this->value,
            'ProductId'                  => $this->product_id,
            'SpecificationAttributeId'   => $this->specification_attribute_id,
        ];
    }
}
