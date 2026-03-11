<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutContent extends Model
{
    use HasFactory;


    protected $table = 'about_contents';

    protected $fillable = ['section', 'content'];

    protected $casts = [
        'content' => 'array'
    ];

    /**
     * Récupère le contenu dans la langue courante
     */
    public static function getContent(string $section, string $key = null, $default = null)
    {
        $content = self::where('section', $section)->first();

        if (!$content) {
            return $default;
        }

        $locale = app()->getLocale();
        $data = $content->content;

        // Si un chemin spécifique est demandé
        if ($key) {
            $keys = explode('.', $key);
            foreach ($keys as $k) {
                if (isset($data[$k])) {
                    $data = $data[$k];
                } else {
                    return $default;
                }
            }
        }

        // Gestion multilingue
        if (is_array($data)) {
            return $data[$locale] ?? $data['fr'] ?? $data['en'] ?? $default;
        }

        return $data;
    }
}
