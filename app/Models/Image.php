<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['image_url', 'activity_id'];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
