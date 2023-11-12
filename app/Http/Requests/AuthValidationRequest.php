<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthValidationRequest extends FormRequest
{
    public function rules() {
        return [
            "email" => 'required | string|unique:users,email',
            "phone" => " required|string |max:10 | min:10",
            "password" => 'required' ,
            'role' => 'array'
        ];
    }
    public function messages()
    {
        return [
            'email.required' => 'chưa nhập email.',
            'phone.required' => 'chưa nhập số điện thoại.',
            'password.required' => 'chưa nhập mật khẩu.',
            'email.email' => 'email không đúng định dạng.',
            'email.unique' => 'email đã tồn tại.',
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
