<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StaffMemberContact extends Model
{
    protected $fillable = [
        'member_id',
        'contact_type_id',
        'contact_value',
        'custom_url',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    /**
     * Relation avec le membre
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(StaffMember::class, 'member_id');
    }

    /**
     * Relation avec le type de contact
     */
    public function contactType(): BelongsTo
    {
        return $this->belongsTo(ContactType::class, 'contact_type_id');
    }

    /**
     * Obtenir l'URL finale (custom ou générée)
     */
    public function getUrlAttribute()
    {
        if ($this->custom_url) {
            return $this->custom_url;
        }

        return $this->contactType ? $this->contactType->generateUrl($this->contact_value) : null;
    }

    /**
     * Obtenir l'icône du type de contact
     */
    public function getIconClassAttribute()
    {
        return $this->contactType ? $this->contactType->icon_class : 'fas fa-link';
    }

    /**
     * Obtenir le slug du type de contact
     */
    public function getTypeSlugAttribute()
    {
        return $this->contactType ? $this->contactType->slug : 'other';
    }

    /**
     * Obtenir le nom du type de contact
     */
    public function getTypeNameAttribute()
    {
        return $this->contactType ? $this->contactType->name : 'Autre';
    }

    /**
     * Scope pour un membre spécifique
     */
    public function scopeForMember($query, $memberId)
    {
        return $query->where('member_id', $memberId);
    }

    /**
     * Scope pour trier par ordre
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
