<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSizeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $sizeId = $this->route('size')->id;

        return [
            'name' => 'required|string|max:255|unique:sizes,name,' . $sizeId,
        ];
    }
}
