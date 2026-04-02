@extends('admin.layouts.master')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
    <section class="content_contents">
        <div class="container mx-auto px-4 py-6 overflow-scroll">

            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <i class="fas fa-th-large text-3xl text-blue-600"></i>
                    <h1 class="text-2xl font-bold text-gray-800">Gestion des Cartes About</h1>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.about-cards.create') }}"
                        class="flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition shadow-md">
                        <i class="fas fa-plus-circle"></i>
                        <span>Ajouter une Carte</span>
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
                @if ($cards->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">ID</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Langue</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Icône</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Titre</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Description</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-600 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($cards as $card)
                                <tr class="hover:bg-blue-50 transition">
                                    <td class="px-6 py-4">
                                        <span
                                            class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full font-bold text-sm inline-flex items-center justify-center">
                                            {{ $card->id }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($card->lang === 'mg')
                                            <span
                                                class="px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-700">
                                                <i class="fas fa-language mr-1"></i>Malagasy
                                            </span>
                                        @elseif ($card->lang === 'fr')
                                            <span
                                                class="px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-700">
                                                <i class="fas fa-language mr-1"></i>Français
                                            </span>
                                        @else
                                            <span
                                                class="px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-700">
                                                <i class="fas fa-language mr-1"></i>English
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if (Storage::disk('public')->exists($card->card_icon))
                                            <img src="{{ Storage::url($card->card_icon) }}" alt="Icon"
                                                class="w-12 h-12 object-contain">
                                        @else
                                            <span class="text-red-500 text-sm">Introuvable</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-medium text-gray-900">{{ Str::limit($card->card_title, 30) }}
                                        </p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm text-gray-600 line-clamp-2">
                                            {{ Str::limit($card->card_description, 50) }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-3">
                                            <a href="{{ route('admin.about-cards.edit', $card->id) }}"
                                                class="text-orange-600 hover:text-orange-900 transition">
                                                <i class="fas fa-edit text-lg"></i>
                                            </a>
                                            <form action="{{ route('admin.about-cards.destroy', $card->id) }}"
                                                method="POST" class="inline"
                                                onsubmit="return confirm('Supprimer cette carte ?')">
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
                        {{ $cards->links() }}
                    </div>
                @else
                    <div class="text-center py-16">
                        <div class="w-24 h-24 bg-blue-100 rounded-full mx-auto mb-6 flex items-center justify-center">
                            <i class="fas fa-th-large text-5xl text-blue-600"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Aucune carte pour le moment</h3>
                        <p class="text-gray-500 mb-8">Ajoutez vos cartes (Mission, Vision, Valeurs) pour les 3 langues.</p>
                        <a href="{{ route('admin.about-cards.create') }}"
                            class="inline-flex items-center gap-2 bg-blue-600 text-white px-8 py-4 rounded-xl font-semibold hover:bg-blue-700 transition">
                            <i class="fas fa-plus-circle"></i>
                            <span>Ajouter la première carte</span>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
