@extends('admin.layouts.master')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
    <section class="content_contents">
        <div class="container mx-auto px-4 py-6">

            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-file-alt text-blue-600 mr-2"></i>
                    Détails du Sponsor : {{ $sponsor->name }}
                </h1>
                <a href="{{ route('admin.sponsors.index') }}" class="text-gray-600 hover:text-blue-600 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Retour
                </a>
            </div>

            @if (session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.sponsors.details.update', $sponsor->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    <!-- COLONNE GAUCHE : Infos + Statut -->
                    <div class="lg:col-span-1">
                        <div class="bg-white shadow-lg rounded-xl p-6 sticky top-6">

                            <!-- Logo -->
                            <div class="mb-6 text-center">
                                @if ($sponsor->logo && Storage::disk('public')->exists($sponsor->logo))
                                    <img src="{{ Storage::url($sponsor->logo) }}" alt="{{ $sponsor->name }}"
                                        class="w-32 h-32 object-contain mx-auto border-4 border-gray-200 rounded-lg">
                                @endif
                                <h3 class="mt-4 text-lg font-bold text-gray-800">{{ $sponsor->name }}</h3>
                                @if ($sponsor->website)
                                    <a href="{{ $sponsor->website }}" target="_blank"
                                        class="text-blue-600 hover:underline text-sm">
                                        <i class="fas fa-external-link-alt mr-1"></i>{{ $sponsor->website }}
                                    </a>
                                @endif
                            </div>

                            <!-- Statut Publication -->
                            <div class="mb-6">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" name="is_published" value="1"
                                        {{ old('is_published', $sponsor->details?->is_published ?? false) ? 'checked' : '' }}
                                        class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500">
                                    <span class="text-sm font-medium text-gray-700">
                                        <i class="fas fa-eye text-green-500 mr-1"></i>
                                        Publié (visible sur le site)
                                    </span>
                                </label>
                                <p class="text-xs text-gray-500 mt-1">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    La page détails sera accessible uniquement si publié
                                </p>
                            </div>

                            <!-- Bouton Voir Page -->
                            @if ($sponsor->details?->is_published)
                                <a href="{{ route('sponsors.show', ['locale' => app()->getLocale(), 'slug' => $sponsor->slug]) }}"
                                    target="_blank"target="_blank"
                                    class="block text-center bg-blue-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-blue-700 transition">
                                    <i class="fas fa-external-link-alt mr-2"></i>
                                    Voir la page publique
                                </a>
                            @endif

                        </div>
                    </div>

                    <!-- COLONNE DROITE : Description Multilingue + Galerie -->
                    <div class="lg:col-span-2 space-y-6">

                        <!-- LONGUE DESCRIPTION MULTILINGUE -->
                        <div class="bg-white shadow-lg rounded-xl p-6">
                            <h2 class="text-lg font-bold text-gray-800 mb-4">
                                <i class="fas fa-align-left mr-2 text-blue-600"></i>
                                Histoire du Partenariat (Multilingue)
                            </h2>
                            <p class="text-sm text-gray-600 mb-4">
                                <i class="fas fa-info-circle mr-1"></i>
                                Racontez l'histoire de ce sponsor avec l'association dans chaque langue
                            </p>

                            <!-- Onglets de langues -->
                            <div class="flex gap-2 mb-6 border-b">
                                @foreach ($languages as $code => $name)
                                    <button type="button" onclick="switchLangTab('{{ $code }}')"
                                        class="lang-tab px-4 py-2 font-medium rounded-t-lg transition {{ $code === 'fr' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
                                        data-lang="{{ $code }}">
                                        @if ($code === 'mg')
                                            🇲🇬
                                        @elseif ($code === 'fr')
                                            🇫🇷
                                        @else
                                            🇬🇧
                                        @endif
                                        {{ $name }}
                                    </button>
                                @endforeach
                            </div>

                            <!-- Champs par langue -->
                            @foreach ($languages as $code => $name)
                                <div class="lang-content {{ $code !== 'fr' ? 'hidden' : '' }}"
                                    data-lang="{{ $code }}">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-book mr-2"></i>Description longue ({{ $name }})
                                        </label>
                                        <textarea name="long_descriptions[{{ $code }}]" rows="8"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                            placeholder="Ex: Depuis 2020, BAOBAB soutient nos programmes éducatifs à travers Madagascar...">{{ old('long_descriptions.' . $code, $sponsor->details?->{'long_description_' . $code} ?? '') }}</textarea>
                                        <p class="text-xs text-gray-500 mt-1">
                                            <i class="fas fa-info-circle mr-1"></i>
                                            Description affichée sur la page détails dans cette langue
                                        </p>
                                    </div>

                                    @if ($code !== 'fr')
                                        <div class="text-right mt-3">
                                            <button type="button" onclick="copyFromFrench('{{ $code }}')"
                                                class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                                <i class="fas fa-copy mr-1"></i>
                                                Copier depuis le français
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <!-- GALERIE PHOTOS -->
                        <div class="bg-white shadow-lg rounded-xl p-6">
                            <h2 class="text-lg font-bold text-gray-800 mb-4">
                                <i class="fas fa-images mr-2 text-blue-600"></i>
                                Galerie Photos (Max 5)
                            </h2>
                            <p class="text-sm text-gray-600 mb-4">
                                <i class="fas fa-info-circle mr-1"></i>
                                Ajoutez des photos des événements, rencontres, preuves du partenariat
                            </p>

                            <div id="photos-container" class="space-y-4">
                                @php
                                    $existingPhotos = $sponsor->details?->photos ?? [];
                                @endphp

                                @foreach ($existingPhotos as $index => $photo)
                                    <div class="photo-item border rounded-lg p-4 bg-gray-50">
                                        <div class="flex items-start gap-4">
                                            <img src="{{ Storage::url($photo->photo) }}" alt="Photo {{ $index + 1 }}"
                                                class="w-24 h-24 object-cover rounded-lg border-2 border-gray-200">
                                            <div class="flex-1">
                                                <input type="hidden" name="photos[{{ $index }}][existing_id]"
                                                    value="{{ $photo->id }}">
                                                <input type="text" name="photos[{{ $index }}][caption]"
                                                    value="{{ $photo->caption }}"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg mb-2"
                                                    placeholder="Légende de la photo">
                                                <input type="number" name="photos[{{ $index }}][order]"
                                                    value="{{ $photo->order }}"
                                                    class="w-20 px-3 py-2 border border-gray-300 rounded-lg"
                                                    placeholder="Ordre">
                                            </div>
                                            <div>
                                                <button type="button" onclick="removePhoto(this, {{ $photo->id }})"
                                                    class="text-red-600 hover:text-red-800">
                                                    <i class="fas fa-trash text-lg"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <!-- Nouvelles photos -->
                                @for ($i = count($existingPhotos); $i < 5; $i++)
                                    <div
                                        class="photo-item border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-blue-400 transition">
                                        <label class="cursor-pointer block">
                                            <i class="fas fa-cloud-upload-alt text-3xl text-blue-600 mb-2"></i>
                                            <p class="text-sm text-gray-600">Ajouter une photo</p>
                                            <input type="file" name="photos[{{ $i }}][photo]"
                                                class="hidden" accept="image/*"
                                                onchange="previewNewPhoto(event, {{ $i }})">
                                        </label>
                                        <div id="new-photo-preview-{{ $i }}" class="hidden mt-4">
                                            <img src="#" class="w-24 h-24 object-cover rounded-lg mx-auto">
                                            <input type="text" name="photos[{{ $i }}][caption]"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg mt-2"
                                                placeholder="Légende">
                                            <input type="number" name="photos[{{ $i }}][order]"
                                                value="{{ $i }}"
                                                class="w-20 px-3 py-2 border border-gray-300 rounded-lg mt-2"
                                                placeholder="Ordre">
                                        </div>
                                    </div>
                                @endfor
                            </div>

                            <p class="text-xs text-gray-500 mt-4">
                                <i class="fas fa-info-circle mr-1"></i>
                                Maximum 5 photos. PNG, JPG - Max 5MB chacune.
                            </p>
                        </div>

                        <!-- BOUTONS D'ACTION -->
                        <div class="flex gap-3 pt-6 border-t">
                            <button type="submit"
                                class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-blue-700 transition shadow-md">
                                <i class="fas fa-save mr-2"></i>Enregistrer les détails
                            </button>
                            <a href="{{ route('admin.sponsors.index') }}"
                                class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                                Annuler
                            </a>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </section>
    <script>
        // Aperçu nouvelle photo
        function previewNewPhoto(event, index) {
            const file = event.target.files[0];
            const preview = document.getElementById(`new-photo-preview-${index}`);

            if (file && file.type.match('image.*')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.querySelector('img').src = e.target.result;
                    preview.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        }

        // Supprimer une photo
        function removePhoto(button, photoId) {
            if (confirm('Supprimer cette photo ?')) {
                if (photoId) {
                    // Photo existante → redirection vers route de suppression
                    window.location.href = `{{ route('admin.sponsors.details.photo.destroy', '__ID__') }}`.replace(
                        '__ID__', photoId);
                } else {
                    button.closest('.photo-item').remove();
                }
            }
        }

        // Changer d'onglet de langue
        function switchLangTab(lang) {
            // Masquer tous les contenus
            document.querySelectorAll('.lang-content').forEach(el => {
                el.classList.add('hidden');
            });
            // Désactiver tous les onglets
            document.querySelectorAll('.lang-tab').forEach(el => {
                el.classList.remove('bg-blue-600', 'text-white');
                el.classList.add('bg-gray-100', 'text-gray-600');
            });

            // Activer l'onglet sélectionné
            document.querySelector(`.lang-content[data-lang="${lang}"]`).classList.remove('hidden');
            document.querySelector(`.lang-tab[data-lang="${lang}"]`).classList.remove('bg-gray-100', 'text-gray-600');
            document.querySelector(`.lang-tab[data-lang="${lang}"]`).classList.add('bg-blue-600', 'text-white');
        }

        // Copier depuis le français
        function copyFromFrench(lang) {
            const frDesc = document.querySelector(`.lang-content[data-lang="fr"] textarea[name*="[fr]"]`).value;
            document.querySelector(`.lang-content[data-lang="${lang}"] textarea[name*="[${lang}]"]`).value = frDesc;
            alert('✅ Copié depuis le français !');
        }
    </script>
@endsection
