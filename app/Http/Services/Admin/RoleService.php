<?php

namespace App\Http\Services\Admin;

use App\Exceptions\RegularException;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class RoleService extends BaseService
{
    public function getAllRoles(array $params = [])
    {
        $params = $this->prepareCommonQueryParams($params);

        return Role::withCount('permissions')
            ->whereNot('roles.name', 'super-admin')
            ->applySearch($params['search'])
            ->sortBy($params['sort_by'], $params['sort_dir'])
            ->paginate($params['per_page']);
    }

    public function createRole(array $data): Role
    {
        return DB::transaction(function () use ($data) {
            $data['name'] = Str::slug($data['title']);
            $data['guard_name'] = 'web';
            $role = Role::create($data);

            $role->syncPermissions($data['permission_names']);

            return $role;
        });
    }

    public function updateRole(Role $role, array $data): Role
    {
        if ($role->name === 'super-admin') {
            throw new RegularException('Super admin role cannot be updated');
        }

        return DB::transaction(function () use ($role, $data) {
            $data['name'] = Str::slug($data['title']);
            $role->update($data);
            $role->syncPermissions($data['permission_names']);

            return $role;
        });
    }
}
