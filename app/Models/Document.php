<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Les attributs assignables en masse.
     */
    protected $fillable = [
        'title_fr',
        'title_mg',
        'title_en',
        'description_fr',
        'description_mg',
        'description_en',
        'file_path',
        'file_type',
        'file_size',
        'file_original_name',
        'view_count',
        'download_count',
        'is_published',
        'order',
    ];

    /**
     * Les attributs à caster.
     */
    protected $casts = [
        'is_published' => 'boolean',
        'file_size' => 'integer',
        'view_count' => 'integer',
        'download_count' => 'integer',
        'order' => 'integer',
    ];

    /**
     * Obtenir le titre selon la locale actuelle.
     */
    public function getTitleAttribute()
    {
        $locale = app()->getLocale();

        return match ($locale) {
            'mg' => $this->title_mg ?? $this->title_fr ?? $this->title_en ?? 'Sans titre',
            'en' => $this->title_en ?? $this->title_fr ?? $this->title_mg ?? 'Untitled',
            default => $this->title_fr ?? $this->title_mg ?? $this->title_en ?? 'Sans titre',
        };
    }

    /**
     * Obtenir la description selon la locale actuelle.
     */
    public function getDescriptionAttribute()
    {
        $locale = app()->getLocale();

        return match ($locale) {
            'mg' => $this->description_mg ?? $this->description_fr ?? $this->description_en ?? '',
            'en' => $this->description_en ?? $this->description_fr ?? $this->description_mg ?? '',
            default => $this->description_fr ?? $this->description_mg ?? $this->description_en ?? '',
        };
    }

    /**
     * Obtenir la taille du fichier formatée.
     */
    public function getFormattedSizeAttribute()
    {
        $bytes = $this->file_size;
        $units = ['o', 'Ko', 'Mo', 'Go'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Obtenir l'icône FontAwesome selon le type.
     */
    public function getIconAttribute()
    {
        return match ($this->file_type) {
            'pdf' => 'fa-file-pdf',
            'word' => 'fa-file-word',
            'excel' => 'fa-file-excel',
            'powerpoint' => 'fa-file-powerpoint',
            default => 'fa-file',
        };
    }

    /**
     * Obtenir la classe de couleur selon le type.
     */
    public function getTypeClassAttribute()
    {
        return match ($this->file_type) {
            'pdf' => 'pdf-bg',
            'word' => 'word-bg',
            'excel' => 'excel-bg',
            'powerpoint' => 'ppt-bg',
            default => '',
        };
    }

    /**
     * Scope pour les documents publiés.
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
     * Scope pour filtrer par type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('file_type', $type);
    }

    /**
     * Incrémenter le compteur de vues.
     */
    public function incrementViewCount()
    {
        $this->increment('view_count');
    }

    /**
     * Incrémenter le compteur de téléchargements.
     */
    public function incrementDownloadCount()
    {
        $this->increment('download_count');
    }
}
