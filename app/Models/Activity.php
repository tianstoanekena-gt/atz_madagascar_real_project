<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'slug',
        'category',
        'hero_image',
        'gallery',
        'order',
        'is_published'
    ];

    protected $casts = [
        'gallery' => 'array',
        'is_published' => 'boolean',
        'order' => 'integer',
    ];

    // Relation avec les traductions
    public function translations()
    {
        return $this->hasMany(ActivityTranslation::class);
    }


    // Accesseurs multilingues automatiques (pour afficher $activity->title directement)
    public function getTitleAttribute()
    {
        return $this->getTranslation('title');
    }

    public function getDescriptionAttribute()
    {
        return $this->getTranslation('description');
    }

    private function getTranslation($field)
    {
        $locale = app()->getLocale();
        $translation = $this->translations->firstWhere('locale', $locale)
            ?? $this->translations->firstWhere('locale', 'fr')
            ?? $this->translations->first();

        return $translation ? $translation->$field : '';
    }

    // Scopes pour filtrer facilement
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
