@extends('admin.layouts.master')
@section('title', 'Ajouter un élève')

@section('content')
    <section class="content_contents">
        <div class="container mx-auto px-4 py-6 max-w-4xl">
            <div class="flex items-center gap-3 mb-6">
                <a href="{{ route('admin.students.index') }}" class="text-gray-600 hover:text-blue-600"><i
                        class="fas fa-arrow-left text-xl"></i></a>
                <h1 class="text-2xl font-bold text-gray-800">Ajouter un élève</h1>
            </div>

            <form action="{{ route('admin.students.store') }}" method="POST" enctype="multipart/form-data"
                class="bg-white p-6 rounded-xl shadow-md space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}"
                            class="w-full border-blue-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('first_name') border-red-500 @enderror"
                            required>
                        @error('first_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}"
                            class="w-full border-blue-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('last_name') border-red-500 @enderror"
                            required>
                        @error('last_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date de naissance</label>
                        <input type="date" name="birth_date" value="{{ old('birth_date') }}" max="{{ date('Y-m-d') }}"
                            class="w-full border-blue-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('birth_date') border-red-500 @enderror"
                            required>
                        @error('birth_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Genre</label>
                        <select name="gender"
                            class="w-full border-blue-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('gender') border-red-500 @enderror"
                            required>
                            <option value="M" {{ old('gender') == 'M' ? 'selected' : '' }}>Masculin</option>
                            <option value="F" {{ old('gender') == 'F' ? 'selected' : '' }}>Féminin</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Photo (Obligatoire)</label>
                        <input type="file" name="photo" accept="image/*"
                            class="w-full border-blue-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('photo') border-red-500 @enderror"
                            required>
                        @error('photo')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Localisation</label>
                        <input type="text" name="location" value="{{ old('location') }}"
                            class="w-full border-blue-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('location') border-red-500 @enderror"
                            required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp (Facultatif)</label>
                        <input type="text" name="whatsapp" value="{{ old('whatsapp') }}" placeholder="+261..."
                            class="w-full border-blue-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('whatsapp') border-red-500 @enderror">
                        @error('whatsapp')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Niveau d'éducation</label>
                        <select name="education_level"
                            class="w-full border-blue-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('education_level') border-red-500 @enderror"
                            required>
                            <option value="primaire">Primaire</option>
                            <option value="college">Collège</option>
                            <option value="lycee">Lycée</option>
                            <option value="superieur">Études supérieures</option>
                            <option value="formation_pro">Formation professionnelle</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description (Situation actuelle)</label>
                    <textarea name="description" rows="3"
                        class="w-full border-blue-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror"
                        required>{{ old('description') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Besoins spécifiques</label>
                    <textarea name="needs" rows="2"
                        class="w-full border-blue-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('needs') border-red-500 @enderror"
                        required>{{ old('needs') }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Objectif (Ar)</label>
                        <input type="number" name="target_amount" value="{{ old('target_amount') }}" min="10000"
                            class="w-full border-blue-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('target_amount') border-red-500 @enderror"
                            required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                        <select name="status"
                            class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <option value="pending">En attente</option>
                            <option value="active" selected>En cours</option>
                            <option value="completed">Terminé</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1"
                                {{ old('is_featured') ? 'checked' : '' }}
                                class="rounded text-blue-600 focus:ring-blue-500">
                            <span class="text-sm font-medium text-gray-700">Mettre en avant</span>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t">
                    <a href="{{ route('admin.students.index') }}"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Annuler</a>
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">Enregistrer</button>
                </div>
            </form>
        </div>
    </section>
@endsection
