<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Color;
use App\Models\ProductColor;

class ProductColorSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();
        $colors = Color::all();

        foreach ($products as $product) {
            // اربط المنتج مع 3 ألوان عشوائية
            $randomColors = $colors->random(min(3, $colors->count()));

            foreach ($randomColors as $color) {
                ProductColor::create([
                    'product_id' => $product->id,
                    'color_id' => $color->id,
                ]);
            }
        }

        $this->command->info('✅ Product colors linked successfully!');
    }
}
