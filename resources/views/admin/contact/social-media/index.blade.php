@extends('admin.layouts.master')
@section('title', 'Réseaux Sociaux')

@section('content')
    <section class="content_contents">
        <div class="container mx-auto px-4 py-6">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <i class="fas fa-share-alt text-3xl text-blue-600"></i>
                    <h1 class="text-2xl font-bold text-gray-800">Réseaux Sociaux</h1>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.contact.social-media.create') }}"
                        class="flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition shadow-md">
                        <i class="fas fa-plus-circle"></i><span>Ajouter un réseau</span>
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

            @if ($socialMedias->count() > 0)
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Ordre</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Icône</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Nom du profil
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Lien</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">Statut</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($socialMedias as $social)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-sm text-gray-700 font-medium">{{ $social->order }}</td>
                                    <td class="px-6 py-4">
                                        @if ($social->icon)
                                            <img src="{{ Storage::url($social->icon) }}" alt="{{ $social->name }}"
                                                class="w-10 h-10 object-contain rounded">
                                        @else
                                            <div class="w-10 h-10 bg-gray-200 rounded flex items-center justify-center">
                                                <i class="fas fa-image text-gray-400"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-800 font-medium">{{ $social->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        <a href="{{ $social->url }}" target="_blank"
                                            class="text-blue-600 hover:underline truncate max-w-xs inline-block">
                                            {{ Str::limit($social->url, 40) }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if ($social->is_active)
                                            <span
                                                class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                                <i class="fas fa-check-circle"></i> Actif
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                                <i class="fas fa-times-circle"></i> Inactif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin.contact.social-media.edit', $social->id) }}"
                                                class="bg-orange-100 text-orange-600 p-2 rounded-full hover:bg-orange-200 transition"
                                                title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.contact.social-media.destroy', $social->id) }}"
                                                method="POST" class="inline"
                                                onsubmit="return confirm('Supprimer définitivement ce réseau social ?')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-100 text-red-600 p-2 rounded-full hover:bg-red-200 transition"
                                                    title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-16 bg-white rounded-xl shadow-sm border border-dashed border-gray-300">
                    <i class="fas fa-share-alt text-5xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-bold text-gray-700 mb-2">Aucun réseau social</h3>
                    <a href="{{ route('admin.contact.social-media.create') }}"
                        class="inline-flex items-center gap-2 text-blue-600 font-medium hover:underline mt-2">
                        <i class="fas fa-plus"></i> Ajouter le premier réseau social
                    </a>
                </div>
            @endif
        </div>
    </section>
@endsection
