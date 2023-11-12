<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthValidationRequest;
use App\Http\Requests\UserValidationRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public $service;
    public function __construct() {
        $this->service = new UserService();
    }
    public function register(AuthValidationRequest $authValidator){
        $authValidator->validated();
        return  $this->service->register($authValidator->input());
    }
    public function login(AuthValidationRequest $authValidator){
        $authValidator->validated();
        return  $this->service->login($authValidator->input());
    }
    public function updateUser(UserValidationRequest $userValidator){
        return  $this->service->updateUser($userValidator->input());
    }
}