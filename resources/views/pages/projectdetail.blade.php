@extends('layouts.main')

@section('title', $project->title . ' - ATZ Madagascar')

@section('content')
    <section class="project-detail-page">
        <div class="containers">
            {{-- HEADER --}}
            <div class="header fade-up">
                <h1>{{ $project->title }}</h1>
                <div class="project-status {{ $project->status }}">
                    @if ($project->status === 'completed')
                        @lang('project.status_completed')
                    @elseif($project->status === 'ongoing')
                        @lang('project.status_ongoing')
                    @else
                        @lang('project.status_upcoming')
                    @endif
                </div>
            </div>
            <br>

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
                                    <div class="progress-fill" style="width: {{ $project->progress_percentage }}%"></div>
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
            padding: 80px 20px;
            font-family: system-ui, -apple-system, sans-serif;
            color: var(--color-text);
        }

        .containers {
            margin: 40px 50px;
        }

        /* ===== HEADER ===== */
        .header h1 {
            font-size: 38px;
            color: var(--color-text);
            font-weight: 800;
        }

        .project-status {
            margin-top: 15px;
            padding: 6px 18px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
            display: inline-block;
        }

        .completed {
            background: rgba(110, 157, 46, 0.15);
            color: var(--color-green);
        }

        .ongoing {
            background: rgba(13, 163, 216, 0.15);
            color: var(--color-blue);
        }

        .upcoming {
            background: rgba(254, 237, 2, 0.3);
            color: var(--color-accent);
        }

        /* ===== GRID ===== */
        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
        }

        @media(max-width:900px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }

        /* ===== IMAGE ===== */
        .image-card {
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 12px 40px rgba(13, 12, 67, 0.08);
            background: #ffffff;
        }

        .image-card img {
            width: 100%;
            display: block;
        }

        .image-placeholder {
            width: 100%;
            height: 400px;
            background: rgba(13, 12, 67, 0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            color: var(--color-text);
            opacity: 0.3;
        }

        /* ===== KPI ===== */
        .kpi-grid {
            margin-top: 25px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .kpi-box {
            background: #ffffff;
            padding: 20px;
            border-radius: 14px;
            border-top: 4px solid var(--color-primary);
            box-shadow: 0 4px 15px rgba(13, 12, 67, 0.05);
        }

        .kpi-box span {
            display: block;
            font-size: 13px;
            color: var(--color-text);
            opacity: 0.7;
            margin-bottom: 8px;
        }

        .kpi-box strong {
            font-size: 26px;
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
            padding: 32px;
            border-radius: 18px;
            box-shadow: 0 10px 35px rgba(13, 12, 67, 0.05);
        }

        .info-card h2 {
            color: var(--color-text);
            margin-bottom: 20px;
            font-weight: 700;
        }

        .info-card p {
            color: var(--color-text);
            opacity: .85;
            line-height: 1.7;
            margin-bottom: 15px;
        }

        /* ===== TIMELINE ===== */
        .timeline {
            margin-top: 40px;
            border-left: 3px solid var(--color-secondary);
            padding-left: 20px;
        }

        .timeline h3 {
            font-size: 18px;
            margin-bottom: 20px;
            color: var(--color-text);
        }

        .timeline-item {
            margin-bottom: 22px;
            position: relative;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -28px;
            top: 5px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: var(--color-secondary);
            border: 2px solid var(--color-background);
        }

        .timeline-item span {
            font-size: 13px;
            font-weight: 600;
            color: var(--color-text);
            opacity: 0.6;
            display: block;
            margin-bottom: 4px;
        }

        .timeline-item h4 {
            font-size: 16px;
            margin: 0;
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
            box-shadow: 0 0 0 4px rgba(13, 163, 216, 0.2);
        }

        /* ===== PROGRESS ===== */
        .progress-section {
            margin-top: 40px;
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 14px;
            font-weight: 600;
        }

        .progress-bar {
            height: 10px;
            background: rgba(13, 12, 67, 0.08);
            border-radius: 999px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--color-primary), var(--color-secondary), var(--color-green));
            transition: width 1s ease-out;
        }

        .progress-amounts {
            display: flex;
            justify-content: space-between;
            margin-top: 8px;
            font-size: 13px;
            color: var(--color-text);
            opacity: 0.7;
            font-weight: 500;
        }

        /* ===== CTA ===== */
        .cta {
            margin-top: 40px;
            display: flex;
            gap: 15px;
        }

        .btn {
            padding: 14px 26px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            transition: all .3s ease;
            text-align: center;
        }

        .primary {
            background: var(--color-primary);
            color: var(--color-text);
        }

        .primary:hover {
            background: var(--color-secondary);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(199, 186, 4, 0.3);
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

        /* ===== ANIMATION & HOVER FIX ===== */
        .fade-up {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp .8s forwards cubic-bezier(0.16, 1, 0.3, 1);
        }

        .delay-1 {
            animation-delay: .2s;
        }

        .delay-2 {
            animation-delay: .4s;
        }

        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Le hover-lift est séparé de l'animation pour éviter le conflit CSS */
        .hover-lift {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 45px rgba(13, 12, 67, 0.12);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .project-detail-page {
                padding: 60px 15px;
            }

            .containers {
                margin: 20px 15px;
            }

            .header h1 {
                font-size: 28px;
            }

            .kpi-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .cta {
                flex-direction: column;
            }

            .btn {
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .project-detail-page {
                padding: 50px 12px;
            }

            .containers {
                margin: 15px 10px;
            }

            .header h1 {
                font-size: 24px;
                line-height: 1.3;
            }

            .grid {
                gap: 40px;
            }

            .info-card {
                padding: 24px;
            }

            .timeline {
                padding-left: 15px;
                border-left-width: 2px;
            }

            .timeline-item::before {
                left: -23px;
                width: 10px;
                height: 10px;
            }

            .cta {
                gap: 12px;
            }

            .btn {
                padding: 12px 20px;
                font-size: 14px;
            }
        }

        @media (max-width: 350px) {
            .header h1 {
                font-size: 20px;
            }

            .info-card {
                padding: 18px;
            }

            .kpi-box strong {
                font-size: 20px;
            }
        }
    </style>

    <script>
        // Fix du bug : L'animation CSS "fade-up" bloque le "transform" du ":hover".
        // Ce script retire la classe d'animation une fois qu'elle est terminée pour libérer le hover.
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.fade-up').forEach(el => {
                el.addEventListener('animationend', () => {
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                    el.classList.remove('fade-up', 'delay-1', 'delay-2');
                });
            });
        });
    </script>
@endsection
