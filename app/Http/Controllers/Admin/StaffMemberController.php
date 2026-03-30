<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaffMember;
use App\Models\StaffMemberTranslation;
use App\Models\ContactType;
use App\Models\StaffMemberContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class StaffMemberController extends Controller
{
    /**
     * Afficher la liste des membres
     */
    public function index()
    {
        $members = StaffMember::with(['translations', 'allContacts.contactType'])
            ->ordered()
            ->paginate(10);
        return view('admin.staff-members.index', compact('members'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        $languages = ['mg' => 'Malagasy', 'fr' => 'Français', 'en' => 'English'];
        $contactTypes = ContactType::active()->ordered()->get();
        // dd($contactTypes);
        return view('admin.staff-members.create', compact('languages', 'contactTypes'));
    }

    /**
     * Enregistrer un nouveau membre
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'required|image|mimes:png,jpg,jpeg|max:5120',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'translations' => 'required|array|min:1',
            'translations.*.lang' => 'required|in:mg,fr,en',
            'translations.*.role' => 'required|string|max:255',
            'translations.*.description' => 'nullable|string|max:5000',
            'contacts' => 'nullable|array',
            'contacts.*.contact_type_id' => 'required|exists:contact_types,id',
            'contacts.*.contact_value' => 'required|string|max:255',
            'contacts.*.custom_url' => 'nullable|url|max:500',
        ], [
            'name.required' => 'Le nom est obligatoire.',
            'photo.required' => 'La photo est obligatoire.',
            'photo.image' => 'Le fichier doit être une image.',
            'photo.mimes' => 'La photo doit être au format PNG, JPG ou JPEG.',
            'photo.max' => 'La photo ne doit pas dépasser 5 MB.',
            'translations.required' => 'Au moins une traduction est obligatoire.',
            'translations.*.role.required' => 'Le rôle est obligatoire.',
            'contacts.*.contact_value.required' => 'La valeur du contact est obligatoire.',
        ]);

        DB::beginTransaction();
        try {
            // Upload photo
            $photoPath = $request->file('photo')->store('staff-members', 'public');

            // Créer le membre
            $member = StaffMember::create([
                'name' => $request->name,
                'photo' => $photoPath,
                'order' => $request->order,
                'is_active' => $request->has('is_active'),
            ]);

            // Créer les traductions
            foreach ($request->translations as $translation) {
                StaffMemberTranslation::create([
                    'member_id' => $member->id,
                    'lang' => $translation['lang'],
                    'role' => $translation['role'],
                    'description' => $translation['description'] ?? null,
                ]);
            }

            // Créer les contacts
            if ($request->has('contacts')) {
                foreach ($request->contacts as $index => $contact) {
                    if (!empty($contact['contact_value'])) {
                        StaffMemberContact::create([
                            'member_id' => $member->id,
                            'contact_type_id' => $contact['contact_type_id'],
                            'contact_value' => $contact['contact_value'],
                            'custom_url' => $contact['custom_url'] ?? null,
                            'order' => $index,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.staff-members.index')
                ->with('success', 'Membre ajouté avec succès !');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'Une erreur est survenue : ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(StaffMember $staffMember)
    {
        $languages = ['mg' => 'Malagasy', 'fr' => 'Français', 'en' => 'English'];
        $contactTypes = ContactType::active()->ordered()->get();
        $staffMember->load(['translations', 'allContacts']);
        return view('admin.staff-members.edit', compact('staffMember', 'languages', 'contactTypes'));
    }

    /**
     * Mettre à jour un membre
     */
    public function update(Request $request, StaffMember $staffMember)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:png,jpg,jpeg|max:5120',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'translations' => 'required|array|min:1',
            'translations.*.lang' => 'required|in:mg,fr,en',
            'translations.*.role' => 'required|string|max:255',
            'translations.*.description' => 'nullable|string|max:5000',
            'contacts' => 'nullable|array',
            'contacts.*.contact_type_id' => 'required|exists:contact_types,id',
            'contacts.*.contact_value' => 'required|string|max:255',
            'contacts.*.custom_url' => 'nullable|url|max:500',
        ]);

        DB::beginTransaction();
        try {
            // Upload nouvelle photo si fournie
            if ($request->hasFile('photo')) {
                if (Storage::disk('public')->exists($staffMember->photo)) {
                    Storage::disk('public')->delete($staffMember->photo);
                }
                $photoPath = $request->file('photo')->store('staff-members', 'public');
                $staffMember->photo = $photoPath;
            }

            $staffMember->order = $request->order;
            $staffMember->is_active = $request->has('is_active');
            $staffMember->save();

            // Supprimer anciennes traductions
            $staffMember->translations()->delete();

            // Créer nouvelles traductions
            foreach ($request->translations as $translation) {
                StaffMemberTranslation::create([
                    'member_id' => $staffMember->id,
                    'lang' => $translation['lang'],
                    'role' => $translation['role'],
                    'description' => $translation['description'] ?? null,
                ]);
            }

            // Supprimer anciens contacts
            $staffMember->allContacts()->delete();

            // Créer nouveaux contacts
            if ($request->has('contacts')) {
                foreach ($request->contacts as $index => $contact) {
                    if (!empty($contact['contact_value'])) {
                        StaffMemberContact::create([
                            'member_id' => $staffMember->id,
                            'contact_type_id' => $contact['contact_type_id'],
                            'contact_value' => $contact['contact_value'],
                            'custom_url' => $contact['custom_url'] ?? null,
                            'order' => $index,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.staff-members.index')
                ->with('success', 'Membre mis à jour avec succès !');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'Une erreur est survenue : ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Supprimer un membre
     */
    public function destroy(StaffMember $staffMember)
    {
        if (Storage::disk('public')->exists($staffMember->photo)) {
            Storage::disk('public')->delete($staffMember->photo);
        }

        $staffMember->delete();

        return redirect()->route('admin.staff-members.index')
            ->with('success', 'Membre supprimé avec succès !');
    }
}
