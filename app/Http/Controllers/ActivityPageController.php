<?php

namespace App\Http\Controllers;

use App\Models\Activity;

class ActivityPageController extends Controller
{
    public function index()
    {
        $activities = Activity::published()
            ->ordered()
            ->with('translations')
            ->get();

        return view('pages.activities', compact('activities'));
    }

    public function show($locale, $slug)
    {
        $activity = Activity::where('slug', $slug)
            ->published()
            ->with('translations')
            ->firstOrFail();

        // Optionnel : Charger les activités connexes (même catégorie)
        $relatedActivities = Activity::published()
            ->byCategory($activity->category)
            ->where('id', '!=', $activity->id)
            ->limit(3)
            ->get();

        return view('pages.activity-detail', compact('activity', 'relatedActivities'));
    }
}
