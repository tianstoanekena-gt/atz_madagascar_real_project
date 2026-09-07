<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Godparent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GodparentController extends Controller
{
    public function index()
    {
        $godparents = Godparent::withCount('sponsorships')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.parrainage.godparents.index', compact('godparents'));
    }

    public function show(Godparent $godparent)
    {
        $godparent->load(['sponsorships.student', 'user']);

        return view('admin.parrainage.godparents.show', compact('godparent'));
    }

    public function edit(Godparent $godparent)
    {
        return view('admin.parrainage.godparents.edit', compact('godparent'));
    }

    public function update(Request $request, Godparent $godparent)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100', 'regex:/^[a-zA-ZÀ-ÿ\s\'\-]+$/u'],
            'last_name' => ['required', 'string', 'max:100', 'regex:/^[a-zA-ZÀ-ÿ\s\'\-]+$/u'],
            'email' => ['required', 'email:rfc,dns', 'max:255'],
            'whatsapp' => ['required', 'regex:/^\+?[0-9]{10,15}$/'],
            'address' => ['required', 'string', 'max:500'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ], [
            'first_name.regex' => 'Le prénom ne doit contenir que des lettres, espaces, apostrophes ou tirets.',
            'last_name.regex' => 'Le nom ne doit contenir que des lettres, espaces, apostrophes ou tirets.',
            'email.email' => 'Veuillez entrer une adresse email valide.',
            'whatsapp.regex' => 'Le numéro WhatsApp doit être au format international (ex: +261341234567).',
        ]);

        // Si nouvelle photo uploadée
        if ($request->hasFile('photo')) {
            if ($godparent->photo) {
                Storage::disk('public')->delete($godparent->photo);
            }
            $validated['photo'] = $request->file('photo')->store('godparents', 'public');
        }

        $godparent->update($validated);

        return redirect()->route('admin.godparents.index')
            ->with('success', 'Parrain mis à jour avec succès.');
    }

    public function destroy(Godparent $godparent)
    {
        // Vérifier s'il a des sponsorships
        if ($godparent->sponsorships()->exists()) {
            return redirect()->route('admin.godparents.index')
                ->with('error', 'Impossible de supprimer ce parrain : il a des parrainages actifs.');
        }

        if ($godparent->photo) {
            Storage::disk('public')->delete($godparent->photo);
        }

        $godparent->delete();

        return redirect()->route('admin.godparents.index')
            ->with('success', 'Parrain supprimé avec succès.');
    }
}
