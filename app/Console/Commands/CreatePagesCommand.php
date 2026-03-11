<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Page;

class CreatePagesCommand extends Command
{
    protected $signature = 'pages:create';
    protected $description = 'Créer les pages de base (À propos, Contact, etc.)';

    public function handle()
    {
        $pages = [
            'a-propos' => [
                'fr' => ['title' => 'À propos', 'content' => 'L’association ATZ Madagascar...'],
                'en' => ['title' => 'About', 'content' => 'ATZ Madagascar association...'],
                'mg' => ['title' => 'Mombamomba', 'content' => 'Ny fikambanana ATZ Madagascar...'],
            ],
            'contact' => [
                'fr' => ['title' => 'Contact', 'content' => 'Coordonnées et formulaire...'],
                'en' => ['title' => 'Contact', 'content' => 'Contact details and form...'],
                'mg' => ['title' => 'Fifandraisanana', 'content' => 'Adiresy sy endrika fifandraisanana...'],
            ],
        ];

        foreach ($pages as $slug => $translations) {
            $page = Page::firstOrNew(['slug' => $slug]);

            if (!$page->exists) {
                // Initialiser les champs JSON vides pour éviter l'erreur SQL
                $page->title = [];
                $page->content = [];
                $page->save();
            }

            foreach (['fr', 'en', 'mg'] as $locale) {
                $page->setTranslation('title', $locale, $translations[$locale]['title']);
                $page->setTranslation('content', $locale, $translations[$locale]['content']);
            }

            $page->save();
            $this->info("Page '{$slug}' créée en 3 langues.");
        }

        $this->info('✅ Pages de base prêtes.');
    }
}
