<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Volunteer;
use App\Models\VolunteerTranslation;
use App\Models\ContactType;
use App\Models\VolunteerContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class VolunteerController extends Controller
{
    public function index()
    {
        $volunteers = Volunteer::with(['translations', 'allContacts.contactType'])
            ->ordered()
            ->paginate(12);
        return view('admin.volunteers.index', compact('volunteers'));
    }

    public function create()
    {
        $languages = ['mg' => 'Malagasy', 'fr' => 'Français', 'en' => 'English'];
        $contactTypes = ContactType::active()->ordered()->get();
        $currentYear = date('Y');
        $years = range($currentYear - 10, $currentYear);
        return view('admin.volunteers.create', compact('languages', 'contactTypes', 'years'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'required|image|mimes:png,jpg,jpeg|max:5120',
            'order' => 'required|integer|min:0',
            'volunteer_since' => 'required|integer|min:2000|max:' . date('Y'),
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
            $photoPath = $request->file('photo')->store('volunteers', 'public');

            $volunteer = Volunteer::create([
                'name' => $request->name,
                'photo' => $photoPath,
                'order' => $request->order,
                'volunteer_since' => $request->volunteer_since,
                'is_active' => $request->has('is_active'),
            ]);

            foreach ($request->translations as $translation) {
                VolunteerTranslation::create([
                    'volunteer_id' => $volunteer->id,
                    'lang' => $translation['lang'],
                    'role' => $translation['role'],
                    'description' => $translation['description'] ?? null,
                ]);
            }

            if ($request->has('contacts')) {
                foreach ($request->contacts as $index => $contact) {
                    if (!empty($contact['contact_value'])) {
                        VolunteerContact::create([
                            'volunteer_id' => $volunteer->id,
                            'contact_type_id' => $contact['contact_type_id'],
                            'contact_value' => $contact['contact_value'],
                            'custom_url' => $contact['custom_url'] ?? null,
                            'order' => $index,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.volunteers.index')
                ->with('success', 'Bénévole ajouté avec succès !');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'Une erreur est survenue : ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function edit(Volunteer $volunteer)
    {
        $languages = ['mg' => 'Malagasy', 'fr' => 'Français', 'en' => 'English'];
        $contactTypes = ContactType::active()->ordered()->get();
        $currentYear = date('Y');
        $years = range($currentYear - 10, $currentYear);
        $volunteer->load(['translations', 'allContacts']);
        return view('admin.volunteers.edit', compact('volunteer', 'languages', 'contactTypes', 'years'));
    }

    public function update(Request $request, Volunteer $volunteer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:png,jpg,jpeg|max:5120',
            'order' => 'required|integer|min:0',
            'volunteer_since' => 'required|integer|min:2000|max:' . date('Y'),
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
            if ($request->hasFile('photo')) {
                if (Storage::disk('public')->exists($volunteer->photo)) {
                    Storage::disk('public')->delete($volunteer->photo);
                }
                $photoPath = $request->file('photo')->store('volunteers', 'public');
                $volunteer->photo = $photoPath;
            }

            $volunteer->order = $request->order;
            $volunteer->volunteer_since = $request->volunteer_since;
            $volunteer->is_active = $request->has('is_active');
            $volunteer->save();

            $volunteer->translations()->delete();
            foreach ($request->translations as $translation) {
                VolunteerTranslation::create([
                    'volunteer_id' => $volunteer->id,
                    'lang' => $translation['lang'],
                    'role' => $translation['role'],
                    'description' => $translation['description'] ?? null,
                ]);
            }

            $volunteer->allContacts()->delete();
            if ($request->has('contacts')) {
                foreach ($request->contacts as $index => $contact) {
                    if (!empty($contact['contact_value'])) {
                        VolunteerContact::create([
                            'volunteer_id' => $volunteer->id,
                            'contact_type_id' => $contact['contact_type_id'],
                            'contact_value' => $contact['contact_value'],
                            'custom_url' => $contact['custom_url'] ?? null,
                            'order' => $index,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.volunteers.index')
                ->with('success', 'Bénévole mis à jour avec succès !');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'Une erreur est survenue : ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function destroy(Volunteer $volunteer)
    {
        if (Storage::disk('public')->exists($volunteer->photo)) {
            Storage::disk('public')->delete($volunteer->photo);
        }

        $volunteer->delete();

        return redirect()->route('admin.volunteers.index')
            ->with('success', 'Bénévole supprimé avec succès !');
    }
}
