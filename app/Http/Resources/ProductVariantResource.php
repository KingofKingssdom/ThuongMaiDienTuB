<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariantResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'Id'              => $this->id,
            'ColorName'       => $this->color_name,
            'Storage'         => $this->storage,
            'OriginPrice'     => $this->origin_price,
            'CurrentPrice'    => $this->current_price,
            'Stock'           => $this->stock,
            'UrlProductColor' => $this->url_product_color,
            'CreatedDay'      => $this->created_at,
            'DeletedDay'      => $this->deleted_at,
            'ProductId'       => $this->product_id ?? $this->product?->id,
            'ProductName'     => $this->whenLoaded('product', function () {
                return $this->product?->product_name;
            }),
        ];
    }
}