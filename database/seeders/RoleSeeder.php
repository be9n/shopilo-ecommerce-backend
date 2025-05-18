<?php

namespace Database\Seeders;

use App\Enums\AdminRoleEnum;
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
    }

    public function seedSuperAdmin(): void
    {
        $permissionIds = Permission::pluck('id')->toArray();

        $superAdminRole = Role::where('name', AdminRoleEnum::SUPER_ADMIN->value)->firstOrNew();
        $superAdminRole->name = AdminRoleEnum::SUPER_ADMIN->value;
        $superAdminRole->title = AdminRoleEnum::SUPER_ADMIN->title();
        $superAdminRole->save();

        $superAdminRole->syncPermissions($permissionIds);
    }
}