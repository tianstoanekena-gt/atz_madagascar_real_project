<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactType;
use Illuminate\Http\Request;

class ContactTypeController extends Controller
{
    /**
     * Afficher la liste des types de contacts
     */
    public function index()
    {
        $contactTypes = ContactType::ordered()->paginate(10);
        return view('admin.contact-types.index', compact('contactTypes'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        return view('admin.contact-types.create');
    }

    /**
     * Enregistrer un nouveau type de contact
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:contact_types,name',
            'icon_class' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:contact_types,slug',
            'placeholder' => 'required|string|max:255',
            'validation_regex' => 'nullable|string|max:255',
            'url_template' => 'required|string|max:255',
            'is_active' => 'boolean',
            'order' => 'required|integer|min:0',
        ], [
            'name.required' => 'Le nom est obligatoire.',
            'name.unique' => 'Ce nom existe déjà.',
            'icon_class.required' => 'La classe d\'icône est obligatoire.',
            'slug.required' => 'Le slug est obligatoire.',
            'slug.unique' => 'Ce slug existe déjà.',
            'placeholder.required' => 'Le placeholder est obligatoire.',
            'url_template.required' => 'Le template d\'URL est obligatoire.',
            'order.required' => 'L\'ordre est obligatoire.',
        ]);

        ContactType::create([
            'name' => $request->name,
            'icon_class' => $request->icon_class,
            'slug' => $request->slug,
            'placeholder' => $request->placeholder,
            'validation_regex' => $request->validation_regex,
            'url_template' => $request->url_template,
            'is_active' => $request->has('is_active'),
            'order' => $request->order,
        ]);

        return redirect()->route('admin.contact-types.index')
            ->with('success', 'Type de contact ajouté avec succès !');
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(ContactType $contactType)
    {
        return view('admin.contact-types.edit', compact('contactType'));
    }

    /**
     * Mettre à jour un type de contact
     */
    public function update(Request $request, ContactType $contactType)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:contact_types,name,' . $contactType->id,
            'icon_class' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:contact_types,slug,' . $contactType->id,
            'placeholder' => 'required|string|max:255',
            'validation_regex' => 'nullable|string|max:255',
            'url_template' => 'required|string|max:255',
            'is_active' => 'boolean',
            'order' => 'required|integer|min:0',
        ]);

        $contactType->update([
            'name' => $request->name,
            'icon_class' => $request->icon_class,
            'slug' => $request->slug,
            'placeholder' => $request->placeholder,
            'validation_regex' => $request->validation_regex,
            'url_template' => $request->url_template,
            'is_active' => $request->has('is_active'),
            'order' => $request->order,
        ]);

        return redirect()->route('admin.contact-types.index')
            ->with('success', 'Type de contact mis à jour avec succès !');
    }

    /**
     * Supprimer un type de contact
     */
    public function destroy(ContactType $contactType)
    {
        $contactType->delete();

        return redirect()->route('admin.contact-types.index')
            ->with('success', 'Type de contact supprimé avec succès !');
    }
}
