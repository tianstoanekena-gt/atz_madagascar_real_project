@extends('layouts.main')

@section('title', $project->title . ' - ATZ Madagascar')

@section('content')
    <section class="project-detail-page">
        <div class="containerss">
            {{-- HEADER --}}
            <div class="header fade-up">
                <a href="{{ localized_route('projects') }}" class="back-link">
                    <i class="fas fa-arrow-left"></i>
                    <span>@lang('project.cta_back')</span>
                </a>
                <h1>{{ $project->title }}</h1>
                <div class="project-status {{ $project->status }}">
                    <span class="status-dot"></span>
                    @if ($project->status === 'completed')
                        @lang('project.status_completed')
                    @elseif($project->status === 'ongoing')
                        @lang('project.status_ongoing')
                    @else
                        @lang('project.status_upcoming')
                    @endif
                </div>
            </div>

            {{-- GRID --}}
            <div class="grid">
                {{-- MEDIA --}}
                <div class="media fade-up delay-1">
                    <div class="image-card hover-lift">
                        @if ($project->hero_image)
                            <img src="{{ Storage::url($project->hero_image) }}" alt="{{ $project->title }}">
                        @else
                            <div class="image-placeholder">
                                <i class="fas fa-image"></i>
                            </div>
                        @endif
                    </div>

                    {{-- KPI --}}
                    <div class="kpi-grid">
                        <div class="kpi-box">
                            <span>@lang('project.kpi_beneficiaries')</span>
                            <strong>{{ $project->beneficiaries_count ?? 0 }}</strong>
                        </div>
                        <div class="kpi-box success">
                            <span>@lang('project.kpi_progress')</span>
                            <strong>{{ $project->progress_percentage }}%</strong>
                        </div>
                        <div class="kpi-box accent">
                            <span>@lang('project.kpi_location')</span>
                            <strong>{{ $project->city ?? '-' }}</strong>
                        </div>
                    </div>
                </div>

                {{-- INFOS --}}
                <div class="info fade-up delay-2">
                    <div class="info-card hover-lift">
                        <h2>@lang('project.presentation')</h2>
                        <p>{!! nl2br(e($project->full_description)) !!}</p>

                        {{-- TIMELINE --}}
                        <div class="timeline">
                            <h3>@lang('project.evolution')</h3>
                            <div class="timeline-item {{ $project->status !== 'upcoming' ? 'done' : '' }}">
                                <span>{{ $project->start_date ? $project->start_date->format('M Y') : '-' }}</span>
                                <h4>@lang('project.timeline_start')</h4>
                            </div>
                            <div class="timeline-item {{ $project->status === 'completed' ? 'done' : 'active' }}">
                                <span>{{ $project->end_date ? $project->end_date->format('M Y') : __('project.timeline_ongoing') }}</span>
                                <h4>@lang('project.timeline_end')</h4>
                            </div>
                        </div>

                        {{-- PROGRESS --}}
                        @if ($project->target_amount > 0)
                            <div class="progress-section">
                                <div class="progress-header">
                                    <span>@lang('project.global_progress')</span>
                                    <strong>{{ $project->progress_percentage }}%</strong>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" data-progress="{{ $project->progress_percentage }}"></div>
                                </div>
                                <div class="progress-amounts">
                                    <span>{{ number_format($project->current_amount, 0, ',', ' ') }} Ar</span>
                                    <span>{{ number_format($project->target_amount, 0, ',', ' ') }} Ar</span>
                                </div>
                            </div>
                        @endif

                        {{-- CTA --}}
                        <div class="cta">
                            <a href="{{ localized_route('contact') }}" class="btn primary">
                                @lang('project.cta_support')
                            </a>
                            <a href="{{ localized_route('projects') }}" class="btn secondary">
                                @lang('project.cta_back')
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        /* ===== VARIABLES ===== */
        :root {
            --color-primary: #feed02;
            --color-secondary: #c7ba04;
            --color-text: #0d0c43;
            --color-background: #fffef2;
            --color-accent: #6f4413;
            --color-blue: #0da3d8;
            --color-green: #6e9d2e;
            --color-red: rgb(200, 0, 0);
        }

        /* ===== BASE ===== */
        .project-detail-page {
            background: var(--color-background);
            padding: 64px 20px 90px;
            font-family: system-ui, -apple-system, sans-serif;
            color: var(--color-text);
        }

        .containerss {
            margin: 0 auto;
        }

        /* ===== HEADER ===== */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 600;
            color: var(--color-text);
            opacity: 0.6;
            text-decoration: none;
            margin-bottom: 20px;
            transition: opacity 0.25s ease, transform 0.25s ease;
        }

        .back-link:hover {
            opacity: 1;
            transform: translateX(-3px);
            color: var(--color-blue);
        }

        .header h1 {
            font-size: 34px;
            color: var(--color-text);
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 14px;
        }

        .project-status {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
        }

        .status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: currentColor;
        }

        .completed {
            background: rgba(110, 157, 46, 0.12);
            color: var(--color-green);
        }

        .ongoing {
            background: rgba(13, 163, 216, 0.12);
            color: var(--color-blue);
        }

        .upcoming {
            background: rgba(254, 237, 2, 0.22);
            color: var(--color-accent);
        }

        /* ===== GRID ===== */
        .grid {
            display: grid;
            grid-template-columns: 0.95fr 1.15fr;
            gap: 48px;
            margin-top: 42px;
        }

        @media (max-width: 900px) {
            .grid {
                grid-template-columns: 1fr;
                gap: 32px;
            }
        }

        /* ===== IMAGE ===== */
        .image-card {
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 28px rgba(13, 12, 67, 0.07);
            background: #ffffff;
        }

        .image-card img {
            width: 100%;
            display: block;
            transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .image-card.hover-lift:hover img {
            transform: scale(1.04);
        }

        .image-placeholder {
            width: 100%;
            height: 360px;
            background: rgba(13, 12, 67, 0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3.5rem;
            color: var(--color-text);
            opacity: 0.25;
        }

        /* ===== KPI ===== */
        .kpi-grid {
            margin-top: 20px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .kpi-box {
            background: #ffffff;
            padding: 18px;
            border-radius: 12px;
            border-top: 3px solid var(--color-primary);
            box-shadow: 0 3px 12px rgba(13, 12, 67, 0.05);
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s ease;
        }

        .kpi-box:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 24px rgba(13, 12, 67, 0.09);
        }

        .kpi-box span {
            display: block;
            font-size: 12px;
            color: var(--color-text);
            opacity: 0.6;
            margin-bottom: 6px;
        }

        .kpi-box strong {
            font-size: 22px;
            color: var(--color-text);
            font-weight: 800;
        }

        .kpi-box.success {
            border-top-color: var(--color-green);
        }

        .kpi-box.accent {
            border-top-color: var(--color-accent);
        }

        /* ===== CARD ===== */
        .info-card {
            background: #ffffff;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 8px 28px rgba(13, 12, 67, 0.05);
            transition: box-shadow 0.35s ease;
        }

        .info-card.hover-lift:hover {
            box-shadow: 0 16px 40px rgba(13, 12, 67, 0.09);
        }

        .info-card h2 {
            font-size: 19px;
            color: var(--color-text);
            margin-bottom: 16px;
            font-weight: 700;
        }

        .info-card p {
            color: var(--color-text);
            opacity: .8;
            line-height: 1.7;
            font-size: 15px;
        }

        /* ===== TIMELINE ===== */
        .timeline {
            margin-top: 34px;
            border-left: 2px solid var(--color-secondary);
            padding-left: 20px;
        }

        .timeline h3 {
            font-size: 16px;
            margin-bottom: 18px;
            color: var(--color-text);
            font-weight: 700;
        }

        .timeline-item {
            margin-bottom: 18px;
            position: relative;
            padding: 4px 8px 4px 2px;
            border-radius: 6px;
            transition: background 0.25s ease;
        }

        .timeline-item:hover {
            background: rgba(13, 163, 216, 0.05);
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -25px;
            top: 9px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--color-secondary);
            border: 2px solid var(--color-background);
        }

        .timeline-item span {
            font-size: 12px;
            font-weight: 600;
            color: var(--color-text);
            opacity: 0.55;
            display: block;
            margin-bottom: 3px;
        }

        .timeline-item h4 {
            font-size: 15px;
            margin: 0;
            font-weight: 600;
        }

        .timeline-item.done h4 {
            color: var(--color-green);
        }

        .timeline-item.done::before {
            background: var(--color-green);
        }

        .timeline-item.active h4 {
            color: var(--color-blue);
        }

        .timeline-item.active::before {
            background: var(--color-blue);
            box-shadow: 0 0 0 4px rgba(13, 163, 216, 0.18);
        }

        /* ===== PROGRESS ===== */
        .progress-section {
            margin-top: 34px;
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 600;
        }

        .progress-bar {
            height: 8px;
            background: rgba(13, 12, 67, 0.08);
            border-radius: 999px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            width: 0%;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--color-primary), var(--color-secondary), var(--color-green));
            transition: width 1.1s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .progress-amounts {
            display: flex;
            justify-content: space-between;
            margin-top: 7px;
            font-size: 12px;
            color: var(--color-text);
            opacity: 0.65;
            font-weight: 500;
        }

        /* ===== CTA ===== */
        .cta {
            margin-top: 34px;
            display: flex;
            gap: 12px;
        }

        .btn {
            padding: 13px 24px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s ease, background 0.3s ease, color 0.3s ease;
            text-align: center;
        }

        .primary {
            background: var(--color-primary);
            color: var(--color-text);
        }

        .primary:hover {
            background: var(--color-secondary);
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(199, 186, 4, 0.3);
        }

        .primary:active {
            transform: translateY(0);
        }

        .secondary {
            border: 2px solid var(--color-text);
            color: var(--color-text);
            background: transparent;
        }

        .secondary:hover {
            background: var(--color-text);
            color: var(--color-background);
            transform: translateY(-2px);
        }

        .secondary:active {
            transform: translateY(0);
        }

        /* ===== ANIMATION & HOVER FIX ===== */
        .fade-up {
            opacity: 0;
            transform: translateY(24px);
            animation: fadeUp .7s forwards cubic-bezier(0.16, 1, 0.3, 1);
        }

        .delay-1 {
            animation-delay: .15s;
        }

        .delay-2 {
            animation-delay: .3s;
        }

        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* hover-lift séparé de l'animation pour éviter le conflit CSS sur "transform" */
        .hover-lift {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.3s ease;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .project-detail-page {
                padding: 48px 16px 70px;
            }

            .header h1 {
                font-size: 26px;
            }

            .kpi-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .cta {
                flex-direction: column;
            }
        }

        @media (max-width: 480px) {
            .project-detail-page {
                padding: 40px 12px 60px;
            }

            .header h1 {
                font-size: 22px;
                line-height: 1.3;
            }

            .grid {
                gap: 28px;
            }

            .info-card {
                padding: 22px;
            }

            .timeline {
                padding-left: 14px;
            }

            .timeline-item::before {
                left: -20px;
                width: 9px;
                height: 9px;
            }

            .btn {
                padding: 12px 18px;
                font-size: 13px;
            }
        }

        @media (max-width: 350px) {
            .header h1 {
                font-size: 19px;
            }

            .info-card {
                padding: 16px;
            }

            .kpi-box strong {
                font-size: 19px;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Libère le hover une fois l'animation d'entrée terminée
            // (une animation et une transition ne cohabitent pas bien sur "transform")
            document.querySelectorAll('.fade-up').forEach(el => {
                el.addEventListener('animationend', () => {
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                    el.classList.remove('fade-up', 'delay-1', 'delay-2');
                });
            });

            // Anime la barre de progression après le chargement, plutôt qu'en dur dans le HTML
            const fill = document.querySelector('.progress-fill');
            if (fill) {
                const target = fill.dataset.progress || 0;
                requestAnimationFrame(() => {
                    setTimeout(() => {
                        fill.style.width = target + '%';
                    }, 300);
                });
            }
        });
    </script>
@endsection
