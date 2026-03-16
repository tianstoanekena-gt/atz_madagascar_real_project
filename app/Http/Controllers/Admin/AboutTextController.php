<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutText;
use Illuminate\Http\Request;

class AboutTextController extends Controller
{
    public function index()
    {
        $texts = AboutText::latest()->paginate(10);
        return view('admin.about-texts.index', compact('texts'));
    }

    public function create()
    {
        $languages = ['mg' => 'Malagasy', 'fr' => 'Français', 'en' => 'English'];
        return view('admin.about-texts.create', compact('languages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lang' => 'required|in:mg,fr,en|unique:about_texts,lang',
            'content' => 'required|string|min:10|max:10000',
        ], [
            'lang.required' => 'La langue est obligatoire.',
            'lang.in' => 'La langue doit être mg, fr ou en.',
            'lang.unique' => 'Un texte existe déjà pour cette langue.',
            'content.required' => 'Le contenu est obligatoire.',
            'content.min' => 'Le contenu doit contenir au moins 10 caractères.',
            'content.max' => 'Le contenu ne doit pas dépasser 10000 caractères.',
        ]);

        AboutText::create([
            'lang' => $request->lang,
            'content' => $request->content,
        ]);

        return redirect()->route('admin.about-texts.index')
            ->with('success', 'Texte ajouté avec succès !');
    }

    public function edit(AboutText $aboutText)
    {
        $languages = ['mg' => 'Malagasy', 'fr' => 'Français', 'en' => 'English'];
        return view('admin.about-texts.edit', compact('aboutText', 'languages'));
    }

    public function update(Request $request, AboutText $aboutText)
    {
        $request->validate([
            'lang' => 'required|in:mg,fr,en|unique:about_texts,lang,' . $aboutText->id,
            'content' => 'required|string|min:10|max:10000',
        ], [
            'lang.required' => 'La langue est obligatoire.',
            'lang.in' => 'La langue doit être mg, fr ou en.',
            'lang.unique' => 'Un texte existe déjà pour cette langue.',
            'content.required' => 'Le contenu est obligatoire.',
            'content.min' => 'Le contenu doit contenir au moins 10 caractères.',
            'content.max' => 'Le contenu ne doit pas dépasser 10000 caractères.',
        ]);

        $aboutText->update([
            'lang' => $request->lang,
            'content' => $request->content,
        ]);

        return redirect()->route('admin.about-texts.index')
            ->with('success', 'Texte mis à jour avec succès !');
    }

    public function destroy(AboutText $aboutText)
    {
        $aboutText->delete();

        return redirect()->route('admin.about-texts.index')
            ->with('success', 'Texte supprimé avec succès !');
    }
}
