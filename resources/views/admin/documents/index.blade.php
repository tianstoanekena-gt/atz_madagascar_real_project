@extends('admin.layouts.master')

@section('title', 'Gestion des Documents')

@section('content')
    <section class="content_contents">
        <div class="container mx-auto px-4 py-6">

            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <i class="fas fa-file-alt text-3xl text-blue-600"></i>
                    <h1 class="text-2xl font-bold text-gray-800">Gestion des Documents</h1>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.documents.create') }}"
                        class="flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition shadow-md">
                        <i class="fas fa-plus-circle"></i>
                        <span>Ajouter un document</span>
                    </a>
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center gap-2 text-gray-600 hover:text-blue-600 transition">
                        <i class="fas fa-arrow-left"></i>
                        <span>Tableau de bord</span>
                    </a>
                </div>
            </div>

            <!-- Stats rapides -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white shadow-md rounded-xl p-4 flex items-center gap-4 hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-file-pdf text-red-600 text-xl"></i>
                    </div>
                    <div>
                        <span
                            class="block text-2xl font-bold text-gray-800">{{ \App\Models\Document::ofType('pdf')->count() }}</span>
                        <span class="text-sm text-gray-500">PDF</span>
                    </div>
                </div>
                <div class="bg-white shadow-md rounded-xl p-4 flex items-center gap-4 hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-file-word text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <span
                            class="block text-2xl font-bold text-gray-800">{{ \App\Models\Document::ofType('word')->count() }}</span>
                        <span class="text-sm text-gray-500">Word</span>
                    </div>
                </div>
                <div class="bg-white shadow-md rounded-xl p-4 flex items-center gap-4 hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-file-excel text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <span
                            class="block text-2xl font-bold text-gray-800">{{ \App\Models\Document::ofType('excel')->count() }}</span>
                        <span class="text-sm text-gray-500">Excel</span>
                    </div>
                </div>
                <div class="bg-white shadow-md rounded-xl p-4 flex items-center gap-4 hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-file-powerpoint text-orange-600 text-xl"></i>
                    </div>
                    <div>
                        <span
                            class="block text-2xl font-bold text-gray-800">{{ \App\Models\Document::ofType('powerpoint')->count() }}</span>
                        <span class="text-sm text-gray-500">PowerPoint</span>
                    </div>
                </div>
            </div>

            <!-- Messages de feedback -->
            @if (session('success'))
                <div
                    class="mb-6 flex items-center gap-3 bg-green-100 border-l-4 border-green-500 text-green-700 px-6 py-4 rounded-lg">
                    <i class="fas fa-check-circle text-2xl"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div
                    class="mb-6 flex items-start gap-3 bg-red-100 border-l-4 border-red-500 text-red-700 px-6 py-4 rounded-lg">
                    <i class="fas fa-exclamation-circle text-2xl mt-1"></i>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Tableau des documents -->
            <div class="bg-white shadow-lg rounded-xl overflow-hidden">
                @if ($documents->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Document</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Type</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Taille</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Vues</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">
                                        Téléchargements</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Statut</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Ordre</th>
                                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-600 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($documents as $document)
                                    <tr class="hover:bg-blue-50 transition">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-10 h-10 rounded-lg flex items-center justify-center {{ $document->type_class }}">
                                                    <i class="fas {{ $document->icon }} text-white"></i>
                                                </div>
                                                <div>
                                                    <strong class="text-gray-900">{{ $document->title }}</strong>
                                                    <br>
                                                    <small
                                                        class="text-gray-500">{{ $document->file_original_name }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-medium
                                                {{ $document->file_type === 'pdf'
                                                    ? 'bg-red-100 text-red-700'
                                                    : ($document->file_type === 'word'
                                                        ? 'bg-blue-100 text-blue-700'
                                                        : ($document->file_type === 'excel'
                                                            ? 'bg-green-100 text-green-700'
                                                            : 'bg-orange-100 text-orange-700')) }}">
                                                {{ strtoupper($document->file_type) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $document->formatted_size }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            {{ number_format($document->view_count) }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            {{ number_format($document->download_count) }}</td>
                                        <td class="px-6 py-4">
                                            @if ($document->is_published)
                                                <span
                                                    class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                                    <i class="fas fa-check-circle mr-1"></i>Publié
                                                </span>
                                            @else
                                                <span
                                                    class="px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                                    <i class="fas fa-pause-circle mr-1"></i>Brouillon
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">#{{ $document->order }}</td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex justify-end gap-2">
                                                <a href="{{ route('admin.documents.edit', $document->id) }}"
                                                    class="text-orange-600 hover:text-orange-900 transition p-2"
                                                    title="Modifier">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.documents.destroy', $document->id) }}"
                                                    method="POST" class="inline"
                                                    onsubmit="return confirm('Supprimer ce document ? Cette action est irréversible.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-900 transition p-2"
                                                        title="Supprimer">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-16">
                                            <div
                                                class="w-20 h-20 bg-blue-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                                                <i class="fas fa-folder-open text-4xl text-blue-600"></i>
                                            </div>
                                            <h3 class="text-xl font-bold text-gray-900 mb-2">Aucun document</h3>
                                            <p class="text-gray-500 mb-6">Commencez par ajouter votre premier document</p>
                                            <a href="{{ route('admin.documents.create') }}"
                                                class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition">
                                                <i class="fas fa-plus-circle"></i>
                                                <span>Ajouter le premier document</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if ($documents->hasPages())
                        <div class="px-6 py-4 bg-gray-50 border-t">
                            {{ $documents->links() }}
                        </div>
                    @endif
                @endif
            </div>

        </div>
    </section>
@endsection
