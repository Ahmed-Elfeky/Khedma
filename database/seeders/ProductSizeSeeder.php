<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Size;
use App\Models\ProductSize;

class ProductSizeSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();
        $sizes = Size::all();

        foreach ($products as $product) {
            $randomSizes = $sizes->random(min(3, $sizes->count()));

            foreach ($randomSizes as $size) {
                ProductSize::create([
                    'product_id' => $product->id,
                    'size_id' => $size->id,
                ]);
            }
        }

        $this->command->info('✅ Product sizes linked successfully!');
    }
}
