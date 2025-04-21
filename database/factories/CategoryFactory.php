<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // $isParent = fake()->boolean();
        // $randomParentCategoryId = Category::parent()->inRandomOrder()->first()?->id ?? null;

        return [
            'name' => fake()->company(),
            // 'parent_id' => $isParent ? null : $randomParentCategoryId,// 50% chance to assign a parent
            'parent_id' => null,
        ];
    }

    public function asChild(): static
    {
        return $this->state(function (array $attributes) {
            $randomParentCategoryId = Category::query()->parent()->inRandomOrder()->first()?->id ?? null;

            return [
                'parent_id' => $randomParentCategoryId,
            ];
        });
    }
}
