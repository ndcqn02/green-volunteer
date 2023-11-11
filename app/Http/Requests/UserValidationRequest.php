<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserValidationRequest extends FormRequest
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
            "email" => "email",
            "phone" => "string |max:10 | min:10",
        ];
    }
    public function messages()
    {
        return [
            'email.email' => 'email không đúng định dạng.',
            'phone.max' => 'số điện thoại không đúng định dàng.',
            'phone.min' => 'số điện thoại không đúng định dàng.',
        ];
    }
    public function failedValidation(Validator $vailator)
    {
        throw new HttpResponseException(
            response([
                "data" => $vailator->errors(),
                "status" => 400
            ])
        );
    }
}
