<?php

namespace App\Http\Resources\Api\Admin\Products;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailedProductResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        $name = [];
        $description = [];
        foreach (config('app.locales') as $locale) {
            $name[$locale] = $this->getTranslation('name', $locale);
            $description[$locale] = $this->getTranslation('description', $locale);
        }

        return [
            'id' => $this->id,
            'name' => $name,
            'description' => $description,
            'price' => (float) $this->price,
            'category_id' => $this->category_id,
            'parent_category_id' => $this->category?->parent?->id,
        ];
    }
}
