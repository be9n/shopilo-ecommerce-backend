<?php

namespace App\Http\Resources\Admin\Products;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'discount_price' => $this->discount_price,
            'discount_name' => $this->discount?->name,
            'category_name' => $this->category?->name,
            'active' => (bool) $this->active,
        ];
    }
}
