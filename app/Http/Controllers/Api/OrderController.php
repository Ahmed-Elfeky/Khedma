<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Cart;
use App\Models\City;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Helpers\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'city_id' => 'required|exists:cities,id',
        ]);

        $userId = Auth::id();

        if (!$userId) {
            return ApiResponse::SendResponse(401, 'Unauthorized', []);
        }
      
        $cartItems = Cart::with('product')->where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return ApiResponse::SendResponse(400, 'Cart is empty', []);
        }

        $city = City::find($request->city_id);
        $shipping = $city->shipping_price;

        DB::beginTransaction();

        try {
            $totalProducts = 0;
            $order = Order::create([
                'user_id' => $userId,
                'city_id' => $city->id,
                'shipping_price' => $shipping,
                'total' => 0,
                'status' => 'pending',
            ]);

            foreach ($cartItems as $item) {
                $product = $item->product;
                $quantity = $item->quantity;

                if ($product->stock < $quantity) {
                    DB::rollBack();
                    return ApiResponse::SendResponse(400, "Not enough stock for {$product->name}", []);
                }

                // حساب السعر بعد الخصم
                $finalPrice = $product->price - ($product->discount ?? 0);
                $totalProducts += $finalPrice * $quantity;

                // إضافة المنتج إلى order_items
                $order->products()->attach($product->id, [
                    'quantity' => $quantity,
                    'price' => $finalPrice,
                ]);

                // خصم الكمية من المخزون
                $product->decrement('stock', $quantity);
            }

            // تحديث الإجمالي الكلي
            $order->update([
                'total' => $totalProducts + $shipping,
            ]);

            // حذف محتوى العربة بعد تنفيذ الطلب
            Cart::where('user_id', $userId)->delete();

            DB::commit();

            return ApiResponse::SendResponse(
                200,
                'Order placed successfully',
                new OrderResource($order->load(['products', 'city']))
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::SendResponse(500, 'Order failed', ['error' => $e->getMessage()]);
        }
    }

    /**
     * عرض كل الطلبات للمستخدم الحالي
     */
    public function index()
    {
        $userId = Auth::id();

        $orders = Order::with(['products', 'city'])
            ->where('user_id', $userId)
            ->latest()
            ->get();

        if ($orders->isEmpty()) {
            return ApiResponse::SendResponse(404, 'No orders found', []);
        }

        return ApiResponse::SendResponse(
            200,
            'Orders retrieved successfully',
            OrderResource::collection($orders)
        );
    }

    /**
     * عرض تفاصيل طلب واحد
     */
    public function show($id)
    {
        $userId = Auth::id();

        $order = Order::with(['products', 'city'])
            ->where('user_id', $userId)
            ->find($id);

        if (!$order) {
            return ApiResponse::SendResponse(404, 'Order not found', []);
        }

        return ApiResponse::SendResponse(
            200,
            'Order retrieved successfully',
            new OrderResource($order)
        );
    }

}
