<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\ActivityTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::with('translations')
            ->orderBy('order')
            ->paginate(10);
        return view('admin.activities.index', compact('activities'));
    }

    public function create()
    {
        return view('admin.activities.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:50',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'order' => 'nullable|integer|min:0',
            'is_published' => 'boolean',
            'title_fr' => 'required|string|max:255',
            'title_mg' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'description_fr' => 'nullable|string',
            'description_mg' => 'nullable|string',
            'description_en' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Gestion de l'image Hero
            $heroPath = null;
            if ($request->hasFile('hero_image')) {
                $heroPath = $request->file('hero_image')->store('activities/hero', 'public');
            }

            // Gestion de la Galerie
            $galleryPaths = [];
            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $file) {
                    $galleryPaths[] = $file->store('activities/gallery', 'public');
                }
            }

            $activity = Activity::create([
                'slug' => Str::slug($request->title_fr),
                'category' => $request->category,
                'hero_image' => $heroPath,
                'gallery' => $galleryPaths,
                'order' => $request->order ?? 0,
                'is_published' => $request->has('is_published'),
            ]);

            // Sauvegarde des traductions
            foreach (['fr', 'mg', 'en'] as $locale) {
                if ($request->filled("title_{$locale}")) {
                    ActivityTranslation::create([
                        'activity_id' => $activity->id,
                        'locale' => $locale,
                        'title' => $request->input("title_{$locale}"),
                        'description' => $request->input("description_{$locale}"),
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('admin.activities.index')->with('success', 'Activité ajoutée avec succès !');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Erreur : ' . $e->getMessage()])->withInput();
        }
    }

    public function edit(Activity $activity)
    {
        $activity->load('translations');
        return view('admin.activities.edit', compact('activity'));
    }

    public function update(Request $request, Activity $activity)
    {
        $request->validate([
            'category' => 'required|string|max:50',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'order' => 'nullable|integer|min:0',
            'is_published' => 'boolean',
            'title_fr' => 'required|string|max:255',
            'title_mg' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'description_fr' => 'nullable|string',
            'description_mg' => 'nullable|string',
            'description_en' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $updateData = [
                'category' => $request->category,
                'order' => $request->order ?? 0,
                'is_published' => $request->has('is_published'),
            ];

            // Mise à jour Hero Image
            if ($request->hasFile('hero_image')) {
                if ($activity->hero_image) Storage::disk('public')->delete($activity->hero_image);
                $updateData['hero_image'] = $request->file('hero_image')->store('activities/hero', 'public');
            }

            // Mise à jour Galerie (on remplace tout pour simplifier, ou on ajoute)
            if ($request->hasFile('gallery')) {
                // Supprimer les anciennes images de galerie
                if ($activity->gallery) {
                    foreach ($activity->gallery as $oldImg) {
                        Storage::disk('public')->delete($oldImg);
                    }
                }
                $newGallery = [];
                foreach ($request->file('gallery') as $file) {
                    $newGallery[] = $file->store('activities/gallery', 'public');
                }
                $updateData['gallery'] = $newGallery;
            }

            $activity->update($updateData);

            // Mise à jour des traductions
            foreach (['fr', 'mg', 'en'] as $locale) {
                if ($request->filled("title_{$locale}")) {
                    $activity->translations()->updateOrCreate(
                        ['locale' => $locale],
                        [
                            'title' => $request->input("title_{$locale}"),
                            'description' => $request->input("description_{$locale}"),
                        ]
                    );
                }
            }

            // Mettre à jour le slug si le titre FR a changé
            if ($request->filled('title_fr')) {
                $activity->update(['slug' => Str::slug($request->title_fr)]);
            }

            DB::commit();
            return redirect()->route('admin.activities.index')->with('success', 'Activité mise à jour !');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Erreur : ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy(Activity $activity)
    {
        // Supprimer les fichiers physiques
        if ($activity->hero_image) Storage::disk('public')->delete($activity->hero_image);
        if ($activity->gallery) {
            foreach ($activity->gallery as $img) Storage::disk('public')->delete($img);
        }

        $activity->delete();
        return redirect()->route('admin.activities.index')->with('success', 'Activité supprimée !');
    }
}
