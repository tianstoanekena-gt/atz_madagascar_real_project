@extends('admin.layouts.master')
@section('title', 'Ajouter stat éducation')

@section('content')
    <section class="content_contents">
        <div class="container mx-auto px-4 py-6">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <i class="fas fa-plus-circle text-3xl text-blue-600"></i>
                    <h1 class="text-2xl font-bold text-gray-800">Ajouter stat éducation</h1>
                </div>
                <a href="{{ route('admin.stats.education.index') }}" class="text-gray-600 hover:text-blue-600 transition">
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

            <form action="{{ route('admin.stats.education.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-1">
                        <div class="bg-white shadow-lg rounded-xl p-6 sticky top-6">
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2"><i
                                        class="fas fa-calendar mr-2"></i>Année *</label>
                                <input type="number" name="year" value="{{ old('year', 2025) }}" min="2020"
                                    max="2035" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2"><i
                                        class="fas fa-layer-group mr-2"></i>Type d'affichage *</label>
                                <select name="display_type" id="display_type" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                    <option value="progress" {{ old('display_type') == 'progress' ? 'selected' : '' }}>📊
                                        Barre de progression</option>
                                    <option value="percentage" {{ old('display_type') == 'percentage' ? 'selected' : '' }}>
                                        💯 Pourcentage</option>
                                    <option value="chart_bar" {{ old('display_type') == 'chart_bar' ? 'selected' : '' }}>📈
                                        Barre de graphique</option>
                                </select>
                            </div>
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2"><i
                                        class="fas fa-hashtag mr-2"></i>Valeur *</label>
                                <input type="number" name="value" value="{{ old('value') }}" step="0.01"
                                    min="0" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                <p class="text-xs text-gray-500 mt-1">Ex: 52 (élèves), 161 (primaire), 54 (pourcentage)</p>
                            </div>
                            <div class="mb-6" id="percentage_field" style="display:none;">
                                <label class="block text-sm font-semibold text-gray-700 mb-2"><i
                                        class="fas fa-percent mr-2"></i>Taux affiché (%)</label>
                                <input type="number" name="percentage_value" value="{{ old('percentage_value') }}"
                                    step="0.01" min="0" max="100"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                <p class="text-xs text-gray-500 mt-1">Ex: 54 pour "54% de réussite"</p>
                            </div>
                            <div class="mb-6" id="chart_label_field" style="display:none;">
                                <label class="block text-sm font-semibold text-gray-700 mb-2"><i
                                        class="fas fa-tag mr-2"></i>Nom de la barre</label>
                                <input type="text" name="chart_label" value="{{ old('chart_label') }}" maxlength="50"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                    placeholder="Ex: Primaire, Collège">
                            </div>
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2"><i
                                        class="fas fa-ruler mr-2"></i>Unité</label>
                                <input type="text" name="unit" value="{{ old('unit') }}" maxlength="20"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-icons mr-2"></i>Icône (FontAwesome)
                                </label>
                                <input type="text" name="icon" value="{{ old('icon') }}" maxlength="50"
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
                                    <option value="card" {{ old('layout_style', 'card') == 'card' ? 'selected' : '' }}>📦
                                        Carte classique</option>
                                    <option value="banner" {{ old('layout_style') == 'banner' ? 'selected' : '' }}>📰
                                        Bannière large</option>
                                    <option value="highlight" {{ old('layout_style') == 'highlight' ? 'selected' : '' }}>⭐
                                        Mis en avant</option>
                                    <option value="wide" {{ old('layout_style') == 'wide' ? 'selected' : '' }}>️ Largeur
                                        complète</option>
                                </select>
                            </div>
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2"><i
                                        class="fas fa-sort mr-2"></i>Ordre</label>
                                <input type="number" name="order" value="{{ old('order', 0) }}" min="0"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="mb-6">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" name="is_published" value="1"
                                        {{ old('is_published') ? 'checked' : '' }}
                                        class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500">
                                    <span class="text-sm font-medium text-gray-700"><i
                                            class="fas fa-check-circle text-green-500 mr-1"></i>Publier</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-2">
                        <div class="bg-white shadow-lg rounded-xl p-6 mb-6">
                            <h2 class="text-lg font-bold text-gray-800 mb-4"><i
                                    class="fas fa-tag mr-2 text-blue-600"></i>Labels (FR requis)</h2>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">🇫🇷 FR *</label>
                                    <input type="text" name="label_fr" value="{{ old('label_fr') }}" maxlength="255"
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">🇲🇬 MG</label>
                                    <input type="text" name="label_mg" value="{{ old('label_mg') }}" maxlength="255"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">🇬🇧 EN</label>
                                    <input type="text" name="label_en" value="{{ old('label_en') }}" maxlength="255"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>

                        <div class="bg-white shadow-lg rounded-xl p-6">
                            <h2 class="text-lg font-bold text-gray-800 mb-4"><i
                                    class="fas fa-info-circle mr-2 text-blue-600"></i>Détails (optionnel)</h2>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">🇫🇷 FR</label>
                                    <input type="text" name="detail_fr" value="{{ old('detail_fr') }}"
                                        maxlength="255"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                        placeholder="Ex: 9ème et 6ème">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">🇲🇬 MG</label>
                                    <input type="text" name="detail_mg" value="{{ old('detail_mg') }}"
                                        maxlength="255"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">🇬🇧 EN</label>
                                    <input type="text" name="detail_en" value="{{ old('detail_en') }}"
                                        maxlength="255"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-3 pt-6 mt-6">
                            <button type="submit"
                                class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-blue-700 transition shadow-md flex items-center justify-center gap-2">
                                <i class="fas fa-save"></i><span>Enregistrer</span>
                            </button>
                            <a href="{{ route('admin.stats.education.index') }}"
                                class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">Annuler</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <script>
        document.getElementById('display_type').addEventListener('change', function() {
            document.getElementById('percentage_field').style.display = this.value === 'percentage' ? 'block' :
                'none';
            document.getElementById('chart_label_field').style.display = this.value === 'chart_bar' ? 'block' :
                'none';
        });
        document.getElementById('display_type').dispatchEvent(new Event('change'));
    </script>
@endsection
