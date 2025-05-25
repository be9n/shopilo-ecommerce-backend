<?php

namespace App\ModelFilters;

use App\Exceptions\RegularException;
use Carbon\Carbon;
use EloquentFilter\ModelFilter;

class BaseFilter extends ModelFilter
{
    /**
     * Get the table name for the current model.
     *
     * @return string
     */
    protected function getTableName(): string
    {
        return $this->getModel()->getTable();
    }

    /**
     * Get a column name prefixed with the table name.
     *
     * @param string $column
     * @return string
     */
    protected function column(string $column): string
    {
        return $this->getTableName() . '.' . $column;
    }

    public function createdBetween($dates)
    {
        [$start, $end] = explode(',', $dates);
        if (empty($start) || empty($end)) {
            throw new RegularException('Date range must contain exactly 2 dates separated by comma');
        }

        $start = Carbon::parse($start);
        $end = Carbon::parse($end);

        if ($start->isAfter($end)) {
            throw new RegularException('Start date must be before end date');
        }

        return $this->whereBetween($this->column('created_at'), [$start, $end]);
    }

    public function minPrice($price)
    {
        return $this->where($this->column('price'), '>=', $price);
    }

    public function maxPrice($price)
    {
        return $this->where($this->column('price'), '<=', $price);
    }

    public function active($active)
    {
        return $this->where($this->column('active'), $active);
    }
}