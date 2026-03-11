<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\NavTranslation;

class NavItem extends Model
{
    protected $fillable = [
        'key',
        'route_name',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relation : Un nav item a plusieurs traductions
     */
    public function translations()
    {
        return $this->hasMany(NavTranslation::class);
    }

    /**
     * Récupérer la traduction pour une langue spécifique
     */
    public function translation($locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        return $this->translations()->where('locale', $locale)->first();
    }

    /**
     * Récupérer directement le label traduit
     */
    public function getLabel($locale = null)
    {
        $translation = $this->translation($locale);
        return $translation ? $translation->label : $this->key;
    }

    /**
     * Scope : Récupérer uniquement les items actifs
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope : Ordonner par ordre
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
