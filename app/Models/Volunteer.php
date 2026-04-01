<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Volunteer extends Model
{
    protected $fillable = [
        'name',
        'photo',
        'order',
        'volunteer_since',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'volunteer_since' => 'integer',
    ];

    public function translations(): HasMany
    {
        return $this->hasMany(VolunteerTranslation::class, 'volunteer_id');
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(VolunteerContact::class, 'volunteer_id')
            ->join('contact_types', 'volunteer_contacts.contact_type_id', '=', 'contact_types.id')
            ->where('contact_types.is_active', true)
            ->orderBy('contact_types.order')
            ->select('volunteer_contacts.*');
    }

    public function allContacts(): HasMany
    {
        return $this->hasMany(VolunteerContact::class, 'volunteer_id')
            ->orderBy('order');
    }

    public function translation($lang = null)
    {
        $lang = $lang ?? app()->getLocale();

        return $this->translations->where('lang', $lang)->first()
            ?? $this->translations->where('lang', 'fr')->first()
            ?? $this->translations->first();
    }

    public function getPhotoUrlAttribute()
    {
        return $this->photo ? asset('storage/' . $this->photo) : null;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
