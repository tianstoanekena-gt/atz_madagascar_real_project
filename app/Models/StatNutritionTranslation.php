<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatNutritionTranslation extends Model
{
    use SoftDeletes;
    protected $table = 'stat_nutrition_translations';
    protected $fillable = ['stat_nutrition_id', 'locale', 'label', 'trend', 'detail'];
    public $timestamps = true;

    public function stat()
    {
        return $this->belongsTo(StatNutrition::class, 'stat_nutrition_id');
    }
}
