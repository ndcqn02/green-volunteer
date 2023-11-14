<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;


class Post extends Model
{
    use Notifiable;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "title",
        "body",
        "user_id",
        "images",
        "status"
    ];
    protected $table = 'posts';

    public function User():HasOne{
        return $this->hashOne(User::class);
    }
}
