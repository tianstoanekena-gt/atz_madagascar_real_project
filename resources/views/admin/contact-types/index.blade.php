@extends('admin.layouts.master')

@section('content')
    <div class="container mx-auto px-4 py-6">

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center gap-3">
                <i class="fas fa-address-book text-3xl text-blue-600"></i>
                <h1 class="text-2xl font-bold text-gray-800">Types de Contacts</h1>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.contact-types.create') }}"
                    class="flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition shadow-md">
                    <i class="fas fa-plus-circle"></i>
                    <span>Ajouter un Type</span>
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
            @if ($contactTypes->count() > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Ordre</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Icône</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Nom</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Slug</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">URL Template</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Statut</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-600 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($contactTypes as $type)
                            <tr class="hover:bg-blue-50 transition">
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-700">
                                        #{{ $type->order }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <i class="{{ $type->icon_class }} text-2xl text-blue-600"></i>
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $type->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $type->slug }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 font-mono">
                                    {{ Str::limit($type->url_template, 30) }}</td>
                                <td class="px-6 py-4">
                                    @if ($type->is_active)
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                            <i class="fas fa-check-circle mr-1"></i>Actif
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                            <i class="fas fa-pause-circle mr-1"></i>Inactif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-3">
                                        <a href="{{ route('admin.contact-types.edit', $type->id) }}"
                                            class="text-orange-600 hover:text-orange-900 transition">
                                            <i class="fas fa-edit text-lg"></i>
                                        </a>
                                        <form action="{{ route('admin.contact-types.destroy', $type->id) }}" method="POST"
                                            class="inline" onsubmit="return confirm('Supprimer ce type de contact ?')">
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
                    {{ $contactTypes->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <div class="w-24 h-24 bg-blue-100 rounded-full mx-auto mb-6 flex items-center justify-center">
                        <i class="fas fa-address-book text-5xl text-blue-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Aucun type de contact</h3>
                    <p class="text-gray-500 mb-8">Commencez par ajouter vos premiers types de contacts (Email, WhatsApp,
                        etc.)</p>
                    <a href="{{ route('admin.contact-types.create') }}"
                        class="inline-flex items-center gap-2 bg-blue-600 text-white px-8 py-4 rounded-xl font-semibold hover:bg-blue-700 transition">
                        <i class="fas fa-plus-circle"></i>
                        <span>Ajouter le premier type</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
