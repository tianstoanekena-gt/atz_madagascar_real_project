<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutCardController extends Controller
{
    public function index()
    {
        $cards = AboutCard::latest()->paginate(10);
        return view('admin.about-cards.index', compact('cards'));
    }

    public function create()
    {
        $languages = ['mg' => 'Malagasy', 'fr' => 'Français', 'en' => 'English'];
        return view('admin.about-cards.create', compact('languages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lang' => 'required|in:mg,fr,en',
            'card_icon' => 'required|image|mimes:png|max:2048',
            'card_title' => 'required|string|max:255',
            'card_description' => 'required|string|min:10|max:5000',
        ], [
            'lang.required' => 'La langue est obligatoire.',
            'lang.in' => 'La langue doit être mg, fr ou en.',
            'card_icon.required' => 'L\'icône est obligatoire.',
            'card_icon.image' => 'Le fichier doit être une image.',
            'card_icon.mimes' => 'L\'icône doit être au format PNG.',
            'card_icon.max' => 'L\'icône ne doit pas dépasser 2 MB.',
            'card_title.required' => 'Le titre est obligatoire.',
            'card_description.required' => 'La description est obligatoire.',
            'card_description.min' => 'La description doit contenir au moins 10 caractères.',
        ]);

        $iconPath = $request->file('card_icon')->store('about-cards/icons', 'public');

        AboutCard::create([
            'lang' => $request->lang,
            'card_icon' => $iconPath,
            'card_title' => $request->card_title,
            'card_description' => $request->card_description,
        ]);

        return redirect()->route('admin.about-cards.index')
            ->with('success', 'Carte ajoutée avec succès !');
    }

    public function edit(AboutCard $aboutCard)
    {
        $languages = ['mg' => 'Malagasy', 'fr' => 'Français', 'en' => 'English'];
        return view('admin.about-cards.edit', compact('aboutCard', 'languages'));
    }

    public function update(Request $request, AboutCard $aboutCard)
    {
        $request->validate([
            'lang' => 'required|in:mg,fr,en',
            'card_icon' => 'nullable|image|mimes:png|max:2048',
            'card_title' => 'required|string|max:255',
            'card_description' => 'required|string|min:10|max:5000',
        ], [
            'lang.required' => 'La langue est obligatoire.',
            'card_icon.image' => 'Le fichier doit être une image.',
            'card_icon.mimes' => 'L\'icône doit être au format PNG.',
            'card_title.required' => 'Le titre est obligatoire.',
            'card_description.required' => 'La description est obligatoire.',
        ]);

        if ($request->hasFile('card_icon')) {
            if (Storage::disk('public')->exists($aboutCard->card_icon)) {
                Storage::disk('public')->delete($aboutCard->card_icon);
            }
            $iconPath = $request->file('card_icon')->store('about-cards/icons', 'public');
        } else {
            $iconPath = $aboutCard->card_icon;
        }

        $aboutCard->update([
            'lang' => $request->lang,
            'card_icon' => $iconPath,
            'card_title' => $request->card_title,
            'card_description' => $request->card_description,
        ]);

        return redirect()->route('admin.about-cards.index')
            ->with('success', 'Carte mise à jour avec succès !');
    }

    public function destroy(AboutCard $aboutCard)
    {
        if (Storage::disk('public')->exists($aboutCard->card_icon)) {
            Storage::disk('public')->delete($aboutCard->card_icon);
        }

        $aboutCard->delete();

        return redirect()->route('admin.about-cards.index')
            ->with('success', 'Carte supprimée avec succès !');
    }
}
