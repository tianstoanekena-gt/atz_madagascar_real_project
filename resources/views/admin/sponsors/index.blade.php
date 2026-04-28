@extends('admin.layouts.master')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
    <section class="content_contents">
        <div class="container mx-auto px-4 py-6">

            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <i class="fas fa-handshake text-3xl text-blue-600"></i>
                    <h1 class="text-2xl font-bold text-gray-800">Sponsors & Partenaires</h1>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.sponsors.create') }}"
                        class="flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition shadow-md">
                        <i class="fas fa-plus-circle"></i>
                        <span>Ajouter un Sponsor</span>
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
                @if ($sponsors->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Ordre</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Logo</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Nom</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Site Web</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Depuis</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Statut</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-600 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($sponsors as $sponsor)
                                <tr class="hover:bg-blue-50 transition">
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-700">
                                            #{{ $sponsor->order }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($sponsor->logo && Storage::disk('public')->exists($sponsor->logo))
                                            <img src="{{ Storage::url($sponsor->logo) }}" alt="{{ $sponsor->name }}"
                                                class="w-20 h-16 object-contain border-2 border-gray-200 rounded">
                                        @else
                                            <div class="w-20 h-16 bg-gray-200 rounded flex items-center justify-center">
                                                <i class="fas fa-image text-gray-400"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $sponsor->name }}</td>
                                    <td class="px-6 py-4 text-sm text-blue-600">
                                        @if ($sponsor->website)
                                            <a href="{{ $sponsor->website }}" target="_blank" class="hover:underline">
                                                <i class="fas fa-external-link-alt mr-1"></i>
                                                {{ Str::limit(str_replace(['https://', 'http://', 'www.'], '', $sponsor->website), 30) }}
                                            </a>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        @if ($sponsor->since_year)
                                            <i class="fas fa-calendar mr-1"></i>{{ $sponsor->since_year }}
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($sponsor->is_active)
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                                <i class="fas fa-check-circle mr-1"></i>Actif
                                            </span>
                                        @else
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                                <i class="fas fa-pause-circle mr-1"></i>Inactif
                                            </span>
                                        @endif
                                    </td>
                                    <!-- Dans la colonne Actions -->
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-3">
                                            <!-- Éditer le sponsor (base) -->
                                            <a href="{{ route('admin.sponsors.edit', ['sponsor' => $sponsor->id]) }}"
                                                class="text-orange-600 hover:text-orange-900 transition" title="Éditer">
                                                <i class="fas fa-edit text-lg"></i>
                                            </a>

                                            <!-- Gérer les détails -->
                                            <a href="{{ route('admin.sponsors.details.edit', $sponsor->id) }}"
                                                class="text-blue-600 hover:text-blue-900 transition"
                                                title="Gérer les détails">
                                                <i class="fas fa-file-alt text-lg"></i>
                                            </a>

                                            <!-- Supprimer -->
                                            <form action="{{ route('admin.sponsors.destroy', $sponsor->id) }}"
                                                method="POST" class="inline"
                                                onsubmit="return confirm('Supprimer ce sponsor ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-red-600 hover:text-red-900 transition"
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
                    <div class="px-6 py-4 bg-gray-50 border-t">
                        {{ $sponsors->links() }}
                    </div>
                @else
                    <div class="text-center py-16">
                        <div class="w-24 h-24 bg-blue-100 rounded-full mx-auto mb-6 flex items-center justify-center">
                            <i class="fas fa-handshake text-5xl text-blue-600"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Aucun sponsor</h3>
                        <p class="text-gray-500 mb-8">Commencez par ajouter votre premier sponsor/partenaire</p>
                        <a href="{{ route('admin.sponsors.create') }}"
                            class="inline-flex items-center gap-2 bg-blue-600 text-white px-8 py-4 rounded-xl font-semibold hover:bg-blue-700 transition">
                            <i class="fas fa-plus-circle"></i>
                            <span>Ajouter le premier sponsor</span>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
