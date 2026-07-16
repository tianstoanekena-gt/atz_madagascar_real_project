@extends('admin.layouts.master')
@section('title', 'Stats Nutrition')

@section('content')
    <section class="content_contents">
        <div class="container mx-auto px-4 py-6">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <i class="fas fa-utensils text-3xl text-blue-600"></i>
                    <h1 class="text-2xl font-bold text-gray-800">Stats Nutrition</h1>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.stats.nutrition.create') }}"
                        class="flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition shadow-md">
                        <i class="fas fa-plus-circle"></i><span>Ajouter</span>
                    </a>
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center gap-2 text-gray-600 hover:text-blue-600 transition"><i
                            class="fas fa-arrow-left"></i><span>Tableau de bord</span></a>
                </div>
            </div>

            @if (session('success'))
                <div
                    class="mb-6 flex items-center gap-3 bg-green-100 border-l-4 border-green-500 text-green-700 px-6 py-4 rounded-lg">
                    <i class="fas fa-check-circle text-2xl"></i><span>{{ session('success') }}</span>
                </div>
            @endif

            @if ($stats->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($stats as $stat)
                        <div
                            class="bg-white rounded-xl shadow-md hover:shadow-lg transition border border-gray-100 overflow-hidden relative group">
                            <div class="absolute top-3 right-3 flex gap-2 opacity-0 group-hover:opacity-100 transition">
                                <a href="{{ route('admin.stats.nutrition.edit', $stat->id) }}"
                                    class="bg-orange-100 text-orange-600 p-2 rounded-full hover:bg-orange-200 transition"><i
                                        class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.stats.nutrition.destroy', $stat->id) }}" method="POST"
                                    onsubmit="return confirm('Supprimer ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-100 text-red-600 p-2 rounded-full hover:bg-red-200 transition"><i
                                            class="fas fa-trash"></i></button>
                                </form>
                            </div>

                            <div class="p-6 text-center">
                                <div
                                    class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-orange-100 text-orange-600 mb-4">
                                    <i class="fas fa-bowl-food text-2xl"></i>
                                </div>
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-700 mb-3 inline-block">{{ $stat->year }}</span>

                                <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $stat->label }}</h3>

                                <div class="flex items-center justify-center gap-2 mb-3">
                                    <span
                                        class="text-4xl font-extrabold text-blue-600">{{ number_format($stat->value, 0, ',', ' ') }}</span>
                                    @if ($stat->unit)
                                        <span class="text-sm font-medium text-gray-500">{{ $stat->unit }}</span>
                                    @endif
                                </div>

                                @if ($stat->detail)
                                    <p class="text-xs text-gray-500 mt-3 pt-3 border-t border-gray-100 italic">
                                        {{ $stat->detail }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                @if ($stats->hasPages())
                    <div class="mt-8">{{ $stats->links() }}</div>
                @endif
            @else
                <div class="text-center py-16 bg-white rounded-xl shadow-sm border border-dashed border-gray-300">
                    <i class="fas fa-utensils text-5xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-bold text-gray-700 mb-2">Aucune statistique nutrition</h3>
                    <a href="{{ route('admin.stats.nutrition.create') }}"
                        class="inline-flex items-center gap-2 text-blue-600 font-medium hover:underline mt-2"><i
                            class="fas fa-plus"></i> Ajouter la première stat</a>
                </div>
            @endif
        </div>
    </section>
@endsection
