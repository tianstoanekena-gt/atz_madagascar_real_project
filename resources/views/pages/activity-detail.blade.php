@extends('layouts.main')

@section('title', $activity->title . ' - ATZ Madagascar')

@section('content')
    <section class="activity-page">
        <div class="container mx-auto px-4 max-w-6xl">

            {{-- HEADER --}}
            <div class="header mb-12 fade-up">
                <nav class="breadcrumb text-sm text-gray-500 mb-4 flex items-center gap-2">
                    <a href="{{ localized_route('home') }}" class="head_cta"><i class="fas fa-home"></i></a>
                    <a href="{{ localized_route('activities') }}" class="head_cta"><i class="fas fa-list"></i></a>
                </nav>
                <div class="title-decoration"></div>
            </div>

            {{-- GRID --}}
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 lg:gap-12 detail_card_section">

                <h1 class="activity-title-main col-span-1 lg:col-span-5">{{ $activity->title }}</h1>
                {{-- INFO (2/5) --}}
                <div class="lg:col-span-2 fade-up delay-2">
                    <div class="info-card">
                        <h2 class="info-title">
                            @lang('activity.about')
                            <span class="title-underline"></span>
                        </h2>

                        <div class="info-description">
                            <p>{{ $activity->description }}</p>
                        </div>

                        {{-- CTA --}}
                        <div class="cta-buttons">
                            <a href="{{ localized_route('contact') }}" class="btn btn-primary">
                                <i class="fas fa-heart"></i>
                                <span>@lang('activity.support')</span>
                            </a>
                            <a href="{{ localized_route('activities') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i>
                                <span>@lang('activity.back')</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- MEDIA (3/5) --}}
                <div class="lg:col-span-3 fade-up delay-1">
                    {{-- HERO IMAGE AVEC ZOOM --}}
                    @if ($activity->hero_image)
                        <div class="media-card cursor-zoom-in"
                            onclick="openLightbox('{{ Storage::url($activity->hero_image) }}')">
                            <img src="{{ Storage::url($activity->hero_image) }}" alt="{{ $activity->title }}"
                                class="hero-image">
                            <div class="media-overlay flex items-center justify-center">
                                <i
                                    class="fas fa-search-plus text-white text-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></i>
                            </div>
                        </div>
                    @else
                        <div class="media-card">
                            <div class="hero-placeholder">
                                <i class="fas fa-image text-6xl text-gray-400"></i>
                            </div>
                        </div>
                    @endif
                    <br>
                    <br>

                    {{-- GALERIE MINIMALISTE AVEC ZOOM --}}
                    @if ($activity->galleries->isNotEmpty())
                        <div class="gallery mt-10 fade-up delay-2">
                            <h3 class="gallery-title">
                                <i class="fas fa-images"></i> @lang('activity.gallery')
                            </h3>
                            <div class="gallery-grid grid grid-cols-2 md:grid-cols-3 gap-3">
                                @foreach ($activity->galleries as $galleryItem)
                                    <div class="gallery-item cursor-zoom-in"
                                        onclick="openLightbox('{{ Storage::url($galleryItem->image_path) }}')">
                                        <img src="{{ Storage::url($galleryItem->image_path) }}" alt="Galerie"
                                            class="gallery-image">
                                        <div class="gallery-overlay flex items-center justify-center">
                                            <i
                                                class="fas fa-search-plus text-white text-2xl opacity-0 transition-opacity duration-300"></i>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </div>

        {{-- LIGHTBOX (GRAND PLAN) --}}
        <div id="image-lightbox" class="lightbox" onclick="closeLightbox(event)">
            <span class="lightbox-close">&times;</span>
            <img class="lightbox-content" id="lightbox-img">
        </div>

    </section>

    <style>
        /* ============================================
                                                                   ANIMATIONS & DÉCORATIONS CSS PUR
                                                                   ============================================ */

        /* Animations d'apparition */
        .fade-up {
            opacity: 0;
            transform: translateY(40px);
            animation: fadeUp 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .delay-1 {
            animation-delay: 0.15s;
        }

        .delay-2 {
            animation-delay: 0.3s;
        }

        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .activity-page {
            margin-top: 4rem;
            padding-bottom: 4rem;
        }

        .head_cta {
            color: #0DA3D8;
            transition: all 0.2s ease-in-out;
            font-size: 2rem;
            margin-right: 5rem;
        }

        .head_cta:hover {
            color: #FEE002;
            transform: scale(1.05);
        }

        .detail_card_section {
            margin-top: 4rem;
        }

        /* Header & Titre */
        .activity-title-main {
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 800;
            color: #1a202c;
            line-height: 1.2;
            margin-bottom: 1rem;
            position: relative;
            text-transform: capitalize;
        }

        .title-decoration {
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, #0DA3D8, #FEE002);
            border-radius: 2px;
            margin-top: 1rem;
            animation: expandWidth 1.2s ease-out forwards;
            transform-origin: left;
        }

        @keyframes expandWidth {
            from {
                width: 0;
            }

            to {
                width: 80px;
            }
        }

        /* Media Card */
        .media-card {
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            position: relative;
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .media-card:hover {
            box-shadow: 0 20px 60px rgba(13, 163, 216, 0.15);
            transform: translateY(-5px);
        }

        .hero-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            transition: transform 0.7s ease;
        }

        .media-card:hover .hero-image {
            transform: scale(1.05);
        }

        .hero-placeholder {
            width: 100%;
            height: 400px;
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .media-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.3);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .media-card:hover .media-overlay {
            opacity: 1;
        }

        /* Gallery Minimaliste */
        .gallery-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .gallery-title i {
            color: #0DA3D8;
            font-size: 1.1rem;
        }

        .gallery-item {
            aspect-ratio: 1;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            position: relative;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .gallery-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(13, 163, 216, 0.15);
        }

        .gallery-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .gallery-item:hover .gallery-image {
            transform: scale(1.1);
        }

        .gallery-overlay {
            position: absolute;
            inset: 0;
            background: rgba(13, 163, 216, 0.4);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }

        /* Info Card */
        .info-card {
            background: white;
            border-radius: 24px;
            padding: 2rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            position: sticky;
            top: 6rem;
            transition: all 0.4s ease;
        }

        .info-card:hover {
            box-shadow: 0 15px 50px rgba(13, 163, 216, 0.12);
        }

        .info-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f3f4f6;
            position: relative;
        }

        .title-underline {
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 60px;
            height: 2px;
            background: linear-gradient(90deg, #0DA3D8, #FEE002);
            animation: slideIn 1s ease-out forwards;
        }

        @keyframes slideIn {
            from {
                width: 0;
            }

            to {
                width: 60px;
            }
        }

        .info-description {
            margin-bottom: 2rem;
        }

        .info-description p {
            line-height: 1.8;
            white-space: pre-line;
            font-size: 1.05rem;
            font-weight: 500;
            color: #4b5563;
        }

        /* CTA Buttons */
        .cta-buttons {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .btn {
            padding: 1rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            text-decoration: none;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s ease, height 0.6s ease;
        }

        .btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0DA3D8, #0985b0);
            color: white;
            box-shadow: 0 4px 15px rgba(13, 163, 216, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(13, 163, 216, 0.4);
        }

        .btn-secondary {
            background: white;
            color: #374151;
            border: 2px solid #e5e7eb;
        }

        .btn-secondary:hover {
            border-color: #0DA3D8;
            color: #0DA3D8;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(13, 163, 216, 0.15);
        }

        .btn i {
            font-size: 1.1rem;
            transition: transform 0.3s ease;
        }

        .btn:hover i {
            transform: scale(1.2);
        }

        /* ============================================
                                                                   LIGHTBOX (GRAND PLAN)
                                                                   ============================================ */
        .lightbox {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            backdrop-filter: blur(8px);
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .lightbox.active {
            display: flex;
            opacity: 1;
        }

        .lightbox-content {
            max-width: 90%;
            max-height: 90vh;
            border-radius: 8px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
            transform: scale(0.9);
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            object-fit: contain;
        }

        .lightbox.active .lightbox-content {
            transform: scale(1);
        }

        .lightbox-close {
            position: absolute;
            top: 20px;
            right: 30px;
            color: #fff;
            font-size: 40px;
            font-weight: 300;
            cursor: pointer;
            transition: 0.3s;
            line-height: 1;
        }

        .lightbox-close:hover {
            color: #0DA3D8;
            transform: rotate(90deg);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {

            .hero-image,
            .hero-placeholder {
                height: 280px;
            }

            .info-card {
                position: static;
                padding: 1.5rem;
            }

            .cta-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }

            .gallery-grid {
                gap: 2 !important;
            }
        }
    </style>

    <script>
        // Logique Lightbox (Grand Plan)
        function openLightbox(src) {
            const lightbox = document.getElementById('image-lightbox');
            const img = document.getElementById('lightbox-img');
            img.src = src;
            lightbox.classList.add('active');
            document.body.style.overflow = 'hidden'; // Empêche le scroll arrière-plan
        }

        function closeLightbox(event) {
            // Ferme si on clique sur le fond ou la croix, mais pas sur l'image elle-même
            if (event.target.id === 'image-lightbox' || event.target.classList.contains('lightbox-close')) {
                const lightbox = document.getElementById('image-lightbox');
                lightbox.classList.remove('active');
                document.body.style.overflow = 'auto'; // Réactive le scroll
            }
        }

        // Fermeture avec la touche Echap
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const lightbox = document.getElementById('image-lightbox');
                if (lightbox.classList.contains('active')) {
                    lightbox.classList.remove('active');
                    document.body.style.overflow = 'auto';
                }
            }
        });
    </script>
@endsection
