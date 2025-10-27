<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ApiResponse;
use App\Http\Requests\Api\RatingRequest;

class RatingController extends Controller
{
    public function store(RatingRequest $request)
    {
        $user = Auth::user();
        $validated = $request->validated();
        // تحديث التقييم لو المستخدم قيم المنتج قبل كده
        $rating = Rating::updateOrCreate(
            [
                'user_id' => $user->id,
                'product_id' => $request->product_id
            ],
            [
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]
        );

        return ApiResponse::SendResponse(200, 'Rating saved successfully', $rating);
    }

    public function index($productId)
    {
        $ratings = Rating::where('product_id', $productId)
            ->with('user:id,name')
            ->latest()
            ->get();

        $average = $ratings->avg('rating');
        $count = $ratings->count();

        return ApiResponse::SendResponse(200, 'Ratings fetched successfully', [
            'average_rating' => round($average, 1),
            'total_ratings' => $count,
            'ratings' => $ratings
        ]);
    }
}
