<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randomCategoryId = Category::child()->inRandomOrder()->first();

        return [
            'name' => fake()->name(),
            'price' => fake()->randomFloat(2, 10, 9999),
            'category_id' => $randomCategoryId
        ];
    }
}
