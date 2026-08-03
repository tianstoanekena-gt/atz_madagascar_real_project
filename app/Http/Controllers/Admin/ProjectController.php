<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with(['translations', 'category'])
            ->orderBy('is_featured', 'desc')
            ->orderBy('order')
            ->paginate(10);

        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        $categories = ProjectCategory::orderBy('order')->get();
        return view('admin.projects.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:project_categories,id',
            'status' => 'required|in:upcoming,ongoing,completed',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'location' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'target_amount' => 'nullable|numeric|min:0',
            'current_amount' => 'nullable|numeric|min:0',
            'beneficiaries_count' => 'nullable|integer|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_featured' => 'boolean',
            'order' => 'nullable|integer|min:0',
            'title_fr' => 'required|string|max:255',
            'short_description_fr' => 'nullable|string',
            'full_description_fr' => 'nullable|string',
            'title_mg' => 'nullable|string|max:255',
            'short_description_mg' => 'nullable|string',
            'full_description_mg' => 'nullable|string',
            'title_en' => 'nullable|string|max:255',
            'short_description_en' => 'nullable|string',
            'full_description_en' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // 1. Génération du slug unique
            $baseSlug = Str::slug($request->title_fr);
            $slug = $baseSlug;
            $counter = 1;
            while (Project::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            // 2. Gestion de l'image Hero
            $heroPath = null;
            if ($request->hasFile('hero_image')) {
                $heroPath = $request->file('hero_image')->store('projects/hero', 'public');
            }

            // 3. Création du projet
            $project = Project::create([
                'category_id' => $request->category_id,
                'slug' => $slug,
                'status' => $request->status,
                'hero_image' => $heroPath,
                'location' => $request->location,
                'city' => $request->city,
                'target_amount' => $request->target_amount,
                'current_amount' => $request->current_amount ?? 0,
                'beneficiaries_count' => $request->beneficiaries_count,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'is_featured' => $request->has('is_featured'),
                'order' => $request->order ?? 0,
            ]);

            // 4. Sauvegarde des traductions
            foreach (['fr', 'mg', 'en'] as $locale) {
                if ($request->filled("title_{$locale}")) {
                    \App\Models\ProjectTranslation::create([
                        'project_id' => $project->id,
                        'locale' => $locale,
                        'title' => $request->input("title_{$locale}"),
                        'short_description' => $request->input("short_description_{$locale}"),
                        'full_description' => $request->input("full_description_{$locale}"),
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('admin.projects.index')->with('success', 'Projet ajouté avec succès !');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Erreur : ' . $e->getMessage()])->withInput();
        }
    }

    public function edit(Project $project)
    {
        $project->load('translations');
        $categories = ProjectCategory::orderBy('order')->get();
        return view('admin.projects.edit', compact('project', 'categories'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'category_id' => 'required|exists:project_categories,id',
            'status' => 'required|in:upcoming,ongoing,completed',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'location' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'target_amount' => 'nullable|numeric|min:0',
            'current_amount' => 'nullable|numeric|min:0',
            'beneficiaries_count' => 'nullable|integer|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_featured' => 'boolean',
            'order' => 'nullable|integer|min:0',
            'title_fr' => 'required|string|max:255',
            'short_description_fr' => 'nullable|string',
            'full_description_fr' => 'nullable|string',
            'title_mg' => 'nullable|string|max:255',
            'short_description_mg' => 'nullable|string',
            'full_description_mg' => 'nullable|string',
            'title_en' => 'nullable|string|max:255',
            'short_description_en' => 'nullable|string',
            'full_description_en' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $updateData = [
                'category_id' => $request->category_id,
                'status' => $request->status,
                'location' => $request->location,
                'city' => $request->city,
                'target_amount' => $request->target_amount,
                'current_amount' => $request->current_amount ?? 0,
                'beneficiaries_count' => $request->beneficiaries_count,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'is_featured' => $request->has('is_featured'),
                'order' => $request->order ?? 0,
            ];

            // Mise à jour Hero Image
            if ($request->hasFile('hero_image')) {
                if ($project->hero_image) {
                    Storage::disk('public')->delete($project->hero_image);
                }
                $updateData['hero_image'] = $request->file('hero_image')->store('projects/hero', 'public');
            }

            $project->update($updateData);

            // Mise à jour du slug si le titre FR a changé
            if ($request->filled('title_fr') && Str::slug($request->title_fr) !== Str::slug($project->translations->firstWhere('locale', 'fr')?->title)) {
                $baseSlug = Str::slug($request->title_fr);
                $slug = $baseSlug;
                $counter = 1;
                while (Project::where('slug', $slug)->where('id', '!=', $project->id)->exists()) {
                    $slug = $baseSlug . '-' . $counter;
                    $counter++;
                }
                $project->update(['slug' => $slug]);
            }

            // Mise à jour des traductions
            foreach (['fr', 'mg', 'en'] as $locale) {
                if ($request->filled("title_{$locale}")) {
                    $project->translations()->updateOrCreate(
                        ['locale' => $locale],
                        [
                            'title' => $request->input("title_{$locale}"),
                            'short_description' => $request->input("short_description_{$locale}"),
                            'full_description' => $request->input("full_description_{$locale}"),
                        ]
                    );
                }
            }

            DB::commit();
            return redirect()->route('admin.projects.index')->with('success', 'Projet mis à jour !');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Erreur : ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy(Project $project)
    {
        // Supprimer l'image Hero du disque
        if ($project->hero_image) {
            Storage::disk('public')->delete($project->hero_image);
        }

        // La suppression du projet entraînera la suppression en cascade des traductions
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Projet supprimé définitivement !');
    }
}
