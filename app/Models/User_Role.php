<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;

class User_Role extends Model
{
    use  Notifiable;
    protected $table = "users_role";
    protected $fillable = [
        "users_id",
        "role_id",
    ];
    public $timestamps = false;
}
