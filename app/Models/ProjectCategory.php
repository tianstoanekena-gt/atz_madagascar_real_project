<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectCategory extends Model
{
    protected $fillable = [
        'slug',
        'color_hex',
        'order',
    ];

    /**
     * Relation : Une catégorie a plusieurs projets
     */
    public function projects()
    {
        return $this->hasMany(Project::class, 'category_id');
    }
}
