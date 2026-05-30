<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class CategoryProductSeeder extends Seeder
{
    public function run(): void
    {
        $clothing = Category::create([
            'name' => 'Traditional Clothing',
            'slug' => Str::slug('Traditional Clothing'),
            'description' => 'Authentic regional garments and textiles.'
        ]);

        $produce = Category::create([
            'name' => 'Fresh Produce',
            'slug' => Str::slug('Fresh Produce'),
            'description' => 'Locally sourced agricultural goods.'
        ]);

        Product::create([
            'category_id' => $clothing->id,
            'name' => 'Rajshahi Silk Saree',
            'slug' => Str::slug('Rajshahi Silk Saree'),
            'description' => 'Premium quality pure silk saree woven locally.',
            'price' => 5500.00,
            'stock' => 15,
        ]);

        Product::create([
            'category_id' => $produce->id,
            'name' => 'Fazli Mango Crate (10kg)',
            'slug' => Str::slug('Fazli Mango Crate 10kg'),
            'description' => 'Fresh, seasonal Fazli mangoes ready for delivery.',
            'price' => 1200.00,
            'stock' => 50,
        ]);
    }
}