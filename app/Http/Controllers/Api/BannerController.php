<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\BannerResource;
use App\Models\Banner;

class BannerController extends Controller
{
    
    public function index()
    {
        $banners = Banner::all();
        return ApiResponse::SendResponse(200, 'ALL Banner Successfuly', BannerResource::collection($banners));
    }


    // public function store(BannerRequest $request)
    // {
    //     $attributes = $request->validated();

    //      if ($request->hasFile('image')) {
    //         $filename = time() . '_' . $request->image->getClientOriginalName();
    //         $request->image->move(public_path('uploads/banners'), $filename);
    //         $attributes['image'] = $filename;
    //     }

    //     $banner = Banner::create($attributes);

    //     if ($banner) {
    //         return ApiResponse::SendResponse(201, 'Banner Created Successfully', new BannerResource($banner));
    //     } else {
    //         return ApiResponse::SendResponse(422, 'Banner can\'t be Created ', []);
    //     }
    // }


    // public function show($id)
    // {
    //     $banner = Banner::find($id);
    //     if (!$banner) {
    //         return ApiResponse::SendResponse(404 , 'Banner not found',[]);
    //     }
    //         return ApiResponse::SendResponse(200 , 'Banner Retrived successfuly', new BannerResource($banner));

    // }




}
