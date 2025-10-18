<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;
use App\Models\City;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $city = City::first();
        $product = Product::first();

        if (!$user || !$city || !$product) {
            $this->command->warn('⚠️ تأكد من وجود مستخدم ومدينة ومنتج قبل تشغيل OrderSeeder.');
            return;
        }
        // إنشاء طلب تجريبي
        $order = Order::create([
            'user_id'        => $user->id,
            'city_id'        => $city->id,
            'shipping_price' => $city->shipping_price ?? 25,
            'total'          => $product->price * 2 + ($city->shipping_price ?? 25),
            'status'         => 'pending',
        ]);

        // إضافة عنصر (منتج) إلى الطلب
        OrderItem::create([
            'order_id'   => $order->id,
            'product_id' => $product->id,
            'quantity'   => 2,
            'price'      => $product->price,
        ]);

        $this->command->info(' OrderSeeder done!');
    }
}
