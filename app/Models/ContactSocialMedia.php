<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSocialMedia extends Model
{
    protected $table = 'contact_social_media';

    protected $fillable = [
        'name',
        'url',
        'icon',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
