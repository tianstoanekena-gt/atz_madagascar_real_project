@extends('admin.layouts.master')
@section('title', 'Ajouter un réseau social')

@section('content')
    <section class="content_contents">
        <div class="container mx-auto px-4 py-6">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <i class="fas fa-plus-circle text-3xl text-blue-600"></i>
                    <h1 class="text-2xl font-bold text-gray-800">Ajouter un réseau social</h1>
                </div>
                <a href="{{ route('admin.contact.social-media.index') }}"
                    class="text-gray-600 hover:text-blue-600 transition">
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

            <form id="social-form" action="{{ route('admin.contact.social-media.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    {{-- Colonne Gauche : Image + Paramètres --}}
                    <div class="lg:col-span-1 space-y-6">
                        <div class="bg-white shadow-lg rounded-xl p-6 sticky top-6">

                            {{-- Upload Icône --}}
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-image mr-2"></i>Icône (image) <span class="text-red-500">*</span>
                                </label>
                                <div id="icon-preview-container" class="mb-3 hidden">
                                    <img id="icon-preview"
                                        class="w-20 h-20 object-contain rounded-lg border bg-white p-2 shadow-sm mx-auto">
                                </div>
                                <input type="file" id="icon-input" name="icon" accept="image/*" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 bg-gray-50 cursor-pointer">
                                <p class="text-xs text-gray-500 mt-1">PNG, JPG, SVG ou WEBP. Max 512 Ko.</p>
                            </div>

                            {{-- Ordre --}}
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-sort mr-2"></i>Ordre d'affichage
                                </label>
                                <input type="number" name="order" value="{{ old('order', 0) }}" min="0"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                <p class="text-xs text-gray-500 mt-1">Plus petit = affiché en premier.</p>
                            </div>

                            {{-- Actif / Inactif --}}
                            <div class="mb-6">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" name="is_active" value="1"
                                        {{ old('is_active', true) ? 'checked' : '' }}
                                        class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500">
                                    <span class="text-sm font-medium text-gray-700">
                                        <i class="fas fa-check-circle text-green-500 mr-1"></i>Actif (visible sur le site)
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Colonne Droite : Informations --}}
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white shadow-lg rounded-xl p-6">
                            <h2 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">
                                <i class="fas fa-info-circle mr-2 text-blue-600"></i>Informations du profil
                            </h2>

                            {{-- Nom du profil --}}
                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nom du profil <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                    placeholder="Ex: Tiantsoa Nekena">
                                <p class="text-xs text-gray-500 mt-1">Le nom qui sera affiché à côté de l'icône.</p>
                            </div>

                            {{-- Lien URL --}}
                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Lien URL <span class="text-red-500">*</span>
                                </label>
                                <input type="url" name="url" value="{{ old('url') }}" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                    placeholder="https://www.facebook.com/ton.profil">
                                <p class="text-xs text-gray-500 mt-1">
                                    Utilise un lien universel : <code>https://wa.me/261...</code> pour WhatsApp,
                                    <code>mailto:...</code> pour email, etc.
                                </p>
                            </div>

                            <div class="flex gap-3 mt-6">
                                <button type="submit" id="submit-btn"
                                    class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-blue-700 transition shadow-md flex items-center justify-center gap-2">
                                    <i class="fas fa-save"></i><span>Enregistrer</span>
                                </button>
                                <a href="{{ route('admin.contact.social-media.index') }}"
                                    class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                                    Annuler
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const iconInput = document.getElementById('icon-input');
            const iconPreview = document.getElementById('icon-preview');
            const iconContainer = document.getElementById('icon-preview-container');

            iconInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = (ev) => {
                        iconPreview.src = ev.target.result;
                        iconContainer.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                } else {
                    iconContainer.classList.add('hidden');
                }
            });

            const form = document.getElementById('social-form');
            const submitBtn = document.getElementById('submit-btn');
            form.addEventListener('submit', function() {
                submitBtn.disabled = true;
                submitBtn.innerHTML =
                    '<i class="fas fa-spinner fa-spin"></i><span>Enregistrement...</span>';
            });
        });
    </script>
@endsection
