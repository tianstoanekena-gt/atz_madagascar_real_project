@extends('admin.layouts.master')
@section('title', 'Ajouter une activité')

@section('content')
    <section class="content_contents">
        <div class="container mx-auto px-4 py-6">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <i class="fas fa-plus-circle text-3xl text-blue-600"></i>
                    <h1 class="text-2xl font-bold text-gray-800">Ajouter une activité</h1>
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

            <form action="{{ route('admin.activities.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    {{-- Colonne Gauche --}}
                    <div class="lg:col-span-1 space-y-6">
                        <div class="bg-white shadow-lg rounded-xl p-6 sticky top-6">
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2"><i
                                        class="fas fa-tag mr-2"></i>Catégorie *</label>
                                <input type="text" name="category" value="{{ old('category') }}" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                    placeholder="Ex: Santé, Éducation">
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2"><i
                                        class="fas fa-image mr-2"></i>Image Hero</label>
                                <div id="hero-preview-container" class="mb-3 hidden">
                                    <img id="hero-preview" class="w-full h-32 object-cover rounded-lg border shadow-sm">
                                </div>
                                <input type="file" id="hero-input" name="hero_image" accept="image/*"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 bg-gray-50 cursor-pointer">
                                <p class="text-xs text-gray-500 mt-1">Max 2Mo. JPG, PNG, WEBP.</p>
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-images mr-2"></i>Galerie Photos
                                    <span class="text-xs font-normal text-gray-500 ml-2">(<span
                                            id="gallery-count">0</span>/10)</span>
                                </label>

                                <input type="file" id="gallery-input" name="gallery[]" accept="image/*" multiple
                                    class="hidden">

                                <div id="gallery-dropzone"
                                    class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition-all">
                                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                    <p class="text-sm text-gray-600 font-medium">Cliquez ou glissez vos images ici</p>
                                    <p class="text-xs text-gray-400 mt-1">JPG, PNG, WEBP — Max 2 Mo chacune</p>
                                </div>

                                <div id="gallery-preview" class="grid grid-cols-3 gap-3 mt-4"></div>

                                <p class="text-xs text-gray-500 mt-2"><i class="fas fa-info-circle mr-1"></i> Ajouts
                                    successifs autorisés. Cliquez sur ✕ pour retirer.</p>
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

                    {{-- Colonne Droite --}}
                    <div class="lg:col-span-2 space-y-6">
                        @foreach (['fr' => '🇫🇷 Français', 'mg' => '🇲🇬 Malagasy', 'en' => '🇬🇧 English'] as $locale => $label)
                            <div class="bg-white shadow-lg rounded-xl p-6">
                                <h2 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2"><i
                                        class="fas fa-language mr-2 text-blue-600"></i>{{ $label }} @if ($locale == 'fr')
                                        <span class="text-red-500 text-sm">*</span>
                                    @endif
                                </h2>
                                <div class="mb-4">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Titre *</label>
                                    <input type="text" name="title_{{ $locale }}"
                                        value="{{ old("title_{$locale}") }}" {{ $locale == 'fr' ? 'required' : '' }}
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Description
                                        complète</label>
                                    <textarea name="description_{{ $locale }}" rows="5"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old("description_{$locale}") }}</textarea>
                                </div>
                            </div>
                        @endforeach

                        <div class="flex gap-3">
                            <button type="submit"
                                class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-blue-700 transition shadow-md flex items-center justify-center gap-2">
                                <i class="fas fa-save"></i><span>Enregistrer l'activité</span>
                            </button>
                            <a href="{{ route('admin.activities.index') }}"
                                class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">Annuler</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Hero Preview
            const heroInput = document.getElementById('hero-input');
            const heroPreview = document.getElementById('hero-preview');
            const heroContainer = document.getElementById('hero-preview-container');
            heroInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = (ev) => {
                        heroPreview.src = ev.target.result;
                        heroContainer.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                } else {
                    heroContainer.classList.add('hidden');
                }
            });

            // Gallery Logic
            const galleryInput = document.getElementById('gallery-input');
            const dropzone = document.getElementById('gallery-dropzone');
            const preview = document.getElementById('gallery-preview');
            const countLabel = document.getElementById('gallery-count');
            const MAX_FILES = 10;
            let files = [];

            dropzone.addEventListener('click', () => galleryInput.click());
            dropzone.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropzone.classList.add('border-blue-500', 'bg-blue-50');
            });
            dropzone.addEventListener('dragleave', () => {
                dropzone.classList.remove('border-blue-500', 'bg-blue-50');
            });
            dropzone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropzone.classList.remove('border-blue-500', 'bg-blue-50');
                handleFiles(e.dataTransfer.files);
            });

            galleryInput.addEventListener('change', (e) => {
                handleFiles(e.target.files);
                galleryInput.value = '';
            });

            function handleFiles(newFiles) {
                for (let file of newFiles) {
                    if (!file.type.startsWith('image/')) continue;
                    if (file.size > 2 * 1024 * 1024) {
                        alert(`⚠️ "${file.name}" dépasse 2 Mo.`);
                        continue;
                    }
                    if (files.length >= MAX_FILES) {
                        alert(`⚠️ Maximum ${MAX_FILES} images atteint.`);
                        break;
                    }
                    files.push(file);
                }
                renderPreviews();
            }

            function renderPreviews() {
                preview.innerHTML = '';
                files.forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const div = document.createElement('div');
                        div.className =
                            'relative group aspect-square rounded-lg overflow-hidden border border-gray-200 shadow-sm';
                        div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <button type="button" data-index="${index}" class="remove-btn bg-red-500 text-white w-8 h-8 rounded-full hover:bg-red-600 transition flex items-center justify-center"><i class="fas fa-times"></i></button>
                        </div>
                    `;
                        preview.appendChild(div);
                    };
                    reader.readAsDataURL(file);
                });

                countLabel.textContent = files.length;

                preview.querySelectorAll('.remove-btn').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        files.splice(parseInt(btn.dataset.index), 1);
                        renderPreviews();
                    });
                });

                // Mise à jour native de l'input file (fonctionne sur tous les navigateurs modernes)
                const dt = new DataTransfer();
                files.forEach(f => dt.items.add(f));
                galleryInput.files = dt.files;
            }
        });
    </script>
@endsection
