<?php

namespace App\Http\Services\Admin;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;

class CategoryService extends BaseService
{

    public function getAllCategories(array $params = [])
    {
        $params = $this->prepareCommonQueryParams($params);

        return Category::query()
            ->with('parent')
            ->withCount('products')
            ->applySearch($params['search'])
            ->sortBy($params['sort_by'], $params['sort_dir'])
            ->paginate($params['per_page']);
    }

    public function getCategoriesList(bool $parent = false, bool $withChildren = false)
    {
        return Category::when(
            value: $parent,
            callback: function (Builder $builder) use ($withChildren) {
                // When $parent is true - get only parent categories
                return $builder
                    ->when(
                        $withChildren,
                        fn(Builder $q) => $q->with('children')
                    )
                    ->parent();
            },
            default: fn(Builder $q) => $q->child()
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
        $category->ensureAbility('canBeDeleted');

        return $category->delete();
    }
}
