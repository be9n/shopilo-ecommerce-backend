<?php

namespace App\Http\Traits;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

trait PaginatedResponseTrait
{
    // protected function paginatedResponse(string $message, ResourceCollection $resource): \Illuminate\Http\JsonResponse
    // {
    //     $paginator = $resource->resource;

    //     if (!$paginator instanceof LengthAwarePaginator) {
    //         return $this->successResponse($message, $resource->resolve());
    //     }

    //     return $this->successResponse($message, [
    //         'data' => $resource->resolve(),
    //         'pagination' => $this->getPaginationData($paginator)
    //     ]);
    // }

    protected function getPaginationData(LengthAwarePaginator $paginator): array
    {
        $hasPages = $paginator->lastPage() > 1;
        return [
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
            'next_page' => $paginator->hasMorePages() ? $paginator->currentPage() + 1 : null,
            'prev_page' => $paginator->currentPage() > 1 ? $paginator->currentPage() - 1 : null,
            'per_page' => $paginator->perPage(),
            'total_records' => $paginator->total(),
            'has_pages' => $hasPages,
            'has_next_page' => $paginator->hasMorePages(),
            'has_prev_page' => $hasPages && $paginator->currentPage() > 1,
            'from' => $paginator->firstItem(),
            'to' => $paginator->lastItem(),
            'path' => $paginator->path(),
        ];
    }

    protected function getPaginatedData(ResourceCollection $resource)
    {
        $paginator = $resource->resource;
        if (!$paginator instanceof LengthAwarePaginator) {
            return $resource->resolve();
        }

        return [
            'data' => $resource->resolve(),
            'pagination' => $this->getPaginationData($paginator)
        ];
    }
}