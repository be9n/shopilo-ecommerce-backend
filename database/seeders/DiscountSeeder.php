<?php

namespace Database\Seeders;

use App\Models\Discount;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $discountTypes = ['fixed', 'percentage'];
        $languages = ['en', 'ar'];
        
        for ($i = 1; $i <= 20; $i++) {
            $isPercentage = $discountTypes[array_rand($discountTypes)] === 'percentage';
            $value = $isPercentage ? rand(5, 50) : rand(5, 100);
            $type = $isPercentage ? 'percentage' : 'fixed';
            
            // Generate start and end dates
            $startDate = Carbon::now()->subDays(rand(0, 10));
            $endDate = Carbon::now()->addDays(rand(15, 60));
            
            // Generate translatable name and description
            $name = [];
            $description = [];
            
            foreach ($languages as $lang) {
                $name[$lang] = "Discount " . $i . " " . ($lang === 'ar' ? 'خصم' : '');
                $description[$lang] = "Description for discount " . $i . " " . ($lang === 'ar' ? 'وصف الخصم' : '');
            }
            
            // Determine if we want a discount code
            $hasCode = rand(0, 1) === 1;
            $code = $hasCode ? strtoupper(Str::random(8)) : null;
            
            // Create the discount
            Discount::create([
                'name' => $name,
                'description' => $description,
                'code' => $code,
                'type' => $type,
                'value' => $value,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'active' => 1,
                'max_uses' => rand(0, 100),
                'used_count' => rand(0, 20),
                'max_uses_per_user' => rand(0, 5)
            ]);
        }
    }
}
