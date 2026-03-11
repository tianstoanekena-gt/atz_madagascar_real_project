@extends('admin.layouts.master')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
    <div class="container mx-auto px-4 py-6">

        <!-- Header avec CTA -->
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center gap-3">
                <i class="fas fa-images text-3xl text-blue-600"></i>
                <h1 class="text-2xl font-bold text-gray-800">Gestion des Slides Hero</h1>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.hero-slides.create') }}"
                    class="flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition shadow-md hover:shadow-lg transform hover:scale-105">
                    <i class="fas fa-plus-circle"></i>
                    <span>Ajouter un Slide</span>
                </a>
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-2 text-gray-600 hover:text-blue-600 transition">
                    <i class="fas fa-arrow-left"></i>
                    <span>Tableau de bord</span>
                </a>
            </div>
        </div>

        <!-- Messages de succès -->
        @if (session('success'))
            <div
                class="mb-6 flex items-center gap-3 bg-green-100 border-l-4 border-green-500 text-green-700 px-6 py-4 rounded-lg shadow-sm">
                <i class="fas fa-check-circle text-2xl"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Liste des slides -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            @if ($slides->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                    Ordre
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                    Aperçu
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                    Statut
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                    Date
                                </th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($slides as $slide)
                                <tr class="hover:bg-blue-50 transition-colors duration-150">
                                    <!-- Ordre -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center justify-center w-10 h-10 bg-blue-100 text-blue-600 rounded-full font-bold">
                                            {{ $slide->order }}
                                        </span>
                                    </td>

                                    <!-- Aperçu -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="relative group cursor-pointer"
                                            onclick="openModal('{{ Storage::url($slide->image_path) }}')">
                                            <img src="{{ Storage::url($slide->image_path) }}"
                                                alt="Slide #{{ $slide->id }}"
                                                class="w-32 h-20 object-cover rounded-lg border-2 border-gray-200 hover:border-blue-400 transition">
                                            <div
                                                class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 rounded-lg transition flex items-center justify-center">
                                                <i
                                                    class="fas fa-search-plus text-white text-xl opacity-0 group-hover:opacity-100 transition"></i>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Statut -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($slide->is_active)
                                            <span
                                                class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-700">
                                                <i class="fas fa-check-circle"></i>
                                                Actif
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-600">
                                                <i class="fas fa-pause-circle"></i>
                                                Inactif
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Date -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <i class="far fa-calendar-alt text-gray-400 mr-1"></i>
                                            {{ $slide->created_at->format('d/m/Y') }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            <i class="far fa-clock text-gray-400 mr-1"></i>
                                            {{ $slide->created_at->format('H:i') }}
                                        </div>
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <div class="flex items-center justify-end gap-3">
                                            <!-- Voir -->
                                            <button onclick="openModal('{{ Storage::url($slide->image_path) }}')"
                                                class="text-blue-600 hover:text-blue-900 transition transform hover:scale-110"
                                                title="Voir en grand">
                                                <i class="fas fa-eye text-lg"></i>
                                            </button>

                                            <!-- Modifier -->
                                            <a href="{{ route('admin.hero-slides.edit', $slide->id) }}"
                                                class="text-orange-600 hover:text-orange-900 transition transform hover:scale-110"
                                                title="Modifier" disabled>
                                                <i class="fas fa-edit text-lg"></i>
                                            </a>

                                            <!-- Supprimer -->
                                            <form action="{{ route('admin.hero-slides.destroy', $slide->id) }}"
                                                method="POST" class="inline"
                                                onsubmit="return confirmDelete(event, {{ $slide->id }})">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900 transition transform hover:scale-110"
                                                    title="Supprimer">
                                                    <i class="fas fa-trash text-lg"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-16">
                    <div class="inline-flex items-center justify-center w-24 h-24 bg-blue-100 rounded-full mb-6">
                        <i class="fas fa-images text-5xl text-blue-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Aucun slide pour le moment</h3>
                    <p class="text-gray-500 mb-8 max-w-md mx-auto">
                        Commencez par ajouter votre premier slide pour la section hero de votre site.
                    </p>
                    <a href="{{ route('admin.hero-slides.create') }}"
                        class="inline-flex items-center gap-2 bg-blue-600 text-white px-8 py-4 rounded-xl font-semibold hover:bg-blue-700 transition shadow-lg hover:shadow-xl transform hover:scale-105">
                        <i class="fas fa-plus-circle text-xl"></i>
                        <span>Ajouter votre premier slide</span>
                    </a>
                </div>
            @endif
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

        function confirmDelete(event, id) {
            event.preventDefault();
            if (confirm('⚠️ Êtes-vous sûr de vouloir supprimer le slide #' + id + ' ?')) {
                event.target.submit();
            }
            return false;
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeModal();
        });
    </script>
@endsection
