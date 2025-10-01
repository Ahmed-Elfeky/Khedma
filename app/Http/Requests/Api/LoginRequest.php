<?php

namespace App\Http\Requests\Api;

use App\Helpers\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

// validation api response //
    protected function failedValidation(Validator $validator)
    {
    if ($this->is('api/*')) {
            $response =  ApiResponse::SendResponse(422, ' validation errors',  $validator->messages()->all());
            throw new ValidationException($validator, $response);
        }
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'phone'    => 'required|string|exists:users,phone',
            'password' => 'required|string|min:6',
        ];
    }


    public function messages(): array
    {
        return [
            'phone.required'    => 'رقم الهاتف مطلوب',
            'phone.exists'      => 'رقم الهاتف غير مسجل',
            'password.required' => 'كلمة المرور مطلوبة',
            'password.min'      => 'كلمة المرور يجب ألا تقل عن 6 أحرف',
        ];
    }
}
