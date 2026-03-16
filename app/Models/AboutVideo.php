<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutVideo extends Model
{
    protected $fillable = [
        'lang',
        'video_url'
    ];
}
