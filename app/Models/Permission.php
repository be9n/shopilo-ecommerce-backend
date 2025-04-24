<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    protected $fillable = [
        'name',
        'title',
        'description',
        'guard_name',
    ];

    public function children()
    {
        return $this->hasMany(Permission::class, 'parent_id');
    }

    public function scopeMainGroup(Builder $builder)
    {
        $builder->whereNull('parent_id');
    }
}
