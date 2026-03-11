<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        // Récupérer le logo ou utiliser une valeur par défaut
        $logoPath = Setting::getValue('logo_path', 'public');

        $settings = [
            'logo_path' => $logoPath
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Sauvegarder le logo
        if ($request->hasFile('logo')) {
            // Supprimer l'ancien logo si existant
            $oldLogoPath = Setting::getValue('logo_path');
            if ($oldLogoPath && $oldLogoPath !== 'assets/images/logo.png') {
                if (str_starts_with($oldLogoPath, 'storage/')) {
                    Storage::delete(str_replace('storage/', 'public/', $oldLogoPath));
                }
            }

            $logoPath = $request->file('logo')->store('public/settings');
            Setting::setValue('logo_path', 'storage/' . str_replace('public/', '', $logoPath));
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Logo mis à jour avec succès.');
    }
}
