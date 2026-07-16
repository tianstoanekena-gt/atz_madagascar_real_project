@extends('admin.layouts.master')
@section('title', 'Stats Principales')

@section('content')
    {{-- Styles pour reproduire exactement le design de la page publique dans l'admin --}}
    <style>
        .admin-stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
            margin-bottom: 40px;
        }

        @media (max-width: 1200px) {
            .admin-stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .admin-stats-grid {
                grid-template-columns: 1fr;
            }
        }

        .admin-stat-card {
            background: white;
            border-radius: 20px;
            padding: 30px 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(13, 163, 216, 0.1);
            transition: all 0.4s ease;
        }

        .admin-stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(13, 163, 216, 0.15);
        }

        .admin-stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #0DA3D8, #FEE002);
            /* Bleu vers Jaune (Primary) */
        }

        /* Actions Admin (Edit/Delete) */
        .admin-stat-actions {
            position: absolute;
            top: 15px;
            right: 15px;
            display: flex;
            gap: 8px;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 10;
        }

        .admin-stat-card:hover .admin-stat-actions {
            opacity: 1;
        }

        .admin-stat-icon {
            width: 60px;
            height: 60px;
            background: rgba(13, 163, 216, 0.1);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .admin-stat-icon i {
            font-size: 2rem;
            color: #0DA3D8;
        }

        .admin-stat-number {
            font-size: 3rem;
            font-weight: bold;
            color: #333;
            line-height: 1;
            display: block;
            margin-bottom: 5px;
        }

        .admin-stat-label {
            font-size: 1rem;
            text-transform: uppercase;
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
            font-weight: 900;
            color: #666;
            display: block;
            margin-bottom: 10px;
            min-height: 2.5rem;
        }

        .admin-stat-trend {
            font-size: 0.85rem;
            padding: 5px 10px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: rgba(110, 157, 46, 0.1);
            color: #6E9D2E;
            font-weight: 600;
        }

        .admin-stat-detail {
            font-size: 0.85rem;
            color: #888;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #f0f0f0;
            font-style: italic;
        }

        .admin-stat-badges {
            position: absolute;
            top: 15px;
            left: 15px;
            display: flex;
            gap: 8px;
        }

        .badge-year {
            font-size: 0.75rem;
            font-weight: bold;
            padding: 4px 10px;
            border-radius: 12px;
            background: #f3f4f6;
            color: #4b5563;
        }

        .badge-status {
            font-size: 0.75rem;
            font-weight: bold;
            padding: 4px 10px;
            border-radius: 12px;
        }

        .badge-published {
            background: rgba(110, 157, 46, 0.1);
            color: #6E9D2E;
        }

        .badge-draft {
            background: #f3f4f6;
            color: #9ca3af;
        }
    </style>

    <section class="content_contents">
        <div class="container mx-auto px-4 py-6">
            {{-- En-tête Admin --}}
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <i class="fas fa-chart-line text-3xl text-blue-600"></i>
                    <h1 class="text-2xl font-bold text-gray-800">Stats Principales</h1>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.stats.main.create') }}"
                        class="flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition shadow-md">
                        <i class="fas fa-plus-circle"></i><span>Ajouter une stat</span>
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

            {{-- Grille des cartes --}}
            @if ($stats->count() > 0)
                <div class="admin-stats-grid">
                    @foreach ($stats as $stat)
                        <div class="admin-stat-card">

                            {{-- Badges (Année & Statut) --}}
                            <div class="admin-stat-badges">
                                <span class="badge-year">{{ $stat->year }}</span>
                                @if ($stat->is_published)
                                    <span class="badge-status badge-published"><i class="fas fa-check-circle"></i>
                                        Publié</span>
                                @else
                                    <span class="badge-status badge-draft"><i class="fas fa-pause-circle"></i>
                                        Brouillon</span>
                                @endif
                            </div>

                            {{-- Actions Admin (au survol) --}}
                            <div class="admin-stat-actions">
                                <a href="{{ route('admin.stats.main.edit', $stat->id) }}"
                                    class="bg-orange-100 text-orange-600 p-2 rounded-full hover:bg-orange-200 transition"
                                    title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.stats.main.destroy', $stat->id) }}" method="POST"
                                    onsubmit="return confirm('Supprimer cette statistique ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-100 text-red-600 p-2 rounded-full hover:bg-red-200 transition"
                                        title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>

                            {{-- Contenu de la carte --}}
                            <div class="admin-stat-icon">
                                <i class="fa-solid fa-{{ $stat->icon ?: 'fa-solid fa-chart-line' }}"></i>
                            </div>

                            <span class="admin-stat-number">{{ number_format($stat->value, 0, ',', ' ') }}</span>
                            <span class="admin-stat-label">{{ $stat->label }}</span>

                            @if ($stat->trend)
                                <div class="admin-stat-trend">
                                    <i class="fas fa-arrow-up"></i> {{ $stat->trend }}
                                </div>
                            @endif

                            @if ($stat->detail)
                                <p class="admin-stat-detail">{{ $stat->detail }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>

                @if ($stats->hasPages())
                    <div class="mt-8">{{ $stats->links() }}</div>
                @endif
            @else
                <div class="text-center py-16 bg-white rounded-xl shadow-sm border border-dashed border-gray-300">
                    <i class="fas fa-chart-line text-5xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-bold text-gray-700 mb-2">Aucune statistique principale</h3>
                    <a href="{{ route('admin.stats.main.create') }}"
                        class="inline-flex items-center gap-2 text-blue-600 font-medium hover:underline mt-2">
                        <i class="fas fa-plus"></i> Ajouter la première stat
                    </a>
                </div>
            @endif
        </div>
    </section>
@endsection
