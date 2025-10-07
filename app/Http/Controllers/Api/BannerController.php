<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\BannerRequest;
use App\Http\Resources\BannerResource;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::all();
        return ApiResponse::SendResponse(200, 'ALL Banner Successfuly', BannerResource::collection($banners));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BannerRequest $request)
    {
        $attributes = $request->validated();

         if ($request->hasFile('image')) {
            $filename = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/banners'), $filename);
            $attributes['image'] = $filename;
        }

        $banner = Banner::create($attributes);

        if ($banner) {
            return ApiResponse::SendResponse(201, 'Banner Created Successfully', new BannerResource($banner));
        } else {
            return ApiResponse::SendResponse(422, 'Banner can\'t be Created ', []);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $banner = Banner::find($id);
        if (!$banner) {
            return ApiResponse::SendResponse(404 , 'Banner not found',[]);
        }
            return ApiResponse::SendResponse(200 , 'Banner Retrived successfuly', new BannerResource($banner));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
