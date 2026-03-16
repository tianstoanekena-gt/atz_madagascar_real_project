@extends('admin.layouts.master')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
    <div class="container mx-auto px-4 py-6">

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center gap-3">
                <i class="fas fa-hands-helping text-3xl text-blue-600"></i>
                <h1 class="text-2xl font-bold text-gray-800">Gestion des Interventions</h1>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.about-interventions.create') }}"
                    class="flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition shadow-md">
                    <i class="fas fa-plus-circle"></i>
                    <span>Ajouter une Intervention</span>
                </a>
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-2 text-gray-600 hover:text-blue-600 transition">
                    <i class="fas fa-arrow-left"></i>
                    <span>Tableau de bord</span>
                </a>
            </div>
        </div>

        @if (session('success'))
            <div
                class="mb-6 flex items-center gap-3 bg-green-100 border-l-4 border-green-500 text-green-700 px-6 py-4 rounded-lg">
                <i class="fas fa-check-circle text-2xl"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            @if ($interventions->count() > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">ID</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Ordre</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Image</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Traductions</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-600 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($interventions as $intervention)
                            <tr class="hover:bg-blue-50 transition">
                                <td class="px-6 py-4">
                                    <span
                                        class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full font-bold text-sm inline-flex items-center justify-center">
                                        {{ $intervention->id }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-700">
                                        #{{ $intervention->order }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if (Storage::disk('public')->exists($intervention->image))
                                        <img src="{{ Storage::url($intervention->image) }}" alt="Image"
                                            class="w-20 h-16 object-cover rounded-lg border-2 border-gray-200">
                                    @else
                                        <span class="text-red-500 text-sm">Introuvable</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2">
                                        @foreach ($intervention->translations as $translation)
                                            <span
                                                class="px-2 py-1 rounded text-xs font-medium
                                                @if ($translation->lang === 'mg') bg-purple-100 text-purple-700
                                                @elseif ($translation->lang === 'fr') bg-blue-100 text-blue-700
                                                @else bg-green-100 text-green-700 @endif">
                                                {{ strtoupper($translation->lang) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-3">
                                        <a href="{{ route('admin.about-interventions.edit', $intervention->id) }}"
                                            class="text-orange-600 hover:text-orange-900 transition">
                                            <i class="fas fa-edit text-lg"></i>
                                        </a>
                                        <form action="{{ route('admin.about-interventions.destroy', $intervention->id) }}"
                                            method="POST" class="inline"
                                            onsubmit="return confirm('Supprimer cette intervention ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600 hover:text-red-900 transition">
                                                <i class="fas fa-trash text-lg"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="px-6 py-4 bg-gray-50 border-t">
                    {{ $interventions->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <div class="w-24 h-24 bg-blue-100 rounded-full mx-auto mb-6 flex items-center justify-center">
                        <i class="fas fa-hands-helping text-5xl text-blue-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Aucune intervention pour le moment</h3>
                    <p class="text-gray-500 mb-8">Ajoutez vos interventions (Santé, Nutrition, Éducation) avec leurs
                        traductions.</p>
                    <a href="{{ route('admin.about-interventions.create') }}"
                        class="inline-flex items-center gap-2 bg-blue-600 text-white px-8 py-4 rounded-xl font-semibold hover:bg-blue-700 transition">
                        <i class="fas fa-plus-circle"></i>
                        <span>Ajouter la première intervention</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
