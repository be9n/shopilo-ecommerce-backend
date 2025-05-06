<?php

namespace App\Http\Resources\Api\Admin\Roles;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EditRoleResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'permissions_list' => $this->permissions()->pluck('name')->toArray() 
        ];
    }
}
