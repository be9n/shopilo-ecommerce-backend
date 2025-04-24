<?php

namespace App\Http\Resources\Api\Admin\Products;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailedProductResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => (float) $this->price,
            'category_id' => $this->category_id,
            'parent_category_id' => $this->category?->parent?->id
        ];
    }
}
