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
                    <i class="fas fa-edit text-blue-600 mr-2"></i>
                    Modifier le Membre : {{ $staffMember->name }}
                </h1>
                <a href="{{ route('admin.staff-members.index') }}" class="text-gray-600 hover:text-blue-600 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Retour
                </a>
            </div>

            @if ($errors->any())
                <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.staff-members.update', $staffMember->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    <!-- COLONNE GAUCHE : Photo & Infos de base -->
                    <div class="lg:col-span-1">
                        <div class="bg-white shadow-lg rounded-xl p-6 sticky top-6">

                            <!-- Photo Actuelle -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-3">
                                    <i class="fas fa-image mr-2"></i>Photo du membre
                                </label>
                                @if ($staffMember->photo && Storage::disk('public')->exists($staffMember->photo))
                                    <div class="mb-4">
                                        <img src="{{ Storage::url($staffMember->photo) }}" alt="{{ $staffMember->name }}"
                                            class="w-32 h-32 object-cover rounded-full mx-auto border-4 border-gray-200 shadow-lg">
                                    </div>
                                @endif
                                <div class="border-2 border-dashed border-gray-300 rounded-xl p-4 text-center hover:border-blue-400 transition cursor-pointer"
                                    onclick="document.getElementById('photo').click()">
                                    <i class="fas fa-cloud-upload-alt text-2xl text-blue-600 mb-2"></i>
                                    <p class="text-sm text-gray-600">Changer la photo</p>
                                    <p class="text-xs text-gray-500 mt-1">PNG, JPG - Max 5MB</p>
                                    <input type="file" name="photo" id="photo" class="hidden" accept="image/*"
                                        onchange="previewPhoto(event)">
                                </div>
                                @error('photo')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nom -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-user mr-2"></i>Nom complet *
                                </label>
                                <input type="text" name="name" value="{{ old('name', $staffMember->name) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                    required>
                            </div>

                            <!-- Ordre -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-sort mr-2"></i>Ordre d'affichage *
                                </label>
                                <input type="number" name="order" value="{{ old('order', $staffMember->order) }}"
                                    min="0"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                    required>
                            </div>

                            <!-- Statut Actif -->
                            <div class="mb-6">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" name="is_active" value="1"
                                        {{ old('is_active', $staffMember->is_active) ? 'checked' : '' }}
                                        class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500">
                                    <span class="text-sm font-medium text-gray-700">
                                        <i class="fas fa-check-circle text-green-500 mr-1"></i>
                                        Membre actif
                                    </span>
                                </label>
                            </div>

                        </div>
                    </div>

                    <!-- COLONNE DROITE : Traductions & Contacts -->
                    <div class="lg:col-span-2 space-y-6">

                        <!-- TRADUCTIONS -->
                        <div class="bg-white shadow-lg rounded-xl p-6">
                            <h2 class="text-lg font-bold text-gray-800 mb-4">
                                <i class="fas fa-language mr-2 text-blue-600"></i>
                                Traductions (Rôle & Description)
                            </h2>

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
                                @php
                                    $translation = $staffMember->translations->where('lang', $code)->first();
                                @endphp
                                <div class="lang-content {{ $code !== 'fr' ? 'hidden' : '' }}"
                                    data-lang="{{ $code }}">
                                    <div class="grid grid-cols-1 gap-4">

                                        <!-- Rôle -->
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                <i class="fas fa-briefcase mr-2"></i>Rôle/Poste *
                                            </label>
                                            <input type="text" name="translations[{{ $code }}][lang]"
                                                value="{{ $code }}" class="hidden">
                                            <input type="text" name="translations[{{ $code }}][role]"
                                                value="{{ old('translations.' . $code . '.role', $translation->role ?? '') }}"
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                                {{ $code === 'fr' ? 'required' : '' }}>
                                        </div>

                                        <!-- Description -->
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                <i class="fas fa-align-left mr-2"></i>Description/Bio
                                            </label>
                                            <textarea name="translations[{{ $code }}][description]" rows="4"
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('translations.' . $code . '.description', $translation->description ?? '') }}</textarea>
                                        </div>

                                        @if ($code !== 'fr')
                                            <div class="text-right">
                                                <button type="button" onclick="copyFromFrench('{{ $code }}')"
                                                    class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                                    <i class="fas fa-copy mr-1"></i>
                                                    Copier depuis le français
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- CONTACTS -->
                        <div class="bg-white shadow-lg rounded-xl p-6">
                            <h2 class="text-lg font-bold text-gray-800 mb-4">
                                <i class="fas fa-address-book mr-2 text-blue-600"></i>
                                Contacts / Réseaux Sociaux
                            </h2>

                            <div id="contacts-container" class="space-y-4">
                                @foreach ($contactTypes as $type)
                                    @php
                                        $memberContact = $staffMember->allContacts
                                            ->where('contact_type_id', $type->id)
                                            ->first();
                                    @endphp
                                    <div
                                        class="contact-item border rounded-lg p-4 {{ $memberContact ? 'bg-blue-50 border-blue-300' : 'bg-gray-50' }}">
                                        <!-- Checkbox + Nom + Icône -->
                                        <div class="flex items-center gap-3 mb-3">
                                            <input type="checkbox" id="contact-toggle-{{ $type->id }}"
                                                onchange="toggleContact({{ $type->id }})"
                                                {{ $memberContact ? 'checked' : '' }}
                                                class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500">
                                            <i class="{{ $type->icon_class }} text-xl text-gray-600"></i>
                                            <label for="contact-toggle-{{ $type->id }}"
                                                class="font-medium text-gray-700 cursor-pointer">
                                                {{ $type->name }}
                                            </label>
                                        </div>

                                        <!-- Champs du contact -->
                                        <div id="contact-fields-{{ $type->id }}"
                                            class="{{ $memberContact ? '' : 'hidden' }}">
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                                <!-- Valeur du contact -->
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-600 mb-1">
                                                        Valeur *
                                                    </label>
                                                    <input type="text"
                                                        name="contacts[{{ $type->id }}][contact_type_id]"
                                                        value="{{ $type->id }}" class="hidden">
                                                    <input type="text"
                                                        name="contacts[{{ $type->id }}][contact_value]"
                                                        value="{{ old('contacts.' . $type->id . '.contact_value', $memberContact->contact_value ?? '') }}"
                                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                                        placeholder="{{ $type->placeholder }}">
                                                </div>

                                                <!-- URL personnalisée -->
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-600 mb-1">
                                                        URL personnalisée (optionnel)
                                                    </label>
                                                    <input type="url"
                                                        name="contacts[{{ $type->id }}][custom_url]"
                                                        value="{{ old('contacts.' . $type->id . '.custom_url', $memberContact->custom_url ?? '') }}"
                                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                                        placeholder="https://...">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- BOUTONS D'ACTION -->
                        <div class="flex gap-3 pt-6 border-t">
                            <button type="submit"
                                class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-blue-700 transition shadow-md">
                                <i class="fas fa-save mr-2"></i>Mettre à jour le membre
                            </button>
                            <a href="{{ route('admin.staff-members.index') }}"
                                class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                                Annuler
                            </a>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- JAVASCRIPT -->
    <script>
        // Aperçu photo
        function previewPhoto(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('photo-preview');
            const previewContainer = document.getElementById('photo-preview-container');
            const placeholder = document.getElementById('photo-placeholder');

            if (file && file.type.match('image.*')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        }

        // Changer d'onglet de langue
        function switchLangTab(lang) {
            document.querySelectorAll('.lang-content').forEach(el => {
                el.classList.add('hidden');
            });
            document.querySelectorAll('.lang-tab').forEach(el => {
                el.classList.remove('bg-blue-600', 'text-white');
                el.classList.add('bg-gray-100', 'text-gray-600');
            });

            document.querySelector(`.lang-content[data-lang="${lang}"]`).classList.remove('hidden');
            document.querySelector(`.lang-tab[data-lang="${lang}"]`).classList.remove('bg-gray-100', 'text-gray-600');
            document.querySelector(`.lang-tab[data-lang="${lang}"]`).classList.add('bg-blue-600', 'text-white');
        }

        // Copier depuis le français
        function copyFromFrench(lang) {
            const frRole = document.querySelector(`.lang-content[data-lang="fr"] input[name*="[role]"]`).value;
            const frDesc = document.querySelector(`.lang-content[data-lang="fr"] textarea[name*="[description]"]`).value;

            document.querySelector(`.lang-content[data-lang="${lang}"] input[name*="[role]"]`).value = frRole;
            document.querySelector(`.lang-content[data-lang="${lang}"] textarea[name*="[description]"]`).value = frDesc;

            alert('✅ Copié depuis le français !');
        }

        // Afficher/masquer les champs de contact
        function toggleContact(typeId) {
            const fields = document.getElementById(`contact-fields-${typeId}`);
            const checkbox = document.getElementById(`contact-toggle-${typeId}`);
            const item = fields.closest('.contact-item');

            if (checkbox.checked) {
                fields.classList.remove('hidden');
                item.classList.add('bg-blue-50', 'border-blue-300');
                item.classList.remove('bg-gray-50');
            } else {
                fields.classList.add('hidden');
                item.classList.remove('bg-blue-50', 'border-blue-300');
                item.classList.add('bg-gray-50');
            }
        }
    </script>
@endsection
