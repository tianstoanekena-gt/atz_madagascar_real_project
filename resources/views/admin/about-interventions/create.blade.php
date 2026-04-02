@extends('admin.layouts.master')

@section('content')
    <section class="content_contents">
        <div class="container mx-auto px-4 py-6">

            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-plus-circle text-blue-600 mr-2"></i>
                    Ajouter une Intervention
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
                <form action="{{ route('admin.about-interventions.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Image -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-image mr-2"></i>Image
                        </label>
                        <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center">
                            <label for="image"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 cursor-pointer transition">
                                <i class="fas fa-folder-open"></i>
                                <span>Choisir une image</span>
                                <input id="image" name="image" type="file" class="hidden" accept="image/*"
                                    onchange="previewImage(event)" required>
                            </label>
                            <p class="text-xs text-gray-500 mt-2">
                                <i class="fas fa-info-circle mr-1"></i>PNG, JPG - Max 5 MB
                            </p>
                        </div>
                        <div id="image-preview" class="hidden mt-4">
                            <img src="#" class="w-48 h-32 object-cover rounded-lg border-2 border-blue-300">
                        </div>
                        @error('image')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Ordre -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-sort mr-2"></i>Ordre d'affichage
                        </label>
                        <input type="number" name="order" value="0" min="0"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                            required>
                        @error('order')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Traductions -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-language mr-2"></i>Traductions
                        </label>
                        <p class="text-xs text-gray-500 mb-4">
                            <i class="fas fa-info-circle mr-1"></i>Ajoutez au moins une traduction (recommandé : mg, fr, en)
                        </p>

                        <div id="translations-container">
                            <div class="translation-item bg-gray-50 rounded-lg p-4 mb-4 border">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <!-- Langue -->
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">Langue</label>
                                        <select name="translations[0][lang]"
                                            class="lang-select w-full px-3 py-2 border rounded-lg" required>
                                            <option value="">-- Sélectionner --</option>
                                            @foreach ($languages as $code => $name)
                                                <option value="{{ $code }}">{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- Titre -->
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">Titre</label>
                                        <input type="text" name="translations[0][title]"
                                            class="w-full px-3 py-2 border rounded-lg" required>
                                    </div>
                                    <!-- Description -->
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">Description</label>
                                        <input type="text" name="translations[0][description]"
                                            class="w-full px-3 py-2 border rounded-lg" required>
                                    </div>
                                </div>
                                <button type="button" onclick="removeTranslation(this)"
                                    class="mt-3 text-red-600 hover:text-red-800 text-sm">
                                    <i class="fas fa-trash mr-1"></i>Supprimer
                                </button>
                            </div>
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
                            <i class="fas fa-save mr-2"></i>Enregistrer
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
        let translationCount = 1;

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
