<?php

namespace App\Http\Resources\Customer\Categories;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $image = $this->getFirstMedia('images');

        return [
            'id' => $this->id,
            'name' => $this->name,
            'image_url' => $image ? $image->getUrl() : null,
        ];
    }
}
