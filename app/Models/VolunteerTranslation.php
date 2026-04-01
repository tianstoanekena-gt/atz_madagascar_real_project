<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VolunteerTranslation extends Model
{
    protected $fillable = [
        'volunteer_id',
        'lang',
        'role',
        'description',
    ];

    public function volunteer(): BelongsTo
    {
        return $this->belongsTo(Volunteer::class, 'volunteer_id');
    }

    public function scopeLang($query, $lang)
    {
        return $query->where('lang', $lang);
    }
}
