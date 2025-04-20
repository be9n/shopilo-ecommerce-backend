<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Admin\Api\BaseApiController;
use App\Http\Resources\Api\Admin\Roles\RoleResource;
use App\Http\Services\RoleService;

class RoleController extends BaseApiController
{
    public function __construct(private RoleService $roleService)
    {
    }

    public function index()
    {
        $sortBy = request('sort_by');
        $sortDir = request('sort_dir');
        $search = request('search');

        return $this->successResponse(
            'Processed successfully',
            [
                'roles' => $this->getPaginatedData(RoleResource::collection($this->roleService->getAllRoles($sortBy, $sortDir, $search)))
            ]
        );
    }
}
