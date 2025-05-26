<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Categories\CategoryCreateRequest;
use App\Http\Requests\Admin\Categories\CategoryUpdateRequest;
use App\Http\Resources\Admin\Categories\CategoryListResource;
use App\Http\Resources\Admin\Categories\CategoryResource;
use App\Http\Resources\Admin\Categories\EditCategoryResource;
use App\Http\Services\Admin\CategoryService;
use App\Models\Category;

class CategoryController extends BaseApiController
{
    public function __construct(private CategoryService $categoryService)
    {
        $this->service = $categoryService;
    }

    public function index()
    {
        $categories = $this->categoryService->getAllCategories(params: request()->query());

        return $this->successResponse(
            __('Processed successfully'),
            [
                'categories' => $this->withCustomPagination($categories, CategoryResource::class)
            ]
        );
    }

    public function show(Category $category)
    {
        return $this->successResponse(
            __('Processed successfully'),
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

        return $this->successResponse(__('Category created successfully'));
    }

    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $validated = $request->validated();

        $this->categoryService->updateCategory($category, $validated);

        return $this->successResponse(__('Category updated successfully'));
    }

    public function destroy(Category $category)
    {
        $this->categoryService->deleteCategory($category);

        return $this->successResponse(__('Category deleted successfully'));
    }

    public function list()
    {
        $parent = request('parent', false);
        $withChildren = request('with_children', false);

        $categories = $this->categoryService->getCategoriesList($parent, $withChildren);

        return $this->successResponse(
            __('Processed successfully'),
            [
                'categories' => CategoryListResource::collection($categories)
            ]
        );
    }
}
