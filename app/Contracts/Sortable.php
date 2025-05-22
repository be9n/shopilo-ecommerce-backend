<?php

namespace App\Contracts;

interface Sortable
{
    /**
     * Get the sortable fields for the model.
     *
     * @return array<string>
     * @throws \RuntimeException
     */
    public function getSortableFields(): array;

    /**
     * Apply sorting to a query builder instance.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $sortBy
     * @param string|null $sortDirection
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSortBy($query, string|null $sortBy, string|null $sortDirection);
}