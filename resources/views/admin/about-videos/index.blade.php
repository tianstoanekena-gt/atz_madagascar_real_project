@extends('admin.layouts.master')

@section('content')
    <div class="container mx-auto px-4 py-6">

        <!-- Header avec CTA -->
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center gap-3">
                <i class="fab fa-youtube text-3xl text-red-600"></i>
                <h1 class="text-2xl font-bold text-gray-800">Gestion des Vidéos About</h1>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.about-videos.create') }}"
                    class="flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition shadow-md hover:shadow-lg transform hover:scale-105">
                    <i class="fas fa-plus-circle"></i>
                    <span>Ajouter une Vidéo</span>
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

        <!-- Liste des vidéos -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            @if ($videos->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">ID
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                    Langue</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">URL
                                    YouTube</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                    Date</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($videos as $video)
                                <tr class="hover:bg-blue-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-600 rounded-full font-bold text-sm">
                                            {{ $video->id }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($video->lang === 'mg')
                                            <span
                                                class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-700">
                                                <i class="fas fa-language"></i> Malagasy
                                            </span>
                                        @elseif ($video->lang === 'fr')
                                            <span
                                                class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-700">
                                                <i class="fas fa-language"></i> Français
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-700">
                                                <i class="fas fa-language"></i> English
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ $video->video_url }}" target="_blank"
                                            class="text-blue-600 hover:underline text-sm">
                                            <i class="fab fa-youtube mr-1"></i>
                                            {{ Str::limit($video->video_url, 50) }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <i class="far fa-calendar-alt text-gray-400 mr-1"></i>
                                            {{ $video->created_at->format('d/m/Y') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <div class="flex items-center justify-end gap-3">
                                            <a href="{{ $video->video_url }}" target="_blank"
                                                class="text-blue-600 hover:text-blue-900 transition transform hover:scale-110"
                                                title="Voir">
                                                <i class="fas fa-eye text-lg"></i>
                                            </a>
                                            <a href="{{ route('admin.about-videos.edit', $video->id) }}"
                                                class="text-orange-600 hover:text-orange-900 transition transform hover:scale-110"
                                                title="Modifier">
                                                <i class="fas fa-edit text-lg"></i>
                                            </a>
                                            <form action="{{ route('admin.about-videos.destroy', $video->id) }}"
                                                method="POST" class="inline"
                                                onsubmit="return confirmDelete(event, {{ $video->id }})">
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
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    {{ $videos->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <div class="inline-flex items-center justify-center w-24 h-24 bg-red-100 rounded-full mb-6">
                        <i class="fab fa-youtube text-5xl text-red-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Aucune vidéo pour le moment</h3>
                    <p class="text-gray-500 mb-8 max-w-md mx-auto">
                        Ajoutez vos vidéos YouTube pour les 3 langues (Malagasy, Français, English).
                    </p>
                    <a href="{{ route('admin.about-videos.create') }}"
                        class="inline-flex items-center gap-2 bg-blue-600 text-white px-8 py-4 rounded-xl font-semibold hover:bg-blue-700 transition shadow-lg hover:shadow-xl transform hover:scale-105">
                        <i class="fas fa-plus-circle text-xl"></i>
                        <span>Ajouter votre première vidéo</span>
                    </a>
                </div>
            @endif
        </div>

    </div>

    <script>
        function confirmDelete(event, id) {
            event.preventDefault();
            if (confirm('⚠️ Êtes-vous sûr de vouloir supprimer cette vidéo ?')) {
                event.target.submit();
            }
            return false;
        }
    </script>
@endsection
