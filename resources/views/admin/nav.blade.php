@extends('admin.layouts.master')

@section('content')

    <style scoped>
        .nav-crud-wrapper {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
            height: 100vh;
            overflow-y: scroll;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .page-header h1 {
            font-size: 2rem;
            color: #1f2937;
            font-weight: 700;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.2s ease;
            display: inline-block;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 6px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(102, 126, 234, 0.4);
        }

        .btn-success {
            background: #10b981;
            color: white;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }

        .btn-success:hover {
            background: #059669;
        }

        .btn-danger {
            background: #ef4444;
            color: white;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }

        .btn-secondary:hover {
            background: #4b5563;
        }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border-left: 4px solid #10b981;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }

        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .card-header {
            padding: 1.5rem 2rem;
            border-bottom: 2px solid #f3f4f6;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
        }

        .card-header h2 {
            font-size: 1.25rem;
            color: #1f2937;
            font-weight: 600;
        }

        .card-body {
            padding: 2rem;
        }

        .form-create {
            display: none;
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            padding: 2rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            border: 2px dashed #d1d5db;
            animation: fadeIn 0.3s ease;
        }

        .form-create.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .form-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .form-group label .required {
            color: #ef4444;
        }

        .form-group input {
            padding: 0.75rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 6px;
            font-size: 1rem;
            transition: all 0.2s ease;
            background: white;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group input:hover {
            border-color: #d1d5db;
        }

        .translations-section {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            border: 2px solid #e5e7eb;
        }

        .translations-title {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .translations-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 2px solid #e5e7eb;
        }

        .table-wrapper {
            overflow-x: auto;
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        thead th {
            padding: 1rem 1.5rem;
            text-align: left;
            font-weight: 600;
            color: white;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        tbody td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            color: #374151;
            vertical-align: middle;
        }

        tbody tr {
            transition: all 0.2s ease;
        }

        tbody tr:hover {
            background: #f9fafb;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .order-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2.5rem;
            height: 2.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 50%;
            font-weight: 700;
            font-size: 1rem;
            box-shadow: 0 2px 4px rgba(102, 126, 234, 0.3);
        }

        .key-display {
            font-weight: 600;
            color: #1f2937;
            font-family: 'Courier New', monospace;
            background: #f3f4f6;
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            display: inline-block;
        }

        .route-display {
            color: #6b7280;
            font-size: 0.875rem;
        }

        .translations-display {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .translation-item {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.375rem 0.75rem;
            background: #f9fafb;
            border-radius: 6px;
            font-size: 0.875rem;
            border: 1px solid #e5e7eb;
        }

        .translation-item .flag {
            font-size: 1.25rem;
        }

        .translation-item .text {
            color: #374151;
            font-weight: 500;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.375rem 0.875rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .status-active {
            background: #d1fae5;
            color: #065f46;
        }

        .status-inactive {
            background: #fee2e2;
            color: #991b1b;
        }

        .actions-cell {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .edit-row {
            display: none;
        }

        .edit-row.active {
            display: table-row;
            background: linear-gradient(135deg, #fef3c715 0%, #fbbf2415 100%);
            animation: fadeIn 0.3s ease;
        }

        .edit-row td {
            padding: 2rem 1.5rem;
        }

        .edit-form-wrapper {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            border: 2px solid #fbbf24;
        }

        .edit-form-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .edit-translations {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            padding: 1.5rem;
            background: #fef3c7;
            border-radius: 6px;
            margin-top: 1rem;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #9ca3af;
        }

        .empty-state svg {
            width: 5rem;
            height: 5rem;
            margin: 0 auto 1.5rem;
            opacity: 0.4;
            stroke: currentColor;
        }

        .empty-state h3 {
            font-size: 1.25rem;
            color: #6b7280;
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: #9ca3af;
        }

        .stats-bar {
            display: flex;
            gap: 0.5rem;
            align-items: center;
            color: #6b7280;
            font-size: 0.875rem;
        }

        .stats-bar .count {
            font-weight: 600;
            color: #667eea;
        }

        /* Responsive */
        @media (max-width: 768px) {

            .form-row,
            .translations-grid,
            .edit-form-grid,
            .edit-translations {
                grid-template-columns: 1fr;
            }

            .page-header {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }
        }
    </style>

    <div class="nav-crud-wrapper">

        <!-- Header -->
        <div class="page-header">
            <h1>📋 Gestion de la Navigation</h1>
            <button class="btn btn-primary" onclick="toggleCreateForm()">
                ➕ Créer un élément
            </button>
        </div>

        <!-- Alerts -->
        @if (session('success'))
            <div class="alert alert-success" id="successAlert">
                <span style="font-size: 1.5rem;">✅</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error" id="errorAlert">
                <span style="font-size: 1.5rem;">❌</span>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <!-- Main Card -->
        <div class="card">
            <div class="card-header">
                <h2>Liste des éléments de navigation</h2>
                <div class="stats-bar">
                    <span class="count">{{ $navItems->count() }}</span>
                    <span>élément(s)</span>
                </div>
            </div>

            <div class="card-body">

                <!-- Formulaire de création -->
                <form class="form-create" id="createForm" action="{{ route('nav-items.store') }}" method="POST">
                    @csrf

                    <div class="form-title">
                        <span>✨</span>
                        <span>Créer un nouvel élément</span>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>
                                Clé <span class="required">*</span>
                            </label>
                            <input type="text" name="key" placeholder="home" value="{{ old('key') }}" required>
                            <small style="color: #6b7280; margin-top: 0.25rem;">Identifiant unique (ex: home, about)</small>
                        </div>

                        <div class="form-group">
                            <label>
                                Route Laravel <span class="required">*</span>
                            </label>
                            <input type="text" name="route_name" placeholder="home" value="{{ old('route_name') }}"
                                required>
                            <small style="color: #6b7280; margin-top: 0.25rem;">Nom de la route (ex: home, contact)</small>
                        </div>

                        <div class="form-group">
                            <label>
                                Ordre <span class="required">*</span>
                            </label>
                            <input type="number" name="order" placeholder="0" value="{{ old('order', 0) }}"
                                min="0" required>
                            <small style="color: #6b7280; margin-top: 0.25rem;">Position dans le menu (0, 1, 2...)</small>
                        </div>
                    </div>

                    <div class="translations-section">
                        <div class="translations-title">
                            <span>🌍</span>
                            <span>Traductions</span>
                        </div>

                        <div class="translations-grid">
                            <div class="form-group">
                                <label>
                                    🇫🇷 Français <span class="required">*</span>
                                </label>
                                <input type="text" name="label_fr" placeholder="Accueil" value="{{ old('label_fr') }}"
                                    required>
                            </div>

                            <div class="form-group">
                                <label>
                                    🇬🇧 English <span class="required">*</span>
                                </label>
                                <input type="text" name="label_en" placeholder="Home" value="{{ old('label_en') }}"
                                    required>
                            </div>

                            <div class="form-group">
                                <label>
                                    🇲🇬 Malagasy <span class="required">*</span>
                                </label>
                                <input type="text" name="label_mg" placeholder="Fandraisana"
                                    value="{{ old('label_mg') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-success">
                            💾 Enregistrer
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="toggleCreateForm()">
                            ❌ Annuler
                        </button>
                    </div>
                </form>

                <!-- Tableau -->
                <div class="table-wrapper">
                    @if ($navItems->isEmpty())
                        <div class="empty-state">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            <h3>Aucun élément de navigation</h3>
                            <p>Cliquez sur "Créer un élément" pour ajouter votre premier élément au menu</p>
                        </div>
                    @else
                        <table>
                            <thead>
                                <tr>
                                    <th style="width: 80px;">Ordre</th>
                                    <th style="width: 150px;">Clé</th>
                                    <th style="width: 150px;">Route</th>
                                    <th>Traductions</th>
                                    <th style="width: 100px;">Statut</th>
                                    <th style="width: 220px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($navItems as $item)
                                    <!-- Ligne normale -->
                                    <tr id="row-{{ $item->id }}">
                                        <td>
                                            <span class="order-badge">{{ $item->order }}</span>
                                        </td>
                                        <td>
                                            <span class="key-display">{{ $item->key }}</span>
                                        </td>
                                        <td>
                                            <span class="route-display">{{ $item->route_name }}</span>
                                        </td>
                                        <td>
                                            <div class="translations-display">
                                                @foreach ($item->translations as $trans)
                                                    <div class="translation-item">
                                                        <span class="flag">
                                                            @if ($trans->locale == 'fr')
                                                                🇫🇷
                                                            @elseif($trans->locale == 'en')
                                                                🇬🇧
                                                            @elseif($trans->locale == 'mg')
                                                                🇲🇬
                                                            @endif
                                                        </span>
                                                        <span class="text">{{ $trans->label }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td>
                                            <span
                                                class="status-badge {{ $item->is_active ? 'status-active' : 'status-inactive' }}">
                                                {{ $item->is_active ? '✓ Actif' : '✗ Inactif' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="actions-cell">
                                                <button class="btn btn-secondary" onclick="toggleEdit({{ $item->id }})"
                                                    title="Modifier">
                                                    ✏️ Modifier
                                                </button>
                                                <form action="{{ route('nav-items.destroy', $item->id) }}" method="POST"
                                                    onsubmit="return confirm('⚠️ Êtes-vous sûr de vouloir supprimer cet élément ?')"
                                                    style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" title="Supprimer">
                                                        🗑️
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Ligne d'édition -->
                                    <tr class="edit-row" id="edit-{{ $item->id }}">
                                        <td colspan="6">
                                            <div class="edit-form-wrapper">
                                                <form action="{{ route('nav-items.update', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="form-title" style="color: #d97706;">
                                                        <span>✏️</span>
                                                        <span>Modifier l'élément</span>
                                                    </div>

                                                    <div class="edit-form-grid">
                                                        <div class="form-group">
                                                            <label>
                                                                Clé <span class="required">*</span>
                                                            </label>
                                                            <input type="text" name="key"
                                                                value="{{ $item->key }}" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>
                                                                Route Laravel <span class="required">*</span>
                                                            </label>
                                                            <input type="text" name="route_name"
                                                                value="{{ $item->route_name }}" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>
                                                                Ordre <span class="required">*</span>
                                                            </label>
                                                            <input type="number" name="order"
                                                                value="{{ $item->order }}" min="0" required>
                                                        </div>
                                                    </div>

                                                    <div class="edit-translations">
                                                        @foreach (['fr', 'en', 'mg'] as $locale)
                                                            @php
                                                                $translation = $item->translations
                                                                    ->where('locale', $locale)
                                                                    ->first();
                                                            @endphp
                                                            <div class="form-group">
                                                                <label>
                                                                    @if ($locale == 'fr')
                                                                        🇫🇷 Français
                                                                    @elseif($locale == 'en')
                                                                        🇧 English
                                                                    @elseif($locale == 'mg')
                                                                        🇲🇬 Malagasy
                                                                    @endif
                                                                    <span class="required">*</span>
                                                                </label>
                                                                <input type="text" name="label_{{ $locale }}"
                                                                    value="{{ $translation ? $translation->label : '' }}"
                                                                    required>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    <div class="form-actions">
                                                        <button type="submit" class="btn btn-success">
                                                            💾 Enregistrer les modifications
                                                        </button>
                                                        <button type="button" class="btn btn-secondary"
                                                            onclick="toggleEdit({{ $item->id }})">
                                                            ❌ Annuler
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>

            </div>
        </div>

    </div>

    <script>
        // Toggle le formulaire de création
        function toggleCreateForm() {
            const form = document.getElementById('createForm');
            form.classList.toggle('active');

            // Focus sur le premier input si le formulaire s'ouvre
            if (form.classList.contains('active')) {
                setTimeout(() => {
                    form.querySelector('input[name="key"]').focus();
                }, 100);
            }
        }

        // Toggle l'édition inline d'une ligne
        function toggleEdit(id) {
            const editRow = document.getElementById(`edit-${id}`);
            const normalRow = document.getElementById(`row-${id}`);

            // Fermer toutes les autres lignes d'édition
            document.querySelectorAll('.edit-row.active').forEach(row => {
                if (row.id !== `edit-${id}`) {
                    row.classList.remove('active');
                }
            });

            // Fermer le formulaire de création si ouvert
            if (editRow.classList.contains('active') === false) {
                const createForm = document.getElementById('createForm');
                if (createForm.classList.contains('active')) {
                    createForm.classList.remove('active');
                }
            }

            // Toggle la ligne d'édition actuelle
            editRow.classList.toggle('active');

            // Focus sur le premier input si la ligne s'ouvre
            if (editRow.classList.contains('active')) {
                setTimeout(() => {
                    editRow.querySelector('input[name="key"]').focus();
                }, 100);
            }
        }

        // Auto-hide les alertes après 5 secondes
        setTimeout(() => {
            const successAlert = document.getElementById('successAlert');
            const errorAlert = document.getElementById('errorAlert');

            if (successAlert) {
                successAlert.style.transition = 'opacity 0.5s, transform 0.5s';
                successAlert.style.opacity = '0';
                successAlert.style.transform = 'translateY(-20px)';
                setTimeout(() => successAlert.remove(), 500);
            }

            if (errorAlert) {
                errorAlert.style.transition = 'opacity 0.5s, transform 0.5s';
                errorAlert.style.opacity = '0';
                errorAlert.style.transform = 'translateY(-20px)';
                setTimeout(() => errorAlert.remove(), 500);
            }
        }, 5000);

        // Confirmation avant de quitter la page si un formulaire est en cours d'édition
        let formChanged = false;

        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('change', () => {
                formChanged = true;
            });
        });

        window.addEventListener('beforeunload', (e) => {
            if (formChanged) {
                e.preventDefault();
                e.returnValue = '';
            }
        });

        // Réinitialiser formChanged après soumission
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', () => {
                formChanged = false;
            });
        });
    </script>

@endsection
