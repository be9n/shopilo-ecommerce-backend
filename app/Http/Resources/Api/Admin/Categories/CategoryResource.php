<?php

namespace App\Http\Resources\Api\Admin\Categories;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'children' => $this->when(
                $this->relationLoaded('children'), // Check if children were eager-loaded
                fn() => CategoryResource::collection($this->children)
            )
        ];
    }
}
