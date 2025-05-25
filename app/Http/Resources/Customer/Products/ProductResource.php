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
            'images' => $images->isNotEmpty() ? MediaResource::collection($images) : null,
        ];
    }
}
