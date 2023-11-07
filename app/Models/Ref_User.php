<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;

class Ref_User extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "user_id",
        "register_id",
    ];
    protected $table = 'ref_user';

    public function User():HasOne {
        return $this->hasOne(User::class);
    }
    public function Register():HasOne {
        return $this->hasOne(Register::class);
    }
}
