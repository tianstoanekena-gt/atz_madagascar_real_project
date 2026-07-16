<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatEducationTranslation extends Model
{
    use SoftDeletes;
    protected $table = 'stat_education_translations';
    protected $fillable = ['stat_education_id', 'locale', 'label', 'trend', 'detail'];
    public $timestamps = true;

    public function stat()
    {
        return $this->belongsTo(StatEducation::class, 'stat_education_id');
    }
}
