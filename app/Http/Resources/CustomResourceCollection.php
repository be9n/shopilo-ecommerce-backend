<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CustomResourceCollection extends AnonymousResourceCollection
{
    /**
     * Add the pagination information to the response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $paginated
     * @param  array  $default
     * @return array
     */
    public function paginationInformation($request, $paginated, $default)
    {
        $lastPage = $paginated['last_page'];
        $hasNextPage = $paginated['current_page'] < $lastPage;
        $hasPrevPage = $paginated['current_page'] > 1;

        return [
            'pagination' => [
                'current_page' => $paginated['current_page'],
                'last_page' => $lastPage,
                'next_page' => $hasNextPage ? $paginated['current_page'] + 1 : null,
                'prev_page' => $hasPrevPage ? $paginated['current_page'] - 1 : null,
                'per_page' => $paginated['per_page'],
                'total_records' => $paginated['total'],
                'has_pages' => $lastPage > 1,
                'has_next_page' => $hasNextPage,
                'has_prev_page' => $hasPrevPage,
                'from' => $paginated['from'],
                'to' => $paginated['to'],
                'path' => $paginated['path'],
            ]
        ];
    }
}
