<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value'];

    /**
     * Récupère la valeur d'un paramètre
     */
    public static function getValue(string $key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Met à jour ou crée un paramètre
     */
    public static function setValue(string $key, $value): bool
    {
        $setting = self::firstOrNew(['key' => $key]);
        $setting->value = $value;
        return $setting->save();
    }
}
