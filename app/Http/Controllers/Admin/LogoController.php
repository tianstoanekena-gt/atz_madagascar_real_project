<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Logos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LogoController extends Controller
{
    // Liste tous les logos
    public function index()
    {
        $logos = Logos::latest()->paginate(10);
        // dd($logos);
        return view('admin.logos.index', compact('logos'));
    }


    public function create()
    {
        return view('admin.logos.create');
    }

    /**
     * Enregistre un nouveau logo
     */
    public function store(Request $request)
    {
        // 1. Validation
        $request->validate([
            'logo' => 'required|image|mimes:png,jpg,jpeg,svg|max:2048',
        ], [
            'logo.required' => 'Le logo est obligatoire.',
            'logo.image' => 'Le fichier doit être une image.',
            'logo.mimes' => 'Le logo doit être au format PNG, JPG, JPEG ou SVG.',
            'logo.max' => 'La taille du logo ne doit pas dépasser 2 MB.',
        ]);

        $path = $request->file('logo')->store('logos', 'public');

        $logo = Logos::create([
            'logo' => $path,
        ]);


        return redirect()->route('admin.logos.index')
            ->with('success', "Logo créé avec succès ! ID: {$logo->id}");
    }


    public function edit(Logos $logo)
    {
        return view('admin.logos.edit', compact('logo'));
    }

    public function update(Request $request, Logos $logo)
    {
        $request->validate([
            'logo' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
        ], [
            'logo.image' => 'Le fichier doit être une image.',
            'logo.mimes' => 'Le logo doit être au format PNG, JPG, JPEG ou SVG.',
            'logo.max' => 'La taille du logo ne doit pas dépasser 2 MB.',
        ]);

        //delete the last file
        if (Storage::disk('public')->exists($logo->logo)) {
            Storage::disk('public')->delete($logo->logo);
        }

        //store the new file
        $path = $request->file('logo')->store('logos', 'public');

        //update the database
        $logo->update([
            'logo' => $path,
        ]);

        return redirect()->route('admin.logos.index')
            ->with('success', "Logo mis à jour avec succès ! ID: {$logo->id}");
    }


    public function destroy(Logos $logo)
    {
        //delete the file
        if (Storage::disk('public')->exists($logo->logo)) {
            Storage::disk('public')->delete($logo->logo);
        }

        //delete the database record
        $logo->delete();

        return redirect()->route('admin.logos.index')
            ->with('success', "Logo supprimé avec succès ! ID: {$logo->id}");
    }
}
