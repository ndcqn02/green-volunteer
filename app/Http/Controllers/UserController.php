<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\AuthValidationRequest;
use App\Http\Requests\RegisterValidationRequest;
use App\Http\Requests\UserValidationRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Laravel\Socialite\Facades\Socialite;
use PhpParser\Node\Stmt\TryCatch;

class UserController extends Controller
{
    public $service;
    public function __construct()
    {
        $this->service = new UserService();
    }
    public function register(RegisterValidationRequest $registerValidator)
    {
        $response =  $this->service->register($registerValidator->input());
        if ($response)
            return ResponseHelper::jsonResponse(200, "success", $response, false);
        else
            return ResponseHelper::jsonResponse(400, "failed", null, true);
    }
    public function login(AuthValidationRequest $authValidator)
    {
        $authValidator->validated();
        $response = $this->service->login($authValidator->input());
        if ($response)
            return ResponseHelper::jsonResponse(200, "success", $response, false);
        else
            return ResponseHelper::jsonResponse(400, "failed", null, true);
    }
    public function updateUser(UserValidationRequest $userValidator)
    {
        $response = $this->service->updateUser($userValidator->input());
        if ($response)
            return ResponseHelper::jsonResponse(200, "success", $response, false);
        else
            return ResponseHelper::jsonResponse(400, "failed", null, true);
    }
    public function redirectToAuth()
    {
        return Socialite::driver('google')->redirect();
    }
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $response = $this->service->handleGoogleCallback($user);
            return ResponseHelper::jsonResponse(200, "login success", $response, false);
        } catch (\Throwable $th) {
            dd($th);
        }
    }
    public function handleFacebookCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user();
            dd($user);
            return $user;
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
