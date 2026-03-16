@extends('admin.layouts.master')

@section('content')
    <div class="container mx-auto px-4 py-6">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-plus-circle text-blue-600 mr-2"></i>
                Ajouter une Carte About
            </h1>
            <a href="{{ route('admin.about-cards.index') }}" class="text-gray-600 hover:text-blue-600 transition">
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

        <div class="bg-white shadow-lg rounded-xl p-8 max-w-3xl">
            <form action="{{ route('admin.about-cards.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Langue -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        <i class="fas fa-language mr-2"></i>Langue
                    </label>
                    <select name="lang"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                        required>
                        <option value="">-- Sélectionner --</option>
                        @foreach ($languages as $code => $name)
                            <option value="{{ $code }}" {{ old('lang') == $code ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                    @error('lang')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Icône -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        <i class="fas fa-image mr-2"></i>Icône (PNG)
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center">
                        <label for="card_icon"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 cursor-pointer transition">
                            <i class="fas fa-folder-open"></i>
                            <span>Choisir une icône</span>
                            <input id="card_icon" name="card_icon" type="file" class="hidden" accept="image/png"
                                onchange="previewIcon(event)" required>
                        </label>
                        <p class="text-xs text-gray-500 mt-2">
                            <i class="fas fa-info-circle mr-1"></i>PNG uniquement - Max 2 MB
                        </p>
                    </div>
                    <div id="icon-preview" class="hidden mt-4">
                        <img src="#" class="w-24 h-24 object-contain border-2 border-blue-300 rounded-lg">
                    </div>
                    @error('card_icon')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Titre -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        <i class="fas fa-heading mr-2"></i>Titre
                    </label>
                    <input type="text" name="card_title" value="{{ old('card_title') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                        placeholder="Ex: Notre Mission" required>
                    @error('card_title')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        <i class="fas fa-align-left mr-2"></i>Description
                    </label>
                    <textarea name="card_description" rows="5"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                        placeholder="Description de la carte..." required>{{ old('card_description') }}</textarea>
                    @error('card_description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="flex gap-3 pt-6 border-t">
                    <button type="submit"
                        class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-blue-700 transition">
                        <i class="fas fa-save mr-2"></i>Enregistrer
                    </button>
                    <a href="{{ route('admin.about-cards.index') }}"
                        class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewIcon(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('icon-preview');

            if (file && file.type === 'image/png') {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.querySelector('img').src = e.target.result;
                    preview.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
