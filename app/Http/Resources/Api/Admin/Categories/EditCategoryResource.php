<?php

namespace App\Http\Resources\Api\Admin\Categories;

use App\Http\Resources\Api\Admin\MediaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EditCategoryResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        $name = [];
        foreach (config('app.locales') as $locale) {
            $name[$locale] = $this->getTranslation('name', $locale);
        }

        $image = $this->getFirstMedia('images');

        return [
            'id' => $this->id,
            'name' => $name,
            'image' => $image ? MediaResource::make($image) : null,
            'parent_id' => $this->parent_id,
        ];
    }
}
