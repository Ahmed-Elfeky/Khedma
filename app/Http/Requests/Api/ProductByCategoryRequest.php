<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ProductByCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => 'required|integer|exists:categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'يجب إدخال رقم التصنيف.',
            'category_id.integer'  => 'رقم التصنيف يجب أن يكون رقمًا صحيحًا.',
            'category_id.exists'   => 'هذا التصنيف غير موجود.',
        ];
    }
}
