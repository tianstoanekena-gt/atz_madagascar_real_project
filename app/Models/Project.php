<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'category_id',
        'slug',
        'status',
        'hero_image',
        'location',
        'city',
        'target_amount',
        'current_amount',
        'beneficiaries_count',
        'start_date',
        'end_date',
        'is_featured',
        'order',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_featured' => 'boolean',
        'target_amount' => 'decimal:2',
        'current_amount' => 'decimal:2',
    ];

    /**
     * Relation : Un projet appartient à une catégorie
     */
    public function category()
    {
        return $this->belongsTo(ProjectCategory::class, 'category_id');
    }

    /**
     * Relation : Un projet a plusieurs traductions
     */
    public function translations()
    {
        return $this->hasMany(ProjectTranslation::class);
    }

    /**
     * Accesseur multilingue : Titre
     */
    public function getTitleAttribute()
    {
        return $this->getTranslation('title');
    }

    /**
     * Accesseur multilingue : Description courte
     */
    public function getShortDescriptionAttribute()
    {
        return $this->getTranslation('short_description');
    }

    /**
     * Accesseur multilingue : Description complète
     */
    public function getFullDescriptionAttribute()
    {
        return $this->getTranslation('full_description');
    }

    /**
     * Méthode helper : Récupère la traduction pour la locale courante
     */
    private function getTranslation($field)
    {
        $locale = app()->getLocale();

        // Priorité : locale courante > français > première traduction disponible
        $translation = $this->translations->firstWhere('locale', $locale)
            ?? $this->translations->firstWhere('locale', 'fr')
            ?? $this->translations->first();

        return $translation ? $translation->$field : '';
    }

    /**
     * Scope : Projets en vedette
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope : Projets en cours
     */
    public function scopeOngoing($query)
    {
        return $query->where('status', 'ongoing');
    }

    /**
     * Scope : Projets réalisés
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope : Projets à venir
     */
    public function scopeUpcoming($query)
    {
        return $query->where('status', 'upcoming');
    }

    /**
     * Accesseur : Progression en pourcentage
     */
    public function getProgressPercentageAttribute()
    {
        if (!$this->target_amount || $this->target_amount == 0) {
            return 0;
        }
        return min(100, ($this->current_amount / $this->target_amount) * 100);
    }
}
