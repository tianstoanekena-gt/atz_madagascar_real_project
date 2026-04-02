@extends('admin.layouts.master')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
    <section class="content_contents">
        <div class="container mx-auto px-4 py-6">

            <!-- Header avec CTA -->
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <i class="fas fa-images text-3xl text-blue-600"></i>
                    <h1 class="text-2xl font-bold text-gray-800">Gestion des Logos</h1>
                </div>
                <div class="flex gap-3">
                    <!-- CTA Principal : Ajouter un logo -->
                    <a href="{{ route('admin.logos.create') }}"
                        class="flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition shadow-md hover:shadow-lg transform hover:scale-105">
                        <i class="fas fa-plus-circle"></i>
                        <span>Ajouter un Logo</span>
                    </a>

                    <!-- Retour au dashboard -->
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
                    class="mb-6 flex items-center gap-3 bg-green-100 border-l-4 border-green-500 text-green-700 px-6 py-4 rounded-lg shadow-sm animate-pulse">
                    <i class="fas fa-check-circle text-2xl"></i>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Liste des logos -->
            <div class="bg-white shadow-lg rounded-xl overflow-hidden">
                @if ($logos->count() > 0)
                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                <tr>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                        ID
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                        Aperçu
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                        Informations
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th
                                        class="px-6 py-4 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($logos as $logo)
                                    <tr class="hover:bg-blue-50 transition-colors duration-150">
                                        <!-- ID -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <span
                                                    class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-600 rounded-full font-bold text-sm">
                                                    {{ $logo->id }}
                                                </span>
                                            </div>
                                        </td>

                                        <!-- Aperçu -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="relative group cursor-pointer"
                                                onclick="openModal('{{ Storage::url($logo->logo) }}')">
                                                <img src="{{ Storage::url($logo->logo) }}" alt="Logo #{{ $logo->id }}"
                                                    class="w-24 h-24 object-contain rounded-xl border-2 border-gray-200 hover:border-blue-400 transition p-2 bg-gray-50">
                                                <div
                                                    class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 rounded-xl transition flex items-center justify-center">
                                                    <i
                                                        class="fas fa-search-plus text-white text-xl opacity-0 group-hover:opacity-100 transition"></i>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Informations -->
                                        <td class="px-6 py-4">
                                            <div class="text-sm">
                                                <div class="font-medium text-gray-900 mb-1">
                                                    <i class="fas fa-file-image text-blue-500 mr-1"></i>
                                                    {{ basename($logo->logo) }}
                                                </div>
                                                <div class="text-gray-500 text-xs">
                                                    <i class="fas fa-weight-hanging mr-1"></i>
                                                    @if (Storage::disk('public')->exists($logo->logo))
                                                        {{ number_format(Storage::disk('public')->size($logo->logo) / 1024, 2) }}
                                                        KB
                                                    @else
                                                        <span class="text-red-500">Fichier introuvable</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Date -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                <i class="far fa-calendar-alt text-gray-400 mr-1"></i>
                                                {{ $logo->created_at->format('d/m/Y') }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                <i class="far fa-clock text-gray-400 mr-1"></i>
                                                {{ $logo->created_at->format('H:i') }}
                                            </div>
                                        </td>

                                        <!-- Actions -->
                                        <!-- Actions -->
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <div class="flex items-center justify-end gap-3">
                                                <!-- Voir -->
                                                <button onclick="openModal('{{ Storage::url($logo->logo) }}')"
                                                    class="text-blue-600 hover:text-blue-900 transition transform hover:scale-110"
                                                    title="Voir en grand">
                                                    <i class="fas fa-eye text-lg"></i>
                                                </button>

                                                <!-- Télécharger -->
                                                <a href="{{ Storage::url($logo->logo) }}" download
                                                    class="text-green-600 hover:text-green-900 transition transform hover:scale-110"
                                                    title="Télécharger">
                                                    <i class="fas fa-download text-lg"></i>
                                                </a>

                                                <!-- Modifier -->
                                                <a href="{{ route('admin.logos.edit', $logo->id) }}"
                                                    class="text-orange-600 hover:text-orange-900 transition transform hover:scale-110"
                                                    title="Modifier">
                                                    <i class="fas fa-edit text-lg"></i>
                                                </a>

                                                <!-- Supprimer -->
                                                <form action="{{ route('admin.logos.destroy', $logo->id) }}" method="POST"
                                                    class="inline"
                                                    onsubmit="return confirmDelete(event, {{ $logo->id }})">
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

                    <!-- Pagination -->
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                        {{ $logos->links() }}
                    </div>
                @else
                    <!-- État vide avec CTA -->
                    <div class="text-center py-16">
                        <div class="inline-flex items-center justify-center w-24 h-24 bg-blue-100 rounded-full mb-6">
                            <i class="fas fa-image text-5xl text-blue-600"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">
                            Aucun logo pour le moment
                        </h3>
                        <p class="text-gray-500 mb-8 max-w-md mx-auto">
                            Commencez par ajouter votre premier logo pour personnaliser votre site.
                        </p>

                        <!-- CTA dans l'état vide -->
                        <a href="{{ route('admin.logos.create') }}"
                            class="inline-flex items-center gap-2 bg-blue-600 text-white px-8 py-4 rounded-xl font-semibold hover:bg-blue-700 transition shadow-lg hover:shadow-xl transform hover:scale-105">
                            <i class="fas fa-plus-circle text-xl"></i>
                            <span>Ajouter votre premier logo</span>
                        </a>
                    </div>
                @endif
            </div>

            <!-- Statistiques rapides -->
            @if ($logos->count() > 0)
                <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-blue-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Total de logos</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $logos->total() }}</p>
                            </div>
                            <i class="fas fa-images text-3xl text-blue-500"></i>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-green-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Dernier ajout</p>
                                <p class="text-lg font-bold text-gray-900">
                                    {{ $logos->first()->created_at->diffForHumans() }}
                                </p>
                            </div>
                            <i class="fas fa-clock text-3xl text-green-500"></i>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-purple-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Espace utilisé</p>
                                <p class="text-lg font-bold text-gray-900">
                                    @php
                                        $totalSize = 0;
                                        foreach ($logos as $logo) {
                                            if (Storage::disk('public')->exists($logo->logo)) {
                                                $totalSize += Storage::disk('public')->size($logo->logo);
                                            }
                                        }
                                    @endphp
                                    {{ number_format($totalSize / 1024, 2) }} KB
                                </p>
                            </div>
                            <i class="fas fa-hdd text-3xl text-purple-500"></i>
                        </div>
                    </div>
                </div>
            @endif

        </div>

        <!-- Modal pour voir l'image en grand -->
        <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-80 hidden flex items-center justify-center z-50 p-4"
            onclick="closeModal()">
            <div class="relative max-w-5xl w-full" onclick="event.stopPropagation()">
                <img id="modalImage" class="w-full h-auto max-h-[85vh] object-contain rounded-xl shadow-2xl"
                    src="#" alt="Aperçu">
                <button onclick="closeModal()"
                    class="absolute -top-4 -right-4 bg-white text-gray-800 rounded-full w-12 h-12 flex items-center justify-center hover:bg-gray-100 transition shadow-xl hover:rotate-90 transform duration-300">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
    </section>
    <!-- JavaScript -->
    <script>
        // Ouvrir le modal
        function openModal(src) {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            modalImage.src = src;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        // Fermer le modal
        function closeModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Fermer avec la touche Échap
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    </script>
@endsection
