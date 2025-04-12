<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    protected $fillable = [
        'name',
        'guard_name',
        'group',
        'section',
        'description'
    ];
    
    /**
     * Get permissions grouped by their group
     *
     * @return array
     */
    public static function getGroupedPermissions()
    {
        $permissions = self::all();
        $groupedPermissions = [];
        
        foreach ($permissions as $permission) {
            $groupedPermissions[$permission->group][] = $permission;
        }
        
        return $groupedPermissions;
    }
    
    /**
     * Get permissions grouped by section and then by group
     *
     * @return array
     */
    public static function getSectionedPermissions()
    {
        $permissions = self::all();
        $sectionedPermissions = [];
        
        foreach ($permissions as $permission) {
            $section = $permission->section ?? 'Other';
            $group = $permission->group;
            
            if (!isset($sectionedPermissions[$section])) {
                $sectionedPermissions[$section] = [];
            }
            
            if (!isset($sectionedPermissions[$section][$group])) {
                $sectionedPermissions[$section][$group] = [];
            }
            
            $sectionedPermissions[$section][$group][] = $permission;
        }
        
        return $sectionedPermissions;
    }
    
    /**
     * Determine if this permission is a wildcard permission
     */
    public function isWildcard(): bool
    {
        return str_contains($this->name, '*');
    }
    
    /**
     * Get base permission name (without wildcards)
     */
    public function getBasePermission(): string
    {
        return str_replace('.*', '', $this->name);
    }
    
    /**
     * Get all non-wildcard permissions for a specific module
     */
    public static function getModulePermissions(string $module): array
    {
        return self::where('name', 'like', $module . '.%')
            ->where('name', 'not like', '%*%')
            ->get()
            ->toArray();
    }
}
