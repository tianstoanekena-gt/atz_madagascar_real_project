<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityGallery extends Model
{
    protected $table = 'activity_galleries';

    protected $fillable = [
        'activity_id',
        'image_path',
        'order'
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
