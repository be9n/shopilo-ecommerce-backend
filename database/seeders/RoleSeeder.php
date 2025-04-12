<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedSuperAdmin();
        $this->seedManager();
    }

    public function seedSuperAdmin(): void
    {
        $permissionIds = Permission::pluck('id')->toArray();

        $superAdminRole = Role::where('name', 'super-admin')->firstOrNew();
        $superAdminRole->name = 'super-admin';
        $superAdminRole->title = 'Super Admin';
        $superAdminRole->save();

        $superAdminRole->syncPermissions($permissionIds);
    }

    public function seedManager(): void
    {
        $managerRole = Role::where('name', 'manager')->firstOrNew();
        $managerRole->name = 'manager';
        $managerRole->title = 'Manager';
        $managerRole->save();

        $managerRole->givePermissionTo([
            'user_management.users.view_all',
            'user_management.users.view',
        ]);
    }
}