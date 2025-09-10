<?php

namespace App\Traits;

use RuntimeException;

trait HasSortable
{
    public function getSortableFields(): array
    {
        if (!property_exists($this, 'sortable')) {
            throw new RuntimeException(
                sprintf(
                    'Model %s must define a protected $sortable array property.'
                    ,
                    static::class
                )
            );
        }

        return $this->sortable;
    }

    public function scopeSortBy($query, string|null $sortBy, string|null $sortDirection)
    {
        if (!$sortBy || !in_array($sortBy, $this->getSortableFields())) {
            return $query;
        }

        // Handle translatable fields if applicable
        if (isset($this->translatable) && in_array($sortBy, $this->translatable)) {
            $sortBy = $sortBy . '->' . app()->getLocale();
        }

        // Add the table name to the sortBy so it doesn't conflict with other tables
        $sortBy = $this->getTable() . '.' . $sortBy;

        return $query->orderBy($sortBy, $sortDirection ?? config('query-params.default_sort_dir'));
    }
}