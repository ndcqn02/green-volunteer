<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthValidationRequest extends FormRequest
{
    public function rules() {
        return [
            "email" => 'string|email',
            "password" => 'required' ,
        ];
    }
    public function messages()
    {
        return [
            'password.required' => 'chưa nhập mật khẩu.',
            'email.email' => 'email không đúng định dạng.',
            'phone.max' => 'số điện thoại không đúng định dàng.',
            'phone.min' => 'số điện thoại không đúng định dàng.',
        ];
    }
    public function failedValidation(Validator $vailator){
        throw new HttpResponseException(response([
            "data" => $vailator->errors(),
            "status" => 400
        ])
        );
    }
}
