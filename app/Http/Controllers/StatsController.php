<?php

namespace App\Http\Controllers;

use App\Models\StatMain;
use App\Models\StatEducation;
use App\Models\StatNutrition;
use App\Models\StatHealth;
// use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function index()
    {
        // On récupère l'année la plus récente publiée, ou 2025 par défaut
        $currentYear = StatMain::published()->max('year') ?? 2025;

        $mainStats = StatMain::published()
            ->forYear($currentYear)
            ->ordered()
            ->get();

        $educationStats = StatEducation::published()
            ->forYear($currentYear)
            ->ordered()
            ->get();

        $nutritionStats = StatNutrition::published()
            ->forYear($currentYear)
            ->ordered()
            ->get();

        $healthStats = StatHealth::published()
            ->forYear($currentYear)
            ->ordered()
            ->get();

        // Récupérer les années disponibles pour un éventuel sélecteur
        $availableYears = StatMain::published()->orderBy('year', 'desc')->pluck('year')->unique();

        return view('pages.stat', compact(
            'currentYear',
            'availableYears',
            'mainStats',
            'educationStats',
            'nutritionStats',
            'healthStats'
        ));
    }
}
