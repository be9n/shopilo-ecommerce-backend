<?php

namespace App\Http\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;

class CategoryService
{
    public function getCategoriesList()
    {
        return Category::get();
    }
}
