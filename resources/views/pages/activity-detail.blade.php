@extends('layouts.main')

@section('title', $activity->title . ' - ATZ Madagascar')

@section('content')
    <section class="activity-page">
        <div class="container mx-auto px-4 max-w-6xl">

            {{-- HEADER --}}
            <div class="header mb-12 fade-up">
                <nav class="breadcrumb text-sm text-gray-500 mb-4 flex items-center gap-2">
                    <a href="{{ localized_route('home') }}" class="hover:text-blue-600 transition">@lang('activity.common_home')</a>
                    <i class="fas fa-chevron-right text-xs"></i>
                    <a href="{{ localized_route('activities') }}" class="hover:text-blue-600 transition">@lang('activity.title')</a>
                    <i class="fas fa-chevron-right text-xs"></i>
                    <span class="text-gray-800 font-medium truncate">{{ $activity->title }}</span>
                </nav>
                <h1 class="activity-title-main">{{ $activity->title }}</h1>
                <div class="title-decoration"></div>
            </div>

            {{-- GRID --}}
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 lg:gap-12">

                {{-- MEDIA (3/5) --}}
                <div class="lg:col-span-3 fade-up delay-1">
                    <div class="media-card">
                        @if ($activity->hero_image)
                            <img src="{{ Storage::url($activity->hero_image) }}" alt="{{ $activity->title }}"
                                class="hero-image">
                        @else
                            <div class="hero-placeholder">
                                <i class="fas fa-image text-6xl text-gray-400"></i>
                            </div>
                        @endif
                        <div class="media-overlay"></div>
                    </div>

                    @if (!empty($activity->gallery) && count($activity->gallery) > 0)
                        <div class="gallery mt-8 fade-up delay-2">
                            <h3 class="gallery-title">
                                <i class="fas fa-images"></i> @lang('activity.gallery')
                            </h3>
                            <div class="gallery-grid grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach ($activity->gallery as $img)
                                    <div class="gallery-item">
                                        <img src="{{ Storage::url($img) }}" alt="Galerie" class="gallery-image">
                                        <div class="gallery-overlay"></div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

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

                        {{-- PRACTICAL INFO --}}
                        <div class="practical-info">
                            <div class="info-box category-box">
                                <div class="info-icon category-icon">
                                    <i class="fas fa-tag"></i>
                                </div>
                                <div class="info-content">
                                    <small>@lang('activity.category')</small>
                                    <strong>{{ $activity->category }}</strong>
                                </div>
                            </div>
                            <div class="info-box status-box">
                                <div class="info-icon status-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
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
            </div>
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

        /* Header & Titre */
        .activity-title-main {
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 800;
            color: #1a202c;
            line-height: 1.2;
            margin-bottom: 1rem;
            position: relative;
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
            bottom: 0;
            left: 0;
            right: 0;
            height: 100px;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.3), transparent);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .media-card:hover .media-overlay {
            opacity: 1;
        }

        /* Gallery */
        .gallery-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .gallery-title i {
            color: #0DA3D8;
            font-size: 1.25rem;
        }

        .gallery-item {
            aspect-ratio: 1;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            position: relative;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .gallery-item:hover {
            transform: scale(1.08);
            box-shadow: 0 12px 30px rgba(13, 163, 216, 0.2);
        }

        .gallery-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .gallery-item:hover .gallery-image {
            transform: scale(1.15);
        }

        .gallery-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(13, 163, 216, 0.3), rgba(254, 224, 2, 0.2));
            opacity: 0;
            transition: opacity 0.4s ease;
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
            font-size: 1.75rem;
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
            color: #4b5563;
            line-height: 1.8;
            font-size: 1rem;
            white-space: pre-line;
        }

        /* Practical Info Boxes */
        .practical-info {
            display: grid;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .info-box {
            padding: 1.25rem;
            border-radius: 16px;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: all 0.3s ease;
        }

        .info-box:hover {
            transform: translateX(5px);
        }

        .category-box {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        }

        .status-box {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        }

        .info-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: transform 0.3s ease;
        }

        .info-box:hover .info-icon {
            transform: rotate(360deg);
        }

        .category-icon {
            background: linear-gradient(135deg, #3b82f6, #0DA3D8);
            color: white;
        }

        .status-icon {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }

        .info-icon i {
            font-size: 1.25rem;
        }

        .info-content small {
            display: block;
            font-size: 0.75rem;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.25rem;
        }

        .info-content strong {
            color: #1a202c;
            font-size: 1rem;
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

        /* Related Activities */
        .related-activities {
            margin-top: 5rem;
            padding-top: 4rem;
            border-top: 1px solid #e5e7eb;
        }

        .related-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1a202c;
            text-align: center;
            margin-bottom: 3rem;
            position: relative;
        }

        .related-title::after {
            content: '';
            position: absolute;
            bottom: -1rem;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, #0DA3D8, #FEE002);
            border-radius: 2px;
        }

        .related-card {
            display: block;
            text-decoration: none;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            border: 1px solid #f3f4f6;
        }

        .related-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(13, 163, 216, 0.15);
        }

        .related-image-wrapper {
            height: 200px;
            overflow: hidden;
            position: relative;
        }

        .related-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .related-card:hover .related-image {
            transform: scale(1.1);
        }

        .related-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .related-placeholder i {
            font-size: 3rem;
            color: #9ca3af;
        }

        .related-content {
            padding: 1.5rem;
        }

        .related-category {
            display: inline-block;
            padding: 0.4rem 1rem;
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            color: #92400e;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-radius: 20px;
            margin-bottom: 0.75rem;
        }

        .related-card-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1a202c;
            line-height: 1.4;
            transition: color 0.3s ease;
        }

        .related-card:hover .related-card-title {
            color: #0DA3D8;
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
        }
    </style>
@endsection
