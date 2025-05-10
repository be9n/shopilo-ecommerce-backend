<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Requests\Api\Categories\CategoryCreateRequest;
use App\Http\Requests\Api\Categories\CategoryUpdateRequest;
use App\Http\Resources\Api\Admin\Categories\CategoryListResource;
use App\Http\Resources\Api\Admin\Categories\CategoryResource;
use App\Http\Resources\Api\Admin\Categories\EditCategoryResource;
use App\Http\Services\CategoryService;
use App\Models\Category;

class CategoryController extends BaseApiController
{
    public function __construct(private CategoryService $categoryService)
    {
    }

    public function index()
    {
        $sortBy = request('sort_by');
        $sortDir = request('sort_dir');
        $search = request('search');

        return $this->successResponse(
            'Processed successfully',
            [
                'categories' => $this->getPaginatedData(
                    CategoryResource::collection(
                        $this->categoryService->getAllCategories($sortBy, $sortDir, $search)
                    )
                )
            ]
        );
    }

    public function show(Category $category)
    {
        return $this->successResponse(
            'Processed successfully',
            [
                'category' =>
                    EditCategoryResource::make(
                        $category
                    )
            ]
        );
    }

    public function store(CategoryCreateRequest $request)
    {
        $validated = $request->validated();

        $this->categoryService->createCategory($validated);

        return $this->successResponse('Category created successfully');
    }

    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $validated = $request->validated();

        $this->categoryService->updateCategory($category, $validated);

        return $this->successResponse('Category updated successfully');
    }

    public function destroy(Category $category)
    {
        $this->categoryService->deleteCategory($category);

        return $this->successResponse('Category deleted successfully');
    }

    public function categoriesList()
    {
        $parent = request('parent', false);
        $withChildren = request('with_children', false);

        return $this->successResponse(
            'Processed successfully',
            [
                'categories' => $this->getPaginatedData(
                    CategoryListResource::collection(
                        $this->categoryService->getCategoriesList($parent, $withChildren)
                    )
                )
            ]
        );
    }
}
