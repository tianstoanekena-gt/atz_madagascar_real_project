<?php

namespace App\Http\Controllers;

use App\Models\HeroSlide;

class HomeController extends Controller
{
    public function index()
    {
        // Récupère les slides actifs triés par ordre
        $heroSlides = HeroSlide::where('is_active', true)
            ->orderBy('order')
            ->get();

        // dd($heroSlides);

        return view('pages.home', [
            'heroSlides' => $heroSlides
        ]);
    }
}
