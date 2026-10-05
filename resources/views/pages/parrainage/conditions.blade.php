@extends('layouts.main')

@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/parrainage.css') }}">

    <section class="">
        <div class="">

            {{-- Titre --}}
            <div class="parrainage-hero">
                <h2 class="parrainage-title">@lang('parrainage.conditions.title')</h2>
                <p class="parrainage-desc">@lang('parrainage.conditions.subtitle')</p>
                <div class="title-underline"></div>
            </div>

            {{-- Contenu des conditions --}}
            <div class="conditions-card">

                {{-- Introduction --}}
                <div class="condition-intro">
                    <p>
                        @lang('parrainage.conditions.intro')
                    </p>
                </div>

                {{-- Article 1 --}}
                <article class="condition-item condition-blue">

                    <div class="condition-header">
                        <span class="condition-number">1</span>

                        <h3>
                            @lang('parrainage.conditions.article1.title')
                        </h3>
                    </div>

                    <p class="condition-text">
                        @lang('parrainage.conditions.article1.content')
                    </p>

                </article>

                {{-- Article 2 --}}
                <article class="condition-item condition-primary">

                    <div class="condition-header">
                        <span class="condition-number">2</span>

                        <h3>
                            @lang('parrainage.conditions.article2.title')
                        </h3>
                    </div>

                    <p class="condition-text">
                        @lang('parrainage.conditions.article2.content')
                    </p>

                    <div class="condition-highlight">
                        <p>
                            @lang('parrainage.conditions.article2.highlight')
                        </p>
                    </div>

                </article>

                {{-- Article 3 --}}
                <article class="condition-item condition-blue">

                    <div class="condition-header">
                        <span class="condition-number">3</span>

                        <h3>
                            @lang('parrainage.conditions.article3.title')
                        </h3>
                    </div>

                    <p class="condition-text">
                        @lang('parrainage.conditions.article3.content')
                    </p>

                    <ul class="condition-list">
                        <li>
                            <span class="list-marker"></span>
                            <span>
                                @lang('parrainage.conditions.article3.point1')
                            </span>
                        </li>

                        <li>
                            <span class="list-marker"></span>
                            <span>
                                @lang('parrainage.conditions.article3.point2')
                            </span>
                        </li>

                        <li>
                            <span class="list-marker"></span>
                            <span>
                                @lang('parrainage.conditions.article3.point3')
                            </span>
                        </li>
                    </ul>

                </article>

                {{-- Article 4 --}}
                <article class="condition-item condition-green">

                    <div class="condition-header">
                        <span class="condition-number">4</span>

                        <h3>
                            @lang('parrainage.conditions.article4.title')
                        </h3>
                    </div>

                    <p class="condition-text">
                        @lang('parrainage.conditions.article4.content')
                    </p>

                    <div class="commitments-grid">

                        <div class="commitment-card commitment-green">
                            <div class="commitment-icon">
                                <i class="fas fa-hand-holding-heart"></i>
                            </div>

                            <p>
                                @lang('parrainage.conditions.article4.commitment_parrain')
                            </p>
                        </div>

                        <div class="commitment-card commitment-blue">
                            <div class="commitment-icon">
                                <i class="fas fa-building"></i>
                            </div>

                            <p>
                                @lang('parrainage.conditions.article4.commitment_atz')
                            </p>
                        </div>

                    </div>

                </article>

                {{-- Article 5 --}}
                <article class="condition-item condition-red">

                    <div class="condition-header">
                        <span class="condition-number">5</span>

                        <h3>
                            @lang('parrainage.conditions.article5.title')
                        </h3>
                    </div>

                    <p class="condition-text">
                        @lang('parrainage.conditions.article5.content')
                    </p>

                </article>

                {{-- Article 6 --}}
                <article class="condition-item condition-accent">

                    <div class="condition-header">
                        <span class="condition-number">6</span>

                        <h3>
                            @lang('parrainage.conditions.article6.title')
                        </h3>
                    </div>

                    <p class="condition-text">
                        @lang('parrainage.conditions.article6.content')
                    </p>

                </article>

                {{-- Article 7 --}}
                <article class="condition-item condition-primary-dark">

                    <div class="condition-header">
                        <span class="condition-number">7</span>

                        <h3>
                            @lang('parrainage.conditions.article7.title')
                        </h3>
                    </div>

                    <p class="condition-text">
                        @lang('parrainage.conditions.article7.content')
                    </p>

                    <div class="condition-highlight condition-note">
                        <p>
                            @lang('parrainage.conditions.article7.note')
                        </p>
                    </div>

                </article>

                {{-- CTA Final --}}
                <div class="conditions-cta-wrapper">

                    <div class="conditions-cta">

                        <div class="cta-decoration cta-decoration-one"></div>
                        <div class="cta-decoration cta-decoration-two"></div>

                        <div class="cta-content">

                            <div class="cta-icon">
                                <i class="fas fa-heart"></i>
                            </div>

                            <h3>
                                @lang('parrainage.conditions.cta_title')
                            </h3>

                            <p>
                                @lang('parrainage.conditions.cta_text')
                            </p>

                            <div class="cta-buttons">

                                <a href="" class="cta-button cta-button-primary">

                                    <span>
                                        <i class="fas fa-users"></i>
                                    </span>

                                    <span>
                                        @lang('parrainage.conditions.btn_browse')
                                    </span>

                                    <i class="fas fa-arrow-right cta-arrow"></i>

                                </a>

                                <a href="{{ route('register') }}" class="cta-button cta-button-secondary">

                                    <span>
                                        <i class="fas fa-user-plus"></i>
                                    </span>

                                    <span>
                                        @lang('parrainage.conditions.btn_register')
                                    </span>

                                    <i class="fas fa-arrow-right cta-arrow"></i>

                                </a>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- Date de dernière mise à jour --}}
                <div class="last-update">
                    <span class="update-line"></span>

                    <p>
                        @lang('parrainage.conditions.last_update')
                        :
                        {{ now()->format('d/m/Y') }}
                    </p>

                    <span class="update-line"></span>
                </div>

            </div>

        </div>
    </section>

    <style>
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


        .p_section {
            margin-top: 12rem;
        }

        .parrainage-section {
            position: relative;

            padding: 4rem 0 6rem;

            background:
                linear-gradient(180deg,
                    var(--color-background) 0%,
                    #ffffff 45%,
                    var(--color-background) 100%);

            overflow: hidden;
        }


        .parrainage-section::before {
            content: "";

            position: absolute;

            width: 420px;
            height: 420px;

            top: -180px;
            right: -180px;

            border-radius: 50%;

            border:
                1px solid var(--color-primary);

            opacity: .18;

            pointer-events: none;
        }


        .parrainage-section::after {
            content: "";

            position: absolute;

            width: 300px;
            height: 300px;

            bottom: -150px;
            left: -150px;

            border-radius: 50%;

            border:
                1px solid var(--color-blue);

            opacity: .14;

            pointer-events: none;
        }


        .parrainage-container {
            position: relative;

            width: min(900px, calc(100% - 40px));

            margin: 40px auto;

            z-index: 1;
        }


        /* =========================================================
                       HERO
                       ========================================================= */

        .parrainage-hero {
            text-align: center;

            margin-bottom: 3rem;
        }


        .parrainage-title {
            margin: 0 0 .6rem;

            color: var(--color-blue);

            font-size: clamp(2rem, 5vw, 2.7rem);

            font-weight: 800;

            line-height: 1.15;

            letter-spacing: -.03em;
        }


        .parrainage-desc {
            max-width: 700px;

            margin: 0 auto;

            color: var(--color-text);

            font-size: .98rem;

            line-height: 1.7;
        }


        .title-underline {
            width: 90px;
            height: 4px;

            margin: 1rem auto 0;

            border-radius: 100px;

            background:
                linear-gradient(90deg,
                    var(--color-blue),
                    var(--color-primary));
        }


        /* =========================================================
                       MAIN CARD
                       ========================================================= */

        .conditions-card {
            position: relative;

            padding: 2.5rem;

            background: #ffffff;

            border:
                1px solid var(--color-background);

            border-radius: 24px;

            box-shadow:
                0 20px 60px rgba(13, 12, 67, .10);
        }


        .conditions-card::before {
            content: "";

            position: absolute;

            top: 0;
            left: 50%;

            width: 90%;
            height: 3px;

            transform: translateX(-50%);

            background:
                linear-gradient(90deg,
                    var(--color-blue),
                    var(--color-primary),
                    var(--color-blue));

            border-radius:
                0 0 100px 100px;
        }


        /* =========================================================
                       INTRODUCTION
                       ========================================================= */

        .condition-intro {
            position: relative;

            margin-bottom: 2.5rem;

            padding: 1.4rem 1.5rem;

            border-left:
                4px solid var(--color-primary);

            border-radius: 0 14px 14px 0;

            background:
                var(--color-background);
        }


        .condition-intro::before {
            content: "";

            position: absolute;

            left: -4px;
            top: 0;

            width: 4px;
            height: 0;

            background:
                var(--color-blue);

            border-radius: 0 100px 100px 0;

            transition:
                height .5s ease;
        }


        .condition-intro:hover::before {
            height: 100%;
        }


        .condition-intro p {
            margin: 0;

            color: var(--color-text);

            font-size: 1.05rem;

            line-height: 1.8;
        }


        /* =========================================================
                       ARTICLES
                       ========================================================= */

        .condition-item {
            position: relative;

            margin-bottom: 2.4rem;

            padding:
                .7rem 0 .7rem 1.6rem;

            border-left:
                4px solid var(--color-blue);

            border-radius: 0 12px 12px 0;

            transition:
                transform .35s ease,
                padding-left .35s ease,
                background-color .35s ease;
        }


        .condition-item:hover {
            transform: translateX(5px);

            padding-left: 1.8rem;
        }


        .condition-item:last-of-type {
            margin-bottom: 0;
        }


        /* =========================================================
                       ARTICLE COLOR VARIANTS
                       ========================================================= */

        .condition-blue {
            border-left-color:
                var(--color-blue);
        }


        .condition-primary {
            border-left-color:
                var(--color-primary);
        }


        .condition-green {
            border-left-color:
                var(--color-green);
        }


        .condition-red {
            border-left-color:
                var(--color-red);
        }


        .condition-accent {
            border-left-color:
                var(--color-accent);
        }


        .condition-primary-dark {
            border-left-color:
                var(--color-secondary);
        }


        /* =========================================================
                       ARTICLE HEADER
                       ========================================================= */

        .condition-header {
            display: flex;

            align-items: center;

            gap: .8rem;

            margin-bottom: 1rem;
        }


        .condition-header h3 {
            margin: 0;

            color: var(--color-text);

            font-size: 1.2rem;

            font-weight: 800;

            line-height: 1.35;
        }


        .condition-number {
            position: relative;

            display: flex;

            align-items: center;
            justify-content: center;

            width: 38px;
            height: 38px;

            flex: 0 0 38px;

            border-radius: 50%;

            color: var(--color-text);

            background:
                var(--color-primary);

            font-size: .85rem;

            font-weight: 800;

            box-shadow:
                0 5px 15px rgba(254, 237, 2, .25);

            transition:
                transform .35s ease,
                box-shadow .35s ease;
        }


        .condition-item:hover .condition-number {
            transform:
                rotate(8deg) scale(1.08);

            box-shadow:
                0 8px 20px rgba(254, 237, 2, .38);
        }


        .condition-blue .condition-number {
            color: #ffffff;

            background:
                var(--color-blue);
        }


        .condition-green .condition-number {
            color: #ffffff;

            background:
                var(--color-green);
        }


        .condition-red .condition-number {
            color: #ffffff;

            background:
                var(--color-red);
        }


        .condition-accent .condition-number {
            color: #ffffff;

            background:
                var(--color-accent);
        }


        /* =========================================================
                       TEXT
                       ========================================================= */

        .condition-text {
            margin: 0;

            color: var(--color-text);

            opacity: .82;

            font-size: .95rem;

            line-height: 1.8;
        }


        /* =========================================================
                       HIGHLIGHT
                       ========================================================= */

        .condition-highlight {
            position: relative;

            margin-top: 1.1rem;

            padding: 1rem 1.2rem;

            border:
                1px solid var(--color-primary);

            border-radius: 12px;

            background:
                var(--color-background);

            overflow: hidden;
        }


        .condition-highlight::before {
            content: "";

            position: absolute;

            left: 0;
            top: 0;

            width: 3px;
            height: 100%;

            background:
                var(--color-secondary);
        }


        .condition-highlight p {
            position: relative;

            margin: 0;
            padding-left: .4rem;

            color: var(--color-text);

            font-size: .9rem;

            font-weight: 700;

            line-height: 1.6;
        }


        .condition-note {
            border-color:
                var(--color-secondary);

            background:
                var(--color-background);
        }


        .condition-note::before {
            background:
                var(--color-accent);
        }


        /* =========================================================
                       LIST
                       ========================================================= */

        .condition-list {
            display: flex;

            flex-direction: column;

            gap: .8rem;

            margin: 1.2rem 0 0;
            padding: 0;

            list-style: none;
        }


        .condition-list li {
            display: flex;

            align-items: flex-start;

            gap: .7rem;

            color: var(--color-text);

            opacity: .85;

            font-size: .9rem;

            line-height: 1.6;
        }


        .list-marker {
            position: relative;

            display: block;

            width: 7px;
            height: 7px;

            flex: 0 0 7px;

            margin-top: .55rem;

            border-radius: 50%;

            background:
                var(--color-blue);
        }


        .list-marker::after {
            content: "";

            position: absolute;

            inset: -4px;

            border:
                1px solid var(--color-blue);

            border-radius: 50%;

            opacity: .25;
        }


        /* =========================================================
                       COMMITMENTS
                       ========================================================= */

        .commitments-grid {
            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 1rem;

            margin-top: 1.3rem;
        }


        .commitment-card {
            position: relative;

            display: flex;

            align-items: flex-start;

            gap: .8rem;

            min-height: 90px;

            padding: 1.1rem;

            border-radius: 14px;

            overflow: hidden;

            transition:
                transform .35s ease,
                box-shadow .35s ease;
        }


        .commitment-card:hover {
            transform: translateY(-4px);

            box-shadow:
                0 10px 25px rgba(13, 12, 67, .08);
        }


        .commitment-green {
            background:
                var(--color-background);

            border:
                1px solid var(--color-green);
        }


        .commitment-blue {
            background:
                var(--color-background);

            border:
                1px solid var(--color-blue);
        }


        .commitment-icon {
            display: flex;

            align-items: center;
            justify-content: center;

            width: 34px;
            height: 34px;

            flex: 0 0 34px;

            border-radius: 9px;

            color: #ffffff;

            background:
                var(--color-green);
        }


        .commitment-blue .commitment-icon {
            background:
                var(--color-blue);
        }


        .commitment-card p {
            margin: 0;

            color: var(--color-text);

            font-size: .85rem;

            font-weight: 700;

            line-height: 1.6;
        }


        /* =========================================================
                       CTA
                       ========================================================= */

        .conditions-cta-wrapper {
            padding-top: 2.5rem;

            margin-top: 2.5rem;

            border-top:
                2px solid var(--color-background);
        }


        .conditions-cta {
            position: relative;

            padding: 2.7rem 2rem;

            overflow: hidden;

            border-radius: 20px;

            background:
                linear-gradient(135deg,
                    var(--color-text),
                    var(--color-accent));

            color: #ffffff;

            text-align: center;

            box-shadow:
                0 15px 35px rgba(13, 12, 67, .18);
        }


        .cta-decoration {
            position: absolute;

            border:
                1px solid var(--color-primary);

            border-radius: 50%;

            opacity: .15;

            pointer-events: none;
        }


        .cta-decoration-one {
            width: 180px;
            height: 180px;

            top: -100px;
            right: -50px;
        }


        .cta-decoration-two {
            width: 120px;
            height: 120px;

            bottom: -70px;
            left: -35px;

            border-color:
                var(--color-blue);
        }


        .cta-content {
            position: relative;

            z-index: 2;
        }


        .cta-icon {
            display: flex;

            align-items: center;
            justify-content: center;

            width: 55px;
            height: 55px;

            margin: 0 auto 1rem;

            border-radius: 16px;

            color: var(--color-text);

            background:
                var(--color-primary);

            box-shadow:
                0 8px 20px rgba(254, 237, 2, .25);

            animation:
                ctaHeart 2.5s ease-in-out infinite;
        }


        @keyframes ctaHeart {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.08);
            }

        }


        .conditions-cta h3 {
            margin: 0 0 .8rem;

            color: #ffffff;

            font-size: clamp(1.35rem, 4vw, 1.8rem);

            font-weight: 800;

            line-height: 1.3;
        }


        .conditions-cta p {
            max-width: 600px;

            margin: 0 auto 1.6rem;

            color: var(--color-background);

            font-size: .9rem;

            line-height: 1.7;
        }


        /* =========================================================
                       CTA BUTTONS
                       ========================================================= */

        .cta-buttons {
            display: flex;

            align-items: center;
            justify-content: center;

            gap: 1rem;

            flex-wrap: wrap;
        }


        .cta-button {
            position: relative;

            display: inline-flex;

            align-items: center;
            justify-content: center;

            gap: .65rem;

            min-width: 190px;

            padding: .85rem 1.3rem;

            border-radius: 11px;

            font-size: .86rem;

            font-weight: 800;

            text-decoration: none;

            overflow: hidden;

            transition:
                transform .3s ease,
                box-shadow .3s ease,
                background-color .3s ease,
                color .3s ease;
        }


        .cta-button:hover {
            transform:
                translateY(-4px);
        }


        .cta-button-primary {
            color: var(--color-text);

            background:
                var(--color-primary);

            box-shadow:
                0 8px 20px rgba(254, 237, 2, .18);
        }


        .cta-button-primary:hover {
            color: var(--color-text);

            background:
                var(--color-secondary);

            box-shadow:
                0 12px 25px rgba(199, 186, 4, .25);
        }


        .cta-button-secondary {
            color: var(--color-text);

            background:
                var(--color-background);

            box-shadow:
                0 8px 20px rgba(255, 254, 242, .10);
        }


        .cta-button-secondary:hover {
            color: var(--color-text);

            background:
                var(--color-primary);

            box-shadow:
                0 12px 25px rgba(254, 237, 2, .18);
        }


        .cta-arrow {
            transition:
                transform .3s ease;
        }


        .cta-button:hover .cta-arrow {
            transform:
                translateX(4px);
        }


        /* =========================================================
                       LAST UPDATE
                       ========================================================= */

        .last-update {
            display: flex;

            align-items: center;

            justify-content: center;

            gap: 1rem;

            margin-top: 2rem;
        }


        .last-update p {
            margin: 0;

            color: var(--color-text);

            opacity: .55;

            font-size: .75rem;

            font-style: italic;

            white-space: nowrap;
        }


        .update-line {
            width: 45px;
            height: 1px;

            background:
                var(--color-secondary);

            opacity: .4;
        }


        /* =========================================================
                       TABLET
                       ========================================================= */

        @media (max-width: 768px) {

            .parrainage-section {
                padding:
                    3rem 0 4rem;
            }


            .parrainage-container {
                width:
                    calc(100% - 28px);

                margin:
                    25px auto;
            }


            .conditions-card {
                padding:
                    1.5rem;

                border-radius:
                    19px;
            }


            .condition-item {
                padding-left:
                    1.2rem;
            }


            .commitments-grid {
                grid-template-columns:
                    1fr;
            }


            .conditions-cta {
                padding:
                    2rem 1.3rem;
            }


            .cta-buttons {
                flex-direction:
                    column;
            }


            .cta-button {
                width: 100%;
                min-width: 0;
            }

        }


        /* =========================================================
                       MOBILE
                       ========================================================= */

        @media (max-width: 520px) {

            .parrainage-title {
                font-size:
                    2rem;
            }


            .parrainage-desc {
                font-size:
                    .9rem;
            }


            .conditions-card {
                padding:
                    1.15rem;
            }


            .condition-intro {
                padding:
                    1.1rem;
            }


            .condition-intro p {
                font-size:
                    .92rem;
            }


            .condition-item {
                margin-bottom:
                    2rem;

                padding-left:
                    1rem;
            }


            .condition-header {
                align-items:
                    flex-start;

                gap:
                    .65rem;
            }


            .condition-header h3 {
                font-size:
                    1.05rem;
            }


            .condition-number {
                width:
                    34px;

                height:
                    34px;

                flex-basis:
                    34px;
            }


            .condition-text {
                font-size:
                    .88rem;
            }


            .condition-list li {
                font-size:
                    .85rem;
            }


            .commitment-card {
                padding:
                    .9rem;
            }


            .conditions-cta {
                padding:
                    1.8rem 1rem;
            }


            .conditions-cta h3 {
                font-size:
                    1.3rem;
            }


            .conditions-cta p {
                font-size:
                    .84rem;
            }


            .last-update {
                gap:
                    .6rem;
            }


            .update-line {
                width:
                    25px;
            }


            .last-update p {
                font-size:
                    .68rem;
            }

        }


        /* =========================================================
                       VERY SMALL SCREENS
                       ========================================================= */

        @media (max-width: 350px) {

            .parrainage-container {
                width:
                    calc(100% - 18px);
            }


            .conditions-card {
                padding:
                    .9rem;
            }


            .condition-item {
                padding-left:
                    .8rem;
            }


            .condition-header h3 {
                font-size:
                    .98rem;
            }


            .cta-button {
                font-size:
                    .8rem;

                padding:
                    .75rem .8rem;
            }

        }


        /* =========================================================
                       ACCESSIBILITÉ
                       ========================================================= */

        .cta-button:focus-visible {
            outline:
                3px solid var(--color-blue);

            outline-offset:
                3px;
        }


        /* =========================================================
                       REDUCTION DES ANIMATIONS
                       ========================================================= */

        @media (prefers-reduced-motion: reduce) {

            .condition-item,
            .condition-number,
            .commitment-card,
            .cta-button,
            .cta-arrow {
                transition:
                    none !important;
            }


            .cta-icon {
                animation:
                    none !important;
            }

        }
    </style>
@endsection
