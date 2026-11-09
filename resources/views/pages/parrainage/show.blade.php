@extends('layouts.main')
@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/parrainage.css') }}">

    <section class="student-show-section">
        <div class="student-show-container">

            {{-- Bouton Retour --}}
            <div class="show-back-btn-wrapper">
                <a href="{{ route('parrainage.index', ['locale' => app()->getLocale()]) }}" class="show-back-btn">
                    <i class="fas fa-arrow-left"></i>
                    <span>@lang('parrainage.back_to_list')</span>
                </a>
            </div>

            <div class="show-main-card">
                <div class="show-grid">

                    {{-- COLONNE GAUCHE : PHOTO & INFO CLÉS --}}
                    <div class="show-left-col">
                        <div class="show-photo-wrapper">
                            <img src="{{ $student->photo_url }}" alt="{{ $student->full_name }}" class="show-photo">
                        </div>

                        <div class="show-identity">
                            <h1 class="show-name">{{ $student->full_name }}</h1>
                            <div class="show-tags">
                                <span class="show-tag">
                                    <i class="fas fa-birthday-cake"></i> {{ $student->age }}
                                </span>
                                <span class="show-tag">
                                    <i class="fas fa-graduation-cap"></i> {{ $student->education_level_label }}
                                </span>
                                <span class="show-tag">
                                    <i class="fas fa-map-marker-alt"></i> {{ $student->location }}
                                </span>
                                @if ($student->is_sponsored && $student->main_godparent)
                                    <span class="show-tag sponsored-tag">
                                        <i class="fas fa-heart"></i>
                                        <span>@lang('parrainage.sponsored_by', ['name' => $student->main_godparent])</span>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- COLONNE DROITE : HISTOIRE, BESOINS & ACTION --}}
                    <div class="show-right-col">

                        {{-- Histoire --}}
                        <div class="show-info-block">
                            <h2 class="show-info-title">
                                <i class="fas fa-book-open"></i>
                                @lang('parrainage.story_telling')
                            </h2>
                            <div class="show-info-content story-content">
                                {!! nl2br(e($student->description_translated ?? $student->description)) !!}
                            </div>
                        </div>

                        {{-- Besoins --}}
                        <div class="show-info-block">
                            <h2 class="show-info-title">
                                <i class="fas fa-hands-helping"></i>
                                @lang('parrainage.specific_needs')
                            </h2>
                            <div class="show-info-content needs-content">
                                {!! nl2br(e($student->needs_translated ?? $student->needs)) !!}
                            </div>
                        </div>

                        {{-- CTA FINAL --}}
                        <div class="show-cta-wrapper">
                            <div class="show-cta-card">
                                <h3 class="cta-title">@lang('parrainage.parrainage_thnks', ['name' => explode(' ', $student->first_name)[0], 'default' => 'Vous souhaitez parrainer ' . explode(' ', $student->first_name)[0] . ' ?'])</h3>

                                {{-- ✅ STATUT AU-DESSUS DU BOUTON --}}
                                @if ($student->is_sponsored && $student->main_godparent)
                                    <div class="sponsored-status-banner">
                                        <i class="fas fa-heart"></i>
                                        <span>@lang('parrainage.sponsored_by', ['name' => $student->main_godparent])</span>
                                    </div>
                                @endif

                                {{-- ✅ BOUTON CONDITIONNEL --}}
                                @if ($student->is_sponsored)
                                    {{-- Bouton désactivé si déjà parrainé --}}
                                    <button type="button" class="show-cta-btn btn-disabled" disabled>
                                        <span class="btn-content">
                                            <i class="fas fa-check-circle"></i>
                                            <span>@lang('parrainage.already_sponsored', 'Déjà parrainé')</span>
                                        </span>
                                    </button>
                                @else
                                    {{-- Bouton actif si disponible --}}
                                    <a href="{{ route('contact', ['locale' => app()->getLocale()]) }}" class="show-cta-btn">
                                        <span class="btn-content">
                                            <i class="fas fa-heart"></i>
                                            <span>@lang('parrainage.cta_spronsor', ['name' => explode(' ', $student->first_name)[0]])</span>
                                        </span>
                                        <span class="btn-shine"></span>
                                    </a>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        /* =========================================================
                                                                                                               VARIABLES & BASE - COULEURS ATZ MADAGASCAR
                                                                                                               ========================================================= */
        :root {
            --show-primary: #feed02;
            --show-secondary: #c7ba04;
            --show-text: #0d0c43;
            --show-background: #fffef2;
            --show-accent: #6f4413;
            --show-blue: #0da3d8;
            --show-green: #6e9d2e;
            --show-red: rgb(200, 0, 0);
            --show-white: #ffffff;
            --show-muted: #6b7280;
            --show-radius: 1.5rem;
            --show-shadow: 0 20px 40px rgba(13, 12, 67, 0.08);
            --show-transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Banner de statut "Déjà parrainé" */
        .sponsored-status-banner {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.2rem;
            background: rgba(254, 237, 2, 0.15);
            border: 1px solid var(--show-primary);
            border-radius: 999px;
            color: var(--show-primary);
            font-size: 0.9rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            position: relative;
        }

        .sponsored-status-banner i {
            animation: heartBeatBanner 1.5s ease-in-out infinite;
        }

        @keyframes heartBeatBanner {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.3);
            }
        }

        /* Bouton désactivé */
        .show-cta-btn.btn-disabled {
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.5);
            cursor: not-allowed;
            box-shadow: none;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .show-cta-btn.btn-disabled:hover {
            transform: none;
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.5);
            box-shadow: none;
        }

        .show-cta-btn.btn-disabled .btn-content {
            opacity: 0.7;
        }

        .student-show-section {
            padding: 3rem 1.5rem 5rem;
            background: linear-gradient(180deg, var(--show-background) 0%, #ffffff 100%);
            min-height: 80vh;
        }

        .student-show-container {
            max-width: 1100px;
            margin: 0 auto;
        }

        /* Bouton Retour */
        .show-back-btn-wrapper {
            margin-bottom: 2rem;
        }

        .show-back-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--show-muted);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 600;
            padding: 0.6rem 1.2rem;
            border-radius: 999px;
            background: var(--show-white);
            border: 1px solid rgba(13, 12, 67, 0.1);
            transition: all var(--show-transition);
        }

        .show-back-btn:hover {
            color: var(--show-blue);
            border-color: var(--show-blue);
            transform: translateX(-4px);
            box-shadow: 0 4px 12px rgba(13, 163, 216, 0.15);
        }

        /* Carte Principale */
        .show-main-card {
            background: var(--show-white);
            border-radius: var(--show-radius);
            box-shadow: var(--show-shadow);
            overflow: hidden;
            border: 1px solid rgba(13, 12, 67, 0.05);
        }

        .show-grid {
            display: grid;
            grid-template-columns: 1fr;
        }

        @media (min-width: 900px) {
            .show-grid {
                grid-template-columns: 380px 1fr;
            }
        }

        /* Colonne Gauche */
        .show-left-col {
            background: linear-gradient(160deg, var(--show-text) 0%, #1a195a 100%);
            color: white;
            padding: 2.5rem;
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .show-photo-wrapper {
            position: relative;
            width: 220px;
            height: 220px;
            margin: 0 auto;
            border-radius: 50%;
            border: 4px solid var(--show-primary);
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        }

        .show-photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .show-photo-wrapper:hover .show-photo {
            transform: scale(1.05);
        }

        .show-photo-badge {
            position: absolute;
            bottom: 10px;
            right: 10px;
        }

        .badge-available,
        .badge-completed {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 700;
            backdrop-filter: blur(8px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .badge-available {
            background: rgba(110, 157, 46, 0.9);
            color: white;
        }

        .pulse-dot {
            width: 8px;
            height: 8px;
            background: white;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.5);
                opacity: 0.5;
            }
        }

        .badge-completed {
            background: rgba(13, 163, 216, 0.9);
            color: white;
        }

        .show-identity {
            text-align: center;
        }

        .show-name {
            font-size: 2rem;
            font-weight: 800;
            margin: 0 0 1rem 0;
            letter-spacing: -0.02em;
            line-height: 1.2;
            color: white;
        }

        .show-tags {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 0.75rem;
        }

        .show-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 0.5rem 1rem;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 999px;
            font-size: 0.85rem;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.9);
        }

        .show-tag i {
            color: var(--show-primary);
        }

        .show-tag.sponsored-tag {
            background: rgba(254, 237, 2, 0.25);
            border-color: var(--show-primary);
            color: var(--show-primary);
            font-weight: 700;
        }

        .show-tag.sponsored-tag i {
            animation: heartBeatShow 1.5s ease-in-out infinite;
        }

        @keyframes heartBeatShow {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.3);
            }
        }

        /* Progression */
        .show-progress-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            border-radius: 1rem;
            padding: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .progress-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: rgba(255, 255, 255, 0.6);
            margin-bottom: 0.25rem;
            font-weight: 600;
        }

        .progress-amount,
        .progress-target {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--show-primary);
        }

        .progress-target {
            color: white;
            text-align: right;
        }

        .progress-bar-bg {
            height: 10px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 999px;
            overflow: hidden;
            margin-bottom: 0.75rem;
        }

        .progress-bar-fill {
            height: 100%;
            width: var(--progress-width, 0%);
            background: linear-gradient(90deg, var(--show-primary), var(--show-blue));
            border-radius: 999px;
            position: relative;
            transition: width 1.2s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .progress-glow {
            position: absolute;
            top: 0;
            right: 0;
            width: 20px;
            height: 100%;
            background: rgba(255, 255, 255, 0.6);
            filter: blur(4px);
            animation: glow 2s ease-in-out infinite;
        }

        @keyframes glow {

            0%,
            100% {
                opacity: 0.4;
            }

            50% {
                opacity: 0.9;
            }
        }

        .progress-percent {
            text-align: center;
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--show-primary);
        }

        /* Colonne Droite */
        .show-right-col {
            padding: 2.5rem;
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .show-info-block {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .show-info-title {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--show-text);
            margin: 0;
        }

        .show-info-title i {
            color: var(--show-blue);
            font-size: 1.1rem;
        }

        .show-info-content {
            font-size: 1rem;
            line-height: 1.7;
            color: var(--show-text);
            padding: 1.5rem;
            border-radius: 1rem;
        }

        .story-content {
            background: rgba(13, 163, 216, 0.04);
            border-left: 4px solid var(--show-blue);
        }

        .needs-content {
            background: rgba(254, 237, 2, 0.08);
            border-left: 4px solid var(--show-primary);
        }

        /* CTA */
        .show-cta-wrapper {
            margin-top: auto;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(13, 12, 67, 0.08);
        }

        .show-cta-card {
            background: linear-gradient(135deg, var(--show-text), #1a195a);
            border-radius: 1.25rem;
            padding: 2rem;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .show-cta-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(254, 237, 2, 0.1) 0%, transparent 60%);
            pointer-events: none;
        }

        .cta-title {
            font-size: 1.5rem;
            font-weight: 800;
            margin: 0 0 0.75rem 0;
            position: relative;
        }

        .cta-desc {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.95rem;
            margin: 0 0 1.5rem 0;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
            position: relative;
        }

        .show-cta-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            width: 100%;
            max-width: 320px;
            padding: 1rem 1.5rem;
            background: var(--show-primary);
            color: var(--show-text);
            font-weight: 800;
            font-size: 1rem;
            text-decoration: none;
            border-radius: 1rem;
            position: relative;
            overflow: hidden;
            transition: all var(--show-transition);
            box-shadow: 0 8px 20px rgba(254, 237, 2, 0.3);
        }

        .show-cta-btn:hover {
            transform: translateY(-3px);
            background: var(--show-blue);
            color: white;
            box-shadow: 0 12px 25px rgba(13, 163, 216, 0.4);
        }

        .btn-shine {
            position: absolute;
            top: 0;
            left: -100%;
            width: 60%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transform: skewX(-20deg);
            transition: left 0.6s ease;
        }

        .show-cta-btn:hover .btn-shine {
            left: 130%;
        }

        .cta-security {
            margin-top: 1rem;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            position: relative;
        }

        /* =========================================================
                                                                                                               RESPONSIVE - TABLETTE (max-width: 899px)
                                                                                                               ========================================================= */
        @media (max-width: 899px) {
            .student-show-section {
                padding: 2rem 1.25rem 4rem;
            }

            .show-left-col,
            .show-right-col {
                padding: 2rem;
            }

            .show-name {
                font-size: 1.75rem;
            }

            .show-photo-wrapper {
                width: 200px;
                height: 200px;
            }

            .cta-title {
                font-size: 1.35rem;
            }
        }

        /* =========================================================
                                                                                                               RESPONSIVE - MOBILE (max-width: 600px)
                                                                                                               ========================================================= */
        @media (max-width: 600px) {
            .student-show-section {
                padding: 1.5rem 1rem 3rem;
            }

            .show-back-btn {
                font-size: 0.85rem;
                padding: 0.5rem 1rem;
            }

            .show-main-card {
                border-radius: 1.25rem;
            }

            .show-left-col {
                padding: 1.75rem 1.5rem;
                gap: 1.5rem;
            }

            .show-photo-wrapper {
                width: 180px;
                height: 180px;
            }

            .show-name {
                font-size: 1.5rem;
            }

            .show-tags {
                flex-direction: column;
                align-items: center;
                gap: 0.6rem;
            }

            .show-tag {
                font-size: 0.8rem;
                padding: 0.45rem 0.9rem;
            }

            .show-progress-card {
                padding: 1.25rem;
            }

            .progress-header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .progress-target {
                text-align: center;
            }

            .progress-amount,
            .progress-target {
                font-size: 1.1rem;
            }

            .show-right-col {
                padding: 1.75rem 1.5rem;
                gap: 1.5rem;
            }

            .show-info-title {
                font-size: 1.1rem;
            }

            .show-info-content {
                padding: 1.25rem;
                font-size: 0.95rem;
            }

            .show-cta-card {
                padding: 1.5rem 1.25rem;
            }

            .cta-title {
                font-size: 1.25rem;
            }

            .show-cta-btn {
                padding: 0.9rem 1.25rem;
                font-size: 0.95rem;
            }
        }

        /* =========================================================
                                                                                                               RESPONSIVE - TRÈS PETIT ÉCRAN (max-width: 400px)
                                                                                                               ========================================================= */
        @media (max-width: 400px) {
            .student-show-section {
                padding: 1rem 0.75rem 2.5rem;
            }

            .show-back-btn-wrapper {
                margin-bottom: 1.5rem;
            }

            .show-back-btn {
                font-size: 0.8rem;
                padding: 0.45rem 0.9rem;
                gap: 0.4rem;
            }

            .show-main-card {
                border-radius: 1rem;
            }

            .show-left-col {
                padding: 1.5rem 1.25rem;
            }

            .show-photo-wrapper {
                width: 160px;
                height: 160px;
                border-width: 3px;
            }

            .show-name {
                font-size: 1.35rem;
                margin-bottom: 0.75rem;
            }

            .show-tag {
                font-size: 0.75rem;
                padding: 0.4rem 0.8rem;
            }

            .show-progress-card {
                padding: 1rem;
            }

            .progress-amount,
            .progress-target {
                font-size: 1rem;
            }

            .progress-bar-bg {
                height: 8px;
            }

            .show-right-col {
                padding: 1.5rem 1.25rem;
            }

            .show-info-title {
                font-size: 1rem;
            }

            .show-info-content {
                padding: 1rem;
                font-size: 0.9rem;
                line-height: 1.6;
            }

            .show-cta-card {
                padding: 1.25rem 1rem;
                border-radius: 1rem;
            }

            .cta-title {
                font-size: 1.15rem;
            }

            .show-cta-btn {
                padding: 0.85rem 1rem;
                font-size: 0.9rem;
                border-radius: 0.85rem;
            }
        }
    </style>
@endsection
