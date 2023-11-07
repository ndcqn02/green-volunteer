<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserValidationRequest extends FormRequest
{
    public function rules() {
        return [
            "email" => 'required | string',
            "password" => 'required' ,
            'role' => 'array'
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
