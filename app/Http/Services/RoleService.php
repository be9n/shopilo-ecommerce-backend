<?php

namespace App\Http\Services;

use App\Models\Role;


class RoleService
{
    public function getAllRoles()
    {
        return Role::withCount('permissions')->paginate(10);
    }
}
