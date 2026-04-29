@extends('layouts.main')

@php
    use Illuminate\Support\Facades\Storage;
    $locale = app()->getLocale();
    $translation = $sponsor->translation($locale);
    $hasDetails = $sponsor->details && $sponsor->details->getLongDescription($locale);
    $hasPhotos = $sponsor->details && $sponsor->details->photos->count() > 0;
@endphp

@section('content')
    <section class="sponsor-detail-section">
        <div class="sponsor-detail-container">

            {{-- Bouton Retour --}}
            <div class="back-button-wrapper fade-up">
                <a href="{{ localized_route('sponsors') }}" class="back-button">
                    <span class="back-icon">
                        <i class="fas fa-arrow-left"></i>
                    </span>
                    <span class="back-text">@lang('sponsor.back_to_list')</span>
                </a>
            </div>

            {{-- Carte principale sponsor --}}
            <div class="sponsor-main-card fade-up delay-1">
                <div class="sponsor-main-inner">

                    {{-- Logo --}}
                    @if ($sponsor->logo && Storage::disk('public')->exists($sponsor->logo))
                        <div class="sponsor-logo-area">
                            <div class="sponsor-logo-wrapper">
                                <img src="{{ Storage::url($sponsor->logo) }}" alt="{{ $sponsor->name }}" loading="lazy"
                                    class="sponsor-logo-img">
                            </div>
                        </div>
                    @endif

                    {{-- Infos --}}
                    <div class="sponsor-info-area">
                        <h1 class="sponsor-name">{{ $sponsor->name }}</h1>

                        <div class="sponsor-badges">
                            @if ($sponsor->since_year)
                                <span class="badge badge-blue">
                                    <i class="fas fa-calendar-alt"></i>
                                    @lang('sponsor.partner_since') {{ $sponsor->since_year }}
                                </span>
                            @endif
                            @if ($sponsor->is_active)
                                <span class="badge badge-green">
                                    <i class="fas fa-check-circle"></i>
                                    @lang('sponsor.active')
                                </span>
                            @endif
                        </div>

                        @if ($sponsor->website)
                            <a href="{{ $sponsor->website }}" target="_blank" rel="noopener noreferrer"
                                class="sponsor-website">
                                <span>@lang('sponsor.visit_website')</span>
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Description courte --}}
            @if ($translation?->short_description)
                <div class="info-card fade-up delay-2">
                    <div class="card-header">
                        <div class="card-icon blue">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <h2 class="card-title">@lang('sponsor.about')</h2>
                    </div>
                    <div class="card-content">
                        <p class="description-text">{{ $translation->short_description }}</p>
                    </div>
                </div>
            @endif

            {{-- Histoire du partenariat --}}
            @if ($hasDetails)
                <div class="info-card fade-up delay-3">
                    <div class="card-header">
                        <div class="card-icon blue">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <h2 class="card-title">@lang('sponsor.our_story')</h2>
                    </div>
                    <div class="card-content story-content">
                        {!! nl2br(e($sponsor->details->getLongDescription($locale))) !!}
                    </div>
                </div>
            @endif

            {{-- Galerie photo --}}
            @if ($hasPhotos)
                <div class="gallery-card fade-up delay-4">
                    <div class="gallery-header">
                        <div class="card-icon purple">
                            <i class="fas fa-images"></i>
                        </div>
                        <h2 class="card-title">@lang('sponsor.gallery')</h2>
                        <span class="photo-count">
                            <i class="fas fa-camera"></i> {{ $sponsor->details->photos->count() }}
                        </span>
                    </div>

                    <div class="gallery-grid">
                        @foreach ($sponsor->details->photos as $index => $photo)
                            <div class="gallery-item"
                                onclick="openLightbox('{{ Storage::url($photo->photo) }}', '{{ addslashes($photo->caption ?? '') }}', {{ $index }})"
                                role="button" tabindex="0"
                                onkeypress="if(event.key==='Enter')openLightbox('{{ Storage::url($photo->photo) }}', '{{ addslashes($photo->caption ?? '') }}', {{ $index }})"
                                style="animation-delay: {{ 0.03 * $index }}s">
                                <div class="gallery-image-wrapper">
                                    <img src="{{ Storage::url($photo->photo) }}"
                                        alt="{{ $photo->caption ?? 'Photo sponsor' }}" loading="lazy" class="gallery-img">
                                    <div class="gallery-overlay">
                                        <div class="gallery-overlay-content">
                                            <i class="fas fa-search-plus"></i>
                                            @if ($photo->caption)
                                                <span class="gallery-caption-text">{{ $photo->caption }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <span class="gallery-index">{{ $index + 1 }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- CTA sobre --}}
            <div class="cta-sobre-card fade-up delay-5">
                <div class="cta-sobre-content">
                    <div class="cta-sobre-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h2 class="cta-sobre-title">@lang('sponsor.cta_title')</h2>
                    <p class="cta-sobre-text">@lang('sponsor.cta_description')</p>

                    <div class="cta-sobre-buttons">
                        <a href="{{ localized_route('contact') }}" class="cta-btn cta-btn-primary">
                            <i class="fas fa-envelope"></i>
                            <span>@lang('sponsor.cta_contact')</span>
                        </a>
                        <a href="{{ localized_route('sponsors') }}" class="cta-btn cta-btn-secondary">
                            <i class="fas fa-users"></i>
                            <span>@lang('sponsor.cta_see_all')</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- Lightbox --}}
    <div id="lightbox" class="lightbox hidden" onclick="closeLightbox()" role="dialog" aria-modal="true">
        <div class="lightbox-container" onclick="event.stopPropagation()">
            <div class="lightbox-image-wrapper">
                <img id="lightbox-image" class="lightbox-image" alt="Photo agrandie">
                <div id="lightbox-loader" class="lightbox-loader hidden">
                    <div class="spinner"></div>
                </div>
            </div>
            <p id="lightbox-caption" class="lightbox-caption"></p>
            <button onclick="closeLightbox()" class="lightbox-close" title="@lang('sponsor.close')">
                <i class="fas fa-times"></i>
            </button>
            @if ($hasPhotos && $sponsor->details->photos->count() > 1)
                <button onclick="previousPhoto(); event.stopPropagation();" class="lightbox-nav lightbox-prev">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button onclick="nextPhoto(); event.stopPropagation();" class="lightbox-nav lightbox-next">
                    <i class="fas fa-chevron-right"></i>
                </button>
                <div class="lightbox-counter">
                    <span id="lightbox-counter-current">1</span>
                    <span>/</span>
                    <span>{{ $sponsor->details->photos->count() }}</span>
                </div>
            @endif
        </div>
    </div>

    <style>
        /* ============================================
                   SPONSOR DETAIL PAGE - CSS PUR
                   ============================================ */

        :root {
            --color-primary: #feed02;
            --color-secondary: #c7ba04;
            --color-text: #0d0c43;
            --color-background: #fffef2;
            --color-accent: #6f4413;
            --color-blue: #0da3d8;
            --color-green: #6e9d2e;
            --color-red: rgb(200, 0, 0);
            --color-gray-50: #f8f9fa;
            --color-gray-100: #f3f4f6;
            --color-gray-200: #e5e7eb;
            --color-gray-300: #d1d5db;
            --color-gray-400: #9ca3af;
            --color-gray-500: #6b7280;
            --color-gray-600: #4b5563;
            --color-gray-700: #374151;
            --color-gray-800: #1f2937;
            --color-gray-900: #111827;
        }

        .sponsor-detail-section {
            padding: 60px 20px 80px;
            background: linear-gradient(135deg, var(--color-gray-50) 0%, #ffffff 100%);
            min-height: 100vh;
        }

        .sponsor-detail-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* ===== BOUTON RETOUR ===== */
        .back-button-wrapper {
            margin-bottom: 40px;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: var(--color-gray-600);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .back-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            background: white;
            border-radius: 50%;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .back-button:hover {
            color: var(--color-blue);
        }

        .back-button:hover .back-icon {
            background: var(--color-blue);
            color: white;
            transform: translateX(-3px);
        }

        /* ===== CARTE PRINCIPALE ===== */
        .sponsor-main-card {
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            border: 1px solid var(--color-gray-200);
            transition: all 0.3s ease;
        }

        .sponsor-main-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(13, 163, 216, 0.1);
            border-color: rgba(13, 163, 216, 0.2);
        }

        .sponsor-main-inner {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 40px;
            padding: 40px;
        }

        .sponsor-logo-area {
            flex-shrink: 0;
        }

        .sponsor-logo-wrapper {
            background: white;
            border-radius: 20px;
            padding: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .sponsor-logo-wrapper:hover {
            transform: scale(1.02);
            box-shadow: 0 10px 30px rgba(13, 163, 216, 0.15);
        }

        .sponsor-logo-img {
            width: 140px;
            height: 140px;
            object-fit: contain;
            display: block;
        }

        .sponsor-info-area {
            flex: 1;
            text-align: left;
        }

        .sponsor-name {
            font-size: 36px;
            font-weight: 700;
            color: var(--color-gray-900);
            margin-bottom: 15px;
            letter-spacing: -0.5px;
        }

        .sponsor-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 15px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 500;
        }

        .badge-blue {
            background: rgba(13, 163, 216, 0.1);
            color: var(--color-blue);
        }

        .badge-green {
            background: rgba(110, 157, 46, 0.1);
            color: var(--color-green);
        }

        .sponsor-website {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--color-blue);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .sponsor-website:hover {
            gap: 12px;
            color: var(--color-text);
        }

        /* ===== CARTES INFO ===== */
        .info-card {
            background: white;
            border-radius: 24px;
            padding: 30px;
            margin-bottom: 30px;
            border: 1px solid var(--color-gray-200);
            transition: all 0.3s ease;
        }

        .info-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.05);
            border-color: rgba(13, 163, 216, 0.2);
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .card-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .card-icon.blue {
            background: rgba(13, 163, 216, 0.1);
            color: var(--color-blue);
        }

        .card-icon.purple {
            background: rgba(139, 92, 246, 0.1);
            color: #8b5cf6;
        }

        .card-title {
            font-size: 22px;
            font-weight: 600;
            color: var(--color-gray-800);
            margin: 0;
        }

        .card-content {
            padding-left: 0;
        }

        .description-text {
            font-size: 16px;
            line-height: 1.7;
            color: var(--color-gray-600);
            margin: 0;
            border-left: 3px solid var(--color-blue);
            padding-left: 20px;
        }

        .story-content {
            font-size: 15px;
            line-height: 1.7;
            color: var(--color-gray-600);
        }

        /* ===== GALERIE ===== */
        .gallery-card {
            background: white;
            border-radius: 24px;
            padding: 30px;
            margin-bottom: 30px;
            border: 1px solid var(--color-gray-200);
            transition: all 0.3s ease;
        }

        .gallery-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.05);
        }

        .gallery-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .photo-count {
            margin-left: auto;
            font-size: 13px;
            color: var(--color-gray-500);
            background: var(--color-gray-100);
            padding: 5px 12px;
            border-radius: 20px;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }

        .gallery-item {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            cursor: pointer;
            opacity: 0;
            transform: scale(0.95);
            animation: galleryItemAppear 0.4s ease forwards;
        }

        @keyframes galleryItemAppear {
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .gallery-image-wrapper {
            position: relative;
            aspect-ratio: 1 / 1;
            overflow: hidden;
            border-radius: 16px;
        }

        .gallery-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .gallery-item:hover .gallery-img {
            transform: scale(1.1);
        }

        .gallery-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(13, 163, 216, 0.85);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }

        .gallery-overlay-content {
            text-align: center;
            color: white;
            transform: translateY(15px);
            transition: transform 0.3s ease;
        }

        .gallery-item:hover .gallery-overlay-content {
            transform: translateY(0);
        }

        .gallery-overlay-content i {
            font-size: 28px;
            margin-bottom: 8px;
            display: inline-block;
        }

        .gallery-caption-text {
            font-size: 12px;
            display: block;
            max-width: 150px;
            margin-top: 5px;
        }

        .gallery-index {
            position: absolute;
            top: 10px;
            left: 10px;
            width: 26px;
            height: 26px;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 600;
            color: white;
            z-index: 2;
        }

        /* ===== CTA SOBRE (sans bleu dominant) ===== */
        .cta-sobre-card {
            background: linear-gradient(135deg, var(--color-gray-800) 0%, var(--color-gray-900) 100%);
            border-radius: 24px;
            padding: 50px 40px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .cta-sobre-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .cta-sobre-icon {
            width: 70px;
            height: 70px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .cta-sobre-icon i {
            font-size: 32px;
            color: var(--color-primary);
        }

        .cta-sobre-title {
            font-size: 26px;
            font-weight: 700;
            color: white;
            margin-bottom: 12px;
        }

        .cta-sobre-text {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 30px;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta-sobre-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .cta-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 28px;
            border-radius: 40px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .cta-btn-primary {
            background: var(--color-primary);
            color: var(--color-text);
        }

        .cta-btn-primary:hover {
            background: #e5d602;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(254, 237, 2, 0.3);
        }

        .cta-btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .cta-btn-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        /* ===== ANIMATIONS ===== */
        .fade-up {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp 0.6s ease forwards;
        }

        .delay-1 {
            animation-delay: 0.1s;
        }

        .delay-2 {
            animation-delay: 0.2s;
        }

        .delay-3 {
            animation-delay: 0.3s;
        }

        .delay-4 {
            animation-delay: 0.4s;
        }

        .delay-5 {
            animation-delay: 0.5s;
        }

        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ===== LIGHTBOX ===== */
        .lightbox {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(15px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .lightbox:not(.hidden) {
            opacity: 1;
            visibility: visible;
        }

        .lightbox.hidden {
            display: none;
        }

        .lightbox-container {
            position: relative;
            max-width: 90vw;
            max-height: 90vh;
        }

        .lightbox-image-wrapper {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
        }

        .lightbox-image {
            max-width: 85vw;
            max-height: 80vh;
            object-fit: contain;
            display: block;
            transition: all 0.3s ease;
        }

        .lightbox-caption {
            text-align: center;
            color: white;
            margin-top: 15px;
            font-size: 14px;
        }

        .lightbox-close {
            position: absolute;
            top: -15px;
            right: -15px;
            width: 45px;
            height: 45px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 18px;
            color: var(--color-gray-800);
        }

        .lightbox-close:hover {
            transform: scale(1.1);
            background: var(--color-red);
            color: white;
        }

        .lightbox-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(5px);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            color: white;
            transition: all 0.3s ease;
        }

        .lightbox-nav:hover {
            background: rgba(255, 255, 255, 0.4);
            transform: translateY(-50%) scale(1.05);
        }

        .lightbox-prev {
            left: -20px;
        }

        .lightbox-next {
            right: -20px;
        }

        .lightbox-counter {
            position: absolute;
            bottom: -35px;
            left: 50%;
            transform: translateX(-50%);
            color: white;
            /* background: rgba(0, 0, 0, 0.5); */
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 13px;
        }

        .lightbox-loader {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            /* background: rgba(0, 0, 0, 0.5); */
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top-color: var(--color-primary);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            display: none;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 900px) {
            .sponsor-main-inner {
                flex-direction: column;
                text-align: center;
                padding: 30px;
            }

            .sponsor-info-area {
                text-align: center;
            }

            .sponsor-badges {
                justify-content: center;
            }

            .sponsor-name {
                font-size: 28px;
            }

            .sponsor-logo-img {
                width: 110px;
                height: 110px;
            }
        }

        @media (max-width: 768px) {
            .sponsor-detail-section {
                padding: 40px 15px 60px;
            }

            .sponsor-main-inner {
                padding: 25px;
                gap: 20px;
            }

            .sponsor-name {
                font-size: 24px;
            }

            .info-card,
            .gallery-card {
                padding: 20px;
            }

            .card-title {
                font-size: 18px;
            }

            .description-text {
                font-size: 14px;
                padding-left: 15px;
            }

            .gallery-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                gap: 12px;
            }

            .cta-sobre-card {
                padding: 35px 25px;
            }

            .cta-sobre-title {
                font-size: 22px;
            }

            .cta-sobre-text {
                font-size: 14px;
            }

            .cta-btn {
                padding: 10px 20px;
                font-size: 13px;
            }

            .lightbox-prev,
            .lightbox-next {
                display: none;
            }

            .lightbox-close {
                top: -10px;
                right: -10px;
                width: 35px;
                height: 35px;
            }
        }

        @media (max-width: 480px) {
            .gallery-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }

            .cta-sobre-buttons {
                flex-direction: column;
                align-items: center;
            }

            .cta-btn {
                width: 100%;
                justify-content: center;
            }

            .sponsor-logo-img {
                width: 90px;
                height: 90px;
            }
        }
    </style>

    <script>
        // Données photos
        const photos = @json(
            $sponsor->details?->photos->map(fn($p) => [
                    'src' => Storage::url($p->photo),
                    'caption' => $p->caption ?? '',
                ]) ?? []
        );

        let currentPhotoIndex = 0;
        const lightbox = document.getElementById('lightbox');
        const lightboxImage = document.getElementById('lightbox-image');
        const lightboxCaption = document.getElementById('lightbox-caption');
        const lightboxLoader = document.getElementById('lightbox-loader');
        const lightboxCounterSpan = document.getElementById('lightbox-counter-current');

        function openLightbox(src, caption, index = 0) {
            currentPhotoIndex = index;
            lightboxLoader.classList.remove('hidden');
            lightboxImage.style.opacity = '0';

            const img = new Image();
            img.onload = () => {
                lightboxImage.src = src;
                lightboxCaption.textContent = caption;
                lightbox.classList.remove('hidden');
                setTimeout(() => {
                    lightboxImage.style.opacity = '1';
                }, 10);
                lightboxLoader.classList.add('hidden');
                if (lightboxCounterSpan) lightboxCounterSpan.textContent = currentPhotoIndex + 1;
            };
            img.onerror = () => lightboxLoader.classList.add('hidden');
            img.src = src;

            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            lightbox.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function previousPhoto() {
            if (photos.length === 0) return;
            currentPhotoIndex = (currentPhotoIndex - 1 + photos.length) % photos.length;
            updateLightbox();
        }

        function nextPhoto() {
            if (photos.length === 0) return;
            currentPhotoIndex = (currentPhotoIndex + 1) % photos.length;
            updateLightbox();
        }

        function updateLightbox() {
            const photo = photos[currentPhotoIndex];
            if (!photo) return;

            lightboxLoader.classList.remove('hidden');
            lightboxImage.style.opacity = '0';

            const img = new Image();
            img.onload = () => {
                lightboxImage.src = photo.src;
                lightboxCaption.textContent = photo.caption;
                lightboxImage.style.opacity = '1';
                lightboxLoader.classList.add('hidden');
                if (lightboxCounterSpan) lightboxCounterSpan.textContent = currentPhotoIndex + 1;
            };
            img.src = photo.src;
        }

        // Navigation clavier
        document.addEventListener('keydown', function(e) {
            if (!lightbox.classList.contains('hidden')) {
                if (e.key === 'Escape') closeLightbox();
                if (e.key === 'ArrowLeft') previousPhoto();
                if (e.key === 'ArrowRight') nextPhoto();
            }
        });
    </script>
@endsection
