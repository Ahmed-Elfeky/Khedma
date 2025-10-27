<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class RatingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ];
    }


    public function messages(): array
    {
        return [
            'product_id.required' => 'يجب تحديد المنتج.',
            'product_id.exists'   => 'المنتج غير موجود.',
            'rating.required'     => 'يجب إدخال التقييم.',
            'rating.integer'      => 'التقييم يجب أن يكون رقمًا.',
            'rating.min'          => 'أقل تقييم هو 1 نجمة.',
            'rating.max'          => 'أقصى تقييم هو 5 نجوم.',
            'comment.max'         => 'التعليق لا يجب أن يزيد عن 500 حرف.',
        ];
    }
}
