<?php

namespace App\ModelFilters;

class ProductFilter extends BaseFilter
{
    public function categorySetup($query)
    {
        return $query->child();
    }

    public function category($id)
    {
        return $this->where('category_id', $id);
    }
}