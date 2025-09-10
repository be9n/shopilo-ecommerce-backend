<?php

namespace App\Http\Resources\Admin\Discounts;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DiscountResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'value' => (float) $this->value,
            'start_date' => $this->start_date->format('Y-m-d'),
            'end_date' => $this->end_date->format('Y-m-d'),
            'max_uses' => $this->max_uses,
            'used_count' => $this->used_count,
            'active' => $this->active,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
