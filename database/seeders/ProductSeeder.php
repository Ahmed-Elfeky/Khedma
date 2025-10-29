<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['phone'       => '01099696706'], // شرط البحث
            [
                'name'     => 'Admin',
                'password' => Hash::make('123456'),
                'email'    => 'admin@gmail.com',
                'role'     => 'admin',
                'city_id'  => null ,
                'address'  => 'Cairo',
            ]
        );
        $products = [
            [
                'subcategory_id'  => 1,
                'name'            => 'Laptop',
                'desc'            => 'laptop with 16GB RAM /512GB SSD.',
                'price'           => 1500.00,
                'stock'           => 1,
                'user_id'         => $user->id,

            ],
            [
                'subcategory_id' => 1,
                'name'           => 'Smartphone',
                'desc'           => 'Latest smartphone camera.',
                'price'          => 900.00,
                'stock'          => 1,
                'user_id'        => $user->id,

            ],
            [
                'subcategory_id' => 2,
                'name'           => 'T-shirt',
                'desc'           => 'Tshirt man and woman.',
                'price'          => 250.00,
                'stock'          => 1,
                'user_id'        => $user->id,
            ],
            [
                'subcategory_id' => 1,
                'name'           => 'Smartwatch',
                'desc'           => 'Waterproof smartwatch with fitness tracking.',
                'price'          => 300.00,
                'stock'          => 1,
                'user_id'        => $user->id,
            ],
        ];

        Product::insert($products);

        $this->command->info('✅ Products seeded successfully!');
    }
}
