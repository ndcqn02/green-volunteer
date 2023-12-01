<?php

namespace App\Http\Requests;

use App\Helpers\ResponseHelper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterValidationRequest extends FormRequest
{
    public function rules() {
        return [
            "email" => 'string|email|unique:users,email',
            "phone" => "string |max:10 | min:10|unique:users,phone",
            "password" => 'required' ,
            'role' => 'array'
        ];
    }
    public function messages()
    {
        return [
            'password.required' => 'chưa nhập mật khẩu.',
            'email.email' => 'email không đúng định dạng.',
            'email.unique' => 'email đã tồn tại.',
            'phone.max' => 'số điện thoại không đúng định dàng.',
            'phone.unique' => 'số điện thoại đã tồn tại.',
            'phone.min' => 'số điện thoại không đúng định dàng.',
        ];
    }
    public function failedValidation(Validator $vailator){
        throw new HttpResponseException(ResponseHelper::jsonResponse(400,$vailator->errors(),null,true));
    }
}
