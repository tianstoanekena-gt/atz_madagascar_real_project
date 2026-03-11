<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSlideController extends Controller
{
    public function index()
    {
        $slides = HeroSlide::orderBy('order')->get();
        return view('admin.hero-slides.index', compact('slides'));
    }

    public function create()
    {
        return view('admin.hero-slides.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean'
        ]);

        // Stockage direct dans le dossier 'hero' sur le disk 'public'
        $imagePath = $request->file('image')->store('hero', 'public');

        HeroSlide::create([
            'image_path' => $imagePath,
            'order' => $request->order,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.hero-slides.index')
            ->with('success', 'Slide créé avec succès.');
    }

    public function edit(HeroSlide $heroSlide)
    {
        return view('admin.hero-slides.edit', compact('heroSlide'));
    }

    public function update(Request $request, HeroSlide $heroSlide)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean'
        ]);

        // Si nouvelle image, supprimer l'ancienne et uploader la nouvelle
        if ($request->hasFile('image')) {
            if (Storage::disk('public')->exists($heroSlide->image_path)) {
                Storage::disk('public')->delete($heroSlide->image_path);
            }

            $imagePath = $request->file('image')->store('hero', 'public');

            $heroSlide->update([
                'image_path' => $imagePath,
                'order' => $request->order,
                'is_active' => $request->has('is_active'),
            ]);
        } else {
            // Mise à jour sans changer l'image
            $heroSlide->update([
                'order' => $request->order,
                'is_active' => $request->has('is_active'),
            ]);
        }

        return redirect()->route('admin.hero-slides.index')
            ->with('success', 'Slide mis à jour avec succès.');
    }

    public function destroy(HeroSlide $heroSlide)
    {
        // Supprimer le fichier du storage
        if (Storage::disk('public')->exists($heroSlide->image_path)) {
            Storage::disk('public')->delete($heroSlide->image_path);
        }

        // Supprimer l'entrée en base
        $heroSlide->delete();

        return redirect()->route('admin.hero-slides.index')
            ->with('success', 'Slide supprimé avec succès.');
    }
}
