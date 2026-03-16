<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutCard extends Model
{
    protected $fillable = [
        'lang',
        'card_icon',
        'card_title',
        'card_description',
    ];
}
