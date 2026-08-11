<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSocialMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContactSocialMediaController extends Controller
{
    public function index()
    {
        $socialMedias = ContactSocialMedia::orderBy('order')->get();
        return view('admin.contact.social-media.index', compact('socialMedias'));
    }

    public function create()
    {
        return view('admin.contact.social-media.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'icon' => 'required|image|mimes:jpeg,png,jpg,svg,webp|max:512',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $iconPath = $request->file('icon')->store('contact/icons', 'public');

        ContactSocialMedia::create([
            'name' => $request->name,
            'url' => $request->url,
            'icon' => $iconPath,
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.contact.social-media.index')->with('success', 'Réseau social ajouté avec succès !');
    }

    public function edit(ContactSocialMedia $socialMedia)
    {
        return view('admin.contact.social-media.edit', compact('socialMedia'));
    }

    public function update(Request $request, ContactSocialMedia $socialMedia)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:512',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $updateData = [
            'name' => $request->name,
            'url' => $request->url,
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('icon')) {
            if ($socialMedia->icon) {
                Storage::disk('public')->delete($socialMedia->icon);
            }
            $updateData['icon'] = $request->file('icon')->store('contact/icons', 'public');
        }

        $socialMedia->update($updateData);

        return redirect()->route('admin.contact.social-media.index')->with('success', 'Réseau social mis à jour !');
    }

    public function destroy(ContactSocialMedia $socialMedia)
    {
        if ($socialMedia->icon) {
            Storage::disk('public')->delete($socialMedia->icon);
        }

        $socialMedia->delete();

        return redirect()->route('admin.contact.social-media.index')->with('success', 'Réseau social supprimé !');
    }
}
