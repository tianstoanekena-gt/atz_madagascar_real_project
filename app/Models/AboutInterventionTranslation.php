<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AboutInterventionTranslation extends Model
{
    protected $fillable = [
        'intervention_id',
        'lang',
        'title',
        'description',
    ];

    public function intervention(): BelongsTo
    {
        return $this->belongsTo(AboutIntervention::class, 'intervention_id');
    }
}
