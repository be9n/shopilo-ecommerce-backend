<?php

namespace App\Http\Services\Admin;

use App\Exceptions\RegularException;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;


class RoleService
{
    public function getAllRoles(?string $sortBy, ?string $sortDir, ?string $search = null)
    {
        return Role::withCount('permissions')
            ->whereNot('name', 'super-admin')
            ->orderBy($sortBy ?? "id", $sortDir ?? "desc")
            ->when($search, function (Builder $builder) use ($search) {
                return $builder->where('title', 'like', "%$search%");
            })
            ->paginate(10);
    }

    public function createRole(array $data)
    {
        $data['name'] = Str::slug($data['title']);
        $data['guard_name'] = 'web';
        $role = Role::create($data);

        $role->syncPermissions($data['permission_names']);

        return $role;
    }

    public function updateRole(Role $role, array $data)
    {
        if ($role->name === 'super-admin') {
            throw new RegularException('Super admin role cannot be updated');
        }

        $data['name'] = Str::slug($data['title']);
        $role->update($data);

        $role->syncPermissions($data['permission_names']);

        return $role;
    }
}
