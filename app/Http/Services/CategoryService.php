<?php

namespace App\Http\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;

class CategoryService
{
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
}
