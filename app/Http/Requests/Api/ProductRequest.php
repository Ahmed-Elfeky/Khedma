<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'subcategory_id' => 'required|exists:subcategories,id',
            'name'           => 'required|string|max:255',
            'price'          => 'required|numeric|min:0',
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
}
