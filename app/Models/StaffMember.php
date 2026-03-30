<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StaffMember extends Model
{
    protected $fillable = [
        'name',
        'photo',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Relation avec les traductions
     */
    public function translations(): HasMany
    {
        return $this->hasMany(StaffMemberTranslation::class, 'member_id');
    }

    /**
     * Relation avec les contacts
     */
    public function contacts(): HasMany
    {
        return $this->hasMany(StaffMemberContact::class, 'member_id')
            ->join('contact_types', 'staff_member_contacts.contact_type_id', '=', 'contact_types.id')
            ->where('contact_types.is_active', true)
            ->orderBy('contact_types.order')
            ->select('staff_member_contacts.*');
    }

    /**
     * Relation avec les contacts (sans filtre, pour admin)
     */
    public function allContacts(): HasMany
    {
        return $this->hasMany(StaffMemberContact::class, 'member_id')
            ->orderBy('order');
    }

    /**
     * Obtenir la traduction pour une langue donnée
     */
    public function translation($lang = null)
    {
        $lang = $lang ?? app()->getLocale();

        return $this->translations->where('lang', $lang)->first()
            ?? $this->translations->where('lang', 'fr')->first()
            ?? $this->translations->first();
    }

    /**
     * Obtenir l'URL de la photo
     */
    public function getPhotoUrlAttribute()
    {
        return $this->photo ? asset('storage/' . $this->photo) : null;
    }

    /**
     * Scope pour les membres actifs
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope pour trier par ordre
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
