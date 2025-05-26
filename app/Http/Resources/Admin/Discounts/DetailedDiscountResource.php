<?php

namespace App\Http\Resources\Admin\Discounts;

use App\Http\Resources\Admin\MediaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailedDiscountResource extends JsonResource
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
            'type' => $this->type,
            'value' => $this->value,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'max_uses' => $this->max_uses,
            'used_count' => $this->used_count,
            'is_active' => $this->is_active,
            'max_uses_per_user' => $this->max_uses_per_user,
        ];
    }
}
