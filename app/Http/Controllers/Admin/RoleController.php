<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\RegularException;
use App\Http\Controllers\Admin\BaseApiController;
use App\Http\Requests\Admin\Roles\RoleCreateRequest;
use App\Http\Requests\Admin\Roles\RoleUpdateRequest;
use App\Http\Resources\Admin\Roles\EditRoleResource;
use App\Http\Resources\Admin\Roles\RoleResource;
use App\Http\Services\Admin\RoleService;
use App\Models\Role;

class RoleController extends BaseApiController
{
    public function __construct(private RoleService $roleService)
    {
        $this->middleware('permission:user_management.roles.view_all')->only('index');
        $this->middleware('permission:user_management.roles.view')->only('show');
        $this->middleware('permission:user_management.roles.create')->only('store');
        $this->middleware('permission:user_management.roles.edit')->only('update');
        $this->middleware('permission:user_management.roles.delete')->only('destroy');
    }

    public function index()
    {
        $roles = $this->roleService->getAllRoles(request()->query());

        return $this->successResponse(
            __('Processed successfully'),
            [
                'roles' => $this->withCustomPagination($roles, RoleResource::class)
            ]
        );
    }

    public function show(Role $role)
    {
        return $this->successResponse(
            __('Processed successfully'),
            [
                'role' => EditRoleResource::make($role->load('permissions'))
            ]
        );
    }

    public function store(RoleCreateRequest $request)
    {
        $this->roleService->createRole($request->validated());

        return $this->successResponse(
            __('Role created successfully')
        );
    }

    public function update(RoleUpdateRequest $request, Role $role)
    {
        try {
            $this->roleService->updateRole($role, $request->validated());

            return $this->successResponse(__('Role updated successfully'));
        } catch (RegularException $e) {
            return $this->failResponse($e->getMessage());
        }
    }
}