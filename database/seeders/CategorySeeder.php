<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Chairs', 'description' => 'Comfortable chairs for home and office'],
            ['name' => 'Tables', 'description' => 'Dining tables, coffee tables, and more'],
            ['name' => 'Sofas', 'description' => 'Living room sofas and sectionals'],
            ['name' => 'Beds', 'description' => 'Bed frames and mattresses'],
            ['name' => 'Storage', 'description' => 'Cabinets, shelves, and wardrobes'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}