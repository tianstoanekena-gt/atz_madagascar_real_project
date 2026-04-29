<?php

namespace App\Http\Controllers;

use App\Models\Sponsor;
// use Illuminate\Support\Facades\Log;

class SponsorController extends Controller
{
    public function index()
    {
        $sponsors = Sponsor::with(['details.photos', 'translations'])
            ->active()
            ->get();

        return view('pages.sponsor.index', compact('sponsors'));
    }


    public function show(...$params)
    {
        logger()->info("DEBUG PARAMS", ['count' => count($params), 'params' => $params]);

        // Récupérer le slug (dernier paramètre)
        $slug = end($params);

        $sponsor = Sponsor::with(['details.photos', 'translations'])
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();

        return view('pages.sponsor.show', compact('sponsor'));
    }
}
