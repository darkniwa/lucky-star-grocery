<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => 'Grocery'],
            ['name' => 'Fruits and Vegetables'],
            ['name' => 'Meat and Seafood'],
            ['name' => 'Dairy and Eggs'],
            ['name' => 'Bakery'],
            ['name' => 'Canned Goods'],
            ['name' => 'Beverages'],
            ['name' => 'Snacks'],
            ['name' => 'Cooking Essentials'],
            ['name' => 'Household Items'],
            ['name' => 'Personal Care'],
            // Add more categories here
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
