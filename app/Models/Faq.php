<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    use HasFactory, SoftDeletes;


    protected $table = 'faq_entries';

    /**
     * Les attributs assignables en masse.
     */
    protected $fillable = [
        'category',
        'order',
        'question_mg',
        'question_fr',
        'question_en',
        'answer_mg',
        'answer_fr',
        'answer_en',
        'is_published',
        'view_count',
    ];

    /**
     * Les attributs à caster.
     */
    protected $casts = [
        'is_published' => 'boolean',
        'order' => 'integer',
        'view_count' => 'integer',
    ];

    /**
     * Obtenir la question selon la locale actuelle.
     */
    public function getQuestionAttribute()
    {
        $locale = app()->getLocale();

        return match ($locale) {
            'mg' => $this->question_mg ?? $this->question_fr ?? $this->question_en ?? 'Sans titre',
            'en' => $this->question_en ?? $this->question_fr ?? $this->question_mg ?? 'Untitled',
            default => $this->question_fr ?? $this->question_mg ?? $this->question_en ?? 'Sans titre',
        };
    }

    /**
     * Obtenir la réponse selon la locale actuelle.
     */
    public function getAnswerAttribute()
    {
        $locale = app()->getLocale();

        return match ($locale) {
            'mg' => $this->answer_mg ?? $this->answer_fr ?? $this->answer_en ?? '',
            'en' => $this->answer_en ?? $this->answer_fr ?? $this->answer_mg ?? '',
            default => $this->answer_fr ?? $this->answer_mg ?? $this->answer_en ?? '',
        };
    }

    /**
     * Obtenir le nom de la catégorie traduite.
     */
    public function getCategoryNameAttribute()
    {
        return __('faq.categories.' . $this->category);
    }

    /**
     * Obtenir l'icône FontAwesome selon la catégorie.
     */
    public function getCategoryIconAttribute()
    {
        return match ($this->category) {
            'general' => 'fa-circle-question',
            'membership' => 'fa-handshake',
            'donation' => 'fa-heart',
            'activities' => 'fa-calendar',
            'contact' => 'fa-envelope',
            default => 'fa-circle-question',
        };
    }

    /**
     * Scope pour les FAQs publiées.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope pour trier par ordre.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('created_at', 'desc');
    }

    /**
     * Scope pour filtrer par catégorie.
     */
    public function scopeOfCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Incrémenter le compteur de vues.
     */
    public function incrementViewCount()
    {
        $this->increment('view_count');
    }
}
