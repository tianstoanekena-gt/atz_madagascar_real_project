@extends('admin.layouts.master')

@section('title', 'Modifier la FAQ')

@section('content')
    <section class="content_contents">
        <div class="container mx-auto px-4 py-6">

            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <i class="fas fa-edit text-3xl text-blue-600"></i>
                    <h1 class="text-2xl font-bold text-gray-800">Modifier la FAQ</h1>
                </div>
                <a href="{{ route('admin.faq.index') }}" class="text-gray-600 hover:text-blue-600 transition">
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

            <form action="{{ route('admin.faq.update', $faq->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    <!-- COLONNE GAUCHE : Catégorie & Paramètres -->
                    <div class="lg:col-span-1">
                        <div class="bg-white shadow-lg rounded-xl p-6 sticky top-6">

                            <!-- Catégorie -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-3">
                                    <i class="fas fa-folder mr-2"></i>Catégorie *
                                </label>
                                <select name="category"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                    required>
                                    @foreach ($categories as $key => $label)
                                        <option value="{{ $key }}"
                                            {{ old('category', $faq->category) == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Ordre d'affichage -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-sort mr-2"></i>Ordre d'affichage
                                </label>
                                <input type="number" name="order" value="{{ old('order', $faq->order) }}" min="0"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                    placeholder="0 = premier">
                            </div>

                            <!-- Statut Publié -->
                            <div class="mb-6">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" name="is_published" value="1"
                                        {{ old('is_published', $faq->is_published) ? 'checked' : '' }}
                                        class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500 border-gray-300">
                                    <span class="text-sm font-medium text-gray-700">
                                        <i class="fas fa-check-circle text-green-500 mr-1"></i>
                                        Publié (visible sur le site)
                                    </span>
                                </label>
                            </div>

                            <!-- Stats (lecture seule) -->
                            <div class="pt-4 border-t border-gray-200">
                                <h4 class="text-sm font-semibold text-gray-700 mb-3">
                                    <i class="fas fa-chart-bar mr-2"></i>Statistiques
                                </h4>
                                <div class="space-y-2">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500">Créée le :</span>
                                        <span
                                            class="font-medium text-gray-900">{{ $faq->created_at->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500">Vues :</span>
                                        <span class="font-medium text-gray-900">{{ number_format($faq->view_count) }}</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- COLONNE DROITE : Questions & Réponses Multilingues -->
                    <div class="lg:col-span-2">

                        <!-- Questions Multilingues -->
                        <div class="bg-white shadow-lg rounded-xl p-6 mb-6">
                            <h2 class="text-lg font-bold text-gray-800 mb-4">
                                <i class="fas fa-question-circle mr-2 text-blue-600"></i>
                                Questions (au moins une requise)
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        🇫🇷 Français
                                    </label>
                                    <input type="text" name="question_fr"
                                        value="{{ old('question_fr', $faq->question_fr) }}" maxlength="500"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                        placeholder="Ex: Qu'est-ce que ATZ Madagascar ?">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        🇲🇬 Malagasy
                                    </label>
                                    <input type="text" name="question_mg"
                                        value="{{ old('question_mg', $faq->question_mg) }}" maxlength="500"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                        placeholder="Ohatra: Inona ny ATZ Madagascar ?">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        🇬🇧 English
                                    </label>
                                    <input type="text" name="question_en"
                                        value="{{ old('question_en', $faq->question_en) }}" maxlength="500"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                        placeholder="Example: What is ATZ Madagascar?">
                                </div>
                            </div>
                        </div>

                        <!-- Réponses Multilingues avec Onglets -->
                        <div class="bg-white shadow-lg rounded-xl p-6">
                            <h2 class="text-lg font-bold text-gray-800 mb-4">
                                <i class="fas fa-reply mr-2 text-blue-600"></i>
                                Réponses (optionnel, HTML autorisé)
                            </h2>

                            <!-- Onglets de langues -->
                            <div class="flex gap-2 mb-6 border-b border-gray-200">
                                <button type="button" onclick="switchAnswerTab('fr')"
                                    class="answer-tab px-4 py-2 font-medium rounded-t-lg transition border-b-2 border-blue-600 text-blue-600"
                                    data-lang="fr">
                                    🇫🇷 Français
                                </button>
                                <button type="button" onclick="switchAnswerTab('mg')"
                                    class="answer-tab px-4 py-2 font-medium rounded-t-lg transition border-b-2 border-transparent text-gray-500 hover:text-gray-700"
                                    data-lang="mg">
                                    🇲🇬 Malagasy
                                </button>
                                <button type="button" onclick="switchAnswerTab('en')"
                                    class="answer-tab px-4 py-2 font-medium rounded-t-lg transition border-b-2 border-transparent text-gray-500 hover:text-gray-700"
                                    data-lang="en">
                                    🇬🇧 English
                                </button>
                            </div>

                            <!-- Champs par langue -->
                            @foreach (['fr' => '🇫🇷', 'mg' => '🇲🇬', 'en' => '🇬🇧'] as $code => $flag)
                                <div class="answer-content {{ $code !== 'fr' ? 'hidden' : '' }}"
                                    data-lang="{{ $code }}">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        {{ $flag }} Réponse {{ strtoupper($code) }}
                                    </label>
                                    <textarea name="answer_{{ $code }}" rows="6"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                        placeholder="Votre réponse...">{{ old('answer_' . $code, $faq->{'answer_' . $code}) }}</textarea>
                                    <p class="text-xs text-gray-500 mt-1">
                                        <i class="fas fa-info-circle mr-1"></i>5000 caractères maximum
                                    </p>

                                    @if ($code !== 'fr')
                                        <div class="text-right mt-3">
                                            <button type="button" onclick="copyFromFrench('{{ $code }}')"
                                                class="text-sm text-blue-600 hover:text-blue-800 font-medium transition">
                                                <i class="fas fa-copy mr-1"></i>
                                                Copier depuis le français
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex gap-3 pt-6 mt-6 border-t border-gray-200">
                            <button type="submit"
                                class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-blue-700 transition shadow-md flex items-center justify-center gap-2">
                                <i class="fas fa-save"></i>
                                <span>Mettre à jour la FAQ</span>
                            </button>
                            <a href="{{ route('admin.faq.index') }}"
                                class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                                Annuler
                            </a>
                        </div>

                    </div>
                </div>
            </form>

            <!-- Zone de Danger -->
            <div class="mt-8 bg-white shadow-lg rounded-xl overflow-hidden border border-red-200">
                <div class="bg-red-50 px-6 py-4 border-b border-red-200">
                    <h3 class="text-lg font-bold text-red-800 flex items-center gap-2">
                        <i class="fas fa-exclamation-triangle"></i>
                        Zone de danger
                    </h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 mb-4">
                        La suppression est irréversible. Cette FAQ sera définitivement effacée.
                    </p>
                    <form action="{{ route('admin.faq.destroy', $faq->id) }}" method="POST" class="inline"
                        onsubmit="return confirm('Êtes-vous SÛR de vouloir supprimer cette FAQ ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center gap-2 bg-red-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-red-700 transition shadow-md">
                            <i class="fas fa-trash"></i>
                            <span>Supprimer définitivement</span>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </section>

    <!-- Scripts -->
    <script>
        function switchAnswerTab(lang) {
            document.querySelectorAll('.answer-content').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.answer-tab').forEach(el => {
                el.classList.remove('border-blue-600', 'text-blue-600');
                el.classList.add('border-transparent', 'text-gray-500');
            });
            document.querySelector(`.answer-content[data-lang="${lang}"]`).classList.remove('hidden');
            const activeTab = document.querySelector(`.answer-tab[data-lang="${lang}"]`);
            activeTab.classList.remove('border-transparent', 'text-gray-500');
            activeTab.classList.add('border-blue-600', 'text-blue-600');
        }

        function copyFromFrench(lang) {
            const frDesc = document.querySelector(`.answer-content[data-lang="fr"] textarea`).value;
            document.querySelector(`.answer-content[data-lang="${lang}"] textarea`).value = frDesc;

            const btn = event.currentTarget;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-check mr-1"></i>Copié !';
            btn.classList.add('text-green-600');
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.classList.remove('text-green-600');
            }, 2000);
        }
    </script>
@endsection
