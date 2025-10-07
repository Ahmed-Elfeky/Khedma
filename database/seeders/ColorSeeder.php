<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Color;

class ColorSeeder extends Seeder
{
    public function run(): void
    {
        $colors = [
            ['name' => 'Red',    'hex' => '#FF0000'],
            ['name' => 'Blue',   'hex' => '#0000FF'],
            ['name' => 'Green',  'hex' => '#00FF00'],
            ['name' => 'Black',  'hex' => '#000000'],
            ['name' => 'White',  'hex' => '#FFFFFF'],
            ['name' => 'Silver', 'hex' => '#C0C0C0'],
            ['name' => 'Gold',   'hex' => '#FFD700'],
        ];

        Color::insert($colors);

    }
}
