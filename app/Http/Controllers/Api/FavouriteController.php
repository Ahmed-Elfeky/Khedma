<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreFavouriteRequest;
use App\Http\Resources\FavouriteResource;
use App\Http\Resources\ProductResource;
use App\Models\Favourite;
use Illuminate\Support\Facades\Auth;

class FavouriteController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        if (!$userId) {
            return ApiResponse::SendResponse(401, 'Unauthorized', []);
        }
        $favourites = Favourite::with('product.images', 'product.colors', 'product.sizes')
            ->where('user_id', $userId)
            ->latest()
            ->get();

        if ($favourites->isEmpty()) {
            return ApiResponse::SendResponse(404, 'No favourite products found', []);
        }
        // نرجّع المنتجات نفسها فقط
        $products = $favourites->pluck('product')->filter();

        return ApiResponse::SendResponse(
            200,
            'Favourite products retrieved successfully',
            ProductResource::collection($products)
        );
    }


    public function store(StoreFavouriteRequest $request)
    {
        $data = $request->validated();
        $userId = Auth::id();
        $productId = (int) $request->product_id;

        if (!$userId) {
            return ApiResponse::SendResponse(401, 'Unauthorized', []);
        }

        $existingFav = Favourite::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($existingFav) {
            $existingFav->delete();

            return ApiResponse::SendResponse(200, 'Product removed from favourites', [
                'product_id' => $productId,
                'is_favourite' => false,
            ]);
        }

        $fav = Favourite::create([
            'user_id' => $userId,
            'product_id' => $productId,
        ]);

        return ApiResponse::SendResponse(
            200,
            'Product added to favourites',
            new ProductResource($fav->product)
        );
    }
}
