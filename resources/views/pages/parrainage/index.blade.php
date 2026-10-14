@extends('layouts.main')
@section('content')
    <section class="parrainage-section">
        <div class="parrainage-container">
            {{-- Hero --}}
            <div class="parrainage-hero">
                <h2 class="parrainage-title">@lang('parrainage.title')</h2>
                <p class="parrainage-desc">@lang('parrainage.description')</p>
                <div class="title-underline"></div>
            </div>

            {{-- Toasts --}}
            @if (session('success'))
                <x-toast type="success" :message="session('success')" />
            @endif
            @if (session('info'))
                <x-toast type="info" :message="session('info')" />
            @endif

            {{-- FILTRES DYNAMIQUES --}}
            <div class="filters-container">
                <div class="filters-header">
                    <h3 class="filters-title">
                        <i class="fas fa-filter"></i>
                        @lang('parrainage.filter_by_level')
                    </h3>
                    {{-- <span class="total-count">
                        <span id="visible-count">{{ $students->count() }}</span>
                        <span>@lang('parrainage.students_found')</span>
                    </span> --}}
                </div>

                <div class="filters-buttons">
                    <button type="button" class="filter-btn active" data-filter="all" aria-pressed="true">
                        <i class="fas fa-th"></i>
                        <span>@lang('parrainage.filter_all')</span>
                        <span class="filter-count" data-count="all">{{ $students->count() }}</span>
                    </button>

                    @php
                        $levels = [
                            'primaire' => ['icon' => 'fa-child', 'label' => 'parrainage.filter_primaire'],
                            'college' => ['icon' => 'fa-book-open', 'label' => 'parrainage.filter_college'],
                            'lycee' => ['icon' => 'fa-graduation-cap', 'label' => 'parrainage.filter_lycee'],
                            'superieur' => ['icon' => 'fa-university', 'label' => 'parrainage.filter_superieur'],
                            'formation_pro' => ['icon' => 'fa-tools', 'label' => 'parrainage.filter_formation_pro'],
                        ];
                    @endphp

                    @foreach ($levels as $key => $config)
                        @php
                            $count = $students->where('education_level', $key)->count();
                        @endphp
                        @if ($count > 0)
                            <button type="button" class="filter-btn" data-filter="{{ $key }}"
                                aria-pressed="false">
                                <i class="fas {{ $config['icon'] }}"></i>
                                <span>@lang($config['label'])</span>
                                <span class="filter-count" data-count="{{ $key }}">{{ $count }}</span>
                            </button>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Grille --}}
            <div class="students-grid" id="students-grid">
                @forelse ($students as $student)
                    <article class="student-card {{ $student->status === 'completed' ? 'is-completed' : '' }}"
                        data-level="{{ $student->education_level }}" data-status="{{ $student->status }}">
                        {{-- Image --}}
                        <div class="student-media">
                            <img src="{{ $student->photo_url }}" alt="{{ $student->full_name }}" class="student-photo"
                                loading="lazy">
                            <div class="student-media-overlay"></div>
                            {{-- Statut --}}
                            @if ($student->status === 'completed')
                                <div class="student-status completed">
                                    <i class="fas fa-check-circle"></i>
                                    <span>@lang('parrainage.completed')</span>
                                </div>
                            @endif
                        </div>
                        {{-- Contenu --}}
                        <div class="student-content">
                            {{-- En-tête --}}
                            <div class="student-heading">
                                <div class="student-name-wrapper">
                                    <h3 class="student-name">
                                        {{ $student->full_name }}
                                    </h3>
                                    <span class="student-name-line"></span>
                                </div>
                                <span class="student-level-badge" data-level="{{ $student->education_level }}">
                                    {{ $student->education_level_label }}
                                </span>
                            </div>
                            {{-- Informations --}}
                            <div class="student-details">
                                <div class="student-info">
                                    <span class="info-icon">
                                        <i class="fas fa-birthday-cake"></i>
                                    </span>
                                    <span>
                                        {{ $student->age }} @lang('students.years_old')
                                    </span>
                                </div>
                                <div class="student-info student-location">
                                    <span class="info-icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </span>
                                    <span>
                                        {{ $student->location }}
                                    </span>
                                </div>
                            </div>
                            {{-- Description courte (Traduite dynamiquement) --}}
                            <p class="student-description">
                                {{ Str::limit($student->description_translated, 180) }}
                            </p>
                            {{-- Progression --}}
                            <div class="progress-container">
                                <div class="progress-top">
                                    <div class="progress-title">
                                        <i class="fas fa-hand-holding-heart"></i>
                                        <span>@lang('parrainage.progress')</span>
                                    </div>
                                    <span class="progress-percentage">
                                        {{ $student->progress }}%
                                    </span>
                                </div>
                                <div class="progress-bar-bg">
                                    <div class="progress-bar-fill" style="--progress-width: {{ $student->progress }}%">
                                        <span class="progress-glow"></span>
                                    </div>
                                </div>
                                <div class="progress-labels">
                                    <span class="amount-current">
                                        {{ number_format($student->collected_amount, 0, ',', ' ') }}
                                        <small>Ar</small>
                                    </span>
                                    <span class="amount-target">
                                        {{ number_format($student->target_amount, 0, ',', ' ') }}
                                        <small>Ar</small>
                                    </span>
                                </div>
                            </div>
                            {{-- CTA --}}
                            <div class="student-action">
                                @if ($student->status !== 'completed')
                                    <a href="{{ route('parrainage.show', ['locale' => app()->getLocale(), 'studentId' => $student->id]) }}"
                                        class="btn-parrainer">
                                        <span class="btn-content">
                                            <span class="btn-icon">
                                                <i class="fas fa-heart"></i>
                                            </span>
                                            <span class="btn-text">
                                                @lang('parrainage.cta_button', ['name' => $student->first_name])
                                            </span>
                                            <span class="btn-arrow">
                                                <i class="fas fa-arrow-right"></i>
                                            </span>
                                        </span>
                                        <span class="btn-shine"></span>
                                    </a>
                                @else
                                    <button type="button" class="btn-parrainer btn-completed" disabled>
                                        <span class="btn-content">
                                            <span class="btn-icon">
                                                <i class="fas fa-check"></i>
                                            </span>
                                            <span class="btn-text">
                                                @lang('parrainage.completed')
                                            </span>
                                        </span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="empty-students">
                        <div class="empty-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <p>
                            @lang('parrainage.no_students')
                        </p>
                    </div>
                @endforelse
            </div>

            {{-- Message "Aucun résultat" (caché par défaut) --}}
            <div class="no-results" id="no-results" style="display: none;">
                <div class="empty-icon">
                    <i class="fas fa-search"></i>
                </div>
                <p>@lang('parrainage.no_results')</p>
            </div>
        </div>
    </section>

    <style>
        /* =========================================================
                                                                                                                       VARIABLES — ATZ MADAGASCAR
                                                                                                                       (MANQUANTES dans le fichier d'origine : c'était le bug)
                                                                                                                       ========================================================= */
        :root {
            --par-primary: #feed02;
            --par-secondary: #0d0c43;
            --par-blue: #0da3d8;
            --par-blue-dark: #0b8fbd;
            --par-green: #6e9d2e;
            --par-muted: #64748b;
            --par-border: rgba(13, 12, 67, 0.08);
            --par-radius: 1.25rem;
            --par-radius-small: 0.6rem;
            --par-shadow: 0 10px 30px rgba(13, 12, 67, 0.07);
            --par-shadow-hover: 0 20px 45px rgba(13, 12, 67, 0.14);
            --par-transition: 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* =========================================================
                                                                                                                       BASE — SECTION / HERO
                                                                                                                       ========================================================= */
        .parrainage-section {
            padding: 4.5rem 0 6rem;
            background: linear-gradient(180deg, #ffffff 0%, #fbfcfe 100%);
        }

        .parrainage-container {
            max-width: 1240px;
            margin: 0 auto;
            padding: 0 1.25rem;
        }

        .parrainage-hero {
            text-align: center;
            margin-bottom: 3rem;
        }

        .parrainage-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--par-secondary);
            margin-bottom: 0.75rem;
            letter-spacing: -0.01em;
        }

        .parrainage-desc {
            color: var(--par-muted);
            max-width: 650px;
            margin: 0 auto;
            line-height: 1.65;
            font-size: 1.05rem;
        }

        .title-underline {
            width: 5.5rem;
            height: 4px;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--par-primary), var(--par-blue));
            margin: 1.25rem auto 0;
        }

        /* =========================================================
                                                                                                                       FILTRES DYNAMIQUES
                                                                                                                       ========================================================= */
        .filters-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: var(--par-radius);
            padding: 1.5rem;
            margin-bottom: 2.5rem;
            box-shadow: var(--par-shadow);
            border: 1px solid var(--par-border);
        }

        .filters-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.25rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid rgba(13, 12, 67, 0.06);
        }

        .filters-title {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            color: var(--par-secondary);
            font-size: 1.1rem;
            font-weight: 700;
            margin: 0;
        }

        .filters-title i {
            color: var(--par-blue);
            font-size: 1rem;
        }

        .total-count {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--par-muted);
            font-size: 0.9rem;
            font-weight: 600;
        }

        #visible-count {
            color: var(--par-blue);
            font-size: 1.3rem;
            font-weight: 800;
            transition: all 0.3s ease;
        }

        .filters-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .filter-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.7rem 1.2rem;
            border: 2px solid rgba(13, 12, 67, 0.1);
            border-radius: 999px;
            background: white;
            color: var(--par-secondary);
            font-family: inherit;
            font-size: 0.88rem;
            font-weight: 600;
            cursor: pointer;
            transition: all var(--par-transition);
            position: relative;
            overflow: hidden;
        }

        .filter-btn i {
            font-size: 0.95rem;
            transition: transform var(--par-transition);
        }

        .filter-count {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 22px;
            height: 22px;
            padding: 0 6px;
            border-radius: 999px;
            background: rgba(13, 163, 216, 0.12);
            color: var(--par-blue);
            font-size: 0.75rem;
            font-weight: 800;
            transition: all var(--par-transition);
        }

        .filter-btn:hover {
            border-color: var(--par-blue);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(13, 163, 216, 0.15);
        }

        .filter-btn:hover i {
            transform: scale(1.15);
        }

        .filter-btn.active {
            background: linear-gradient(135deg, var(--par-blue), var(--par-blue-dark));
            color: white;
            border-color: var(--par-blue);
            box-shadow: 0 6px 16px rgba(13, 163, 216, 0.25);
        }

        .filter-btn.active .filter-count {
            background: rgba(255, 255, 255, 0.25);
            color: white;
        }

        .filter-btn.active i {
            animation: filterIconPulse 0.5s ease;
        }

        @keyframes filterIconPulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.3);
            }
        }

        /* =========================================================
                                                                                                                       GRILLE DE CARTES
                                                                                                                       ========================================================= */
        .students-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.75rem;
        }

        .student-card {
            background: white;
            border-radius: var(--par-radius);
            overflow: hidden;
            box-shadow: var(--par-shadow);
            border: 1px solid var(--par-border);
            display: flex;
            flex-direction: column;
            transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
            opacity: 1;
            transform: scale(1);
        }

        .student-card:hover {
            transform: translateY(-8px) scale(1);
            box-shadow: var(--par-shadow-hover);
            border-color: rgba(13, 163, 216, 0.15);
        }

        .student-card.is-completed {
            opacity: 0.88;
        }

        .student-card.hidden {
            opacity: 0;
            transform: scale(0.85);
            position: absolute;
            pointer-events: none;
            visibility: hidden;
        }

        .student-card.fade-in {
            animation: cardFadeIn 0.5s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }

        @keyframes cardFadeIn {
            from {
                opacity: 0;
                transform: scale(0.85) translateY(20px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        /* ===== MEDIA ===== */
        .student-media {
            position: relative;
            height: 220px;
            overflow: hidden;
        }

        .student-photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .student-card:hover .student-photo {
            transform: scale(1.07);
        }

        .student-media-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(13, 12, 67, 0.55) 0%, transparent 55%);
        }

        .student-status {
            position: absolute;
            top: 0.9rem;
            right: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 0.4rem 0.85rem;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .student-status.available {
            background: rgba(255, 255, 255, 0.92);
            color: var(--par-green);
        }

        .status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--par-green);
            box-shadow: 0 0 0 3px rgba(110, 157, 46, 0.2);
            animation: statusPulse 2s ease-in-out infinite;
        }

        @keyframes statusPulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        .student-status.completed {
            background: var(--par-secondary);
            color: var(--par-primary);
        }

        /* ===== CONTENT ===== */
        .student-content {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .student-heading {
            margin-bottom: 1rem;
        }

        .student-name-wrapper {
            position: relative;
            display: inline-block;
            margin-bottom: 0.4rem;
        }

        .student-name {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--par-secondary);
            margin: 0;
        }

        .student-name-line {
            display: block;
            width: 2rem;
            height: 3px;
            border-radius: 999px;
            background: var(--par-primary);
            margin-top: 6px;
        }

        .student-level-badge {
            display: inline-block;
            padding: 0.3rem 0.75rem;
            border-radius: 999px;
            background: linear-gradient(135deg, rgba(13, 163, 216, 0.1), rgba(254, 237, 2, 0.15));
            color: var(--par-blue);
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        /* ===== INFOS (age / lieu) ===== */
        .student-details {
            display: flex;
            flex-wrap: wrap;
            gap: 0.9rem;
            margin-bottom: 1rem;
        }

        .student-info {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.85rem;
            color: var(--par-muted);
            font-weight: 500;
        }

        .info-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: rgba(13, 163, 216, 0.08);
            color: var(--par-blue);
            font-size: 0.7rem;
        }

        /* ===== DESCRIPTION ===== */
        .student-description {
            color: var(--par-muted);
            font-size: 0.88rem;
            line-height: 1.6;
            margin: 0 0 1rem 0;
            padding: 0.75rem;
            background: rgba(245, 247, 250, 0.6);
            border-radius: var(--par-radius-small);
            border-left: 3px solid var(--par-blue);
        }

        /* ===== PROGRESSION ===== */
        .progress-container {
            margin-top: auto;
            margin-bottom: 1.25rem;
        }

        .progress-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .progress-title {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--par-secondary);
        }

        .progress-title i {
            color: var(--par-primary);
        }

        .progress-percentage {
            font-size: 0.95rem;
            font-weight: 800;
            color: var(--par-blue);
        }

        .progress-bar-bg {
            height: 9px;
            background: rgba(13, 12, 67, 0.07);
            border-radius: 999px;
            overflow: hidden;
        }

        .progress-bar-fill {
            position: relative;
            height: 100%;
            width: var(--progress-width, 0%);
            border-radius: 999px;
            background: linear-gradient(90deg, var(--par-primary), var(--par-blue));
            transition: width 1s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .progress-glow {
            position: absolute;
            top: 0;
            right: 0;
            width: 14px;
            height: 100%;
            background: rgba(255, 255, 255, 0.6);
            filter: blur(4px);
        }

        .progress-labels {
            display: flex;
            justify-content: space-between;
            margin-top: 0.5rem;
            font-size: 0.78rem;
            font-weight: 600;
        }

        .amount-current {
            color: var(--par-blue);
        }

        .amount-target {
            color: var(--par-muted);
        }

        .amount-current small,
        .amount-target small {
            font-weight: 500;
            opacity: 0.8;
        }

        /* ===== CTA ===== */
        .student-action {
            margin-top: auto;
        }

        .btn-parrainer {
            position: relative;
            display: flex;
            width: 100%;
            padding: 0.85rem 1.1rem;
            border: none;
            border-radius: var(--par-radius-small);
            background: var(--par-primary);
            color: var(--par-secondary);
            font-weight: 700;
            font-size: 0.9rem;
            text-decoration: none;
            cursor: pointer;
            overflow: hidden;
            transition: background var(--par-transition), color var(--par-transition), transform var(--par-transition), box-shadow var(--par-transition);
        }

        .btn-parrainer:hover {
            background: var(--par-secondary);
            color: var(--par-primary);
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(13, 12, 67, 0.2);
        }

        .btn-content {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
        }

        .btn-icon {
            display: inline-flex;
        }

        .btn-arrow {
            display: inline-flex;
            transition: transform 0.3s ease;
        }

        .btn-parrainer:hover .btn-arrow {
            transform: translateX(4px);
        }

        .btn-shine {
            position: absolute;
            top: 0;
            left: -60%;
            width: 40%;
            height: 100%;
            background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.5), transparent);
            transform: skewX(-20deg);
            transition: left 0.6s ease;
        }

        .btn-parrainer:hover .btn-shine {
            left: 120%;
        }

        .btn-completed {
            background: #eef0f2;
            color: var(--par-muted);
            cursor: not-allowed;
        }

        .btn-completed:hover {
            background: #eef0f2;
            color: var(--par-muted);
            transform: none;
            box-shadow: none;
        }

        /* =========================================================
                                                                                                                       ÉTATS VIDES
                                                                                                                       ========================================================= */
        .empty-students,
        .no-results {
            grid-column: 1 / -1;
            text-align: center;
            padding: 4rem 2rem;
            color: var(--par-muted);
        }

        .empty-students .empty-icon,
        .no-results .empty-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            border-radius: 50%;
            background: rgba(13, 163, 216, 0.1);
            color: var(--par-blue);
            font-size: 2rem;
        }

        .no-results .empty-icon {
            animation: noResultsPulse 2s ease-in-out infinite;
        }

        @keyframes noResultsPulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.7;
            }
        }

        .empty-students p,
        .no-results p {
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0;
        }

        /* =========================================================
                                                                                                                       RESPONSIVE
                                                                                                                       ========================================================= */
        @media (max-width: 700px) {
            .parrainage-title {
                font-size: 2rem;
            }

            .filters-container {
                padding: 1rem;
            }

            .filters-header {
                flex-direction: column;
                gap: 0.75rem;
                align-items: flex-start;
            }

            .filters-buttons {
                gap: 0.5rem;
            }

            .filter-btn {
                padding: 0.6rem 1rem;
                font-size: 0.82rem;
            }

            .filter-btn span:not(.filter-count) {
                font-size: 0.8rem;
            }

            .students-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .filters-buttons {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
            }

            .filter-btn {
                justify-content: center;
            }
        }
    </style>

    {{-- SCRIPT JAVASCRIPT POUR LE FILTRAGE DYNAMIQUE --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.filter-btn');
            const studentCards = document.querySelectorAll('.student-card');
            const visibleCountEl = document.getElementById('visible-count');
            const noResultsEl = document.getElementById('no-results');
            const studentsGrid = document.getElementById('students-grid');

            function filterStudents(level) {
                let visibleCount = 0;

                studentCards.forEach((card, index) => {
                    const cardLevel = card.getAttribute('data-level');
                    const shouldShow = level === 'all' || cardLevel === level;

                    if (shouldShow) {
                        card.classList.remove('hidden');
                        card.style.animationDelay = `${index * 0.05}s`;
                        card.classList.add('fade-in');
                        visibleCount++;

                        setTimeout(() => {
                            card.classList.remove('fade-in');
                        }, 500);
                    } else {
                        card.classList.add('hidden');
                        card.classList.remove('fade-in');
                    }
                });

                animateCounter(visibleCountEl, parseInt(visibleCountEl.textContent, 10) || 0, visibleCount);

                if (visibleCount === 0) {
                    noResultsEl.style.display = 'block';
                    studentsGrid.style.display = 'none';
                } else {
                    noResultsEl.style.display = 'none';
                    studentsGrid.style.display = 'grid';
                }
            }

            function animateCounter(element, start, end) {
                const duration = 400;
                const startTime = performance.now();

                function update(currentTime) {
                    const elapsed = currentTime - startTime;
                    const progress = Math.min(elapsed / duration, 1);
                    const easeOut = 1 - Math.pow(1 - progress, 3);
                    const current = Math.round(start + (end - start) * easeOut);

                    element.textContent = current;

                    if (progress < 1) {
                        requestAnimationFrame(update);
                    }
                }

                requestAnimationFrame(update);
            }

            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    filterButtons.forEach(btn => {
                        btn.classList.remove('active');
                        btn.setAttribute('aria-pressed', 'false');
                    });

                    this.classList.add('active');
                    this.setAttribute('aria-pressed', 'true');

                    const filter = this.getAttribute('data-filter');
                    filterStudents(filter);

                    if (window.innerWidth <= 700) {
                        studentsGrid.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            studentCards.forEach(card => {
                card.classList.remove('hidden');
            });
        });
    </script>
@endsection
