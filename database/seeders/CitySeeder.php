<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            ['name' => 'Cairo', 'shipping_price' => 30.00],
            ['name' => 'Alexandria', 'shipping_price' => 35.00],
            ['name' => 'Mansoura', 'shipping_price' => 25.00],
        ];
        City::insert($cities);
    }
}
