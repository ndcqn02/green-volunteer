<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use App\Models\User_Role;
use Illuminate\Support\Facades\Auth;
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
                "status" => 200
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(
                [
                    "message" => 'đăng kí tài khoản thất bại',
                    "data" => null,
                    "status" => 400
                ]
            );
        }
    }
    public function login ($data){
        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            return response()->json([
                "message" => 'login success',
                "data" => $data,
                "status" => 200
            ]);
        }
        else{
            return response()->json([
                "message" => "email or password is incorrect",
                "data" => null,
                "status" => 400
            ]);
        }
    }
}
