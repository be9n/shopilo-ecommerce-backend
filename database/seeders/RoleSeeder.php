<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
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

        $superAdminRole = Role::where('name', RoleEnum::SUPER_ADMIN->value)->firstOrNew();
        $superAdminRole->name = RoleEnum::SUPER_ADMIN->value;
        $superAdminRole->title = RoleEnum::SUPER_ADMIN->title();
        $superAdminRole->save();

        $superAdminRole->syncPermissions($permissionIds);
    }

    public function seedManager(): void
    {
        $managerRole = Role::where('name', RoleEnum::MANAGER->value)->firstOrNew();
        $managerRole->name = RoleEnum::MANAGER->value;
        $managerRole->title = RoleEnum::MANAGER->title();
        $managerRole->save();

        $managerRole->givePermissionTo([
            'user_management.users.view_all',
            'user_management.users.view',
        ]);
    }
}