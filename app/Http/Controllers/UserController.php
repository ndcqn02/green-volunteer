<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\AuthValidationRequest;
use App\Http\Requests\RegisterValidationRequest;
use App\Http\Requests\UserValidationRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public $service;
    public function __construct() {
        $this->service = new UserService();
    }
    public function register(RegisterValidationRequest $registerValidator){
        $response =  $this->service->register($registerValidator->input());
        if($response)
            return ResponseHelper::jsonResponse(200, "success", $response, false);
        else
            return ResponseHelper::jsonResponse(400, "failed", null, true);
    }
    public function login(AuthValidationRequest $authValidator){
        $authValidator->validated();
        $response= $this->service->login($authValidator->input());
        if($response)
            return ResponseHelper::jsonResponse(200, "success", $response, false);
        else
            return ResponseHelper::jsonResponse(400, "failed", null, true);
    }
    public function updateUser(UserValidationRequest $userValidator){
        $response=$this->service->updateUser($userValidator->input());
        if($response)
            return ResponseHelper::jsonResponse(200, "success", $response, false);
        else
            return ResponseHelper::jsonResponse(400, "failed", null, true);
    }
}