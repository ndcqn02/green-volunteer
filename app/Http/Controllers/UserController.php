<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserValidationRequest;
use App\Services\UserService;

class UserController extends Controller
{
    public $service;
    public function __construct() {
        $this->service = new UserService();
    }
    public function Register(UserValidationRequest $userValidator){
        $userValidator->validated();
        return  $this->service->Register($userValidator->input());
    }
    public function login(UserValidationRequest $userValidator){
        $userValidator->validated();
        return  $this->service->login($userValidator->input());
    }
}
