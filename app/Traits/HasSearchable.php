<?php

namespace App\Traits;
use Illuminate\Database\Eloquent\Builder;
use Nicolaslopezj\Searchable\SearchableTrait;

trait HasSearchable
{
    use SearchableTrait;

    /**
     * Apply search to a query builder instance.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $search
     * @param bool $distinct
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApplySearch(Builder $query, string|null $search, bool $distinct = true): Builder
    {
        return $query->search($search)
            ->when($distinct, fn(Builder $query)
                => $query->distinct()); // nicolaslopezj/searchable package doesn't support distinct

    }
}
