@extends('admin.layouts.master')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
    <section class="content_contents">
        <div class="container mx-auto px-4 py-6">

            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-edit text-blue-600 mr-2"></i>
                    Modifier l'Intervention #{{ $aboutIntervention->id }}
                </h1>
                <a href="{{ route('admin.about-interventions.index') }}" class="text-gray-600 hover:text-blue-600 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Retour
                </a>
            </div>

            @if (session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
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

            <div class="bg-white shadow-lg rounded-xl p-8 max-w-4xl">
                <form action="{{ route('admin.about-interventions.update', $aboutIntervention->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Image Actuelle -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-image mr-2"></i>Image actuelle
                        </label>
                        @if (Storage::disk('public')->exists($aboutIntervention->image))
                            <img src="{{ Storage::url($aboutIntervention->image) }}"
                                class="w-48 h-32 object-cover rounded-lg border-2 border-gray-200">
                        @endif
                    </div>

                    <!-- Nouvelle Image -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-upload mr-2"></i>Nouvelle image (optionnel)
                        </label>
                        <input type="file" name="image" accept="image/*"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg" onchange="previewImage(event)">
                        <p class="text-xs text-gray-500 mt-2">
                            <i class="fas fa-info-circle mr-1"></i>Laisser vide pour garder l'image actuelle
                        </p>
                    </div>

                    <!-- Ordre -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-sort mr-2"></i>Ordre d'affichage
                        </label>
                        <input type="number" name="order" value="{{ $aboutIntervention->order }}" min="0"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>

                    <!-- Traductions -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-language mr-2"></i>Traductions
                        </label>

                        <div id="translations-container">
                            @foreach ($aboutIntervention->translations as $index => $translation)
                                <div class="translation-item bg-gray-50 rounded-lg p-4 mb-4 border">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 mb-1">Langue</label>
                                            <select name="translations[{{ $index }}][lang]"
                                                class="lang-select w-full px-3 py-2 border rounded-lg" required>
                                                @foreach ($languages as $code => $name)
                                                    <option value="{{ $code }}"
                                                        {{ $translation->lang == $code ? 'selected' : '' }}>
                                                        {{ $name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 mb-1">Titre</label>
                                            <input type="text" name="translations[{{ $index }}][title]"
                                                value="{{ $translation->title }}"
                                                class="w-full px-3 py-2 border rounded-lg" required>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 mb-1">Description</label>
                                            <input type="text" name="translations[{{ $index }}][description]"
                                                value="{{ $translation->description }}"
                                                class="w-full px-3 py-2 border rounded-lg" required>
                                        </div>
                                    </div>
                                    <button type="button" onclick="removeTranslation(this)"
                                        class="mt-3 text-red-600 hover:text-red-800 text-sm">
                                        <i class="fas fa-trash mr-1"></i>Supprimer
                                    </button>
                                </div>
                            @endforeach
                        </div>

                        <button type="button" onclick="addTranslation()"
                            class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            <i class="fas fa-plus mr-1"></i>Ajouter une traduction
                        </button>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-3 pt-6 border-t">
                        <button type="submit"
                            class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-blue-700 transition">
                            <i class="fas fa-save mr-2"></i>Mettre à jour
                        </button>
                        <a href="{{ route('admin.about-interventions.index') }}"
                            class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script>
        let translationCount = {{ $aboutIntervention->translations->count() }};

        function previewImage(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('image-preview');

            if (file && file.type.match('image.*')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.querySelector('img').src = e.target.result;
                    preview.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        }

        function addTranslation() {
            const container = document.getElementById('translations-container');
            const newIndex = translationCount++;

            const html = `
                <div class="translation-item bg-gray-50 rounded-lg p-4 mb-4 border">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Langue</label>
                            <select name="translations[${newIndex}][lang]" class="lang-select w-full px-3 py-2 border rounded-lg" required>
                                <option value="">-- Sélectionner --</option>
                                @foreach ($languages as $code => $name)
                                    <option value="{{ $code }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Titre</label>
                            <input type="text" name="translations[${newIndex}][title]" class="w-full px-3 py-2 border rounded-lg" required>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Description</label>
                            <input type="text" name="translations[${newIndex}][description]" class="w-full px-3 py-2 border rounded-lg" required>
                        </div>
                    </div>
                    <button type="button" onclick="removeTranslation(this)" class="mt-3 text-red-600 hover:text-red-800 text-sm">
                        <i class="fas fa-trash mr-1"></i>Supprimer
                    </button>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', html);
        }

        function removeTranslation(button) {
            button.closest('.translation-item').remove();
        }
    </script>
@endsection
