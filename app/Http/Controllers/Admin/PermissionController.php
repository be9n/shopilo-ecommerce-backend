<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PermissionController extends Controller
{
    /**
     * Display a listing of permissions grouped by their group
     */
    public function index()
    {
        $groupedPermissions = Permission::getGroupedPermissions();
        
        return Inertia::render('Admin/Permissions/Index', [
            'groupedPermissions' => $groupedPermissions
        ]);
    }
    
    /**
     * Show the form for creating a new permission
     */
    public function create()
    {
        // Get all unique permission groups
        $groups = Permission::select('group')->distinct()->pluck('group');
        
        return Inertia::render('Admin/Permissions/Create', [
            'groups' => $groups
        ]);
    }
    
    /**
     * Store a newly created permission
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name',
            'group' => 'required|string'
        ]);
        
        Permission::create([
            'name' => $request->name,
            'group' => $request->group
        ]);
        
        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission created successfully');
    }
    
    /**
     * Show the form for editing the permission
     */
    public function edit(Permission $permission)
    {
        // Get all unique permission groups
        $groups = Permission::select('group')->distinct()->pluck('group');
        
        return Inertia::render('Admin/Permissions/Edit', [
            'permission' => $permission,
            'groups' => $groups
        ]);
    }
    
    /**
     * Update the permission
     */
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $permission->id,
            'group' => 'required|string'
        ]);
        
        $permission->update([
            'name' => $request->name,
            'group' => $request->group
        ]);
        
        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission updated successfully');
    }
    
    /**
     * Delete the permission
     */
    public function destroy(Permission $permission)
    {
        // Check if this permission is assigned to any role
        if ($permission->roles()->count() > 0) {
            return redirect()->route('admin.permissions.index')
                ->with('error', 'Cannot delete permission as it is assigned to at least one role');
        }
        
        $permission->delete();
        
        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission deleted successfully');
    }
}
