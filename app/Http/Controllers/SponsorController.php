<?php

namespace App\Http\Controllers;

use App\Models\Sponsor;

class SponsorController extends Controller
{
    public function show($slug)
    {
        $sponsor = Sponsor::with(['details.photos', 'translations'])
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();

        return view('pages.sponsor.show', compact('sponsor'));
    }

    // public function test($id)
    // {
    //     $sponsor = Sponsor::with(['details.photos', 'translations'])
    //         ->where('id', $id)
    //         ->active()
    //         ->firstOrFail();

    //     dump($sponsor);

    //     return view('pages.sponsor.show', compact('sponsor'));
    // }
}
