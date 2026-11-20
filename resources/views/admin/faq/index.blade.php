@extends('admin.layouts.master')

@section('title', 'Gestion des FAQ')

@section('content')
    <section class="content_contents">
        <div class="container mx-auto px-4 py-6">

            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <i class="fas fa-circle-question text-3xl text-blue-600"></i>
                    <h1 class="text-2xl font-bold text-gray-800">Gestion des FAQ</h1>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.faq.create') }}"
                        class="flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition shadow-md">
                        <i class="fas fa-plus-circle"></i>
                        <span>Ajouter une FAQ</span>
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
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-list text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <span class="block text-2xl font-bold text-gray-800">{{ $stats['total'] }}</span>
                        <span class="text-sm text-gray-500">Total FAQ</span>
                    </div>
                </div>
                <div class="bg-white shadow-md rounded-xl p-4 flex items-center gap-4 hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <span class="block text-2xl font-bold text-gray-800">{{ $stats['published'] }}</span>
                        <span class="text-sm text-gray-500">Publiées</span>
                    </div>
                </div>
                <div class="bg-white shadow-md rounded-xl p-4 flex items-center gap-4 hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-pause-circle text-gray-600 text-xl"></i>
                    </div>
                    <div>
                        <span class="block text-2xl font-bold text-gray-800">{{ $stats['draft'] }}</span>
                        <span class="text-sm text-gray-500">Brouillons</span>
                    </div>
                </div>
                <div class="bg-white shadow-md rounded-xl p-4 flex items-center gap-4 hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-folder text-purple-600 text-xl"></i>
                    </div>
                    <div>
                        <span class="block text-2xl font-bold text-gray-800">{{ count($stats['by_category']) }}</span>
                        <span class="text-sm text-gray-500">Catégories</span>
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

            <!-- ✅ NOUVEAU : Barre de filtres et recherche -->
            <div class="bg-white shadow-md rounded-xl p-5 mb-6">
                <form method="GET" action="{{ route('admin.faq.index') }}"
                    class="flex flex-col md:flex-row gap-4 items-end">

                    {{-- Recherche par question --}}
                    <div class="flex-1 min-w-0">
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">
                            <i class="fas fa-search mr-1"></i> Rechercher
                        </label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Rechercher une question..."
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                    </div>

                    {{-- Filtre par catégorie --}}
                    <div class="md:w-64">
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">
                            <i class="fas fa-folder mr-1"></i> Catégorie
                        </label>
                        <select name="category"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm bg-white">
                            <option value="">Toutes les catégories</option>
                            @foreach ($stats['by_category'] as $categoryKey => $categoryData)
                                <option value="{{ $categoryKey }}"
                                    {{ request('category') == $categoryKey ? 'selected' : '' }}>
                                    {{ $categoryData['name'] }} ({{ $categoryData['count'] }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filtre par statut --}}
                    <div class="md:w-48">
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">
                            <i class="fas fa-toggle-on mr-1"></i> Statut
                        </label>
                        <select name="status"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm bg-white">
                            <option value="">Tous les statuts</option>
                            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Publiés
                            </option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Brouillons</option>
                        </select>
                    </div>

                    {{-- Boutons d'action --}}
                    <div class="flex gap-2">
                        <button type="submit"
                            class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium text-sm transition shadow-sm flex items-center gap-2">
                            <i class="fas fa-filter"></i>
                            <span>Filtrer</span>
                        </button>

                        @if (request()->hasAny(['search', 'category', 'status']))
                            <a href="{{ route('admin.faq.index') }}"
                                class="px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium text-sm transition flex items-center gap-2">
                                <i class="fas fa-times"></i>
                                <span>Reset</span>
                            </a>
                        @endif
                    </div>
                </form>

                {{-- Indicateur de filtres actifs --}}
                @if (request()->hasAny(['search', 'category', 'status']))
                    <div class="mt-4 pt-4 border-t border-gray-100 flex flex-wrap items-center gap-2 text-sm">
                        <span class="text-gray-500 font-medium">
                            <i class="fas fa-info-circle mr-1"></i> Filtres actifs :
                        </span>
                        @if (request('search'))
                            <span
                                class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">
                                <i class="fas fa-search"></i> "{{ Str::limit(request('search'), 20) }}"
                            </span>
                        @endif
                        @if (request('category'))
                            <span
                                class="inline-flex items-center gap-1 px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-medium">
                                <i class="fas fa-folder"></i>
                                {{ $stats['by_category'][request('category')]['name'] ?? request('category') }}
                            </span>
                        @endif
                        @if (request('status'))
                            <span
                                class="inline-flex items-center gap-1 px-3 py-1 {{ request('status') == 'published' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }} rounded-full text-xs font-medium">
                                <i
                                    class="fas fa-{{ request('status') == 'published' ? 'check-circle' : 'pause-circle' }}"></i>
                                {{ request('status') == 'published' ? 'Publié' : 'Brouillon' }}
                            </span>
                        @endif
                    </div>
                @endif
            </div>


            <!-- Tableau des FAQs -->
            <div class="bg-white shadow-lg rounded-xl overflow-hidden">
                @if ($faqs->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Ordre</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Catégorie</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Question</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Statut</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Vues</th>
                                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-600 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($faqs as $faq)
                                    <tr class="hover:bg-blue-50 transition">
                                        <td class="px-6 py-4">
                                            <span
                                                class="px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-700">
                                                #{{ $faq->order }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="flex items-center gap-2">
                                                <i class="fas {{ $faq->category_icon }} text-blue-600"></i>
                                                <span
                                                    class="px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                                    {{ $faq->category_name }}
                                                </span>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div>
                                                <strong
                                                    class="text-gray-900">{{ Str::limit($faq->question, 60) }}</strong>
                                                <br>
                                                <small class="text-gray-500">
                                                    {{ $faq->created_at->format('d/m/Y') }}
                                                </small>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($faq->is_published)
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
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            {{ number_format($faq->view_count) }}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex justify-end gap-2">
                                                <a href="{{ route('admin.faq.edit', $faq->id) }}"
                                                    class="text-orange-600 hover:text-orange-900 transition p-2"
                                                    title="Modifier">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.faq.destroy', $faq->id) }}" method="POST"
                                                    class="inline" onsubmit="return confirm('Supprimer cette FAQ ?')">
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
                                        <td colspan="6" class="text-center py-16">
                                            <div
                                                class="w-20 h-20 bg-blue-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                                                <i class="fas fa-circle-question text-4xl text-blue-600"></i>
                                            </div>
                                            <h3 class="text-xl font-bold text-gray-900 mb-2">Aucune FAQ</h3>
                                            <p class="text-gray-500 mb-6">Commencez par ajouter votre première
                                                question/réponse</p>
                                            <a href="{{ route('admin.faq.create') }}"
                                                class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition">
                                                <i class="fas fa-plus-circle"></i>
                                                <span>Ajouter la première FAQ</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if ($faqs->hasPages())
                        <div class="px-6 py-4 bg-gray-50 border-t">
                            {{ $faqs->links() }}
                        </div>
                    @endif
                @endif
            </div>

        </div>
    </section>
@endsection
