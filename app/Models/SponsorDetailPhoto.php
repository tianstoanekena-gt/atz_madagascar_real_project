<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SponsorDetailPhoto extends Model
{
    protected $fillable = [
        'sponsor_detail_id',
        'photo',
        'caption',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    public function sponsorDetail(): BelongsTo
    {
        return $this->belongsTo(SponsorDetail::class, 'sponsor_detail_id');
    }
}
