<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use App\Models\User_Role;
use GuzzleHttp\Psr7\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB;

class UserService 
{
    public function Register($data)
    {
        $email = $data['email'];
        $password = bcrypt($data['password']);
        $listRole = Role::whereIn('role_Name', $data['role'])->get();
        $checkUser = User::where('email', "$email")->exists();
        if ($checkUser) {
            return response()->json([
                "message" => 'email đã tồn tại',
                "data" => null,
                "status" => 400
            ]);
        }
        try {
            DB::beginTransaction();
            $new_user = User::create([
                'email' => $email,
                'password' => $password,
            ]);
            foreach ($listRole as $key => $value) {
                User_Role::create([
                    "user_id" => $new_user->id,
                    "role_id" => $value->id
                ]);
            }
            DB::commit();
            return response()->json([
                "message" => 'đăng kí tài khoản thành công',
                "data" => $new_user,
                "error" => false
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(
                [
                    "message" => 'đăng kí tài khoản thất bại',
                    "data" => null,
                    "error" => true
                ]
            );
        }
    }
    public function login ($data){
        $token = JWTAuth::attempt(['email' => $data['email'], 'password' => $data['password']]);
        if ($token) {
            return response()->json([
                "message" => 'login success',
                "data" => [
                    "user"=>$data,
                    "token"=>$token
                ],
                "error" => false
            ]);
        }
        else{
            return response()->json([
                "message" => "email or password is incorrect",
                "data" => null,
                "error" => true
            ]);
        }
    }
}
