@extends('layouts.main')

@section('content')
    {{-- Lien CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/css/pages/parrainage.css') }}">

    ```
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

            {{-- Grille --}}
            <div class="students-grid">

                @forelse ($students as $student)
                    <article class="student-card {{ $student->status === 'completed' ? 'is-completed' : '' }}">

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
                            @else
                                <div class="student-status available">
                                    <span class="status-dot"></span>
                                    <span>@lang('parrainage.cta_button', ['name' => $student->first_name])</span>
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

                            </div>

                            {{-- Informations --}}
                            <div class="student-details">

                                <div class="student-info">
                                    <span class="info-icon">
                                        <i class="fas fa-birthday-cake"></i>
                                    </span>

                                    <span>
                                        {{ $student->age }} ans
                                    </span>
                                </div>

                                <div class="student-info">
                                    <span class="info-icon">
                                        <i class="fas fa-graduation-cap"></i>
                                    </span>

                                    <span>
                                        {{ $student->education_level_label }}
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

                            {{-- Progression --}}
                            <div class="progress-container">

                                <div class="progress-top">

                                    <div class="progress-title">
                                        <i class="fas fa-hand-holding-heart"></i>
                                        <span>Progression</span>
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
                                    <a href="{{ route('parrainage.form', ['locale' => app()->getLocale(), 'student' => $student->id]) }}"
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
                                    <button class="btn-parrainer btn-completed" disabled>
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

        </div>
    </section>


    <style>
        /* =========================================================
                   PARRAINAGE — MODERN STUDENT CARDS
                   Aucun changement backend
                   ========================================================= */


        /* =========================
                   VARIABLES
                   ========================= */

        :root {
            --par-primary: #feed02;
            --par-primary-dark: #d8c900;

            --par-secondary: #0d0c43;
            --par-secondary-soft: #191854;

            --par-blue: #0da3d8;
            --par-blue-dark: #087eaa;

            --par-green: #10b981;
            --par-green-dark: #059669;

            --par-text: #172033;
            --par-muted: #737b8c;
            --par-light: #f5f7fa;
            --par-border: rgba(13, 12, 67, 0.08);

            --par-white: #ffffff;

            --par-radius: 22px;
            --par-radius-small: 12px;

            --par-shadow:
                0 12px 35px rgba(13, 12, 67, 0.08);

            --par-shadow-hover:
                0 25px 55px rgba(13, 12, 67, 0.16);

            --par-transition:
                0.35s cubic-bezier(.22, 1, .36, 1);
        }


        /* =========================
                   SECTION
                   ========================= */

        .parrainage-section {
            padding: 4rem 0 6rem;
            background:
                radial-gradient(circle at 10% 5%,
                    rgba(13, 163, 216, .06),
                    transparent 28%),
                radial-gradient(circle at 90% 20%,
                    rgba(254, 237, 2, .09),
                    transparent 25%),
                linear-gradient(180deg,
                    #ffffff 0%,
                    #fbfcfe 55%,
                    #fffef2 100%);
            overflow: hidden;
        }


        .parrainage-container {
            width: min(1400px, calc(100% - 80px));
            margin: 40px auto;
            padding: 0;
        }


        /* =========================
                   HERO — INCHANGÉ VISUELLEMENT
                   ========================= */

        .parrainage-hero {
            text-align: center;
            margin-bottom: 3.5rem;
        }


        .parrainage-title {
            font-size: clamp(2rem, 4vw, 2.8rem);
            font-weight: 800;
            color: var(--par-blue);
            margin-bottom: .6rem;
            letter-spacing: -.03em;
        }


        .parrainage-desc {
            color: var(--par-text);
            max-width: 700px;
            margin: 0 auto;
            line-height: 1.7;
        }


        .title-underline {
            width: 6rem;
            height: 4px;
            border-radius: 100px;
            background:
                linear-gradient(90deg,
                    var(--par-blue),
                    var(--par-primary));
            margin: 1rem auto 0;
        }


        /* =========================================================
                   GRID
                   ========================================================= */

        .students-grid {
            display: grid;
            grid-template-columns:
                repeat(auto-fill, minmax(310px, 1fr));
            gap: 2rem;
            align-items: stretch;
        }


        /* =========================================================
                   CARD
                   ========================================================= */

        .student-card {
            position: relative;
            display: flex;
            flex-direction: column;

            min-width: 0;

            background: rgba(255, 255, 255, .96);

            border:
                1px solid rgba(13, 12, 67, .07);

            border-radius: var(--par-radius);

            overflow: hidden;

            box-shadow: var(--par-shadow);

            isolation: isolate;

            transform: translateY(0);

            transition:
                transform var(--par-transition),
                box-shadow var(--par-transition),
                border-color var(--par-transition);
        }


        .student-card::before {
            content: "";

            position: absolute;
            inset: 0;

            border-radius: inherit;

            background:
                linear-gradient(135deg,
                    rgba(13, 163, 216, .05),
                    transparent 40%,
                    rgba(254, 237, 2, .06));

            pointer-events: none;
            z-index: -1;
        }


        .student-card:hover {
            transform: translateY(-10px);

            box-shadow: var(--par-shadow-hover);

            border-color:
                rgba(13, 163, 216, .18);
        }


        /* =========================================================
                   IMAGE AREA
                   ========================================================= */

        .student-media {
            position: relative;

            width: 100%;
            height: 255px;

            overflow: hidden;

            background:
                linear-gradient(135deg,
                    #e9f7fc,
                    #fffef2);
        }


        .student-photo {
            display: block;

            width: 100%;
            height: 100%;

            object-fit: cover;

            transform: scale(1);

            transition:
                transform .8s cubic-bezier(.22, 1, .36, 1);
        }


        .student-card:hover .student-photo {
            transform: scale(1.07);
        }


        .student-media-overlay {
            position: absolute;
            inset: 0;

            background:
                linear-gradient(180deg,
                    rgba(13, 12, 67, 0) 40%,
                    rgba(13, 12, 67, .52) 100%);

            opacity: .85;

            transition:
                opacity var(--par-transition);

            pointer-events: none;
        }


        .student-card:hover .student-media-overlay {
            opacity: 1;
        }


        /* =========================================================
                   STATUS
                   ========================================================= */

        .student-status {
            position: absolute;

            top: 16px;
            left: 16px;

            display: inline-flex;
            align-items: center;
            gap: 8px;

            max-width: calc(100% - 32px);

            padding: 8px 12px;

            border-radius: 999px;

            font-size: .72rem;
            font-weight: 700;

            letter-spacing: .01em;

            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);

            box-shadow:
                0 6px 18px rgba(0, 0, 0, .12);

            z-index: 3;
        }


        .student-status.available {
            color: white;
            background:
                rgba(13, 12, 67, .72);

            border:
                1px solid rgba(255, 255, 255, .18);
        }


        .student-status.completed {
            color: white;
            background:
                rgba(16, 185, 129, .88);

            border:
                1px solid rgba(255, 255, 255, .25);
        }


        .status-dot {
            width: 7px;
            height: 7px;

            flex: 0 0 7px;

            border-radius: 50%;

            background: var(--par-primary);

            box-shadow:
                0 0 0 4px rgba(254, 237, 2, .15);

            animation: statusPulse 2s infinite;
        }


        @keyframes statusPulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(.75);
                opacity: .65;
            }
        }


        /* =========================================================
                   CARD CONTENT
                   ========================================================= */

        .student-content {
            display: flex;
            flex-direction: column;

            flex: 1;

            padding: 1.5rem 1.5rem 1.35rem;
        }


        /* =========================================================
                   NAME
                   ========================================================= */

        .student-heading {
            margin-bottom: 1.15rem;
        }


        .student-name-wrapper {
            position: relative;
            display: inline-block;
            max-width: 100%;
        }


        .student-name {
            margin: 0;

            color: var(--par-secondary);

            font-size: 1.3rem;
            line-height: 1.25;

            font-weight: 800;

            letter-spacing: -.025em;

            overflow-wrap: anywhere;
        }


        .student-name-line {
            display: block;

            width: 28px;
            height: 3px;

            margin-top: 8px;

            border-radius: 999px;

            background:
                linear-gradient(90deg,
                    var(--par-blue),
                    var(--par-primary));

            transition:
                width var(--par-transition);
        }


        .student-card:hover .student-name-line {
            width: 65px;
        }


        /* =========================================================
                   DETAILS
                   ========================================================= */

        .student-details {
            display: flex;
            flex-direction: column;
            gap: .62rem;

            margin-bottom: 1.35rem;
        }


        .student-info {
            display: flex;
            align-items: center;
            gap: .65rem;

            min-width: 0;

            margin: 0;

            color: var(--par-muted);

            font-size: .86rem;
            line-height: 1.4;
        }


        .student-info>span:last-child {
            min-width: 0;

            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }


        .info-icon {
            display: flex;
            align-items: center;
            justify-content: center;

            width: 30px;
            height: 30px;

            flex: 0 0 30px;

            border-radius: 9px;

            color: var(--par-blue);

            background:
                rgba(13, 163, 216, .09);

            font-size: .78rem;

            transition:
                transform var(--par-transition),
                background var(--par-transition);
        }


        .student-card:hover .info-icon {
            transform: translateX(2px);

            background:
                rgba(13, 163, 216, .14);
        }


        .student-location .info-icon {
            color: #e36b4f;

            background:
                rgba(227, 107, 79, .09);
        }


        /* =========================================================
                   PROGRESS
                   ========================================================= */

        .progress-container {
            margin-top: auto;
            margin-bottom: 1.2rem;
            padding: 1rem;

            border-radius: 15px;

            background:
                linear-gradient(135deg,
                    #f8fafc,
                    #ffffff);

            border:
                1px solid rgba(13, 12, 67, .06);
        }


        .progress-top {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 10px;

            margin-bottom: .75rem;
        }


        .progress-title {
            display: flex;
            align-items: center;
            gap: .45rem;

            color: var(--par-secondary);

            font-size: .76rem;
            font-weight: 700;

            text-transform: uppercase;
            letter-spacing: .05em;
        }


        .progress-title i {
            color: var(--par-blue);
        }


        .progress-percentage {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            padding: 4px 8px;

            border-radius: 7px;

            color: var(--par-secondary);

            background:
                rgba(254, 237, 2, .28);

            font-size: .72rem;
            font-weight: 800;
        }


        .progress-bar-bg {
            position: relative;

            width: 100%;
            height: 9px;

            overflow: hidden;

            border-radius: 100px;

            background: #e8edf2;

            box-shadow:
                inset 0 1px 2px rgba(0, 0, 0, .05);
        }


        .progress-bar-fill {
            position: relative;

            width: var(--progress-width);

            height: 100%;

            border-radius: inherit;

            background:
                linear-gradient(90deg,
                    var(--par-blue) 0%,
                    #20b9e9 50%,
                    var(--par-primary) 100%);

            box-shadow:
                0 2px 8px rgba(13, 163, 216, .22);

            transform-origin: left;

            animation:
                progressReveal 1.2s cubic-bezier(.22, 1, .36, 1) both;
        }


        .progress-glow {
            position: absolute;

            top: 0;
            right: -10px;

            width: 25px;
            height: 100%;

            border-radius: inherit;

            background: rgba(255, 255, 255, .65);

            filter: blur(4px);

            opacity: .6;

            animation:
                progressShine 2.4s ease-in-out infinite;
        }


        @keyframes progressReveal {

            from {
                width: 0;
                transform: scaleX(.2);
            }

            to {
                width: var(--progress-width);
                transform: scaleX(1);
            }
        }


        @keyframes progressShine {

            0%,
            100% {
                opacity: .15;
            }

            50% {
                opacity: .8;
            }
        }


        .progress-labels {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 10px;

            margin-top: .7rem;
        }


        .amount-current {
            color: var(--par-blue);

            font-size: .8rem;
            font-weight: 800;
        }


        .amount-target {
            color: var(--par-muted);

            font-size: .75rem;
            font-weight: 600;
        }


        .progress-labels small {
            font-size: .68rem;
            font-weight: 700;
            opacity: .8;
        }


        /* =========================================================
                   CTA
                   ========================================================= */

        .student-action {
            position: relative;
        }


        .btn-parrainer {
            position: relative;

            display: flex;
            align-items: center;
            justify-content: center;

            width: 100%;
            min-height: 52px;

            overflow: hidden;

            padding: .8rem 1rem;

            border: 0;
            border-radius: 13px;

            background:
                linear-gradient(135deg,
                    var(--par-primary),
                    #fff36b);

            color: var(--par-secondary);

            font-family: inherit;
            font-size: .88rem;
            font-weight: 800;

            text-decoration: none;

            cursor: pointer;

            box-shadow:
                0 8px 20px rgba(254, 237, 2, .20);

            transition:
                transform var(--par-transition),
                box-shadow var(--par-transition),
                background var(--par-transition);
        }


        .btn-content {
            position: relative;
            z-index: 2;

            display: flex;
            align-items: center;
            justify-content: center;

            width: 100%;

            gap: .7rem;
        }


        .btn-icon {
            display: flex;
            align-items: center;
            justify-content: center;

            width: 30px;
            height: 30px;

            flex: 0 0 30px;

            border-radius: 9px;

            background:
                rgba(13, 12, 67, .09);

            transition:
                transform var(--par-transition);
        }


        .btn-text {
            flex: 1;

            text-align: center;
        }


        .btn-arrow {
            display: flex;
            align-items: center;
            justify-content: center;

            width: 26px;
            height: 26px;

            flex: 0 0 26px;

            border-radius: 50%;

            background:
                rgba(13, 12, 67, .09);

            transition:
                transform var(--par-transition),
                background var(--par-transition);
        }


        .btn-parrainer:hover {
            transform: translateY(-3px);

            background:
                linear-gradient(135deg,
                    var(--par-secondary),
                    var(--par-secondary-soft));

            color: var(--par-primary);

            box-shadow:
                0 14px 28px rgba(13, 12, 67, .22);
        }


        .btn-parrainer:hover .btn-icon {
            transform: scale(1.08) rotate(-5deg);

            background:
                rgba(254, 237, 2, .12);
        }


        .btn-parrainer:hover .btn-arrow {
            transform: translateX(4px);

            background:
                rgba(254, 237, 2, .12);
        }


        .btn-parrainer:active {
            transform: translateY(-1px);
        }


        .btn-parrainer:focus-visible {
            outline: 3px solid rgba(13, 163, 216, .25);
            outline-offset: 3px;
        }


        /* Effet lumineux */

        .btn-shine {
            position: absolute;

            top: 0;
            left: -100%;

            width: 60%;
            height: 100%;

            transform: skewX(-20deg);

            background:
                linear-gradient(90deg,
                    transparent,
                    rgba(255, 255, 255, .5),
                    transparent);

            transition:
                left .7s ease;

            pointer-events: none;
        }


        .btn-parrainer:hover .btn-shine {
            left: 130%;
        }


        /* =========================================================
                   COMPLETED STATE
                   ========================================================= */

        .student-card.is-completed {
            border-color:
                rgba(16, 185, 129, .15);
        }


        .student-card.is-completed .progress-bar-fill {
            background:
                linear-gradient(90deg,
                    var(--par-green-dark),
                    var(--par-green));
        }


        .btn-completed {
            background:
                linear-gradient(135deg,
                    #10b981,
                    #34d399);

            color: white;

            box-shadow:
                0 8px 20px rgba(16, 185, 129, .18);

            cursor: default;
        }


        .btn-completed:hover {
            background:
                linear-gradient(135deg,
                    #10b981,
                    #34d399);

            color: white;

            transform: none;

            box-shadow:
                0 8px 20px rgba(16, 185, 129, .18);
        }


        .btn-completed .btn-icon {
            background:
                rgba(255, 255, 255, .16);
        }


        /* =========================================================
                   EMPTY STATE
                   ========================================================= */

        .empty-students {
            grid-column: 1 / -1;

            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;

            min-height: 250px;

            padding: 3rem;

            text-align: center;

            color: var(--par-muted);

            background: rgba(255, 255, 255, .8);

            border:
                1px dashed rgba(13, 12, 67, .14);

            border-radius: var(--par-radius);
        }


        .empty-icon {
            display: flex;
            align-items: center;
            justify-content: center;

            width: 65px;
            height: 65px;

            margin-bottom: 1rem;

            border-radius: 20px;

            color: var(--par-blue);

            background:
                rgba(13, 163, 216, .08);

            font-size: 1.4rem;
        }


        .empty-students p {
            margin: 0;

            font-size: .95rem;
            font-weight: 600;
        }


        /* =========================================================
                   RESPONSIVE — TABLET
                   ========================================================= */

        @media (max-width: 1100px) {

            .parrainage-container {
                width: min(100% - 48px, 1000px);
            }

            .students-grid {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));

                gap: 1.5rem;
            }

        }


        /* =========================================================
                   RESPONSIVE — MOBILE
                   ========================================================= */

        @media (max-width: 700px) {

            .parrainage-section {
                padding:
                    2.5rem 0 4rem;
            }


            .parrainage-container {
                width: calc(100% - 28px);

                margin:
                    20px auto;
            }


            .parrainage-hero {
                margin-bottom: 2.5rem;
            }


            .students-grid {
                grid-template-columns: 1fr;

                gap: 1.25rem;
            }


            .student-card {
                border-radius: 19px;
            }


            .student-media {
                height: 245px;
            }


            .student-content {
                padding:
                    1.3rem;
            }


            .student-name {
                font-size: 1.2rem;
            }


            .progress-container {
                padding: .9rem;
            }


            .btn-parrainer {
                min-height: 50px;
            }

        }


        /* =========================================================
                   PETITS ÉCRANS
                   ========================================================= */

        @media (max-width: 400px) {

            .parrainage-container {
                width: calc(100% - 20px);
            }


            .student-media {
                height: 220px;
            }


            .student-content {
                padding: 1.1rem;
            }


            .student-status {
                top: 12px;
                left: 12px;

                max-width:
                    calc(100% - 24px);

                font-size: .67rem;
            }


            .progress-title {
                font-size: .68rem;
            }


            .progress-percentage {
                font-size: .68rem;
            }


            .btn-text {
                font-size: .8rem;
            }

        }


        /* =========================================================
                   ACCESSIBILITÉ / MOTION
                   ========================================================= */

        @media (prefers-reduced-motion: reduce) {

            .student-card,
            .student-photo,
            .btn-parrainer,
            .btn-arrow,
            .btn-icon,
            .student-name-line,
            .info-icon {
                transition: none !important;
            }


            .progress-bar-fill,
            .progress-glow,
            .status-dot {
                animation: none !important;
            }

        }
    </style>
    ```
@endsection
