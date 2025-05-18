<?php

namespace App\Http\Resources\Admin\Categories;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryListResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'children' => $this->when(
                $this->relationLoaded('children'), // Check if children were eager-loaded
                fn() => CategoryListResource::collection($this->children)
            )
        ];
    }
}
