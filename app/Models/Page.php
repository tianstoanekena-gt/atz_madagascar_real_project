<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    use HasTranslations;

    protected $fillable = ['slug', 'title', 'content', 'is_active', 'published_at'];

    public $translatable = ['title', 'content'];
}
