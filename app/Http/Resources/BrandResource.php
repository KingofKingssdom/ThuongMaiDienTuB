<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'Id'            => $this->id,
            'BrandName'     => $this->brand_name,
            'UrlImageBrand' => $this->url_image_brand,
            // Map danh sách các Category thuộc Brand nếu quan hệ đã được load
            'Category'      => CategoryResource::collection($this->whenLoaded('categories')),
        ];
    }
}
