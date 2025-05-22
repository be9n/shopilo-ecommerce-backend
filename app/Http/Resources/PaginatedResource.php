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
    protected $collects;

    /**
     * Create a new resource instance.
     *
     * @param  mixed  $resource
     * @param  string|null  $collects
     * @return void
     */
    public function __construct($resource, $collects = null)
    {
        parent::__construct($resource);

        if ($collects) {
            $this->collects = $collects;
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
                'data' => $this->resource->toArray(),
            ];
        }

        $resourceClass = $this->collects;

        return [
            'data' => $resourceClass::collection($paginator->items())->toArray($request),
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