<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChangeActiveRequest;
use App\Http\Resources\PaginatedResource;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Traits\PaginatedResponseTrait;

class BaseApiController extends Controller
{
    use ApiResponseTrait, PaginatedResponseTrait;

    protected $service;

    /**
     * Create a paginated resource from a paginator and resource class.
     *
     * @param mixed $paginator The paginator instance
     * @param string $resourceClass The resource class to use for items
     * @return PaginatedResource
     */
    protected function withCustomPagination($paginator, string $resourceClass)
    {
        return new PaginatedResource($paginator, $resourceClass);
    }

    public function changeActive(ChangeActiveRequest $request, int $id)
    {
        $this->service->changeActive($id, $request->active);

        return $this->successResponse(__('Active status updated successfully'));
    }
}
