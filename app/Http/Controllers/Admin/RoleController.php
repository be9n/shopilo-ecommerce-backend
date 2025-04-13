<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\Admin\Roles\RoleResource;
use App\Http\Services\RoleService;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct(private RoleService $roleService)
    {
    }

    public function index()
    {
        return inertia('admin/roles/index', [
            'roles' => RoleResource::collection($this->roleService->getAllRoles())
        ]);
    }

    /**
     * Show the form for creating a new role
     */
    public function create()
    {
        $permissions = Permission::getGroupedPermissions();

        return Inertia::render('Admin/Roles/Create', [
            'permissions' => $permissions
        ]);
    }

    /**
     * Store a newly created role
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'required|array'
        ]);

        DB::transaction(function () use ($request) {
            $role = Role::create(['name' => $request->name]);
            $role->syncPermissions($request->permissions);
        });

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role created successfully');
    }

    /**
     * Show the form for editing the role
     */
    public function edit(Role $role)
    {
        $role->load('permissions');
        $permissions = Permission::getGroupedPermissions();

        return Inertia::render('Admin/Roles/Edit', [
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $role->permissions->pluck('id')->toArray()
        ]);
    }

    /**
     * Update the role
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
            'permissions' => 'required|array'
        ]);

        DB::transaction(function () use ($request, $role) {
            $role->update(['name' => $request->name]);
            $role->syncPermissions($request->permissions);
        });

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role updated successfully');
    }

    /**
     * Delete the role
     */
    public function destroy(Role $role)
    {
        if ($role->name === 'super-admin') {
            return to_route('admin.roles.index')
                ->withAlert('Super Admin role cannot be deleted', 'error');
        }

        $role->delete();

        return redirect()->back()->withAlert('Deleted successfully!');
    }
}
