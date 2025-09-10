<?php

namespace App\Http\Resources\Customer\Products;

use App\Http\Resources\Admin\MediaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $images = $this->getMedia('images');

        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => (float) $this->price,
            'discount_price' => (float) round($this->discount_price, 2),
            'discount_amount' => (float) $this->discount?->value,
            'discount_type' => $this->discount?->type,
            'images' => $images->isNotEmpty() ? MediaResource::collection($images) : null,
        ];
    }
}
