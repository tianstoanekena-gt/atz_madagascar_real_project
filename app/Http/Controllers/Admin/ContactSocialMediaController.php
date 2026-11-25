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
            'url' => [
                'required',
                'string',
                'max:255',
                'regex:/^(https?:\/\/[^\s]+|mailto:[^\s@]+@[^\s@]+\.[^\s@]+|tel:\+?[0-9\s\-]+)$/i',
            ],
            'icon' => 'required|image|mimes:jpeg,png,jpg,svg,webp|max:2050',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ], [
            'url.regex' => 'Le lien doit être une URL valide (https://...), un email (mailto:...) ou un numéro (tel:...).',
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
            'url' => [
                'required',
                'string',
                'max:255',
                'regex:/^(https?:\/\/[^\s]+|mailto:[^\s@]+@[^\s@]+\.[^\s@]+|tel:\+?[0-9\s\-]+)$/i',
            ],
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:5120',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ], [
            'url.regex' => 'Le lien doit être une URL valide (https://...), un email (mailto:...) ou un numéro (tel:...).',
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
