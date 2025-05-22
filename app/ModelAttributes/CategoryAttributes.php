<?php

namespace App\ModelAttributes;

use App\Models\Category;

class CategoryAttributes
{
    /**
     * Get the can be deleted attribute with detailed status.
     *
     * @param Category $category
     * @return array {
     *     @var string|null $message
     *     @var bool $status
     * }
     */
    public static function canBeDeleted(Category $category): array
    {
        if ($category->parent_id === null && $category->children()->exists()) {
            return [
                'message' => __('This category cannot be deleted due to having children'),
                'status' => false,
            ];
        }

        if ($category->products()->exists()) {
            return [
                'message' => __('This category cannot be deleted due to having products'),
                'status' => false,
            ];
        }

        return [
            'status' => true,
        ];
    }
}