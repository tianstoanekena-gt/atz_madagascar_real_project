@extends('admin.layouts.master')
@section('title', 'Gestion des Activités')

@section('content')
    <section class="content_contents">
        <div class="container mx-auto px-4 py-6">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <i class="fas fa-hands-helping text-3xl text-blue-600"></i>
                    <h1 class="text-2xl font-bold text-gray-800">Gestion des Activités</h1>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.activities.create') }}"
                        class="flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition shadow-md">
                        <i class="fas fa-plus-circle"></i><span>Nouvelle activité</span>
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

            @if ($activities->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($activities as $activity)
                        <div
                            class="bg-white rounded-xl shadow-md hover:shadow-lg transition border border-gray-100 overflow-hidden relative group">
                            <div
                                class="absolute top-3 right-3 flex gap-2 opacity-0 group-hover:opacity-100 transition z-10">
                                <a href="{{ route('admin.activities.edit', $activity->id) }}"
                                    class="bg-orange-100 text-orange-600 p-2 rounded-full hover:bg-orange-200 transition"><i
                                        class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.activities.destroy', $activity->id) }}" method="POST"
                                    onsubmit="return confirm('Supprimer cette activité ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-100 text-red-600 p-2 rounded-full hover:bg-red-200 transition"><i
                                            class="fas fa-trash"></i></button>
                                </form>
                            </div>

                            {{-- Image Hero --}}
                            <div class="h-48 bg-gray-200 relative overflow-hidden">
                                @if ($activity->hero_image)
                                    <img src="{{ Storage::url($activity->hero_image) }}" alt="{{ $activity->title }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div class="flex items-center justify-center h-full text-gray-400">
                                        <i class="fas fa-image text-4xl"></i>
                                    </div>
                                @endif
                                <div class="absolute top-3 left-3">
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-400 text-gray-900 shadow-sm">{{ strtoupper($activity->category) }}</span>
                                </div>
                            </div>

                            <div class="p-5">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-lg font-bold text-gray-800 line-clamp-2">{{ $activity->title }}</h3>
                                    @if ($activity->is_published)
                                        <span class="text-green-500 text-xs font-semibold ml-2"><i
                                                class="fas fa-check-circle"></i></span>
                                    @else
                                        <span class="text-gray-400 text-xs font-semibold ml-2"><i
                                                class="fas fa-pause-circle"></i></span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-500 line-clamp-3 mb-4">
                                    {{ Str::limit($activity->description, 100) }}</p>

                                <div class="flex justify-between items-center text-xs text-gray-400 border-t pt-3">
                                    <span><i class="fas fa-images mr-1"></i> {{ count($activity->gallery ?? []) }}
                                        photos</span>
                                    <span>Ordre: {{ $activity->order }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if ($activities->hasPages())
                    <div class="mt-8">{{ $activities->links() }}</div>
                @endif
            @else
                <div class="text-center py-16 bg-white rounded-xl shadow-sm border border-dashed border-gray-300">
                    <i class="fas fa-hands-helping text-5xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-bold text-gray-700 mb-2">Aucune activité</h3>
                    <a href="{{ route('admin.activities.create') }}"
                        class="inline-flex items-center gap-2 text-blue-600 font-medium hover:underline mt-2"><i
                            class="fas fa-plus"></i> Créer la première activité</a>
                </div>
            @endif
        </div>
    </section>
@endsection
