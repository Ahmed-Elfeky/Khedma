<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'name'           => 'nullable|string|max:255',
            'price'          => 'nullable|numeric|min:0',
            'desc'           => 'nullable|string',
            'discount'       => 'nullable|numeric|min:0|max:100',
            'guarantee'      => 'nullable|string|max:255',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:2048',

            'colors'         => 'nullable|array',
            'colors.*'       => 'string|distinct|regex:/^#([A-Fa-f0-9]{6})$/',

            'sizes'          => 'nullable|array',
            'sizes.*'        => 'string|max:10|distinct',
        ];
    }


    public function messages()
    {
        return [
            'subcategory_id.exists' => 'Invalid subcategory.',
            'colors.*.regex'        => 'Each color must be a valid HEX code like #FFFFFF.',
        ];
    }



}
