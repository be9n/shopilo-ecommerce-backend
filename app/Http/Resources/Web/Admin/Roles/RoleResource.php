<?php

namespace App\Http\Resources\Web\Admin\Roles;

use App\Http\Resources\BaseResource;
use Illuminate\Http\Request;

class RoleResource extends BaseResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'permissions_count' => $this->permissions_count
        ];
    }
}
