<?php

namespace Database\Seeders;

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
            PermissionSeeder2::class,
            RoleSeeder::class,
            // CategorySeeder::class,
            // ProductSeeder::class,
        ]);

        $admin = User::firstWhere('email', 'super-admin@gmail.com');
        if (!$admin) {
            $admin = User::create([
                'name' => 'Super Admin User',
                'email' => 'super-admin@gmail.com',
                'password' => "123123"
            ]);

            $admin->assignRole('super-admin');
        }


        $manager = User::firstWhere('email', 'manager@gmail.com');
        if (!$manager) {
            $manager = User::factory()->create([
                'name' => 'Manager User',
                'email' => 'manager@gmail.com',
                'password' => "123123"
            ]);

            $manager->assignRole('manager');
        }
    }
}
