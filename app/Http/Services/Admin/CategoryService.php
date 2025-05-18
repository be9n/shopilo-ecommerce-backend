<?php

namespace App\Http\Services\Admin;

use App\Exceptions\CanBeDeletedException;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;

class CategoryService
{

    public function getAllCategories(?string $sortBy, ?string $sortDir, ?string $search)
    {
        return Category::query()
            ->with('parent')
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->when($sortBy, function (Builder $builder) use ($sortBy, $sortDir) {
                return $builder->orderBy($sortBy, $sortDir ?? 'asc');
            })
            ->withCount('products')
            ->paginate(10);
    }

    public function getCategoriesList(bool $parent = false, bool $withChildren = false)
    {
        return Category::when(
            $parent,
            function (Builder $builder) use ($withChildren) {
                // When $parent is true - get only parent categories
                return $builder
                    ->when(
                        $withChildren,
                        fn(Builder $q) => $q->with('children')
                    )
                    ->parent();
            },
            fn(Builder $q) => $q->child()
        )
            ->get();
    }

    public function createCategory($data)
    {
        $category = Category::create($data);
        if (isset($data['image'])) {
            $category->storeFile($data['image']);
        }

        return $category;
    }

    public function updateCategory(Category $category, $data)
    {
        $category->update($data);
        if (isset($data['image'])) {
            $category->updateFile($data['image']);
        }

        return $category;
    }

    public function deleteCategory(Category $category)
    {
        if (!$category->can_be_deleted) {
            throw new CanBeDeletedException('Category has children');
        }

        return $category->delete();
    }
}
