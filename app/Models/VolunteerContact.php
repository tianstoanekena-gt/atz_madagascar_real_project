<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VolunteerContact extends Model
{
    protected $fillable = [
        'volunteer_id',
        'contact_type_id',
        'contact_value',
        'custom_url',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    public function volunteer(): BelongsTo
    {
        return $this->belongsTo(Volunteer::class, 'volunteer_id');
    }

    public function contactType(): BelongsTo
    {
        return $this->belongsTo(ContactType::class, 'contact_type_id');
    }

    public function getUrlAttribute()
    {
        if ($this->custom_url) {
            return $this->custom_url;
        }

        return $this->contactType ? $this->contactType->generateUrl($this->contact_value) : null;
    }

    public function getIconClassAttribute()
    {
        return $this->contactType ? $this->contactType->icon_class : 'fas fa-link';
    }

    public function getTypeSlugAttribute()
    {
        return $this->contactType ? $this->contactType->slug : 'other';
    }

    public function scopeForVolunteer($query, $volunteerId)
    {
        return $query->where('volunteer_id', $volunteerId);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
