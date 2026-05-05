@extends('admin.layouts.master')

@section('title', 'Modifier le Document')

@section('content')
    <section class="content_contents">
        <div class="container mx-auto px-4 py-6">

            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <i class="fas fa-edit text-3xl text-blue-600"></i>
                    <h1 class="text-2xl font-bold text-gray-800">Modifier le Document</h1>
                </div>
                <a href="{{ route('admin.documents.index') }}" class="text-gray-600 hover:text-blue-600 transition">
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

            <form action="{{ route('admin.documents.update', $document->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    <!-- COLONNE GAUCHE : Fichier actuel + Paramètres -->
                    <div class="lg:col-span-1">
                        <div class="bg-white shadow-lg rounded-xl p-6 sticky top-6">

                            <!-- Fichier Actuel -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-3">
                                    <i class="fas fa-file mr-2"></i>Fichier actuel
                                </label>
                                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-12 h-12 rounded-lg flex items-center justify-center {{ $document->type_class }}">
                                            <i class="fas {{ $document->icon }} text-white text-xl"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <strong
                                                class="text-gray-900 block truncate">{{ $document->file_original_name }}</strong>
                                            <small class="text-gray-500">
                                                {{ $document->formatted_size }} •
                                                {{ $document->created_at->format('d/m/Y') }}
                                            </small>
                                        </div>
                                    </div>
                                    <a href="{{ Storage::url($document->file_path) }}" target="_blank"
                                        class="mt-3 inline-flex items-center gap-2 text-sm text-blue-600 hover:text-blue-800 font-medium transition">
                                        <i class="fas fa-external-link-alt"></i>
                                        Voir le fichier
                                    </a>
                                </div>
                            </div>

                            <!-- Remplacer le Fichier (optionnel) -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-3">
                                    <i class="fas fa-sync-alt mr-2"></i>Remplacer le fichier
                                </label>
                                <div class="border-2 border-dashed border-gray-300 rounded-xl p-4 text-center hover:border-blue-400 transition cursor-pointer bg-gray-50"
                                    onclick="document.getElementById('file').click()">
                                    <i class="fas fa-cloud-upload-alt text-2xl text-blue-600 mb-2"></i>
                                    <p class="text-sm text-gray-600">Cliquez pour uploader un nouveau fichier</p>
                                    <p class="text-xs text-gray-500 mt-1">Laissez vide pour conserver l'actuel</p>
                                    <input type="file" name="file" id="file" class="hidden"
                                        accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.odt,.ods,.odp"
                                        onchange="previewNewFile(event)">
                                </div>
                                <p id="new-file-preview" class="mt-3 text-sm text-blue-600 font-medium hidden">
                                    <i class="fas fa-check-circle mr-1"></i><span id="new-file-name"></span>
                                </p>
                                @error('file')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Ordre d'affichage -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-sort mr-2"></i>Ordre d'affichage
                                </label>
                                <input type="number" name="order" value="{{ old('order', $document->order) }}"
                                    min="0"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                    placeholder="0 = premier">
                            </div>

                            <!-- Statut Publié -->
                            <div class="mb-6">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" name="is_published" value="1"
                                        {{ old('is_published', $document->is_published) ? 'checked' : '' }}
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
                                        <span class="text-gray-500">Vues :</span>
                                        <span
                                            class="font-medium text-gray-900">{{ number_format($document->view_count) }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500">Téléchargements :</span>
                                        <span
                                            class="font-medium text-gray-900">{{ number_format($document->download_count) }}</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- COLONNE DROITE : Titres & Descriptions Multilingues -->
                    <div class="lg:col-span-2">

                        <!-- Titres Multilingues -->
                        <div class="bg-white shadow-lg rounded-xl p-6 mb-6">
                            <h2 class="text-lg font-bold text-gray-800 mb-4">
                                <i class="fas fa-heading mr-2 text-blue-600"></i>
                                Titres (au moins un requis)
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        🇫🇷 Français
                                    </label>
                                    <input type="text" name="title_fr"
                                        value="{{ old('title_fr', $document->title_fr) }}" maxlength="255"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                        placeholder="Ex: Rapport annuel 2025">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        🇲🇬 Malagasy
                                    </label>
                                    <input type="text" name="title_mg"
                                        value="{{ old('title_mg', $document->title_mg) }}" maxlength="255"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                        placeholder="Ohatra: Tatitra taona 2025">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        🇬🇧 English
                                    </label>
                                    <input type="text" name="title_en"
                                        value="{{ old('title_en', $document->title_en) }}" maxlength="255"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                        placeholder="Example: Annual Report 2025">
                                </div>
                            </div>
                        </div>

                        <!-- Descriptions Multilingues avec Onglets -->
                        <div class="bg-white shadow-lg rounded-xl p-6">
                            <h2 class="text-lg font-bold text-gray-800 mb-4">
                                <i class="fas fa-align-left mr-2 text-blue-600"></i>
                                Descriptions (optionnel)
                            </h2>

                            <!-- Onglets de langues -->
                            <div class="flex gap-2 mb-6 border-b border-gray-200">
                                <button type="button" onclick="switchDescTab('fr')"
                                    class="desc-tab px-4 py-2 font-medium rounded-t-lg transition border-b-2 border-blue-600 text-blue-600"
                                    data-lang="fr">
                                    🇫🇷 Français
                                </button>
                                <button type="button" onclick="switchDescTab('mg')"
                                    class="desc-tab px-4 py-2 font-medium rounded-t-lg transition border-b-2 border-transparent text-gray-500 hover:text-gray-700"
                                    data-lang="mg">
                                    🇲🇬 Malagasy
                                </button>
                                <button type="button" onclick="switchDescTab('en')"
                                    class="desc-tab px-4 py-2 font-medium rounded-t-lg transition border-b-2 border-transparent text-gray-500 hover:text-gray-700"
                                    data-lang="en">
                                    🇬🇧 English
                                </button>
                            </div>

                            <!-- Champs par langue -->
                            @foreach (['fr' => '🇫🇷', 'mg' => '🇲🇬', 'en' => '🇬🇧'] as $code => $flag)
                                <div class="desc-content {{ $code !== 'fr' ? 'hidden' : '' }}"
                                    data-lang="{{ $code }}">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        {{ $flag }} Description {{ strtoupper($code) }}
                                    </label>
                                    <textarea name="description_{{ $code }}" rows="5"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                        placeholder="Brève description du document...">{{ old('description_' . $code, $document->{'description_' . $code}) }}</textarea>
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
                                <span>Mettre à jour le document</span>
                            </button>
                            <a href="{{ route('admin.documents.index') }}"
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
                        La suppression est irréversible. Le fichier sera définitivement effacé du serveur et ne pourra pas
                        être récupéré.
                    </p>
                    <form action="{{ route('admin.documents.destroy', $document->id) }}" method="POST" class="inline"
                        onsubmit="return confirm('Êtes-vous SÛR de vouloir supprimer ce document ? Cette action est irréversible.')">
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
        // Prévisualisation du nouveau fichier
        function previewNewFile(event) {
            const fileName = event.target.files[0]?.name;
            if (fileName) {
                document.getElementById('new-file-name').textContent = fileName;
                document.getElementById('new-file-preview').classList.remove('hidden');
            }
        }

        // Gestion des onglets de description
        function switchDescTab(lang) {
            document.querySelectorAll('.desc-content').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.desc-tab').forEach(el => {
                el.classList.remove('border-blue-600', 'text-blue-600');
                el.classList.add('border-transparent', 'text-gray-500');
            });
            document.querySelector(`.desc-content[data-lang="${lang}"]`).classList.remove('hidden');
            const activeTab = document.querySelector(`.desc-tab[data-lang="${lang}"]`);
            activeTab.classList.remove('border-transparent', 'text-gray-500');
            activeTab.classList.add('border-blue-600', 'text-blue-600');
        }

        // Copier depuis le français
        function copyFromFrench(lang) {
            const frDesc = document.querySelector(`.desc-content[data-lang="fr"] textarea`).value;
            document.querySelector(`.desc-content[data-lang="${lang}"] textarea`).value = frDesc;

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
