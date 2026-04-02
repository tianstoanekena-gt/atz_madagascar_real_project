@extends('admin.layouts.master')

@section('content')
    <section class="content_contents">
        <div class="container mx-auto px-4 py-6">

            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-plus-circle text-blue-600 mr-2"></i>
                    Ajouter un Logo
                </h1>
                <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-blue-600 transition">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour au tableau de bord
                </a>
            </div>

            <!-- Message de succès -->
            @if (session('success'))
                <div
                    class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded flex items-center gap-2">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Formulaire -->
            <div class="bg-white shadow-lg rounded-xl p-8 max-w-2xl">
                <form action="{{ route('admin.logos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Upload Logo -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-image mr-2"></i>
                            Sélectionnez votre logo
                        </label>

                        <!-- Zone de drop -->
                        <div
                            class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-blue-400 transition">
                            <div class="space-y-4">
                                <!-- Icône -->
                                <div class="flex justify-center">
                                    <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center">
                                        <i class="fas fa-cloud-upload-alt text-3xl text-blue-600"></i>
                                    </div>
                                </div>

                                <!-- Bouton -->
                                <label for="logo"
                                    class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 cursor-pointer transition">
                                    <i class="fas fa-folder-open"></i>
                                    <span>Choisir un fichier</span>
                                    <input id="logo" name="logo" type="file" class="hidden" accept="image/*"
                                        onchange="previewImage(event)" required>
                                </label>

                                <!-- Info -->
                                <p class="text-xs text-gray-500">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    PNG, JPG, JPEG, SVG - Maximum 2 MB
                                </p>
                            </div>
                        </div>

                        <!-- Erreur de validation -->
                        @error('logo')
                            <p class="mt-3 text-sm text-red-600 flex items-center gap-2">
                                <i class="fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Aperçu -->
                    <div id="preview-container" class="hidden mb-6">
                        <p class="text-sm text-gray-600 mb-2 font-semibold">Aperçu :</p>
                        <div class="relative inline-block">
                            <img id="logo-preview"
                                class="w-48 h-48 object-contain rounded-lg border-2 border-blue-300 shadow-md bg-gray-50 p-2"
                                src="#" alt="Aperçu du logo">
                            <button type="button" onclick="removePreview()"
                                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-8 h-8 flex items-center justify-center hover:bg-red-600 transition shadow-lg">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="flex gap-3 pt-6 border-t border-gray-200">
                        <button type="submit"
                            class="flex-1 flex items-center justify-center gap-2 bg-blue-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-blue-700 transition shadow-md">
                            <i class="fas fa-save"></i>
                            <span>Enregistrer le logo</span>
                        </button>

                        <button type="reset" onclick="removePreview()"
                            class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition">
                            <i class="fas fa-redo mr-2"></i>
                            Réinitialiser
                        </button>
                    </div>
                </form>
            </div>

            <!-- Section Debug (à retirer en production) -->
            <div class="mt-8 bg-gray-100 rounded-lg p-4">
                <h3 class="font-bold mb-2">🔍 Informations de debug :</h3>
                <ul class="text-sm text-gray-700 space-y-1">
                    <li>✅ Route store : {{ route('admin.logos.store') }}</li>
                    <li>✅ Storage path : {{ storage_path('app/public/logos') }}</li>
                    <li>✅ Public link : {{ public_path('storage/logos') }}</li>
                    <li>✅ Storage link exists :
                        {{ file_exists(public_path('storage')) ? 'OUI ✓' : 'NON ✗ (Exécuter: php artisan storage:link)' }}
                    </li>
                </ul>
            </div>

        </div>
    </section>
    <!-- JavaScript -->
    <script>
        // Aperçu de l'image
        function previewImage(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('logo-preview');
            const container = document.getElementById('preview-container');

            if (file && file.type.match('image.*')) {
                // Vérifier la taille
                const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
                if (sizeMB > 2) {
                    alert('⚠️ Le fichier est trop volumineux (' + sizeMB + ' MB). Maximum autorisé : 2 MB');
                    event.target.value = '';
                    return;
                }

                // Afficher l'aperçu
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    container.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        }

        // Supprimer l'aperçu
        function removePreview() {
            document.getElementById('logo').value = '';
            document.getElementById('preview-container').classList.add('hidden');
        }
    </script>
@endsection
