<?php

namespace App\Http\Controllers;

use App\Models\Faq;

class FaqController extends Controller
{
    /**
     * Display a listing of the FAQs (frontend).
     */
    public function index()
    {
        // Récupérer les FAQs publiées, triées par ordre
        $faqs = Faq::published()
            ->ordered()
            ->get();

        // Groupement par catégorie pour l'affichage
        $faqsByCategory = $faqs->groupBy('category');

        // Catégories disponibles (pour les filtres)
        $categories = [
            'general' => 'Général',
            'membership' => 'Adhésion',
            'donation' => 'Dons',
            'activities' => 'Activités',
            'contact' => 'Contact',
        ];

        return view('pages.faq', compact('faqs', 'faqsByCategory', 'categories'));
    }
}
