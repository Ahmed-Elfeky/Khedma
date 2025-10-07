<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subcategory;
use App\Models\Category;

class SubcategorySeeder extends Seeder
{
    public function run(): void
    {
        $electronics = Category::where('name', 'Electronics')->first();
        $fashion = Category::where('name', 'Fashion')->first();

        $subcategories = [
            ['category_id' => $electronics->id, 'name' => 'Mobile Phones'],
            ['category_id' => $electronics->id, 'name' => 'Laptops'],
            ['category_id' => $fashion->id, 'name' => 'Men'],
            ['category_id' => $fashion->id, 'name' => 'Women'],
        ];

        foreach ($subcategories as $sub) {
            Subcategory::create($sub);
        }
    }
}
