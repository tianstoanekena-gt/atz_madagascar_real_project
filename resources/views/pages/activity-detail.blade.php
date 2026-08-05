@extends('layouts.main')

@section('title', $activity->title . ' - ATZ Madagascar')

@section('content')
    <section class="activity-page">

        {{-- HERO PLEINE LARGEUR --}}
        <div class="activity-hero">
            @if ($activity->hero_image)
                <img src="{{ Storage::url($activity->hero_image) }}" alt="{{ $activity->title }}" class="activity-hero-img">
            @else
                <div class="activity-hero-placeholder">
                    <i class="fas fa-image"></i>
                </div>
            @endif

            <div class="activity-hero-overlay"></div>

            <div class="activity-hero-content">
                <nav class="activity-breadcrumb">
                    <a href="{{ localized_route('home') }}" class="activity-breadcrumb-link">
                        <i class="fas fa-home"></i>
                    </a>
                    <span class="activity-breadcrumb-sep">/</span>
                    <a href="{{ localized_route('activities') }}" class="activity-breadcrumb-link">
                        @lang('activity.back')
                    </a>
                    <span class="activity-breadcrumb-sep">/</span>
                    <span class="activity-breadcrumb-current">{{ $activity->title }}</span>
                </nav>

                <h1 class="activity-hero-title">{{ $activity->title }}</h1>
            </div>
        </div>

        {{-- CORPS --}}
        <div class="activity-body">
            <div class="activity-layout">

                {{-- CONTENU PRINCIPAL --}}
                <div class="activity-main">
                    <div class="activity-section-label">
                        <span class="activity-label-dot"></span>
                        @lang('activity.about')
                    </div>

                    <div class="activity-text">
                        <p>{{ $activity->description }}</p>
                    </div>

                    {{-- GALERIE --}}
                    @if ($activity->galleries->isNotEmpty())
                        <div class="activity-gallery-block">
                            <div class="activity-section-label">
                                <span class="activity-label-dot"></span>
                                @lang('activity.gallery')
                            </div>

                            <div class="activity-gallery-grid">
                                @foreach ($activity->galleries as $galleryItem)
                                    <div class="activity-gallery-item"
                                        onclick="activityOpenLightbox('{{ Storage::url($galleryItem->image_path) }}')">
                                        <img src="{{ Storage::url($galleryItem->image_path) }}" alt="Galerie"
                                            class="activity-gallery-img" loading="lazy">
                                        <div class="activity-gallery-zoom">
                                            <i class="fas fa-search-plus"></i>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- LIGHTBOX --}}
        <div id="activity-lightbox" class="activity-lightbox" onclick="activityCloseLightbox(event)">
            <button type="button" class="activity-lightbox-close" onclick="activityCloseLightbox(event)">
                <i class="fas fa-times"></i>
            </button>
            <img class="activity-lightbox-img" id="activity-lightbox-img" alt="Aperçu">
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

        .activity-page {
            background: #ffffff;
            font-family: system-ui, -apple-system, sans-serif;
            color: var(--color-text);
        }

        /* ===== HERO ===== */
        .activity-hero {
            position: relative;
            width: 100%;
            height: 62vh;
            min-height: 380px;
            max-height: 620px;
            overflow: hidden;
            background: var(--color-text);
        }

        .activity-hero-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            animation: activityHeroZoom 12s ease-out forwards;
        }

        @keyframes activityHeroZoom {
            from {
                transform: scale(1.12);
            }

            to {
                transform: scale(1);
            }
        }

        .activity-hero-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 5rem;
            color: rgba(255, 255, 255, 0.15);
        }

        .activity-hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(13, 12, 67, 0.92) 0%, rgba(13, 12, 67, 0.35) 45%, rgba(13, 12, 67, 0.05) 75%);
        }

        .activity-hero-content {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            padding: 0 24px 44px;
            max-width: 1180px;
            margin: 0 auto;
        }

        .activity-breadcrumb {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
            opacity: 0;
            animation: activityFadeIn 0.7s ease forwards 0.2s;
        }

        .activity-breadcrumb-link {
            color: rgba(255, 255, 255, 0.75);
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: color 0.25s ease;
        }

        .activity-breadcrumb-link:hover {
            color: var(--color-primary);
        }

        .activity-breadcrumb-sep {
            color: rgba(255, 255, 255, 0.4);
            font-size: 13px;
        }

        .activity-breadcrumb-current {
            color: var(--color-primary);
            font-size: 13px;
            font-weight: 700;
            max-width: 220px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .activity-hero-title {
            font-size: 3rem;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.15;
            max-width: 780px;
            opacity: 0;
            transform: translateY(18px);
            animation: activityFadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards 0.35s;
        }

        @keyframes activityFadeIn {
            to {
                opacity: 1;
            }
        }

        @keyframes activityFadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ===== BODY ===== */
        .activity-body {
            padding: 56px 24px 90px;
        }

        .activity-layout {
            max-width: 1180px;
            margin: 0 auto;
            grid-template-columns: 1fr 300px;
            gap: 56px;
            align-items: start;
        }

        .activity-section-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--color-blue);
            margin-bottom: 18px;
        }

        .activity-label-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--color-primary);
        }

        .activity-text p {
            font-size: 1.15rem;
            line-height: 1.85;
            color: var(--color-text);
            opacity: 0.82;
            white-space: pre-line;
        }

        .activity-gallery-block {
            margin-top: 56px;
        }

        /* ===== GALERIE MASONRY ===== */
        .activity-gallery-grid {
            column-count: 6;
            column-gap: 2px;
        }

        .activity-gallery-item {
            position: relative;
            break-inside: avoid;
            margin-bottom: 14px;
            border-radius: 12px;
            overflow: hidden;
            cursor: pointer;
            box-shadow: 0 4px 16px rgba(13, 12, 67, 0.08);
        }

        .activity-gallery-img {
            width: 100%;
            display: block;
            transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .activity-gallery-item:hover .activity-gallery-img {
            transform: scale(1.06);
        }

        .activity-gallery-zoom {
            position: absolute;
            inset: 0;
            background: rgba(13, 12, 67, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .activity-gallery-item:hover .activity-gallery-zoom {
            opacity: 1;
        }

        .activity-gallery-zoom i {
            color: #ffffff;
            font-size: 1.4rem;
        }

        /* ===== SIDEBAR ===== */
        .activity-sidebar-card {
            position: sticky;
            top: 24px;
            background: var(--color-background);
            border-radius: 16px;
            padding: 18px;
            border: 1px solid rgba(13, 12, 67, 0.06);
            display: none;
        }

        .activity-sidebar-thumb {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            cursor: pointer;
            margin-bottom: 16px;
        }

        .activity-sidebar-thumb img {
            width: 100%;
            display: block;
            transition: transform 0.5s ease;
        }

        .activity-sidebar-thumb:hover img {
            transform: scale(1.06);
        }

        .activity-sidebar-thumb-zoom {
            position: absolute;
            inset: 0;
            background: rgba(13, 12, 67, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .activity-sidebar-thumb:hover .activity-sidebar-thumb-zoom {
            opacity: 1;
        }

        .activity-sidebar-thumb-zoom i {
            color: #ffffff;
            font-size: 1.2rem;
        }

        .activity-sidebar-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 13px 18px;
            background: var(--color-text);
            color: #ffffff;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), background 0.3s ease;
        }

        .activity-sidebar-btn:hover {
            background: var(--color-blue);
            transform: translateY(-2px);
        }

        /* ===== LIGHTBOX ===== */
        .activity-lightbox {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(13, 12, 67, 0.95);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 30px;
        }

        .activity-lightbox.is-open {
            display: flex;
        }

        .activity-lightbox-img {
            max-width: 100%;
            max-height: 88vh;
            border-radius: 8px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
        }

        .activity-lightbox-close {
            position: absolute;
            top: 24px;
            right: 24px;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: #ffffff;
            font-size: 1.1rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.25s ease, transform 0.25s ease;
        }

        .activity-lightbox-close:hover {
            background: var(--color-red);
            transform: rotate(90deg);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 900px) {
            .activity-layout {
                grid-template-columns: 1fr;
            }

            .activity-sidebar-card {
                position: static;
            }

            .activity-hero-title {
                font-size: 2.2rem;
            }
        }

        @media (max-width: 600px) {
            .activity-hero {
                height: 46vh;
                min-height: 300px;
            }

            .activity-hero-title {
                font-size: 1.6rem;
            }

            .activity-body {
                padding: 40px 16px 60px;
            }

            .activity-text p {
                font-size: 1rem;
            }

            .activity-gallery-grid {
                column-count: 2;
                column-gap: 10px;
            }

            .activity-gallery-item {
                margin-bottom: 10px;
            }
        }

        @media (max-width: 380px) {
            .activity-hero-title {
                font-size: 1.35rem;
            }

            .activity-breadcrumb-current {
                max-width: 140px;
            }
        }
    </style>

    <script>
        function activityOpenLightbox(src) {
            const lightbox = document.getElementById('activity-lightbox');
            const img = document.getElementById('activity-lightbox-img');
            img.src = src;
            lightbox.classList.add('is-open');
            document.body.style.overflow = 'hidden';
        }

        function activityCloseLightbox(event) {
            // Ferme uniquement au clic sur le fond ou le bouton, pas sur l'image elle-même
            if (event.target.id === 'activity-lightbox-img') return;
            const lightbox = document.getElementById('activity-lightbox');
            lightbox.classList.remove('is-open');
            document.body.style.overflow = 'auto';
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                document.getElementById('activity-lightbox').classList.remove('is-open');
                document.body.style.overflow = 'auto';
            }
        });
    </script>
@endsection
