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
use Illuminate\Support\Facades\DB;

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
        $sortBy = request('sort_by');
        $sortDir = request('sort_dir');
        $search = request('search');

        $roles = $this->roleService->getAllRoles($sortBy, $sortDir, $search);

        return $this->successResponse(
            __('Processed successfully'),
            [
                'roles' => $this->getPaginatedData(
                    RoleResource::collection(
                        $roles
                    )
                )
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
        $validated = $request->validated();

        DB::beginTransaction();
        try {
            $this->roleService->createRole($validated);

            DB::commit();
            return $this->successResponse(__('Role created successfully'));
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function update(RoleUpdateRequest $request, Role $role)
    {
        $validated = $request->validated();

        DB::beginTransaction();
        try {
            $this->roleService->updateRole($role, $validated);

            DB::commit();
            return $this->successResponse(__('Role updated successfully'));
        } catch (RegularException $th) {
            DB::rollBack();
            return $this->failResponse($th->getMessage());
        }
    }
}