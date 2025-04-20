<?php

namespace App\Http\Services;

use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;


class RoleService
{
    public function getAllRoles(?string $sortBy = null, ?string $sortDir = null, ?string $search = null)
    {
        return Role::withCount('permissions')
            ->when($sortBy, function (Builder $builder) use ($sortBy, $sortDir) {
                return $builder->orderBy($sortBy, $sortDir ?? 'asc');
            })
            ->when($search, function (Builder $builder) use ($search) {
                return $builder->where('title', 'like', "%$search%");
            })
            ->paginate(10);
    }
}
