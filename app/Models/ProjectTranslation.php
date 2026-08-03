<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectTranslation extends Model
{
    protected $table = 'project_translations';

    protected $fillable = [
        'project_id',
        'locale',
        'title',
        'short_description',
        'full_description',
    ];

    /**
     * Relation : Une traduction appartient à un projet
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
