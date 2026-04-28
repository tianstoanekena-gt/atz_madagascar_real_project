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
                    Modifier le Sponsor : {{ $sponsor->name }}
                </h1>
                <a href="{{ route('admin.sponsors.index') }}" class="text-gray-600 hover:text-blue-600 transition">
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

            <form action="{{ route('admin.sponsors.update', $sponsor->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    <!-- COLONNE GAUCHE : Logo & Infos -->
                    <div class="lg:col-span-1">
                        <div class="bg-white shadow-lg rounded-xl p-6 sticky top-6">

                            <!-- Logo Actuel -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-3">
                                    <i class="fas fa-image mr-2"></i>Logo du sponsor
                                </label>
                                @if ($sponsor->logo && Storage::disk('public')->exists($sponsor->logo))
                                    <div class="mb-4">
                                        <img src="{{ Storage::url($sponsor->logo) }}" alt="{{ $sponsor->name }}"
                                            class="w-32 h-32 object-contain mx-auto border-4 border-gray-200 shadow-lg rounded">
                                    </div>
                                @endif
                                <div class="border-2 border-dashed border-gray-300 rounded-xl p-4 text-center hover:border-blue-400 transition cursor-pointer"
                                    onclick="document.getElementById('logo').click()">
                                    <i class="fas fa-cloud-upload-alt text-2xl text-blue-600 mb-2"></i>
                                    <p class="text-sm text-gray-600">Changer le logo</p>
                                    <p class="text-xs text-gray-500 mt-1">PNG, JPG - Max 5MB</p>
                                    <input type="file" name="logo" id="logo" class="hidden" accept="image/*"
                                        onchange="previewLogo(event)">
                                </div>
                                @error('logo')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nom -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-tag mr-2"></i>Nom du sponsor *
                                </label>
                                <input type="text" name="name" value="{{ old('name', $sponsor->name) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                    placeholder="Ex: BAOBAB, Orange, Telma..." required>
                            </div>

                            <!-- Site Web -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-globe mr-2"></i>Site Web
                                </label>
                                <input type="url" name="website" value="{{ old('website', $sponsor->website) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                    placeholder="https://exemple.com">
                            </div>

                            <!-- Année de partenariat -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-calendar mr-2"></i>Depuis
                                </label>
                                <select name="since_year"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                    <option value="">-- Sélectionner l'année --</option>
                                    @foreach ($years as $year)
                                        <option value="{{ $year }}"
                                            {{ old('since_year', $sponsor->since_year) == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Ordre -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-sort mr-2"></i>Ordre d'affichage *
                                </label>
                                <input type="number" name="order" value="{{ old('order', $sponsor->order) }}"
                                    min="0"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                    required>
                            </div>

                            <!-- Statut Actif -->
                            <div class="mb-6">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" name="is_active" value="1"
                                        {{ old('is_active', $sponsor->is_active) ? 'checked' : '' }}
                                        class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500">
                                    <span class="text-sm font-medium text-gray-700">
                                        <i class="fas fa-check-circle text-green-500 mr-1"></i>
                                        Sponsor actif (affiché sur le site)
                                    </span>
                                </label>
                            </div>

                        </div>
                    </div>

                    <!-- COLONNE DROITE : Traductions -->
                    <div class="lg:col-span-2">

                        <!-- TRADUCTIONS -->
                        <div class="bg-white shadow-lg rounded-xl p-6">
                            <h2 class="text-lg font-bold text-gray-800 mb-4">
                                <i class="fas fa-language mr-2 text-blue-600"></i>
                                Descriptions (Multilingue)
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
                                    $translation = $sponsor->translations->where('lang', $code)->first();
                                @endphp
                                <div class="lang-content {{ $code !== 'fr' ? 'hidden' : '' }}"
                                    data-lang="{{ $code }}">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-align-left mr-2"></i>Description courte *
                                        </label>
                                        <input type="text" name="translations[{{ $code }}][lang]"
                                            value="{{ $code }}" class="hidden">
                                        <textarea name="translations[{{ $code }}][short_description]" rows="4"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                            placeholder="Ex: Partenaire stratégique depuis 20XX, soutient nos programmes..."
                                            {{ $code === 'fr' ? 'required' : '' }}>{{ old('translations.' . $code . '.short_description', $translation->short_description ?? '') }}</textarea>
                                        <p class="text-xs text-gray-500 mt-1">
                                            <i class="fas fa-info-circle mr-1"></i>Description affichée sur la carte sponsor
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

                        <!-- BOUTONS D'ACTION -->
                        <div class="flex gap-3 pt-6 border-t mt-6">
                            <button type="submit"
                                class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-blue-700 transition shadow-md">
                                <i class="fas fa-save mr-2"></i>Mettre à jour le sponsor
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
        function previewLogo(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('logo-preview');
            const previewContainer = document.getElementById('logo-preview-container');
            const placeholder = document.getElementById('logo-placeholder');

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

        function copyFromFrench(lang) {
            const frDesc = document.querySelector(`.lang-content[data-lang="fr"] textarea[name*="[short_description]"]`)
                .value;
            document.querySelector(`.lang-content[data-lang="${lang}"] textarea[name*="[short_description]"]`).value =
                frDesc;
            alert('✅ Copié depuis le français !');
        }
    </script>
@endsection
