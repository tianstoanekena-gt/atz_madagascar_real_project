<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

class Godparent extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'whatsapp',
        'address',
        'photo',
    ];

    // ==================== RELATIONS ====================

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function sponsorships(): HasMany
    {
        return $this->hasMany(Sponsorship::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'sponsorships')
            ->withPivot('id', 'amount', 'payment_status', 'message', 'validated_at')
            ->withTimestamps();
    }

    // ==================== ACCESSORS ====================

    /**
     * Nom complet
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * URL de la photo (avec fallback)
     */
    public function getPhotoUrlAttribute(): string
    {
        return $this->photo ? Storage::url($this->photo) : asset('assets/images/default-avatar.png');
    }

    /**
     * Lien WhatsApp formaté (avec préfixe https://wa.me/)
     */
    public function getWhatsappLinkAttribute(): string
    {
        $number = preg_replace('/[^0-9]/', '', $this->whatsapp);
        return "https://wa.me/{$number}";
    }

    /**
     * Nombre total donné (tous parrainages validés confondus)
     */
    public function getTotalDonatedAttribute(): float
    {
        return $this->sponsorships()
            ->where('payment_status', 'validated')
            ->sum('amount');
    }

    /**
     * Nombre d'élèves parrainés (validés)
     */
    public function getStudentsCountAttribute(): int
    {
        return $this->sponsorships()
            ->where('payment_status', 'validated')
            ->distinct('student_id')
            ->count('student_id');
    }
}
