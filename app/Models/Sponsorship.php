<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Sponsorship extends Model
{
    protected $fillable = [
        'student_id',
        'godparent_id',
        'amount',
        'payment_status',
        'payment_proof',
        'message',
        'validated_by',
        'validated_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'validated_at' => 'datetime',
    ];

    // ==================== RELATIONS ====================

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function godparent(): BelongsTo
    {
        return $this->belongsTo(Godparent::class);
    }

    public function validator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    // ==================== SCOPES ====================

    public function scopePending($query)
    {
        return $query->where('payment_status', 'pending');
    }

    public function scopeValidated($query)
    {
        return $query->where('payment_status', 'validated');
    }

    public function scopeRejected($query)
    {
        return $query->where('payment_status', 'rejected');
    }

    public function scopeForStudent($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }

    public function scopeForGodparent($query, $godparentId)
    {
        return $query->where('godparent_id', $godparentId);
    }

    // ==================== ACCESSORS ====================

    /**
     * Montant formaté en Ariary
     */
    public function getFormattedAmountAttribute(): string
    {
        return number_format($this->amount, 0, ',', ' ') . ' Ar';
    }

    /**
     * URL de la preuve de paiement
     */
    public function getPaymentProofUrlAttribute(): ?string
    {
        return $this->payment_proof ? Storage::url($this->payment_proof) : null;
    }

    /**
     * Label du statut de paiement
     */
    public function getPaymentStatusLabelAttribute(): string
    {
        return [
            'pending' => 'En attente',
            'validated' => 'Validé',
            'rejected' => 'Rejeté',
        ][$this->payment_status] ?? $this->payment_status;
    }

    /**
     * Couleur du badge statut
     */
    public function getPaymentStatusColorAttribute(): string
    {
        return [
            'pending' => 'orange',
            'validated' => 'green',
            'rejected' => 'red',
        ][$this->payment_status] ?? 'gray';
    }

    // ==================== MÉTHODES UTILITAIRES ====================

    /**
     * Valider le parrainage (appelé par le CM)
     */
    public function validateBy(User $user): void
    {
        $this->update([
            'payment_status' => 'validated',
            'validated_by' => $user->id,
            'validated_at' => now(),
        ]);

        // Incrémenter le montant collecté de l'élève
        $this->student->increment('collected_amount', $this->amount);

        // Vérifier si l'objectif est atteint
        if ($this->student->collected_amount >= $this->student->target_amount) {
            $this->student->update(['status' => 'completed']);
        }
    }

    /**
     * Rejeter le parrainage
     */
    public function rejectBy(User $user, string $reason = ''): void
    {
        $this->update([
            'payment_status' => 'rejected',
            'validated_by' => $user->id,
            'validated_at' => now(),
        ]);
    }
}
