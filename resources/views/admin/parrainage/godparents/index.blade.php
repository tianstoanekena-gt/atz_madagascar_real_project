@extends('admin.layouts.master')
@section('title', 'Liste des Parrains')

@section('content')
    <section class="content_contents">
        <div class="godparent-list-wrapper">

            {{-- En-tête avec stats --}}
            <div class="list-header">
                <div class="header-title">
                    <div class="title-icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div>
                        <h1 class="page-title">Parrains enregistrés</h1>
                        <p class="page-subtitle">Gérez les parrains de l'association ATZ Madagascar</p>
                    </div>
                </div>
                <a href="{{ route('admin.godparents.create') }}" class="btn-add">
                    <i class="fas fa-plus"></i>
                    <span>Ajouter un parrain</span>
                    <span class="btn-shine"></span>
                </a>
            </div>

            {{-- Stats rapides --}}
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon bg-blue">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <p class="stat-label">Total Parrains</p>
                        <p class="stat-value">{{ $godparents->count() }}</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon bg-green">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <div class="stat-info">
                        <p class="stat-label">Total Donné</p>
                        <p class="stat-value">{{ number_format($godparents->sum('total_donated'), 0, ',', ' ') }}
                            <small>Ar</small>
                        </p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon bg-yellow">
                        <i class="fas fa-child"></i>
                    </div>
                    <div class="stat-info">
                        <p class="stat-label">Enfants Parrainés</p>
                        <p class="stat-value">{{ $godparents->sum('students_count') }}</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon bg-purple">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stat-info">
                        <p class="stat-label">Moyenne par Parrain</p>
                        <p class="stat-value">
                            {{ $godparents->count() > 0 ? number_format($godparents->avg('total_donated'), 0, ',', ' ') : 0 }}
                            <small>Ar</small>
                        </p>
                    </div>
                </div>
            </div>

            {{-- Toast de succès --}}
            @if (session('success'))
                <div class="toast-success">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            {{-- Tableau --}}
            <div class="table-card">
                <div class="table-header">
                    <h2 class="table-title">
                        <i class="fas fa-list"></i>
                        Liste complète
                    </h2>
                    <span class="table-count">{{ $godparents->count() }} parrain(s)</span>
                </div>

                <div class="table-wrapper">
                    <table class="godparent-table">
                        <thead>
                            <tr>
                                <th>
                                    <i class="fas fa-user"></i>
                                    Parrain
                                </th>
                                <th>
                                    <i class="fas fa-address-book"></i>
                                    Contact
                                </th>
                                <th>
                                    <i class="fas fa-heart"></i>
                                    Parrainages
                                </th>
                                <th>
                                    <i class="fas fa-coins"></i>
                                    Total Donné
                                </th>
                                <th class="text-center">
                                    <i class="fas fa-cog"></i>
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($godparents as $godparent)
                                <tr class="godparent-row">
                                    <td>
                                        <div class="godparent-identity">
                                            <div class="avatar">
                                                @if ($godparent->photo)
                                                    <img src="{{ $godparent->photo_url }}"
                                                        alt="{{ $godparent->full_name }}">
                                                @else
                                                    <span
                                                        class="avatar-initial">{{ strtoupper(substr($godparent->first_name, 0, 1)) }}</span>
                                                @endif
                                            </div>
                                            <div class="identity-info">
                                                <p class="godparent-name">{{ $godparent->full_name }}</p>
                                                <p class="godparent-address">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    {{ Str::limit($godparent->address, 30) }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="contact-info">
                                            <a href="mailto:{{ $godparent->email }}" class="contact-item email">
                                                <i class="fas fa-envelope"></i>
                                                <span>{{ $godparent->email }}</span>
                                            </a>
                                            <a href="{{ $godparent->whatsapp_link }}" target="_blank"
                                                class="contact-item whatsapp">
                                                <i class="fab fa-whatsapp"></i>
                                                <span>{{ $godparent->whatsapp }}</span>
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="sponsorships-count">
                                            <span class="count-badge">
                                                <i class="fas fa-child"></i>
                                                {{ $godparent->students_count }}
                                            </span>
                                            <span class="count-label">enfant(s)</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="donation-amount">
                                            <span
                                                class="amount-value">{{ number_format($godparent->total_donated, 0, ',', ' ') }}</span>
                                            <span class="amount-currency">Ar</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.godparents.show', $godparent->id) }}"
                                                class="action-btn view" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.godparents.edit', $godparent->id) }}"
                                                class="action-btn edit" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if ($godparent->sponsorships_count == 0)
                                                <form action="{{ route('admin.godparents.destroy', $godparent->id) }}"
                                                    method="POST" class="inline-form"
                                                    onsubmit="return confirm('Supprimer ce parrain ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="action-btn delete" title="Supprimer">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <span class="action-btn locked" title="Parrain actif - non supprimable">
                                                    <i class="fas fa-lock"></i>
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <div class="empty-state">
                                            <div class="empty-icon">
                                                <i class="fas fa-user-tie"></i>
                                            </div>
                                            <h3 class="empty-title">Aucun parrain enregistré</h3>
                                            <p class="empty-desc">Commencez par ajouter votre premier parrain pour gérer
                                                les parrainages.</p>
                                            <a href="{{ route('admin.godparents.create') }}" class="empty-btn">
                                                <i class="fas fa-plus"></i>
                                                <span>Ajouter un parrain</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <style>
        :root {
            --gp-primary: #0da3d8;
            --gp-primary-dark: #087eaa;
            --gp-secondary: #0d0c43;
            --gp-yellow: #feed02;
            --gp-green: #10b981;
            --gp-purple: #8b5cf6;
            --gp-red: #ef4444;
            --gp-bg: #f8fafc;
            --gp-white: #ffffff;
            --gp-text: #1f2937;
            --gp-muted: #6b7280;
            --gp-border: #e5e7eb;
            --gp-radius: 12px;
            --gp-shadow: 0 4px 20px rgba(13, 12, 67, 0.08);
            --gp-shadow-hover: 0 8px 30px rgba(13, 12, 67, 0.12);
            --gp-transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .godparent-list-wrapper {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        /* HEADER */
        .list-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .header-title {
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }

        .title-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--gp-primary), var(--gp-primary-dark));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            box-shadow: 0 8px 20px rgba(13, 163, 216, 0.3);
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--gp-secondary);
            margin: 0 0 0.25rem 0;
            letter-spacing: -0.02em;
        }

        .page-subtitle {
            color: var(--gp-muted);
            font-size: 0.95rem;
            margin: 0;
        }

        .btn-add {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, var(--gp-primary), var(--gp-primary-dark));
            color: white;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(13, 163, 216, 0.3);
            transition: all var(--gp-transition);
            position: relative;
            overflow: hidden;
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(13, 163, 216, 0.4);
        }

        .btn-shine {
            position: absolute;
            top: 0;
            left: -100%;
            width: 60%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s ease;
        }

        .btn-add:hover .btn-shine {
            left: 130%;
        }

        /* STATS */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.25rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--gp-white);
            border-radius: var(--gp-radius);
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: var(--gp-shadow);
            border: 1px solid var(--gp-border);
            transition: all var(--gp-transition);
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--gp-shadow-hover);
        }

        .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: white;
            flex-shrink: 0;
        }

        .stat-icon.bg-blue {
            background: linear-gradient(135deg, var(--gp-primary), var(--gp-primary-dark));
        }

        .stat-icon.bg-green {
            background: linear-gradient(135deg, var(--gp-green), #059669);
        }

        .stat-icon.bg-yellow {
            background: linear-gradient(135deg, var(--gp-yellow), #d8c900);
            color: var(--gp-secondary);
        }

        .stat-icon.bg-purple {
            background: linear-gradient(135deg, var(--gp-purple), #7c3aed);
        }

        .stat-label {
            font-size: 0.8rem;
            color: var(--gp-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 600;
            margin: 0 0 0.25rem 0;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--gp-secondary);
            margin: 0;
            letter-spacing: -0.02em;
        }

        .stat-value small {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--gp-muted);
            margin-left: 0.25rem;
        }

        /* TOAST */
        .toast-success {
            background: rgba(16, 185, 129, 0.1);
            border-left: 4px solid var(--gp-green);
            color: var(--gp-green);
            padding: 1rem 1.25rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
            animation: slideIn 0.4s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* TABLE CARD */
        .table-card {
            background: var(--gp-white);
            border-radius: var(--gp-radius);
            box-shadow: var(--gp-shadow);
            border: 1px solid var(--gp-border);
            overflow: hidden;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.25rem 1.5rem;
            border-bottom: 2px solid var(--gp-border);
            background: linear-gradient(180deg, #fafbfc 0%, #ffffff 100%);
        }

        .table-title {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--gp-secondary);
            margin: 0;
        }

        .table-title i {
            color: var(--gp-primary);
        }

        .table-count {
            background: rgba(13, 163, 216, 0.1);
            color: var(--gp-primary);
            padding: 0.4rem 0.9rem;
            border-radius: 999px;
            font-size: 0.85rem;
            font-weight: 700;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        .godparent-table {
            width: 100%;
            border-collapse: collapse;
        }

        .godparent-table thead {
            background: #fafbfc;
        }

        .godparent-table thead th {
            padding: 1rem 1.5rem;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--gp-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid var(--gp-border);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .godparent-table thead th i {
            color: var(--gp-primary);
        }

        .godparent-table thead th.text-center {
            text-align: center;
            justify-content: center;
        }

        .godparent-row {
            border-bottom: 1px solid var(--gp-border);
            transition: all var(--gp-transition);
        }

        .godparent-row:hover {
            background: rgba(13, 163, 216, 0.02);
        }

        .godparent-row:last-child {
            border-bottom: none;
        }

        .godparent-row td {
            padding: 1.25rem 1.5rem;
            vertical-align: middle;
        }

        /* IDENTITÉ */
        .godparent-identity {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--gp-primary), var(--gp-primary-dark));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
            flex-shrink: 0;
            overflow: hidden;
            border: 2px solid white;
            box-shadow: 0 2px 8px rgba(13, 163, 216, 0.2);
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-initial {
            text-transform: uppercase;
        }

        .godparent-name {
            font-weight: 700;
            color: var(--gp-secondary);
            margin: 0 0 0.2rem 0;
            font-size: 0.95rem;
        }

        .godparent-address {
            color: var(--gp-muted);
            font-size: 0.8rem;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .godparent-address i {
            color: var(--gp-primary);
            font-size: 0.7rem;
        }

        /* CONTACT */
        .contact-info {
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
        }

        .contact-item {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            color: var(--gp-text);
            text-decoration: none;
            transition: color var(--gp-transition);
        }

        .contact-item.email i {
            color: var(--gp-primary);
        }

        .contact-item.whatsapp i {
            color: var(--gp-green);
        }

        .contact-item:hover {
            color: var(--gp-primary);
        }

        /* PARRAINAGES */
        .sponsorships-count {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .count-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: linear-gradient(135deg, rgba(13, 163, 216, 0.1), rgba(254, 237, 2, 0.15));
            color: var(--gp-primary);
            padding: 0.4rem 0.8rem;
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.85rem;
            width: fit-content;
        }

        .count-badge i {
            font-size: 0.75rem;
        }

        .count-label {
            font-size: 0.75rem;
            color: var(--gp-muted);
        }

        /* DONATION */
        .donation-amount {
            display: flex;
            align-items: baseline;
            gap: 0.3rem;
        }

        .amount-value {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--gp-green);
            letter-spacing: -0.02em;
        }

        .amount-currency {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--gp-muted);
        }

        /* ACTIONS */
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
        }

        .action-btn {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 0.85rem;
            transition: all var(--gp-transition);
            border: none;
            cursor: pointer;
            background: transparent;
        }

        .action-btn.view {
            background: rgba(13, 163, 216, 0.1);
            color: var(--gp-primary);
        }

        .action-btn.view:hover {
            background: var(--gp-primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(13, 163, 216, 0.3);
        }

        .action-btn.edit {
            background: rgba(254, 237, 2, 0.2);
            color: #b8a500;
        }

        .action-btn.edit:hover {
            background: var(--gp-yellow);
            color: var(--gp-secondary);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(254, 237, 2, 0.4);
        }

        .action-btn.delete {
            background: rgba(239, 68, 68, 0.1);
            color: var(--gp-red);
        }

        .action-btn.delete:hover {
            background: var(--gp-red);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .action-btn.locked {
            background: rgba(107, 114, 128, 0.1);
            color: var(--gp-muted);
            cursor: not-allowed;
        }

        .inline-form {
            display: inline;
        }

        /* EMPTY STATE */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            border-radius: 50%;
            background: rgba(13, 163, 216, 0.1);
            color: var(--gp-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            animation: emptyPulse 2s ease-in-out infinite;
        }

        @keyframes emptyPulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.05);
                opacity: 0.8;
            }
        }

        .empty-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gp-secondary);
            margin: 0 0 0.5rem 0;
        }

        .empty-desc {
            color: var(--gp-muted);
            font-size: 0.95rem;
            margin: 0 0 1.5rem 0;
        }

        .empty-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, var(--gp-primary), var(--gp-primary-dark));
            color: white;
            font-weight: 600;
            text-decoration: none;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(13, 163, 216, 0.3);
            transition: all var(--gp-transition);
        }

        .empty-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(13, 163, 216, 0.4);
        }

        /* RESPONSIVE */
        @media (max-width: 1024px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .godparent-list-wrapper {
                padding: 1rem;
            }

            .list-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .btn-add {
                width: 100%;
                justify-content: center;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .godparent-table thead {
                display: none;
            }

            .godparent-row {
                display: block;
                padding: 1.25rem;
                border-bottom: 2px solid var(--gp-border);
            }

            .godparent-row td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.75rem 0;
                border-bottom: 1px solid var(--gp-border);
            }

            .godparent-row td:last-child {
                border-bottom: none;
                justify-content: center;
                padding-top: 1rem;
            }

            .godparent-row td::before {
                content: attr(data-label);
                font-weight: 700;
                color: var(--gp-muted);
                font-size: 0.75rem;
                text-transform: uppercase;
                letter-spacing: 0.05em;
            }
        }

        @media (max-width: 480px) {
            .page-title {
                font-size: 1.4rem;
            }

            .stat-value {
                font-size: 1.25rem;
            }

            .header-title {
                gap: 1rem;
            }

            .title-icon {
                width: 50px;
                height: 50px;
                font-size: 1.25rem;
            }
        }
    </style>
@endsection
