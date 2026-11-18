<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpecificationAttributeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'Id'                   => $this->id,
            'LabelSpecification'   => $this->label_specification,
            'SpecificationGroupId' => $this->specification_group_id,
            'SpecificationValues'  => SpecificationValueResource::collection($this->whenLoaded('specificationValues')),
        ];
    }
}
