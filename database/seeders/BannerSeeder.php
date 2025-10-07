<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Banner::insert([
            [
                'title' => 'Winter Sale',
                'desc' => 'Get up to 50% off on all winter products.',
                'image' => 'banner1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'New Arrivals',
                'desc' => 'Check out the latest products in our store.',
                'image' => 'banner2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Exclusive Offer',
                'desc' => 'Limited time offer – don’t miss out!',
                'image' => 'banner3.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
