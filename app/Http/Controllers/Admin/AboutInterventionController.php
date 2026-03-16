<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutIntervention;
use App\Models\AboutInterventionTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AboutInterventionController extends Controller
{
    public function index()
    {
        $interventions = AboutIntervention::with('translations')
            ->orderBy('order')
            ->paginate(10);
        return view('admin.about-interventions.index', compact('interventions'));
    }

    public function create()
    {
        $languages = ['mg' => 'Malagasy', 'fr' => 'Français', 'en' => 'English'];
        return view('admin.about-interventions.create', compact('languages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:png,jpg,jpeg|max:5120',
            'order' => 'required|integer|min:0',
            'translations' => 'required|array|min:1',
            'translations.*.lang' => 'required|in:mg,fr,en',
            'translations.*.title' => 'required|string|max:255',
            'translations.*.description' => 'required|string|min:10|max:5000',
        ], [
            'image.required' => 'L\'image est obligatoire.',
            'image.image' => 'Le fichier doit être une image.',
            'order.required' => 'L\'ordre est obligatoire.',
            'translations.required' => 'Au moins une traduction est obligatoire.',
            'translations.*.title.required' => 'Le titre est obligatoire.',
            'translations.*.description.required' => 'La description est obligatoire.',
        ]);

        DB::beginTransaction();
        try {
            // Upload image
            $imagePath = $request->file('image')->store('about-interventions', 'public');

            // Créer l'intervention
            $intervention = AboutIntervention::create([
                'image' => $imagePath,
                'order' => $request->order,
            ]);

            // Créer les traductions
            foreach ($request->translations as $translation) {
                AboutInterventionTranslation::create([
                    'intervention_id' => $intervention->id,
                    'lang' => $translation['lang'],
                    'title' => $translation['title'],
                    'description' => $translation['description'],
                ]);
            }

            DB::commit();

            return redirect()->route('admin.about-interventions.index')
                ->with('success', 'Intervention ajoutée avec succès !');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'Une erreur est survenue : ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function edit(AboutIntervention $aboutIntervention)
    {
        $languages = ['mg' => 'Malagasy', 'fr' => 'Français', 'en' => 'English'];
        $aboutIntervention->load('translations');
        return view('admin.about-interventions.edit', compact('aboutIntervention', 'languages'));
    }

    public function update(Request $request, AboutIntervention $aboutIntervention)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:5120',
            'order' => 'required|integer|min:0',
            'translations' => 'required|array|min:1',
            'translations.*.lang' => 'required|in:mg,fr,en',
            'translations.*.title' => 'required|string|max:255',
            'translations.*.description' => 'required|string|min:10|max:5000',
        ]);

        DB::beginTransaction();
        try {
            // Upload nouvelle image si fournie
            if ($request->hasFile('image')) {
                if (Storage::disk('public')->exists($aboutIntervention->image)) {
                    Storage::disk('public')->delete($aboutIntervention->image);
                }
                $imagePath = $request->file('image')->store('about-interventions', 'public');
                $aboutIntervention->image = $imagePath;
            }

            $aboutIntervention->order = $request->order;
            $aboutIntervention->save();

            // Supprimer anciennes traductions
            $aboutIntervention->translations()->delete();

            // Créer nouvelles traductions
            foreach ($request->translations as $translation) {
                AboutInterventionTranslation::create([
                    'intervention_id' => $aboutIntervention->id,
                    'lang' => $translation['lang'],
                    'title' => $translation['title'],
                    'description' => $translation['description'],
                ]);
            }

            DB::commit();

            return redirect()->route('admin.about-interventions.index')
                ->with('success', 'Intervention mise à jour avec succès !');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'Une erreur est survenue : ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function destroy(AboutIntervention $aboutIntervention)
    {
        if (Storage::disk('public')->exists($aboutIntervention->image)) {
            Storage::disk('public')->delete($aboutIntervention->image);
        }

        $aboutIntervention->delete();

        return redirect()->route('admin.about-interventions.index')
            ->with('success', 'Intervention supprimée avec succès !');
    }
}
