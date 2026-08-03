@extends('admin.layouts.master')
@section('title', 'Gestion des Projets')

@section('content')
    <section class="content_contents">
        <div class="container mx-auto px-4 py-6">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <i class="fas fa-project-diagram text-3xl text-blue-600"></i>
                    <h1 class="text-2xl font-bold text-gray-800">Gestion des Projets</h1>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.projects.create') }}"
                        class="flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition shadow-md">
                        <i class="fas fa-plus-circle"></i><span>Nouveau projet</span>
                    </a>
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center gap-2 text-gray-600 hover:text-blue-600 transition">
                        <i class="fas fa-arrow-left"></i><span>Tableau de bord</span>
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div
                    class="mb-6 flex items-center gap-3 bg-green-100 border-l-4 border-green-500 text-green-700 px-6 py-4 rounded-lg">
                    <i class="fas fa-check-circle text-2xl"></i><span>{{ session('success') }}</span>
                </div>
            @endif

            @if ($projects->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($projects as $project)
                        <div
                            class="bg-white rounded-xl shadow-md hover:shadow-lg transition border border-gray-100 overflow-hidden relative group">
                            <div
                                class="absolute top-3 right-3 flex gap-2 opacity-0 group-hover:opacity-100 transition z-10">
                                <a href="{{ route('admin.projects.edit', $project->id) }}"
                                    class="bg-orange-100 text-orange-600 p-2 rounded-full hover:bg-orange-200 transition"><i
                                        class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST"
                                    onsubmit="return confirm('Supprimer définitivement ce projet ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-100 text-red-600 p-2 rounded-full hover:bg-red-200 transition"><i
                                            class="fas fa-trash"></i></button>
                                </form>
                            </div>

                            {{-- Image Hero --}}
                            <div class="h-48 bg-gray-200 relative overflow-hidden">
                                @if ($project->hero_image)
                                    <img src="{{ Storage::url($project->hero_image) }}" alt="{{ $project->title }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div class="flex items-center justify-center h-full text-gray-400">
                                        <i class="fas fa-image text-4xl"></i>
                                    </div>
                                @endif
                                <div class="absolute top-3 left-3 flex gap-2">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold shadow-sm"
                                        style="background-color: {{ $project->category->color_hex ?? '#0DA3D8' }}; color: white;">
                                        {{ strtoupper($project->category->slug) }}
                                    </span>
                                    @if ($project->is_featured)
                                        <span
                                            class="px-2 py-1 rounded-full text-xs font-bold bg-yellow-400 text-gray-900 shadow-sm">
                                            <i class="fas fa-star"></i>
                                        </span>
                                    @endif
                                </div>
                                <div class="absolute bottom-3 left-3">
                                    @if ($project->status === 'completed')
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-bold bg-green-500 text-white">Réalisé</span>
                                    @elseif ($project->status === 'ongoing')
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-500 text-white">En
                                            cours</span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-500 text-gray-900">À
                                            venir</span>
                                    @endif
                                </div>
                            </div>

                            <div class="p-5">
                                <h3 class="text-lg font-bold text-gray-800 line-clamp-2 mb-2">{{ $project->title }}</h3>
                                <p class="text-sm text-gray-500 line-clamp-2 mb-3">
                                    {{ Str::limit($project->short_description, 80) }}</p>

                                {{-- Lieu & Ville --}}
                                @if ($project->city || $project->location)
                                    <div class="flex items-center gap-1 text-xs text-gray-400 mb-3">
                                        <i class="fas fa-map-marker-alt text-red-400"></i>
                                        <span>{{ $project->location }}{{ $project->location && $project->city ? ', ' : '' }}{{ $project->city }}</span>
                                    </div>
                                @endif

                                {{-- Barre de progression --}}
                                @if ($project->target_amount > 0)
                                    <div class="mb-3">
                                        <div class="flex justify-between text-xs text-gray-500 mb-1">
                                            <span>{{ number_format($project->current_amount, 0, ',', ' ') }} Ar</span>
                                            <span>{{ number_format($project->progress_percentage, 0) }}%</span>
                                        </div>
                                        <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                                            <div class="h-full rounded-full transition-all duration-500
                                                @if ($project->status === 'completed') bg-green-500
                                                @elseif ($project->status === 'ongoing') bg-blue-500
                                                @else bg-yellow-500 @endif"
                                                style="width: {{ $project->progress_percentage }}%"></div>
                                        </div>
                                    </div>
                                @endif

                                <div class="flex justify-between items-center text-xs text-gray-400 border-t pt-3">
                                    <span><i class="fas fa-users mr-1"></i> {{ $project->beneficiaries_count ?? 0 }}
                                        bénéficiaires</span>
                                    <span>Ordre: {{ $project->order }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if ($projects->hasPages())
                    <div class="mt-8">{{ $projects->links() }}</div>
                @endif
            @else
                <div class="text-center py-16 bg-white rounded-xl shadow-sm border border-dashed border-gray-300">
                    <i class="fas fa-project-diagram text-5xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-bold text-gray-700 mb-2">Aucun projet</h3>
                    <a href="{{ route('admin.projects.create') }}"
                        class="inline-flex items-center gap-2 text-blue-600 font-medium hover:underline mt-2"><i
                            class="fas fa-plus"></i> Créer le premier projet</a>
                </div>
            @endif
        </div>
    </section>
@endsection
