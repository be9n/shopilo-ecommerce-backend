<?php

namespace App\Http\Controllers\Admin\Api;

use App\Exceptions\RegularException;
use App\Http\Controllers\Admin\Api\BaseApiController;
use App\Http\Requests\Api\Roles\RoleCreateRequest;
use App\Http\Requests\Api\Roles\RoleUpdateRequest;
use App\Http\Resources\Api\Admin\Roles\EditRoleResource;
use App\Http\Resources\Api\Admin\Roles\RoleResource;
use App\Http\Services\RoleService;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

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

        $roles = $this->roleService->getAllRoles($sortBy, $sortDir, $search);

        return $this->successResponse(
            'Processed successfully',
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
            'Processed successfully',
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
            return $this->successResponse();
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
            return $this->successResponse();
        } catch (RegularException $th) {
            DB::rollBack();
            return $this->failResponse($th->getMessage());
        }
    }
}