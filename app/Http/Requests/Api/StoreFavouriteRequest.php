<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreFavouriteRequest extends FormRequest
{
    public function authorize(): bool
    {
        // السماح فقط للمستخدمين المسجلين
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'user_id'    =>  'required|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'Product ID is required.',
            'product_id.exists' => 'This product does not exist.',
            'user_id.required' => 'user ID is required.',
            'user_id.exists' => 'This user does not exist.',
        ];
    }
}

