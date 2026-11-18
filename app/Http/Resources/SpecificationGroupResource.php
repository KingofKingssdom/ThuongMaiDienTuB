<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpecificationGroupResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'Id'                 => $this->id,
            'SpecificationName'  => $this->specification_name,
            'CategoryId'         => $this->category_id,
            'CategoryName'       => $this->whenLoaded('category', function () {
                return $this->category?->category_name;
            }),
            'SpecificationAttributes' => SpecificationAttributeResource::collection($this->whenLoaded('specificationAttributes')),
        ];
    }
}
