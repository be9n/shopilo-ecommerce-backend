<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;

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
        
        // Create Faker instances with specific locales
        $enFaker = FakerFactory::create('en_US');
        $arFaker = FakerFactory::create('ar_SA'); // Saudi Arabia Arabic locale
        
        return [
            'name' => [
                'en' => $enFaker->company(),
                'ar' => $arFaker->company(),
            ],
            'price' => fake()->randomFloat(2, 10, 9999),
            'category_id' => $randomCategoryId
        ];
    }
}
