<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use App\Models\SponsorDetail;
use App\Models\SponsorDetailPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class SponsorDetailController extends Controller
{
    public function edit($sponsorId)
    {
        $sponsor = Sponsor::with(['details.photos'])->findOrFail($sponsorId);
        $languages = ['mg' => 'Malagasy', 'fr' => 'Français', 'en' => 'English'];

        return view('admin.sponsor-details.edit', compact('sponsor', 'languages'));
    }

    public function update(Request $request, $sponsorId)
    {
        $sponsor = Sponsor::findOrFail($sponsorId);

        $request->validate([
            // Longues descriptions multilingues
            'long_descriptions' => 'nullable|array',
            'long_descriptions.mg' => 'nullable|string|max:10000',
            'long_descriptions.fr' => 'nullable|string|max:10000',
            'long_descriptions.en' => 'nullable|string|max:10000',

            'is_published' => 'boolean',

            // Photos
            'photos' => 'nullable|array',
            'photos.*.photo' => 'nullable|image|mimes:png,jpg,jpeg|max:5120',
            'photos.*.caption' => 'nullable|string|max:255',
            'photos.*.order' => 'nullable|integer|min:0',
            'photos.*.existing_id' => 'nullable|exists:sponsor_detail_photos,id',
        ]);

        DB::beginTransaction();
        try {
            // Créer ou mettre à jour sponsor_details
            $detail = SponsorDetail::firstOrCreate(
                ['sponsor_id' => $sponsor->id],
                ['is_published' => false]
            );

            // Mettre à jour les descriptions multilingues
            if ($request->has('long_descriptions')) {
                $detail->long_description_mg = $request->long_descriptions['mg'] ?? null;
                $detail->long_description_fr = $request->long_descriptions['fr'] ?? null;
                $detail->long_description_en = $request->long_descriptions['en'] ?? null;
            }

            $detail->is_published = $request->has('is_published');
            $detail->save();

            // Gérer les photos (même logique qu'avant)
            if ($request->has('photos')) {
                // Supprimer les photos marquées pour suppression
                foreach ($request->photos as $photoData) {
                    if (isset($photoData['delete']) && $photoData['delete'] && isset($photoData['existing_id'])) {
                        $photo = SponsorDetailPhoto::find($photoData['existing_id']);
                        if ($photo && Storage::disk('public')->exists($photo->photo)) {
                            Storage::disk('public')->delete($photo->photo);
                        }
                        $photo?->delete();
                    }
                }

                // Upload nouvelles photos
                foreach ($request->photos as $index => $photoData) {
                    if (isset($photoData['photo']) && $photoData['photo'] instanceof \Illuminate\Http\UploadedFile) {
                        $photoPath = $photoData['photo']->store('sponsors/details', 'public');

                        SponsorDetailPhoto::create([
                            'sponsor_detail_id' => $detail->id,
                            'photo' => $photoPath,
                            'caption' => $photoData['caption'] ?? null,
                            'order' => $photoData['order'] ?? $index,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.sponsors.index')
                ->with('success', 'Détails du sponsor mis à jour avec succès !');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'Une erreur est survenue : ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function destroyPhoto($photoId)
    {
        $photo = SponsorDetailPhoto::findOrFail($photoId);

        if (Storage::disk('public')->exists($photo->photo)) {
            Storage::disk('public')->delete($photo->photo);
        }

        $photo->delete();

        return redirect()->back()
            ->with('success', 'Photo supprimée avec succès !');
    }
}
