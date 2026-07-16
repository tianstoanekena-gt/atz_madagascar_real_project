<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatMainTranslation extends Model
{
    use SoftDeletes;
    protected $table = 'stat_main_translations';
    protected $fillable = ['stat_main_id', 'locale', 'label', 'trend', 'detail'];
    public $timestamps = true;

    public function stat()
    {
        return $this->belongsTo(StatMain::class, 'stat_main_id');
    }
}
