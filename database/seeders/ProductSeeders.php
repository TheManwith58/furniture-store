<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $categories = Category::all();
        
        $products = [
            [
                'name' => 'Nilkamal Pluto Chair',
                'description' => 'Ergonomic office chair with lumbar support',
                'price' => 5999,
                'stock_quantity' => 50,
            ],
            [
                'name' => 'Nilkamal Orion Sofa',
                'description' => '3-seater fabric sofa with wooden legs',
                'price' => 18999,
                'stock_quantity' => 20,
            ],
            // Add 10 more products
        ];

        foreach ($products as $product) {
            Product::create([
                ...$product,
                'category_id' => $categories->random()->id,
                'image_path' => 'products/sample-' . rand(1, 5) . '.jpg',
            ]);
        }
    }
}