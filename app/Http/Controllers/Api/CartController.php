<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ApiResponse;
use App\Http\Requests\StoreCartRequest;
use App\Models\Product;

class CartController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        $cartItems = Cart::with('product')
            ->where('user_id', $user->id)
            ->get();

        if ($cartItems->isEmpty()) {
            return ApiResponse::SendResponse(404, 'No cart items found', []);
        }

        //  حساب إجمالي المنتجات
        $totalProducts = 0;
        foreach ($cartItems as $item) {
            $price = $item->product->price ?? 0;
            $discount = $item->product->discount ?? 0;
            $discounted = $price - ($price * ($discount / 100));
            $totalProducts += $discounted * $item->quantity;
        }

        //  إضافة تكلفة الشحن حسب المدينة
        $shippingPrice = $user->city ? $user->city->shipping_price : 0;

        $totalWithShipping = $totalProducts + $shippingPrice;

        return ApiResponse::SendResponse(200, 'Cart retrieved successfully', [
            'items' => CartResource::collection($cartItems),
            'subtotal' => round($totalProducts, 2),
            'shipping_price' => round($shippingPrice, 2),
            'total' => round($totalWithShipping, 2),
        ]);
    }


    public function store(StoreCartRequest $request)
    {
        $data = $request->validated();
        $userId = Auth::id();

        $productId = $data['product_id'];

        $product = Product::findOrFail($data['product_id']);
        $quantity = $data['quantity'] ?? 1;

        //  تحقق من المخزون
        if ($product->stock < $quantity) {
            return ApiResponse::SendResponse(400, 'Not enough stock available', []);
        }

        $cartItem = Cart::where('user_id', $userId)->where('product_id', $productId)->first();

        if ($cartItem) {
            $cartItem->update([
                'quantity' => $cartItem->quantity + $quantity,
            ]);
        } else {
            $cartItem = Cart::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }
        return ApiResponse::SendResponse(200, 'Product added to cart successfully', new CartResource($cartItem->load('product')));
    }

    public function destroy($id)
    {
        $userId = Auth::id();
        $cartItem = Cart::where('user_id', $userId)->where('id', $id)->first();

        if (!$cartItem) {
            return ApiResponse::SendResponse(404, 'Cart item not found', []);
        }
        $cartItem->delete();
        return ApiResponse::SendResponse(200, 'Product removed from cart successfully', []);
    }
}
