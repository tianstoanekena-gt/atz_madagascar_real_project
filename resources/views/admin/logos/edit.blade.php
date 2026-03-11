@extends('admin.layouts.master')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
    <div class="container mx-auto px-4 py-6">

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-edit text-blue-600 mr-2"></i>
                Modifier le Logo #{{ $logo->id }}
            </h1>
            <a href="{{ route('admin.logos.index') }}" class="text-gray-600 hover:text-blue-600 transition">
                <i class="fas fa-arrow-left mr-2"></i>
                Retour à la liste
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

        <!-- Erreurs de validation -->
        @if ($errors->any())
            <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded flex items-center gap-2">
                <i class="fas fa-exclamation-circle"></i>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulaire -->
        <div class="bg-white shadow-lg rounded-xl p-8 max-w-2xl">
            <form action="{{ route('admin.logos.update', $logo->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Logo Actuel -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        <i class="fas fa-image mr-2"></i>
                        Logo actuel
                    </label>

                    @if (Storage::disk('public')->exists($logo->logo))
                        <div class="relative inline-block group">
                            <img src="{{ Storage::url($logo->logo) }}" alt="Logo actuel"
                                class="w-48 h-48 object-contain rounded-xl border-2 border-gray-200 shadow-md cursor-pointer hover:border-blue-400 transition p-2 bg-gray-50"
                                onclick="openModal('{{ Storage::url($logo->logo) }}')">
                            <div
                                class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 rounded-xl transition flex items-center justify-center">
                                <i
                                    class="fas fa-search-plus text-white text-2xl opacity-0 group-hover:opacity-100 transition"></i>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">
                            <i class="fas fa-info-circle mr-1"></i>
                            Cliquez pour voir en grand
                        </p>
                    @else
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <p class="text-yellow-700">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                Fichier introuvable sur le serveur
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Upload Nouveau Logo -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        <i class="fas fa-upload mr-2"></i>
                        Nouveau logo
                    </label>

                    <!-- Zone de drop -->
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-blue-400 transition"
                        id="drop-zone" ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)"
                        ondrop="handleDrop(event)">
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
                                <span>Choisir un nouveau fichier</span>
                                <input id="logo" name="logo" type="file" class="hidden" accept="image/*"
                                    onchange="previewImage(event)">
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
                    <p class="text-sm text-gray-600 mb-2 font-semibold">Aperçu du nouveau logo :</p>
                    <div class="relative inline-block">
                        <img id="logo-preview"
                            class="w-48 h-48 object-contain rounded-xl border-2 border-blue-300 shadow-md bg-gray-50 p-2"
                            src="#" alt="Aperçu du nouveau logo">
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
                        <span>Mettre à jour le logo</span>
                    </button>

                    <a href="{{ route('admin.logos.index') }}"
                        class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition text-center">
                        <i class="fas fa-times mr-2"></i>
                        Annuler
                    </a>
                </div>
            </form>
        </div>

        <!-- Modal pour voir l'image en grand -->
        <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-80 hidden flex items-center justify-center z-50 p-4"
            onclick="closeModal()">
            <div class="relative max-w-5xl w-full" onclick="event.stopPropagation()">
                <img id="modalImage" class="w-full h-auto max-h-[85vh] object-contain rounded-xl shadow-2xl" src="#"
                    alt="Aperçu">
                <button onclick="closeModal()"
                    class="absolute -top-4 -right-4 bg-white text-gray-800 rounded-full w-12 h-12 flex items-center justify-center hover:bg-gray-100 transition shadow-xl">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>

    </div>

    <!-- JavaScript -->
    <script>
        // Gestion du Drag & Drop
        function handleDragOver(e) {
            e.preventDefault();
            document.getElementById('drop-zone').classList.add('border-blue-500', 'bg-blue-50');
        }

        function handleDragLeave(e) {
            e.preventDefault();
            document.getElementById('drop-zone').classList.remove('border-blue-500', 'bg-blue-50');
        }

        function handleDrop(e) {
            e.preventDefault();
            document.getElementById('drop-zone').classList.remove('border-blue-500', 'bg-blue-50');

            const files = e.dataTransfer.files;
            if (files.length > 0) {
                document.getElementById('logo').files = files;
                previewImage({
                    target: {
                        files: files
                    }
                });
            }
        }

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

        // Modal
        function openModal(src) {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            modalImage.src = src;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Touche Échap
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
        @endsection
    </script>
