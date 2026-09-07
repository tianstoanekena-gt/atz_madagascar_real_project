@extends('admin.layouts.master')
@section('title', 'Élèves à parrainer')

@section('content')
    <section class="content_contents">
        <div class="container mx-auto px-4 py-6">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <i class="fas fa-child text-3xl text-blue-600"></i>
                    <h1 class="text-2xl font-bold text-gray-800">Élèves à parrainer</h1>
                </div>
                <a href="{{ route('admin.students.create') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                    <i class="fas fa-plus"></i> Ajouter un élève
                </a>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-lg">
                    {{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-lg">{{ session('error') }}
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Élève</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Âge / Niveau</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Objectif</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Progression</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Statut</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($students as $student)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $student->photo_url }}" alt="{{ $student->full_name }}"
                                            class="w-10 h-10 rounded-full object-cover">
                                        <div>
                                            <p class="font-medium text-gray-800">{{ $student->full_name }}</p>
                                            <p class="text-xs text-gray-500">{{ $student->location }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    <p>{{ $student->age }} ans</p>
                                    <p class="text-xs text-gray-500">{{ $student->education_level_label }}</p>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-800 font-medium">
                                    {{ number_format($student->target_amount, 0, ',', ' ') }} Ar
                                </td>
                                <td class="px-6 py-4">
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-blue-600 h-2.5 rounded-full"
                                            style="width: {{ $student->progress }}%"></div>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">{{ $student->progress }}%
                                        ({{ number_format($student->collected_amount, 0, ',', ' ') }} Ar)
                                    </p>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2 py-1 text-xs font-medium rounded-full bg-{{ $student->status_color }}-100 text-{{ $student->status_color }}-700">
                                        {{ $student->status_label }}
                                    </span>
                                    @if ($student->is_featured)
                                        <span class="ml-1 text-yellow-500" title="Mis en avant"><i
                                                class="fas fa-star"></i></span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.students.edit', $student->id) }}"
                                            class="bg-blue-100 text-blue-600 p-2 rounded-full hover:bg-blue-200"><i
                                                class="fas fa-edit"></i></a>
                                        <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST"
                                            onsubmit="return confirm('Supprimer cet élève ?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-100 text-red-600 p-2 rounded-full hover:bg-red-200"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-gray-500">Aucun élève enregistré.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
