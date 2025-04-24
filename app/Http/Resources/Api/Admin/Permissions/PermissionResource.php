<?php

namespace App\Http\Resources\Api\Admin\Permissions;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'title' => $this->title,
            'checked' => auth()->user()->hasPermissionTo($this->name),
            'children' => $this->when(
                $this->relationLoaded('children'),
                fn() =>
                PermissionResource::collection(
                    $this->children
                )
            )
        ];
    }
}
