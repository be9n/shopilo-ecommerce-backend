<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginatedResource extends JsonResource
{
    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    protected $resourceClass;

    /**
     * Create a new resource instance.
     *
     * @param  mixed  $resource
     * @param  string|null  $resourceClass
     * @return void
     */
    public function __construct($resource, $resourceClass = null)
    {
        parent::__construct($resource);

        if ($resourceClass) {
            $this->resourceClass = $resourceClass;
        }
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $paginator = $this->resource;
        if (!$paginator instanceof LengthAwarePaginator) {
            return [
                'data' => $this->resourceClass::collection($this->resource)->toArray($request),
            ];
        }

        return [
            'data' => $this->resourceClass::collection($paginator->items())->toArray($request),
            'pagination' => [
                'has_pages' => $paginator->lastPage() > 1,
                'current_page' => $paginator->currentPage(),
                'next_page' => $paginator->hasMorePages() ? $paginator->currentPage() + 1 : null,
                'prev_page' => $paginator->currentPage() > 1 ? $paginator->currentPage() - 1 : null,
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total_records' => $paginator->total(),
                'from' => $paginator->firstItem() ?: 0,
                'to' => $paginator->lastItem() ?: 0,
                'has_more_pages' => $paginator->hasMorePages(),
                'path' => $paginator->path(),
            ],
        ];
    }
}