<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SponsorDetail extends Model
{
    protected $fillable = [
        'sponsor_id',
        'project_id',
        'long_description_mg',
        'long_description_fr',
        'long_description_en',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(Sponsor::class, 'sponsor_id');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(SponsorDetailPhoto::class, 'sponsor_detail_id')
            ->orderBy('order');
    }

    /**
     * Obtenir la longue description selon la langue
     */
    public function getLongDescription($lang = null)
    {
        $lang = $lang ?? app()->getLocale();

        $field = 'long_description_' . $lang;

        // Retourner la description dans la langue demandée
        // Fallback: FR → EN → MG → première disponible
        return $this->$field
            ?? $this->long_description_fr
            ?? $this->long_description_en
            ?? $this->long_description_mg;
    }
}
