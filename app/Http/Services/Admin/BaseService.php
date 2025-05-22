<?php

namespace App\Http\Services\Admin;

class BaseService
{

    /**
     * Prepare common query params
     *
     * @param array $params
     * @return array {per_page: string|null, search: string|null, sort_by: string|null, sort_dir: string|null}
     */
    protected function prepareCommonQueryParams(array $params): array
    {
        return [
            'sort_by' => $params['sort_by'] ?? null,
            'sort_dir' => $params['sort_dir'] ?? config('query-params.default_sort_dir'),
            'search' => $params['search'] ?? null,
            'per_page' => $params['per_page'] ?? config('query-params.per_page.default'),
        ];
    }
}
