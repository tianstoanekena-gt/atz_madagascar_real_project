<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StaffMemberTranslation extends Model
{
    protected $fillable = [
        'member_id',
        'lang',
        'role',
        'description',
    ];

    protected $casts = [
        'lang' => 'string',
    ];

    /**
     * Relation avec le membre
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(StaffMember::class, 'member_id');
    }

    /**
     * Scope pour une langue spécifique
     */
    public function scopeLang($query, $lang)
    {
        return $query->where('lang', $lang);
    }
}
