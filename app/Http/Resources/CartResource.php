<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{

    public function toArray(Request $request): array
    {

        $price = $this->product->price ?? 0;
        $discount = $this->product->discount ?? 0;

        //  حساب السعر بعد الخصم
        $discountedPrice = $price - ($price * ($discount / 100));

        //  إجمالي السعر = السعر بعد الخصم × الكمية
        $totalPrice = $discountedPrice * $this->quantity;

        return [
            'id'          => $this->id,
            'product_id'  => $this->product_id,
            'quantity'    => $this->quantity,
            'price'       => round($discountedPrice, 2),
            'total_price' => round($totalPrice, 2),
            'product'     => new ProductResource($this->whenLoaded('product')),
        ];
    }
}
