<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Models\City;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::all();

        if ($cities->isEmpty()) {
            return ApiResponse::SendResponse(404, 'No City Found', []);
        }
        return ApiResponse::SendResponse(200, 'City Retrieved Successfully', CityResource::collection($cities));
    }
}
