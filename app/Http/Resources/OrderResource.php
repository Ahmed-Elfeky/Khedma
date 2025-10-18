<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'city' => $this->city?->name,
            'shipping_price' => (float) $this->shipping_price,
            'total_products' => (float) $this->total - (float) $this->shipping_price,
            'total_with_shipping' => (float) $this->total,
            'created_at' => $this->created_at->format('Y-m-d H:i'),
            'products' => $this->whenLoaded('products', function () {
                return $this->products->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => (float) $product->price,
                        'discount' => (float) $product->discount,
                        'final_price' => (float) ($product->price - ($product->discount ?? 0)),
                        'quantity' => $product->pivot?->quantity,
                        'image' => $product->image ? url($product->image) : null,
                    ];
                });
            }),
        ];
    }
}
