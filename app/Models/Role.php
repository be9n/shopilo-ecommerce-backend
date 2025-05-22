<?php

namespace App\Models;

use App\Contracts\Sortable as SortableContract;
use App\Traits\HasSearchable;
use App\Traits\HasSortable;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole implements SortableContract
{
    use HasSearchable, HasSortable;

    protected $searchable = [
        'columns' => [
            'roles.name' => 10,
            'permissions.name' => 10,
        ],
        'joins' => [
            'role_has_permissions' => ['roles.id', 'role_has_permissions.role_id'],
            'permissions' => ['role_has_permissions.permission_id', 'permissions.id'],
        ],
    ];

    protected $fillable = [
        'name',
        'title',
        'guard_name'
    ];

    protected $sortable = [
        'id',
        'name',
        'created_at',
        'updated_at'
    ];
}
