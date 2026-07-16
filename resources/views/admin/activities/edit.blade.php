@extends('admin.layouts.master')
@section('title', 'Modifier une activité')

@section('content')
    <section class="content_contents">
        <div class="container mx-auto px-4 py-6">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <i class="fas fa-edit text-3xl text-blue-600"></i>
                    <h1 class="text-2xl font-bold text-gray-800">Modifier l'activité</h1>
                </div>
                <a href="{{ route('admin.activities.index') }}" class="text-gray-600 hover:text-blue-600 transition"><i
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

            <form action="{{ route('admin.activities.update', $activity) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    {{-- Colonne Gauche --}}
                    <div class="lg:col-span-1 space-y-6">
                        <div class="bg-white shadow-lg rounded-xl p-6 sticky top-6">
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2"><i
                                        class="fas fa-tag mr-2"></i>Catégorie *</label>
                                <input type="text" name="category" value="{{ old('category', $activity->category) }}"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2"><i
                                        class="fas fa-image mr-2"></i>Image Hero</label>
                                @if ($activity->hero_image)
                                    <img src="{{ Storage::url($activity->hero_image) }}"
                                        class="w-full h-32 object-cover rounded-lg mb-2 border">
                                @endif
                                <input type="file" name="hero_image" accept="image/*"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 bg-gray-50">
                                <p class="text-xs text-gray-500 mt-1">Laissez vide pour garder l'image actuelle.</p>
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2"><i
                                        class="fas fa-images mr-2"></i>Galerie Photos</label>
                                @if ($activity->gallery)
                                    <div class="grid grid-cols-3 gap-2 mb-2">
                                        @foreach ($activity->gallery as $img)
                                            <img src="{{ Storage::url($img) }}"
                                                class="w-full h-16 object-cover rounded border">
                                        @endforeach
                                    </div>
                                @endif
                                <input type="file" name="gallery[]" accept="image/*" multiple
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 bg-gray-50">
                                <p class="text-xs text-gray-500 mt-1">Remplace toute la galerie actuelle.</p>
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2"><i
                                        class="fas fa-sort mr-2"></i>Ordre</label>
                                <input type="number" name="order" value="{{ old('order', $activity->order) }}"
                                    min="0"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div class="mb-6">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" name="is_published" value="1"
                                        {{ old('is_published', $activity->is_published) ? 'checked' : '' }}
                                        class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500">
                                    <span class="text-sm font-medium text-gray-700"><i
                                            class="fas fa-check-circle text-green-500 mr-1"></i>Publier</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Colonne Droite --}}
                    <div class="lg:col-span-2 space-y-6">
                        @php
                            $getTrans = function ($locale) use ($activity) {
                                return $activity->translations->firstWhere('locale', $locale) ??
                                    (object) ['title' => '', 'description' => ''];
                            };
                        @endphp

                        @foreach (['fr' => '🇫🇷 Français', 'mg' => '🇲 Malagasy', 'en' => '🇧 English'] as $locale => $label)
                            @php $trans = $getTrans($locale); @endphp
                            <div class="bg-white shadow-lg rounded-xl p-6">
                                <h2 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2"><i
                                        class="fas fa-language mr-2 text-blue-600"></i>{{ $label }} @if ($locale == 'fr')
                                        <span class="text-red-500 text-sm">*</span>
                                    @endif
                                </h2>

                                <div class="mb-4">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Titre *</label>
                                    <input type="text" name="title_{{ $locale }}"
                                        value="{{ old("title_{$locale}", $trans->title) }}"
                                        {{ $locale == 'fr' ? 'required' : '' }}
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Description
                                        complète</label>
                                    <textarea name="description_{{ $locale }}" rows="5"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old("description_{$locale}", $trans->description) }}</textarea>
                                </div>
                            </div>
                        @endforeach

                        <div class="flex gap-3">
                            <button type="submit"
                                class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-blue-700 transition shadow-md flex items-center justify-center gap-2">
                                <i class="fas fa-save"></i><span>Mettre à jour</span>
                            </button>
                            <a href="{{ route('admin.activities.index') }}"
                                class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">Annuler</a>
                        </div>
                    </div>
                </div>
            </form>

            {{-- Zone Danger --}}
            <div class="mt-8 bg-white shadow-lg rounded-xl overflow-hidden border border-red-200">
                <div class="bg-red-50 px-6 py-4 border-b border-red-200">
                    <h3 class="text-lg font-bold text-red-800 flex items-center gap-2"><i
                            class="fas fa-exclamation-triangle"></i>Zone de danger</h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.activities.destroy', $activity) }}" method="POST" class="inline"
                        onsubmit="return confirm('Supprimer définitivement ?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center gap-2 bg-red-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-red-700 transition shadow-md">
                            <i class="fas fa-trash"></i><span>Supprimer définitivement</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
