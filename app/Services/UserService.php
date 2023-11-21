<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use App\Models\User_Role;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function checkUserByEmail($email)
    {
        return User::where('email', "$email")->first();
    }
    public function register($data)
    {
        $email = $data['email'];
        $phone = $data['phone'];
        $password = bcrypt($data['password']);
        $listRole = Role::whereIn('role_Name', $data['role'])->get();
        $checkUser = $this->checkUserByEmail($email);
        if ($checkUser) {
            return null;
        }
        try {
            DB::beginTransaction();
            $new_user = User::create([
                'email' => $email,
                "phone" => $phone,
                'password' => $password,
            ]);
            foreach ($listRole as $key => $value) {
                User_Role::create([
                    "users_id" => $new_user->id,
                    "role_id" => $value->id
                ]);
            }
            DB::commit();
            return $new_user;
        } catch (\Throwable $th) {
            DB::rollBack();
            return $data = "demo";
        }
    }
    public function login($data)
    {

        if (auth()->attempt(['email' => $data['email'], 'password' => $data['password']])) {
            $customClaims = [
                'user_id' => auth()->user()->id,
            ];
            $token = JWTAuth::claims($customClaims)->fromUser(auth()->user());
            return [
                "user" => $data,
                "token" => $token
            ];
        } else {
            return null;
        }
    }
    public function updateUser($data)
    {
        try {
            $update = User::find($data['id'])->update([
                "username" => $data['username'],
                "email" => $data['email'],
                "fullName" => $data["fullName"],
                "phone" => $data["phone"],
                "DOB" => $data['DOB'],
                "school" => $data['school'],
            ]);
            return $update;
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function handleGoogleCallback($user)
    {
        $findUser = User::where("google_id", $user->id)->first();
        if (!$findUser) {
            DB::beginTransaction();
            try {
                $data = [
                    "email" => $user->email,
                    "fullName" => $user->name,
                    "google_id"=>$user->id
                ];
                $new_user = User::create($data);
                User_Role::create([
                    "users_id" => $new_user->id,
                    "role_id" => 2,
                ]);
                DB::commit();
                $customClaims = [
                    'user_id' => $new_user->id,
                ];
                $token = JWTAuth::claims($customClaims)->fromUser($new_user);
                return [
                    "user" => $new_user,
                    "token" => $token
                ];
            } catch (\Throwable $th) {
                //throw $th;
                DB::rollBack();
            }
        } else {
            $customClaims = [
                'user_id' => $findUser->id,
            ];
            $token = JWTAuth::claims($customClaims)->fromUser($findUser);
            return [
                "user" => $findUser,
                "token" => $token
            ];
        }
    }
}
