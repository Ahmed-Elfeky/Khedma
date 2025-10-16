<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
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

            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0',
             ];
    }

    public function messages(): array
    {
        return [
            'min_price.numeric' => 'Minimum price must be a valid number.',
            'max_price.numeric' => 'Maximum price must be a valid number.',
        ];

}
}
