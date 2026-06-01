<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Fresh Vegetables',
            'Seasonal Fruits',
            'Organic Produce',
            'Dairy & Eggs',
            'Meat & Fish'
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate([
                'name' => $category,
                'slug' => Str::slug($category)
            ]);
        }
    }
}