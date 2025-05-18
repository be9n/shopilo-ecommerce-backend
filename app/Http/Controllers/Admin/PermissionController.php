<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseApiController;
use App\Http\Resources\Api\Admin\Permissions\PermissionResource;
use App\Models\Permission;

class PermissionController extends BaseApiController
{

    public function permissionsList()
    {
        return $this->successResponse(__('Processed successfully'), [
            'permissions_list' => PermissionResource::collection(Permission::mainGroup()->with('children.children')->get())
        ]);
    }
}
