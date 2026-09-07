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
        'needs',
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

    /**
     * Âge calculé dynamiquement à partir de la date de naissance
     */
    public function getAgeAttribute(): int
    {
        return $this->birth_date->age;
    }

    /**
     * Nom complet
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * URL complète de la photo
     */
    public function getPhotoUrlAttribute(): string
    {
        return $this->photo ? Storage::url($this->photo) : asset('assets/images/default-student.png');
    }

    /**
     * Progression du financement (en %)
     */
    public function getProgressAttribute(): float
    {
        if ($this->target_amount <= 0) return 0;
        return min(100, round(($this->collected_amount / $this->target_amount) * 100, 2));
    }

    /**
     * Montant restant à collecter
     */
    public function getRemainingAmountAttribute(): float
    {
        return max(0, $this->target_amount - $this->collected_amount);
    }

    /**
     * Traduction du niveau d'éducation
     */
    public function getEducationLevelLabelAttribute(): string
    {
        return [
            'primaire' => 'Primaire',
            'college' => 'Collège',
            'lycee' => 'Lycée',
            'superieur' => 'Études supérieures',
            'formation_pro' => 'Formation professionnelle',
        ][$this->education_level] ?? $this->education_level;
    }

    /**
     * Traduction du statut
     */
    public function getStatusLabelAttribute(): string
    {
        return [
            'pending' => 'En attente',
            'active' => 'En cours',
            'completed' => 'Terminé',
        ][$this->status] ?? $this->status;
    }

    /**
     * Couleur du badge statut
     */
    public function getStatusColorAttribute(): string
    {
        return [
            'pending' => 'orange',
            'active' => 'green',
            'completed' => 'blue',
        ][$this->status] ?? 'gray';
    }
}
