<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use App\Models\SponsorTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class SponsorController extends Controller
{
    public function index()
    {
        $sponsors = Sponsor::with('translations')
            ->ordered()
            ->paginate(10);
        return view('admin.sponsors.index', compact('sponsors'));
    }

    public function create()
    {
        $languages = ['mg' => 'Malagasy', 'fr' => 'Français', 'en' => 'English'];
        $currentYear = date('Y');
        $years = range(2000, $currentYear);
        return view('admin.sponsors.create', compact('languages', 'years'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'required|image|mimes:png,jpg,jpeg|max:5120',
            'website' => 'nullable|url|max:255',
            'since_year' => 'nullable|integer|min:2000|max:' . date('Y'),
            'is_active' => 'boolean',
            'order' => 'required|integer|min:0',
            'translations' => 'required|array|min:1',
            'translations.*.lang' => 'required|in:mg,fr,en',
            'translations.*.short_description' => 'required|string|min:10|max:5000',
        ], [
            'name.required' => 'Le nom est obligatoire.',
            'logo.required' => 'Le logo est obligatoire.',
            'logo.image' => 'Le fichier doit être une image.',
            'logo.mimes' => 'Le logo doit être au format PNG, JPG ou JPEG.',
            'logo.max' => 'Le logo ne doit pas dépasser 5 MB.',
            'translations.required' => 'Au moins une traduction est obligatoire.',
            'translations.*.short_description.required' => 'La description est obligatoire.',
        ]);

        DB::beginTransaction();
        try {
            $logoPath = $request->file('logo')->store('sponsors/logos', 'public');

            $sponsor = Sponsor::create([
                'name' => $request->name,
                'logo' => $logoPath,
                'website' => $request->website,
                'since_year' => $request->since_year,
                'is_active' => $request->has('is_active'),
                'order' => $request->order,
            ]);

            foreach ($request->translations as $translation) {
                SponsorTranslation::create([
                    'sponsor_id' => $sponsor->id,
                    'lang' => $translation['lang'],
                    'short_description' => $translation['short_description'],
                ]);
            }

            DB::commit();

            return redirect()->route('admin.sponsors.index')
                ->with('success', 'Sponsor ajouté avec succès !');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'Une erreur est survenue : ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function edit(Sponsor $sponsor)
    {
        $languages = ['mg' => 'Malagasy', 'fr' => 'Français', 'en' => 'English'];
        $currentYear = date('Y');
        $years = range(2000, $currentYear);
        $sponsor->load('translations');
        return view('admin.sponsors.edit', compact('sponsor', 'languages', 'years'));
    }

    public function update(Request $request, Sponsor $sponsor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:5120',
            'website' => 'nullable|url|max:255',
            'since_year' => 'nullable|integer|min:2000|max:' . date('Y'),
            'is_active' => 'boolean',
            'order' => 'required|integer|min:0',
            'translations' => 'required|array|min:1',
            'translations.*.lang' => 'required|in:mg,fr,en',
            'translations.*.short_description' => 'required|string|min:10|max:5000',
        ]);

        DB::beginTransaction();
        try {
            if ($request->hasFile('logo')) {
                if (Storage::disk('public')->exists($sponsor->logo)) {
                    Storage::disk('public')->delete($sponsor->logo);
                }
                $logoPath = $request->file('logo')->store('sponsors/logos', 'public');
                $sponsor->logo = $logoPath;
            }

            $sponsor->website = $request->website;
            $sponsor->since_year = $request->since_year;
            $sponsor->is_active = $request->has('is_active');
            $sponsor->order = $request->order;
            $sponsor->save();

            $sponsor->translations()->delete();
            foreach ($request->translations as $translation) {
                SponsorTranslation::create([
                    'sponsor_id' => $sponsor->id,
                    'lang' => $translation['lang'],
                    'short_description' => $translation['short_description'],
                ]);
            }

            DB::commit();

            return redirect()->route('admin.sponsors.index')
                ->with('success', 'Sponsor mis à jour avec succès !');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'Une erreur est survenue : ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function destroy(Sponsor $sponsor)
    {
        if (Storage::disk('public')->exists($sponsor->logo)) {
            Storage::disk('public')->delete($sponsor->logo);
        }

        $sponsor->delete();

        return redirect()->route('admin.sponsors.index')
            ->with('success', 'Sponsor supprimé avec succès !');
    }
}
