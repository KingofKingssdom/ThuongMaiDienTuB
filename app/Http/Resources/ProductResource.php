<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'Id'              => $this->id,
            'ProductName'     => $this->product_name,
            'UrlImageProduct' => $this->url_image_product,
            'Description'     => $this->description,
            'IsFeatured'      => (bool) $this->is_featured,
            'IsOnPromotion'   => (bool) $this->is_on_promotion,
            // Sử dụng khi quan hệ đã được load
            'Brand'           => new BrandResource($this->whenLoaded('brand')),
            'Category'        => new CategoryResource($this->whenLoaded('category')),
            'ProductVariants' => ProductVariantResource::collection($this->whenLoaded('productVariants')),
        ];
    }
}