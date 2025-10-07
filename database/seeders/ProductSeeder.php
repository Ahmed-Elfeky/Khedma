<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'subcategory_id' => 1,
                'name' => 'Laptop',
                'desc' => 'High performance laptop with 16GB RAM and 512GB SSD.',
                'price' => 1500.00,
                'stock' => 1,
            ],
            [
                'subcategory_id' => 1,
                'name' => 'Smartphone',
                'desc' => 'Latest smartphone with AMOLED display and triple camera.',
                'price' => 900.00,
                'stock' => 1,
            ],
            [
                'subcategory_id' => 2,
                'name' => 'T-shirt',
                'desc' => 'Tshirt man and woman.',
                'price' => 250.00,
                'stock' => 1,
            ],
            [
                'subcategory_id' => 1,
                'name' => 'Smartwatch',
                'desc' => 'Waterproof smartwatch with fitness tracking.',
                'price' => 300.00,
                'stock' => 1,

            ],
        ];

        Product::insert($products);

        $this->command->info('✅ Products seeded successfully!');
    }
}
