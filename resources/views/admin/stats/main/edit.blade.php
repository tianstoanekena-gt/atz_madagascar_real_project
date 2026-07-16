@extends('admin.layouts.master')
@section('title', 'Modifier une stat principale')

@section('content')
    <section class="content_contents">
        <div class="container mx-auto px-4 py-6">

            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <i class="fas fa-edit text-3xl text-blue-600"></i>
                    <h1 class="text-2xl font-bold text-gray-800">Modifier la stat</h1>
                </div>
                <a href="{{ route('admin.stats.main.index') }}" class="text-gray-600 hover:text-blue-600 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Retour à la liste
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

            {{-- CORRECTION ICI : on passe $statMain au lieu de $statMain->id --}}
            <form action="{{ route('admin.stats.main.update', $statMain) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    <!-- Colonne gauche -->
                    <div class="lg:col-span-1">
                        <div class="bg-white shadow-lg rounded-xl p-6 sticky top-6">
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2"><i
                                        class="fas fa-calendar mr-2"></i>Année *</label>
                                <input type="number" name="year" value="{{ old('year', $statMain->year) }}"
                                    min="2020" max="2035" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2"><i
                                        class="fas fa-hashtag mr-2"></i>Valeur *</label>
                                <input type="number" name="value" value="{{ old('value', $statMain->value) }}"
                                    step="0.01" min="0" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2"><i
                                        class="fas fa-ruler mr-2"></i>Unité</label>
                                <input type="text" name="unit" value="{{ old('unit', $statMain->unit) }}"
                                    maxlength="20"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-icons mr-2"></i>Icône (FontAwesome)
                                </label>
                                <input type="text" name="icon" value="{{ old('icon', $statMain->icon) }}"
                                    maxlength="50"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                    placeholder="Ex: house-chimney, users, heart-pulse (sans le fa-)">
                                <p class="text-xs text-gray-500 mt-1">
                                    <a href="https://fontawesome.com/search?o=r&m=free" target="_blank"
                                        class="text-blue-600 underline">Chercher une icône</a>
                                </p>
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-object-group mr-2"></i>Style de carte
                                </label>
                                <select name="layout_style"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                    <option value="card"
                                        {{ old('layout_style', $statMain->layout_style ?? 'card') == 'card' ? 'selected' : '' }}>
                                        📦 Carte classique</option>
                                    <option value="banner"
                                        {{ old('layout_style', $statMain->layout_style ?? 'banner') == 'banner' ? 'selected' : '' }}>
                                        📰
                                        Bannière large</option>
                                    <option value="highlight"
                                        {{ old('layout_style', $statMain->layout_style ?? 'highlight') == 'highlight' ? 'selected' : '' }}>
                                        ⭐
                                        Mis en avant</option>
                                    <option value="wide"
                                        {{ old('layout_style', $statMain->layout_style ?? 'wide') == 'wide' ? 'selected' : '' }}>
                                        ↔️
                                        Largeur complète</option>
                                </select>
                            </div>
                            <input type="hidden" name="display_type" value="counter">
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2"><i
                                        class="fas fa-sort mr-2"></i>Ordre</label>
                                <input type="number" name="order" value="{{ old('order', $statMain->order) }}"
                                    min="0"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="mb-6">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" name="is_published" value="1"
                                        {{ old('is_published', $statMain->is_published) ? 'checked' : '' }}
                                        class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500">
                                    <span class="text-sm font-medium text-gray-700">
                                        <i class="fas fa-check-circle text-green-500 mr-1"></i>Publié
                                    </span>
                                </label>
                            </div>
                            <div class="pt-4 border-t border-gray-200">
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-gray-500">Créée le :</span>
                                    <span class="font-medium">{{ $statMain->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Colonne droite -->
                    <div class="lg:col-span-2">
                        @php
                            $getTranslation = function ($locale) use ($statMain) {
                                return $statMain->translations->firstWhere('locale', $locale) ??
                                    (object) ['label' => '', 'trend' => '', 'detail' => ''];
                            };
                            $fr = $getTranslation('fr');
                            $mg = $getTranslation('mg');
                            $en = $getTranslation('en');
                        @endphp

                        <div class="bg-white shadow-lg rounded-xl p-6 mb-6">
                            <h2 class="text-lg font-bold text-gray-800 mb-4"><i
                                    class="fas fa-tag mr-2 text-blue-600"></i>Labels</h2>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">🇫🇷 FR *</label>
                                    <input type="text" name="label_fr" value="{{ old('label_fr', $fr->label) }}"
                                        maxlength="255" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">🇲🇬 MG</label>
                                    <input type="text" name="label_mg" value="{{ old('label_mg', $mg->label) }}"
                                        maxlength="255"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">🇬🇧 EN</label>
                                    <input type="text" name="label_en" value="{{ old('label_en', $en->label) }}"
                                        maxlength="255"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>

                        <div class="bg-white shadow-lg rounded-xl p-6 mb-6">
                            <h2 class="text-lg font-bold text-gray-800 mb-4"><i
                                    class="fas fa-arrow-trend-up mr-2 text-blue-600"></i>Tendances</h2>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">🇫🇷 FR</label>
                                    <input type="text" name="trend_fr" value="{{ old('trend_fr', $fr->trend) }}"
                                        maxlength="100"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">🇲🇬 MG</label>
                                    <input type="text" name="trend_mg" value="{{ old('trend_mg', $mg->trend) }}"
                                        maxlength="100"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">🇬🇧 EN</label>
                                    <input type="text" name="trend_en" value="{{ old('trend_en', $en->trend) }}"
                                        maxlength="100"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>

                        <div class="bg-white shadow-lg rounded-xl p-6">
                            <h2 class="text-lg font-bold text-gray-800 mb-4"><i
                                    class="fas fa-info-circle mr-2 text-blue-600"></i>Détails</h2>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">🇫🇷 FR</label>
                                    <input type="text" name="detail_fr" value="{{ old('detail_fr', $fr->detail) }}"
                                        maxlength="255"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">🇲🇬 MG</label>
                                    <input type="text" name="detail_mg" value="{{ old('detail_mg', $mg->detail) }}"
                                        maxlength="255"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">🇬🇧 EN</label>
                                    <input type="text" name="detail_en" value="{{ old('detail_en', $en->detail) }}"
                                        maxlength="255"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-3 pt-6 mt-6">
                            <button type="submit"
                                class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-blue-700 transition shadow-md flex items-center justify-center gap-2">
                                <i class="fas fa-save"></i><span>Mettre à jour</span>
                            </button>
                            <a href="{{ route('admin.stats.main.index') }}"
                                class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">Annuler</a>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Zone Danger -->
            <div class="mt-8 bg-white shadow-lg rounded-xl overflow-hidden border border-red-200">
                <div class="bg-red-50 px-6 py-4 border-b border-red-200">
                    <h3 class="text-lg font-bold text-red-800 flex items-center gap-2">
                        <i class="fas fa-exclamation-triangle"></i>Zone de danger
                    </h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 mb-4">La suppression est irréversible.</p>
                    {{-- CORRECTION ICI AUSSI : on passe $statMain au lieu de $statMain->id --}}
                    <form action="{{ route('admin.stats.main.destroy', $statMain) }}" method="POST" class="inline"
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
