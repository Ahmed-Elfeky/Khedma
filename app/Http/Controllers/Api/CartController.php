<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ApiResponse;
use App\Http\Requests\StoreCartRequest;

class CartController extends Controller
{

    public function index()
    {
        $userId = Auth::id();
        $cartItems = Cart::with('product')->where('user_id', $userId)->latest()->get();

        if ($cartItems->isEmpty()) {
            return ApiResponse::SendResponse(404, 'No cart items found', []);
        }

        return ApiResponse::SendResponse(200, 'Cart items retrieved successfully', CartResource::collection($cartItems));
    }

    public function store(StoreCartRequest $request)
    {
        $userId = Auth::id();
        $data = $request->validated();

        $productId = $data['product_id'];
        $quantity = $data['quantity'] ?? 1;

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
