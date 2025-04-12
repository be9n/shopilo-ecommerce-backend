<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();


        $allPermissions = $this->getAllPermissions();
        $this->deleteUnusedPermissions($allPermissions);

        foreach ($allPermissions as $item) {
            $permission = Permission::firstOrNew([
                'name' => $item['name']
            ]);
            $permission->title = $item['title'];
            $permission->section = $item['section'];
            $permission->description = $item['description'];
            $permission->save();
        }
    }

    public function getAllPermissions()
    {
        $directory = __DIR__ . '/data/permissions';
        $allPermissions = [];
        foreach (scandir($directory) as $file) {
            if ($file === '.' || $file === '..')
                continue;

            $allPermissions = array_merge($allPermissions, include($directory . '/' . $file));
        }

        return $allPermissions;
    }

    public function deleteUnusedPermissions($permissions)
    {
        $permissionNames = collect($permissions)
            ->select('name')
            ->map(fn($permission) => strtolower($permission['name']))
            ->toArray();

        Permission::whereNotIn('name', $permissionNames)->delete();
    }
}