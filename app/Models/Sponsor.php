<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;

class Sponsor extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "fullName",
        "title",
        "sponsorship_money",
        "activity_id"
    ];
    protected $table = 'sponsor';

    public function Activity():HasOne{
        return $this->hashOne(Activitie::class);
    }
}
