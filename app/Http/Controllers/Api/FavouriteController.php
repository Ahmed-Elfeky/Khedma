<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFavouriteRequest;
use App\Http\Resources\FavouriteResource;
use App\Models\Favourite;
use Illuminate\Support\Facades\Auth;

class FavouriteController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $favourites = Favourite::with('product')
            ->where('user_id', $userId)->latest()->get();

        if ($favourites->isEmpty()) {
            return ApiResponse::SendResponse(404, 'No favourite products found', []);
        }
        return ApiResponse::SendResponse(200, 'Favourite products retrieved successfully', FavouriteResource::collection($favourites));
    }



    public function store(StoreFavouriteRequest $request)
    {
        $data = $request->validated();
        $userId = Auth::id();
        $productId = $request->product_id;
        // تحقق هل المنتج موجود فعلاً في المفضلة
        $existingFav = Favourite::where('user_id', $userId)
            ->where('product_id', $productId)->first();

        if ($existingFav) {
            //  لو موجود نحذفه (toggle off)
            $existingFav->delete();
            return ApiResponse::SendResponse(200, 'Product removed from favourites', []);
        }
        //  لو غير موجود نضيفه (toggle on)
        $fav = Favourite::create($data);
        return ApiResponse::SendResponse(200, 'Product added to favourites', new FavouriteResource($fav));
    }
}
