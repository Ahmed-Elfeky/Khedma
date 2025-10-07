<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Electronics', 'desc' => 'All electronic devices', 'image' => 'iphone15_1.jpg' ],
            ['name' => 'Fashion', 'desc' => 'Clothing and accessories', 'image' => 'iphone15_1.jpg'],
            ['name' => 'Home Appliances', 'desc' => 'Appliances for home use', 'image' => 'iphone15_1.jpg'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}
