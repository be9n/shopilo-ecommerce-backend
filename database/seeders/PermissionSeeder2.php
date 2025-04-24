<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder2 extends Seeder
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

        $this->seedPermissions($allPermissions);
    }

    private function seedPermissions(array $permissions, $parentId = null): void
    {
        foreach ($permissions as $permission) {
            $newPermission = Permission::firstOrNew([
                'name' => $permission['name']
            ]);
            $newPermission->parent_id = $parentId;
            $newPermission->title = $permission['title'];
            $newPermission->description = $permission['description'];
            $newPermission->guard_name = 'web';
            $newPermission->save();

            if (isset($permission['children']) && is_array($permission['children'])) {
                $this->seedPermissions($permission['children'], $newPermission->id);
            }
        }
    }

    private function getAllPermissions()
    {
        $directory = __DIR__ . '/data/test';
        $allPermissions = [];
        foreach (scandir($directory) as $file) {
            if ($file === '.' || $file === '..')
                continue;

            $allPermissions = array_merge($allPermissions, include($directory . '/' . $file));
        }

        return $allPermissions;
    }

    private function deleteUnusedPermissions($permissions)
    {
        function getAllPermissionNames(array $permissions): array
        {
            $names = [];

            foreach ($permissions as $permission) {
                $names[] = strtolower($permission['name']);

                if (isset($permission['children']) && is_array($permission['children'])) {
                    $names = array_merge($names, getAllPermissionNames($permission['children']));
                }
            }

            return $names;
        }

        $permissionNames = getAllPermissionNames($permissions);

        Permission::whereNotIn('name', $permissionNames)->delete();
    }
}