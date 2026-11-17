<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'ProductVariantId' => $this->product_variant_id,
            'ColorName'        => $this->productVariant?->color_name,
            'Storage'          => $this->productVariant?->storage,
            'UrlProductColor'  => $this->productVariant?->url_product_color,
            'Quantity'         => $this->quantity,
            'PriceAtTime'      => $this->price_at_time,
            'TotalPrice'       => $this->total_price,
        ];
    }
}