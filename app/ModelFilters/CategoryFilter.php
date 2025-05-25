<?php

namespace App\ModelFilters;

class CategoryFilter extends BaseFilter
{
    public function hasParent($hasParent = true)
    {
        return $hasParent 
            ? $this->whereNotNull($this->column('parent_id'))
            : $this->whereNull($this->column('parent_id'));
    }

    public function parentId($parentId)
    {
        return $this->where($this->column('parent_id'), $parentId);
    }
}
