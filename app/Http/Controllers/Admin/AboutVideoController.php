<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutVideo;
use Illuminate\Http\Request;

class AboutVideoController extends Controller
{
    public function index()
    {
        $videos = AboutVideo::latest()->paginate(10);
        return view('admin.about-videos.index', compact('videos'));
    }

    public function create()
    {
        $languages = ['mg' => 'Malagasy', 'fr' => 'Français', 'en' => 'English'];
        return view('admin.about-videos.create', compact('languages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lang' => 'required|in:mg,fr,en|unique:about_videos,lang',
            'video_url' => 'required|url',
        ], [
            'lang.required' => 'La langue est obligatoire.',
            'lang.in' => 'La langue doit être mg, fr ou en.',
            'lang.unique' => 'Une vidéo existe déjà pour cette langue.',
            'video_url.required' => 'L\'URL YouTube est obligatoire.',
            'video_url.url' => 'Veuillez entrer une URL valide.',
            'video_url.regex' => 'URL YouTube invalide. Ex: https://youtu.be/NGZ20jYANjg',
        ]);

        AboutVideo::create([
            'lang' => $request->lang,
            'video_url' => $request->video_url,
        ]);

        return redirect()->route('admin.about-videos.index')
            ->with('success', 'Vidéo ajoutée avec succès !');
    }

    public function edit(AboutVideo $aboutVideo)
    {
        $languages = ['mg' => 'Malagasy', 'fr' => 'Français', 'en' => 'English'];
        return view('admin.about-videos.edit', compact('aboutVideo', 'languages'));
    }

    public function update(Request $request, AboutVideo $aboutVideo)
    {
        $request->validate([
            'lang' => 'required|in:mg,fr,en|unique:about_videos,lang,' . $aboutVideo->id,
            'video_url' => 'required|url|regex:/^(https?\:\/\/)?(www\.youtube\.com|youtu\.?be)\/.+$/',
        ], [
            'lang.required' => 'La langue est obligatoire.',
            'lang.in' => 'La langue doit être mg, fr ou en.',
            'lang.unique' => 'Une vidéo existe déjà pour cette langue.',
            'video_url.required' => 'L\'URL YouTube est obligatoire.',
            'video_url.url' => 'Veuillez entrer une URL valide.',
            'video_url.regex' => 'URL YouTube invalide.',
        ]);

        $aboutVideo->update([
            'lang' => $request->lang,
            'video_url' => $request->video_url,
        ]);

        return redirect()->route('admin.about-videos.index')
            ->with('success', 'Vidéo mise à jour avec succès !');
    }

    public function destroy(AboutVideo $aboutVideo)
    {
        $aboutVideo->delete();

        return redirect()->route('admin.about-videos.index')
            ->with('success', 'Vidéo supprimée avec succès !');
    }
}
