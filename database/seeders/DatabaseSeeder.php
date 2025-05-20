<?php

namespace Database\Seeders;

use App\Enums\AdminRoleEnum;
use App\Exceptions\RegularException;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Run permission and role seeders
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            // CategorySeeder::class,
            // ProductSeeder::class,
        ]);

        $this->createSuperAdmin();
    }

    private function createSuperAdmin()
    {
        $email = config('admin.super_admin.email');
        $password = config('admin.super_admin.password');
        $name = config('admin.super_admin.name');

        if (empty($email) || empty($password)) {
            throw new RegularException(
                'Super admin email and password must be defined in your environment. ' .
                'Please check your .env file for ADMIN_SUPER_EMAIL and ADMIN_SUPER_PASSWORD keys.'
            );
        }

        $admin = User::firstWhere('email', $email);
        if (!$admin) {
            $admin = User::create([
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'user_type' => 'admin'
            ]);

            $admin->assignRole(AdminRoleEnum::SUPER_ADMIN->value);
        }
    }
}
