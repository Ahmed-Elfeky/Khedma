<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
   
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'desc'     => $this->desc,
            'price'    => $this->price,
            'discount'  => $this->discount,
            'guarantee' => $this->guarantee,
            'image'     => url(asset('uploads/' . $this->image)),
        ];
    }
}
