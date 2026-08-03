<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectCategory;

class ProjectPageController extends Controller
{
    /**
     * Afficher la liste des projets (page publique)
     */
    public function index($locale)
    {
        // Récupérer tous les projets avec leurs traductions et catégories
        $projects = Project::with(['translations', 'category'])
            ->orderBy('is_featured', 'desc')
            ->orderBy('order')
            ->get();

        // Récupérer toutes les catégories pour les filtres
        $categories = ProjectCategory::orderBy('order')->get();

        return view('pages.project', compact('projects', 'categories'));
    }

    /**
     * Afficher le détail d'un projet (page publique)
     */
    public function show($locale, $slug)
    {
        $project = Project::where('slug', $slug)
            ->with(['translations', 'category'])
            ->firstOrFail();

        return view('pages.projectdetail', compact('project'));
    }
}
