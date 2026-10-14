<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

class Student extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'birth_date',
        'gender',
        'photo',
        'location',
        'whatsapp',
        'education_level',
        'description',
        'description_mg',
        'description_en',
        'needs',
        'needs_mg',
        'needs_en',
        'target_amount',
        'collected_amount',
        'status',
        'is_featured',
        'order',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'target_amount' => 'decimal:2',
        'collected_amount' => 'decimal:2',
        'is_featured' => 'boolean',
        'order' => 'integer',
    ];

    // ==================== RELATIONS ====================
    public function sponsorships(): HasMany
    {
        return $this->hasMany(Sponsorship::class);
    }

    public function godparents(): BelongsToMany
    {
        return $this->belongsToMany(Godparent::class, 'sponsorships')
            ->withPivot('id', 'amount', 'payment_status', 'message', 'validated_at')
            ->withTimestamps();
    }

    // ==================== SCOPES ====================
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('created_at', 'desc');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // ==================== ACCESSORS ====================

    public function getAgeAttribute(): int
    {
        return $this->birth_date->age;
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getPhotoUrlAttribute(): string
    {
        return $this->photo ? Storage::url($this->photo) : asset('assets/images/default-student.png');
    }

    public function getProgressAttribute(): float
    {
        if ($this->target_amount <= 0) return 0;
        return min(100, round(($this->collected_amount / $this->target_amount) * 100, 2));
    }

    public function getRemainingAmountAttribute(): float
    {
        return max(0, $this->target_amount - $this->collected_amount);
    }

    /**
     * Traduction dynamique du niveau d'éducation via les fichiers de langue
     */
    public function getEducationLevelLabelAttribute(): string
    {
        return __('students.levels.' . $this->education_level);
    }

    /**
     * Traduction dynamique du statut via les fichiers de langue
     */
    public function getStatusLabelAttribute(): string
    {
        return __('students.statuses.' . $this->status);
    }

    public function getStatusColorAttribute(): string
    {
        return [
            'pending' => 'orange',
            'active' => 'green',
            'completed' => 'blue',
        ][$this->status] ?? 'gray';
    }

    /**
     * Récupère la description traduite selon la langue active
     */
    public function getDescriptionTranslatedAttribute(): string
    {
        $locale = app()->getLocale();

        if ($locale === 'mg' && $this->description_mg) {
            return $this->description_mg;
        }
        if ($locale === 'en' && $this->description_en) {
            return $this->description_en;
        }

        return $this->description; // Fallback sur le français
    }

    /**
     * Récupère les besoins traduits selon la langue active
     */
    public function getNeedsTranslatedAttribute(): string
    {
        $locale = app()->getLocale();

        if ($locale === 'mg' && $this->needs_mg) {
            return $this->needs_mg;
        }
        if ($locale === 'en' && $this->needs_en) {
            return $this->needs_en;
        }

        return $this->needs; // Fallback sur le français
    }
}
