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
                Modifier le Slide #{{ $heroSlide->id }}
            </h1>
            <a href="{{ route('admin.hero-slides.index') }}" class="text-gray-600 hover:text-blue-600 transition">
                <i class="fas fa-arrow-left mr-2"></i>
                Retour à la liste
            </a>
        </div>

        @if (session('success'))
            <div
                class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded flex items-center gap-2">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

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

        <div class="bg-white shadow-lg rounded-xl p-8 max-w-2xl">
            <form action="{{ route('admin.hero-slides.update', $heroSlide->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Image Actuelle -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        <i class="fas fa-image mr-2"></i>
                        Image actuelle
                    </label>
                    @if ($heroSlide->image_path)
                        <div class="relative inline-block group">
                            <img src="{{ Storage::url($heroSlide->image_path) }}"
                                class="w-64 h-40 object-cover rounded-lg border-2 border-gray-200 shadow-md cursor-pointer hover:border-blue-400 transition"
                                onclick="openModal('{{ Storage::url($heroSlide->image_path) }}')">
                            <div
                                class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 rounded-lg transition flex items-center justify-center">
                                <i
                                    class="fas fa-search-plus text-white text-2xl opacity-0 group-hover:opacity-100 transition"></i>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Nouvelle Image -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        <i class="fas fa-upload mr-2"></i>
                        Nouvelle image (optionnel)
                    </label>

                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-blue-400 transition"
                        id="drop-zone" ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)"
                        ondrop="handleDrop(event)">
                        <div class="space-y-4">
                            <div class="flex justify-center">
                                <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center">
                                    <i class="fas fa-cloud-upload-alt text-3xl text-blue-600"></i>
                                </div>
                            </div>

                            <label for="image"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 cursor-pointer transition">
                                <i class="fas fa-folder-open"></i>
                                <span>Choisir un nouveau fichier</span>
                                <input id="image" name="image" type="file" class="hidden" accept="image/*"
                                    onchange="previewImage(event)">
                            </label>

                            <p class="text-xs text-gray-500">
                                <i class="fas fa-info-circle mr-1"></i>
                                Laisser vide pour garder l'image actuelle
                            </p>
                        </div>
                    </div>

                    @error('image')
                        <p class="mt-3 text-sm text-red-600 flex items-center gap-2">
                            <i class="fas fa-exclamation-triangle"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Aperçu -->
                <div id="preview-container" class="hidden mb-6">
                    <p class="text-sm text-gray-600 mb-2 font-semibold">Aperçu du nouveau :</p>
                    <div class="relative inline-block">
                        <img id="image-preview" class="w-64 h-40 object-cover rounded-lg border-2 border-blue-300 shadow-md"
                            src="#" alt="Aperçu">
                        <button type="button" onclick="removePreview()"
                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-8 h-8 flex items-center justify-center hover:bg-red-600 transition shadow-lg">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <!-- Ordre -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-sort mr-2"></i>
                        Ordre d'affichage
                    </label>
                    <input type="number" name="order" min="0" value="{{ $heroSlide->order }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>

                <!-- Statut Actif -->
                <div class="mb-6">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ $heroSlide->is_active ? 'checked' : '' }}
                            class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500">
                        <span class="text-sm font-medium text-gray-700">
                            <i class="fas fa-check-circle text-green-500 mr-1"></i>
                            Activer ce slide
                        </span>
                    </label>
                </div>

                <!-- Actions -->
                <div class="flex gap-3 pt-6 border-t border-gray-200">
                    <button type="submit"
                        class="flex-1 flex items-center justify-center gap-2 bg-blue-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-blue-700 transition shadow-md">
                        <i class="fas fa-save"></i>
                        <span>Mettre à jour le slide</span>
                    </button>
                    <a href="{{ route('admin.hero-slides.index') }}"
                        class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition text-center">
                        <i class="fas fa-times mr-2"></i>
                        Annuler
                    </a>
                </div>
            </form>
        </div>

        <!-- Modal -->
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

    <script>
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
                document.getElementById('image').files = files;
                previewImage({
                    target: {
                        files: files
                    }
                });
            }
        }

        function previewImage(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('image-preview');
            const container = document.getElementById('preview-container');

            if (file && file.type.match('image.*')) {
                const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
                if (sizeMB > 2) {
                    alert('⚠️ Fichier trop volumineux (' + sizeMB + ' MB). Max : 2 MB');
                    event.target.value = '';
                    return;
                }
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    container.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        }

        function removePreview() {
            document.getElementById('image').value = '';
            document.getElementById('preview-container').classList.add('hidden');
        }

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

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeModal();
        });
    </script>
@endsection
