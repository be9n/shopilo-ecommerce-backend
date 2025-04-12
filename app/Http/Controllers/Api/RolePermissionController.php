<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    /**
     * Get all roles
     */
    public function getRoles()
    {
        $roles = Role::with('permissions:id,name')->get();
        
        return response()->json([
            'success' => true,
            'data' => $roles
        ]);
    }
    
    /**
     * Get all permissions grouped by their group
     */
    public function getPermissions()
    {
        $permissions = Permission::getGroupedPermissions();
        
        return response()->json([
            'success' => true,
            'data' => $permissions
        ]);
    }
    
    /**
     * Get user roles and permissions
     */
    public function getUserRolesAndPermissions(User $user)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'user' => $user->only(['id', 'name', 'email']),
                'roles' => $user->roles->pluck('name'),
                'permissions' => $user->getPermissionNames()
            ]
        ]);
    }
    
    /**
     * Update user roles
     */
    public function updateUserRoles(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id'
        ]);
        
        $user->syncRoles($request->roles);
        
        return response()->json([
            'success' => true,
            'message' => 'User roles updated successfully',
            'data' => [
                'roles' => $user->roles
            ]
        ]);
    }
    
    /**
     * Get only user permission names
     */
    public function getUserPermissionNames(User $user)
    {
        return response()->json([
            'success' => true,
            'data' => $user->getPermissionNames()
        ]);
    }
    
    /**
     * Get user permissions grouped by module
     */
    public function getUserGroupedPermissions(User $user)
    {
        return response()->json([
            'success' => true,
            'data' => $user->getGroupedPermissions()
        ]);
    }
    
    /**
     * Get all permissions grouped by section and group
     */
    public function getSectionedPermissions()
    {
        $permissions = Permission::getSectionedPermissions();
        
        return response()->json([
            'success' => true,
            'data' => $permissions
        ]);
    }
    
    /**
     * Get user permissions grouped by section and group
     */
    public function getUserSectionedPermissions(User $user)
    {
        return response()->json([
            'success' => true,
            'data' => $user->getSectionedPermissions()
        ]);
    }
} 