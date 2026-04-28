<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SponsorTranslation extends Model
{
    protected $fillable = [
        'sponsor_id',
        'lang',
        'short_description',
    ];

    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(Sponsor::class, 'sponsor_id');
    }

    public function scopeLang($query, $lang)
    {
        return $query->where('lang', $lang);
    }
}
