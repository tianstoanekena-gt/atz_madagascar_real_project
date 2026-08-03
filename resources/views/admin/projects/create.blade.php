@extends('admin.layouts.master')
@section('title', 'Ajouter un projet')

@section('content')
    <section class="content_contents">
        <div class="container mx-auto px-4 py-6">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <i class="fas fa-plus-circle text-3xl text-blue-600"></i>
                    <h1 class="text-2xl font-bold text-gray-800">Ajouter un projet</h1>
                </div>
                <a href="{{ route('admin.projects.index') }}" class="text-gray-600 hover:text-blue-600 transition"><i
                        class="fas fa-arrow-left mr-2"></i>Retour</a>
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

            <form id="project-form" action="{{ route('admin.projects.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    {{-- Colonne Gauche : Paramètres & Image --}}
                    <div class="lg:col-span-1 space-y-6">
                        <div class="bg-white shadow-lg rounded-xl p-6 sticky top-6">

                            {{-- Catégorie --}}
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2"><i
                                        class="fas fa-tag mr-2"></i>Catégorie *</label>
                                <select name="category_id" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                    <option value="">-- Sélectionner --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ ucfirst($category->slug) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Statut --}}
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2"><i
                                        class="fas fa-tasks mr-2"></i>Statut *</label>
                                <select name="status" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                    <option value="ongoing" {{ old('status') == 'ongoing' ? 'selected' : '' }}>En cours
                                    </option>
                                    <option value="upcoming" {{ old('status') == 'upcoming' ? 'selected' : '' }}>À venir
                                    </option>
                                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Réalisé
                                    </option>
                                </select>
                            </div>

                            {{-- Image Hero --}}
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2"><i
                                        class="fas fa-image mr-2"></i>Image Hero</label>
                                <div id="hero-preview-container" class="mb-3 hidden">
                                    <img id="hero-preview" class="w-full h-32 object-cover rounded-lg border shadow-sm">
                                </div>
                                <input type="file" id="hero-input" name="hero_image" accept="image/*"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 bg-gray-50 cursor-pointer">
                                <p class="text-xs text-gray-500 mt-1">Max 2Mo. JPG, PNG, WEBP.</p>
                            </div>

                            {{-- Lieu & Ville --}}
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2"><i
                                        class="fas fa-map-marker-alt mr-2"></i>Lieu</label>
                                <input type="text" name="location" value="{{ old('location') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                    placeholder="Ex: FJKM Andranovelona">
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2"><i
                                        class="fas fa-city mr-2"></i>Ville</label>
                                <input type="text" name="city" value="{{ old('city') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                    placeholder="Ex: Antananarivo">
                            </div>

                            {{-- Finances --}}
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2"><i
                                        class="fas fa-bullseye mr-2"></i>Objectif (Ar)</label>
                                <input type="number" name="target_amount" value="{{ old('target_amount') }}"
                                    min="0" step="0.01"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                    placeholder="5000000">
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2"><i
                                        class="fas fa-hand-holding-usd mr-2"></i>Déjà réuni (Ar)</label>
                                <input type="number" name="current_amount" value="{{ old('current_amount', 0) }}"
                                    min="0" step="0.01"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            </div>

                            {{-- Bénéficiaires --}}
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2"><i
                                        class="fas fa-users mr-2"></i>Bénéficiaires</label>
                                <input type="number" name="beneficiaries_count" value="{{ old('beneficiaries_count') }}"
                                    min="0"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                    placeholder="150">
                            </div>

                            {{-- Dates --}}
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2"><i
                                        class="fas fa-calendar-alt mr-2"></i>Date de début</label>
                                <input type="date" name="start_date" value="{{ old('start_date') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2"><i
                                        class="fas fa-calendar-check mr-2"></i>Date de fin</label>
                                <input type="date" name="end_date" value="{{ old('end_date') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            </div>

                            {{-- Featured & Ordre --}}
                            <div class="mb-6">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" name="is_featured" value="1"
                                        {{ old('is_featured') ? 'checked' : '' }}
                                        class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500">
                                    <span class="text-sm font-medium text-gray-700"><i
                                            class="fas fa-star text-yellow-500 mr-1"></i>Mettre en vedette</span>
                                </label>
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2"><i
                                        class="fas fa-sort mr-2"></i>Ordre</label>
                                <input type="number" name="order" value="{{ old('order', 0) }}" min="0"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>

                    {{-- Colonne Droite : Traductions --}}
                    <div class="lg:col-span-2 space-y-6">
                        @foreach (['fr' => '🇫🇷 Français', 'mg' => '🇲🇬 Malagasy', 'en' => '🇬🇧 English'] as $locale => $label)
                            <div class="bg-white shadow-lg rounded-xl p-6">
                                <h2 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2"><i
                                        class="fas fa-language mr-2 text-blue-600"></i>{{ $label }} @if ($locale == 'fr')
                                        <span class="text-red-500 text-sm">*</span>
                                    @endif
                                </h2>

                                <div class="mb-4">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Titre *</label>
                                    <input type="text" name="title_{{ $locale }}"
                                        value="{{ old("title_{$locale}") }}" {{ $locale == 'fr' ? 'required' : '' }}
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Description courte
                                        (résumé)
                                    </label>
                                    <textarea name="short_description_{{ $locale }}" rows="2"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                        placeholder="2-3 phrases pour les cartes">{{ old("short_description_{$locale}") }}</textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Description complète
                                        (page détail)</label>
                                    <textarea name="full_description_{{ $locale }}" rows="8"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old("full_description_{$locale}") }}</textarea>
                                </div>
                            </div>
                        @endforeach

                        <div class="flex gap-3">
                            <button type="submit" id="submit-btn"
                                class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-blue-700 transition shadow-md flex items-center justify-center gap-2">
                                <i class="fas fa-save"></i><span>Enregistrer le projet</span>
                            </button>
                            <a href="{{ route('admin.projects.index') }}"
                                class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">Annuler</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Hero Preview
            const heroInput = document.getElementById('hero-input');
            const heroPreview = document.getElementById('hero-preview');
            const heroContainer = document.getElementById('hero-preview-container');

            heroInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = (ev) => {
                        heroPreview.src = ev.target.result;
                        heroContainer.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                } else {
                    heroContainer.classList.add('hidden');
                }
            });

            // Désactiver le bouton pendant l'envoi
            const form = document.getElementById('project-form');
            const submitBtn = document.getElementById('submit-btn');
            form.addEventListener('submit', function() {
                submitBtn.disabled = true;
                submitBtn.innerHTML =
                    '<i class="fas fa-spinner fa-spin"></i><span>Enregistrement...</span>';
            });
        });
    </script>
@endsection
