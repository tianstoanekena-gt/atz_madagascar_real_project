<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpeningHour extends Model
{
    protected $fillable = [
        'day',
        'open_time',
        'close_time',
        'is_closed',
        'order',
    ];

    protected $casts = [
        'is_closed' => 'boolean',
        'order' => 'integer',
        'open_time' => 'datetime:H:i',
        'close_time' => 'datetime:H:i',
    ];

    public function scopeOpen($query)
    {
        return $query->where('is_closed', false);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
