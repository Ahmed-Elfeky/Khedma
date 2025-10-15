<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'desc'       => $this->desc,
            'price'      => (float)$this->price,
            'discount'   => $this->discount,
            'guarantee'  => $this->guarantee,
            'image'      => $this->image ? url(asset($this->image)) : null,
            'images' => ImageResource::collection($this->images),

            //  العلاقات
            'sizes'      => SizeResource::collection($this->sizes),
            'colors'     => ColorResource::collection($this->colors),
            'subcategory' => new SubCategoryResource($this->subCategory),
        ];
    }
}
