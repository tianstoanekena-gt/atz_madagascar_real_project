@extends('admin.layouts.master')
@section('title', 'Stats Éducation')

@section('content')
    <section class="content_contents">
        <div class="container mx-auto px-4 py-6">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <i class="fas fa-graduation-cap text-3xl text-blue-600"></i>
                    <h1 class="text-2xl font-bold text-gray-800">Stats Éducation</h1>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.stats.education.create') }}"
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
                        @php
                            $typeColors = [
                                'progress' => 'bg-purple-100 text-purple-700',
                                'percentage' => 'bg-green-100 text-green-700',
                                'chart_bar' => 'bg-blue-100 text-blue-700',
                            ];
                            $typeLabels = [
                                'progress' => 'Progression',
                                'percentage' => 'Pourcentage',
                                'chart_bar' => 'Graphique',
                            ];
                        @endphp
                        <div
                            class="bg-white rounded-xl shadow-md hover:shadow-lg transition border border-gray-100 overflow-hidden relative group">
                            <div class="absolute top-3 right-3 flex gap-2 opacity-0 group-hover:opacity-100 transition">
                                <a href="{{ route('admin.stats.education.edit', $stat->id) }}"
                                    class="bg-orange-100 text-orange-600 p-2 rounded-full hover:bg-orange-200 transition"><i
                                        class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.stats.education.destroy', $stat->id) }}" method="POST"
                                    onsubmit="return confirm('Supprimer ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-100 text-red-600 p-2 rounded-full hover:bg-red-200 transition"><i
                                            class="fas fa-trash"></i></button>
                                </form>
                            </div>

                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-700">{{ $stat->year }}</span>
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-bold {{ $typeColors[$stat->display_type] ?? 'bg-gray-100' }}">
                                        {{ $typeLabels[$stat->display_type] ?? $stat->display_type }}
                                    </span>
                                </div>

                                <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $stat->label }}</h3>
                                @if ($stat->chart_label)
                                    <p class="text-xs text-blue-600 font-medium mb-2"><i class="fas fa-tag mr-1"></i> Barre
                                        : {{ $stat->chart_label }}</p>
                                @endif

                                <div class="flex items-baseline gap-2 mb-3">
                                    <span
                                        class="text-3xl font-extrabold text-blue-600">{{ number_format($stat->value, 0, ',', ' ') }}</span>
                                    @if ($stat->unit)
                                        <span class="text-sm font-medium text-gray-500">{{ $stat->unit }}</span>
                                    @endif
                                </div>

                                @if ($stat->display_type === 'percentage' && $stat->percentage_value)
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 mb-2">
                                        <div class="bg-green-500 h-2.5 rounded-full"
                                            style="width: {{ min($stat->percentage_value, 100) }}%"></div>
                                    </div>
                                    <p class="text-xs text-gray-500">Taux affiché : {{ $stat->percentage_value }}%</p>
                                @endif

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
                    <i class="fas fa-graduation-cap text-5xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-bold text-gray-700 mb-2">Aucune statistique éducation</h3>
                    <a href="{{ route('admin.stats.education.create') }}"
                        class="inline-flex items-center gap-2 text-blue-600 font-medium hover:underline mt-2"><i
                            class="fas fa-plus"></i> Ajouter la première stat</a>
                </div>
            @endif
        </div>
    </section>
@endsection
