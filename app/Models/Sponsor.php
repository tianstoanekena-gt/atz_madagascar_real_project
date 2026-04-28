<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Sponsor extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'logo',
        'website',
        'since_year',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'since_year' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($sponsor) {
            if (empty($sponsor->slug)) {
                $sponsor->slug = Str::slug($sponsor->name);
            }
        });

        static::updating(function ($sponsor) {
            if ($sponsor->isDirty('name')) {
                $sponsor->slug = Str::slug($sponsor->name);
            }
        });
    }

    public function translations(): HasMany
    {
        return $this->hasMany(SponsorTranslation::class, 'sponsor_id');
    }

    public function details(): HasOne
    {
        return $this->hasOne(SponsorDetail::class, 'sponsor_id');
    }

    public function translation($lang = null)
    {
        $lang = $lang ?? app()->getLocale();

        return $this->translations->where('lang', $lang)->first()
            ?? $this->translations->where('lang', 'fr')->first()
            ?? $this->translations->first();
    }

    public function getLogoUrlAttribute()
    {
        return $this->logo ? asset('storage/' . $this->logo) : null;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePublished($query)
    {
        return $query->whereHas('details', function ($q) {
            $q->where('is_published', true);
        });
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
