<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AboutIntervention extends Model
{
    protected $fillable = [
        'image',
        'order',
    ];

    public function translations(): HasMany
    {
        return $this->hasMany(AboutInterventionTranslation::class, 'intervention_id');
    }

    public function translation($lang = null)
    {
        $lang = $lang ?? app()->getLocale();
        return $this->translations->where('lang', $lang)->first()
            ?? $this->translations->where('lang', 'fr')->first();
    }
}
