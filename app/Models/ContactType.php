<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContactType extends Model
{
    protected $fillable = [
        'name',
        'icon_class',
        'slug',
        'placeholder',
        'validation_regex',
        'url_template',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Relation avec les contacts des membres
     */
    public function memberContacts(): HasMany
    {
        return $this->hasMany(StaffMemberContact::class, 'contact_type_id');
    }

    /**
     * Générer l'URL complète à partir de la valeur
     */
    public function generateUrl($value)
    {
        return str_replace('{value}', $value, $this->url_template);
    }

    /**
     * Scope pour les types actifs
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

    /**
     * Obtenir tous les types actifs triés
     */
    public static function getActiveOrdered()
    {
        return self::active()->ordered()->get();
    }
}
