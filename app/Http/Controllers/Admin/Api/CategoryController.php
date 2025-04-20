<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Resources\Api\Admin\Categories\CategoryResource;
use App\Http\Services\CategoryService;

class CategoryController extends BaseApiController
{
    public function __construct(private CategoryService $categoryService)
    {
    }

    public function categoriesList()
    {
        return $this->successResponse(
            'Processed successfully',
            [
                'categories' => $this->getPaginatedData(
                    CategoryResource::collection(
                        $this->categoryService->getCategoriesList()
                    )
                )
            ]
        );
    }
}
