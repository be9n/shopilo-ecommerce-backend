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


        $allPermissionTree = $this->getAllPermissions();

        $this->deleteUnusedPermissions($allPermissionTree);
        $this->seedPermissions($allPermissionTree);
    }

    private function seedPermissions(array $allPermissionTrees, $parentId = null): void
    {
        foreach ($allPermissionTrees as $permission) {
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

    private function deleteUnusedPermissions($permissionTree)
    {
        function getAllPermissionNames(array $permissionTree): array
        {
            $names = [];

            foreach ($permissionTree as $permission) {
                $names[] = strtolower($permission['name']);

                if (isset($permission['children']) && is_array($permission['children'])) {
                    $names = array_merge($names, getAllPermissionNames($permission['children']));
                }
            }

            return $names;
        }

        $permissionNames = getAllPermissionNames($permissionTree);

        Permission::whereNotIn('name', $permissionNames)->delete();
    }

    private function getAllPermissions()
    {
        $directory = __DIR__ . '/data/permissions';
        $allPermissionTree = [];
        foreach (scandir($directory) as $file) {
            if ($file === '.' || $file === '..')
                continue;
            $fileData = include $directory . '/' . $file;
            $allPermissionTree[] = $fileData;
        }

        return $allPermissionTree;
    }
}