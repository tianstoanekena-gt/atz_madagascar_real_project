<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\NavItem;

class NavTranslation extends Model
{
    protected $fillable = [
        'nav_item_id',
        'locale',
        'label'
    ];

    /**
     * Relation : Une traduction appartient à un nav item
     */
    public function navItem()
    {
        return $this->belongsTo(NavItem::class);
    }
}
