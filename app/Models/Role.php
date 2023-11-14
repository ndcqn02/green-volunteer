<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Role extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "role_Name",
        "description"
    ];
    protected $table = 'role';

    public function admin()
    {
        return $this->belongsToMany(User::class, User_Role::class, 'role_id', 'user_id');
    }
}
