<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller
{
    /**
     * Show user roles management page
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $userRoles = $user->roles->pluck('id')->toArray();
        
        return Inertia::render('Admin/Users/Roles', [
            'user' => $user,
            'roles' => $roles,
            'userRoles' => $userRoles
        ]);
    }
    
    /**
     * Update user roles
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'required|array'
        ]);
        
        // If trying to remove super-admin from self, prevent it
        if ($user->id === auth()->id() && 
            $user->hasRole('super-admin') && 
            !in_array(Role::where('name', 'super-admin')->first()->id, $request->roles)) {
            return redirect()->back()
                ->with('error', 'You cannot remove the Super Admin role from yourself');
        }
        
        $user->syncRoles($request->roles);
        
        return redirect()->back()->with('success', 'User roles updated successfully');
    }
} 