<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatMain extends Model
{
    use SoftDeletes;
    protected $table = 'stat_main';
    protected $fillable = ['year', 'value', 'unit', 'display_type', 'icon', 'layout_style',  'order', 'is_published'];
    protected $casts = ['year' => 'integer', 'value' => 'decimal:2', 'order' => 'integer', 'is_published' => 'boolean'];

    public function translations()
    {
        return $this->hasMany(StatMainTranslation::class);
    }

    // Accesseurs multilingues automatiques
    public function getLabelAttribute()
    {
        return $this->getTranslation('label');
    }
    public function getTrendAttribute()
    {
        return $this->getTranslation('trend');
    }
    public function getDetailAttribute()
    {
        return $this->getTranslation('detail');
    }

    private function getTranslation($field)
    {
        $locale = app()->getLocale();
        $translation = $this->translations->firstWhere('locale', $locale)
            ?? $this->translations->firstWhere('locale', 'fr')
            ?? $this->translations->first();
        return $translation ? $translation->$field : '';
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
    public function scopeForYear($query, $year)
    {
        return $query->where('year', $year);
    }
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
