<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatHealthTranslation extends Model
{
    use SoftDeletes;
    protected $table = 'stat_health_translations';
    protected $fillable = ['stat_health_id', 'locale', 'label', 'trend', 'detail'];
    public $timestamps = true;

    public function stat()
    {
        return $this->belongsTo(StatHealth::class, 'stat_health_id');
    }
}
