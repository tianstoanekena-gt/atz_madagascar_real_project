@extends('layouts.main')

@section('title', 'Détails de l\'activité - ATZ Madagascar')

@section('content')
    <section class="activity-page">

        <div class="container">

            {{-- HEADER --}}
            <div class="header fade-up">

                <h1>Programme de Nutrition Communautaire</h1>
            </div>

            {{-- GRID --}}
            <div class="grid">

                {{-- MEDIA --}}
                <div class="media fade-up delay-1">

                    <div class="video-card hover-lift">
                        <video controls>
                            <source src="{{ asset('assets/videos/WhatsApp Video 2026-01-28 at 10.01.54.mp4') }}"
                                type="video/mp4">
                        </video>
                    </div>

                    <div class="gallery">
                        <h3>Galerie photos</h3>

                        <div class="gallery-grid">
                            @foreach (range(1, 6) as $i)
                                <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=400">
                            @endforeach
                        </div>
                    </div>

                </div>

                {{-- INFO --}}
                <div class="info fade-up delay-2">

                    <div class="info-card hover-lift">

                        <h2>À propos du programme</h2>

                        <p>
                            Notre programme vise à combattre la malnutrition infantile dans les quartiers défavorisés
                            d’Antananarivo.
                        </p>

                        <p>
                            Chaque mois, plus de 80 enfants bénéficient de repas équilibrés, d’un suivi nutritionnel et d’un
                            accompagnement médical.
                        </p>

                        {{-- TIMELINE --}}
                        <div class="timeline">
                            <h3>Chronologie</h3>

                            <div class="timeline-item">
                                <span>Octobre 2024</span>
                                <h4>Lancement</h4>
                                <p>Démarrage avec 50 enfants</p>
                            </div>

                            <div class="timeline-item">
                                <span>Novembre 2024</span>
                                <h4>Extension</h4>
                                <p>Extension à 80 bénéficiaires</p>
                            </div>

                            <div class="timeline-item active">
                                <span>2025</span>
                                <h4>Phase actuelle</h4>
                                <p>Suivi nutritionnel renforcé</p>
                            </div>

                        </div>

                        {{-- PRACTICAL --}}
                        <div class="practical">
                            <div class="box">
                                <small>Lieu</small>
                                <strong>FJKM Andranovelona</strong>
                            </div>

                            <div class="box">
                                <small>Horaire</small>
                                <strong>Lun - Mer - Ven</strong>
                            </div>

                            <div class="box">
                                <small>Bénéficiaires</small>
                                <strong>80 enfants</strong>
                            </div>
                        </div>

                        {{-- CTA --}}
                        <div class="cta">
                            <a href="{{ route('contact') }}" class="btn primary">
                                Soutenir le programme
                            </a>
                            <a href="{{ route('activities') }}" class="btn secondary">
                                Retour
                            </a>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <style scoped>
        /* ===== BASE ===== */

        .activity-page {
            background: #f7f8fa;
            padding: 80px 20px;
            font-family: system-ui, -apple-system, sans-serif;
        }

        .container {
            max-width: 1200px;
            margin: auto;
        }

        /* ===== HEADER ===== */

        .header {
            margin-bottom: 60px;
        }

        .header h1 {
            font-size: 38px;
            font-weight: 600;
            letter-spacing: -0.5px;
        }

        .breadcrumb {
            color: #9aa1a9;
            font-size: 14px;
            margin-bottom: 12px;
        }

        .breadcrumb a {
            color: #6b7280;
            text-decoration: none;
        }

        .breadcrumb a:hover {
            color: #111;
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

        /* ===== CARD ===== */

        .info-card,
        .video-card {
            background: white;
            border-radius: 18px;
            padding: 28px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.04);
            transition: all .4s ease;
        }

        .video-card {
            padding: 0;
            overflow: hidden;
        }

        .video-card video {
            width: 100%;
            display: block;
        }

        /* ===== GALLERY ===== */

        .gallery {
            margin-top: 30px;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .gallery-grid img {
            width: 100%;
            height: 110px;
            object-fit: cover;
            border-radius: 12px;
            transition: .4s;
        }

        .gallery-grid img:hover {
            transform: scale(1.05);
        }

        /* ===== INFO ===== */

        .info-card h2 {
            margin-bottom: 18px;
        }

        .info-card p {
            color: #555;
            line-height: 1.7;
        }

        /* ===== TIMELINE ===== */

        .timeline {
            margin-top: 40px;
            border-left: 2px solid #eee;
            padding-left: 20px;
        }

        .timeline h3 {
            margin-bottom: 20px;
        }

        .timeline-item {
            margin-bottom: 25px;
            position: relative;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -27px;
            top: 6px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #ddd;
        }

        .timeline-item.active::before {
            background: #111;
        }

        /* ===== PRACTICAL ===== */

        .practical {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-top: 40px;
        }

        .box {
            background: #f4f6f8;
            padding: 18px;
            border-radius: 12px;
        }

        .box small {
            display: block;
            color: #888;
            margin-bottom: 4px;
        }

        /* ===== CTA ===== */

        .cta {
            margin-top: 40px;
            display: flex;
            gap: 14px;
        }

        .btn {
            padding: 14px 24px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 500;
            transition: .3s;
        }

        .primary {
            background: #111;
            color: white;
        }

        .primary:hover {
            transform: translateY(-2px);
        }

        .secondary {
            border: 1px solid #ddd;
            color: #333;
        }

        .secondary:hover {
            background: #f2f2f2;
        }

        /* ===== ANIMATIONS ===== */

        .fade-up {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp .8s forwards ease;
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

        /* Hover Lift */

        .hover-lift:hover {
            transform: translateY(-6px);
            box-shadow: 0 18px 45px rgba(0, 0, 0, 0.08);
        }

        /* ============================================
                   RESPONSIVE - ACTIVITY DETAIL PAGE
                   ============================================ */

        /* Tablettes et petits écrans (768px et moins) */
        @media (max-width: 768px) {
            .activity-page {
                padding: 60px 15px;
            }

            .container {
                max-width: 100%;
                padding: 0 10px;
            }

            .header {
                margin-bottom: 40px;
            }

            .header h1 {
                font-size: 28px;
            }

            .gallery-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .practical {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .cta {
                flex-direction: column;
            }
        }

        /* Smartphones moyens (480px) */
        @media (max-width: 480px) {
            .activity-page {
                padding: 50px 12px;
            }

            .header {
                margin-bottom: 35px;
            }

            .header h1 {
                font-size: 24px;
                line-height: 1.3;
            }

            .breadcrumb {
                font-size: 12px;
                margin-bottom: 10px;
            }

            .grid {
                gap: 40px;
            }

            .video-card,
            .info-card {
                border-radius: 14px;
            }

            .info-card {
                padding: 22px;
            }

            .gallery {
                margin-top: 25px;
            }

            .gallery h3 {
                font-size: 16px;
                margin-bottom: 12px;
            }

            .gallery-grid {
                gap: 10px;
            }

            .gallery-grid img {
                height: 90px;
                border-radius: 10px;
            }

            .info-card h2 {
                font-size: 20px;
                margin-bottom: 15px;
            }

            .info-card p {
                font-size: 14px;
                line-height: 1.6;
                margin-bottom: 12px;
            }

            .timeline {
                margin-top: 30px;
                padding-left: 15px;
            }

            .timeline h3 {
                font-size: 16px;
                margin-bottom: 15px;
            }

            .timeline-item {
                margin-bottom: 20px;
            }

            .timeline-item::before {
                left: -22px;
                width: 8px;
                height: 8px;
            }

            .timeline-item span {
                font-size: 12px;
                display: block;
                margin-bottom: 4px;
            }

            .timeline-item h4 {
                font-size: 14px;
                margin-bottom: 4px;
            }

            .timeline-item p {
                font-size: 13px;
            }

            .practical {
                margin-top: 30px;
                gap: 10px;
            }

            .box {
                padding: 15px;
                border-radius: 10px;
            }

            .box small {
                font-size: 11px;
            }

            .box strong {
                font-size: 14px;
            }

            .cta {
                margin-top: 30px;
                gap: 12px;
            }

            .btn {
                padding: 12px 20px;
                font-size: 14px;
                border-radius: 10px;
            }
        }

        /* Petits smartphones (350px) */
        @media (max-width: 350px) {
            .activity-page {
                padding: 40px 10px;
            }

            .header {
                margin-bottom: 30px;
            }

            .header h1 {
                font-size: 20px;
                line-height: 1.3;
            }

            .breadcrumb {
                font-size: 11px;
                margin-bottom: 8px;
            }

            .grid {
                gap: 30px;
            }

            .video-card,
            .info-card {
                border-radius: 12px;
            }

            .info-card {
                padding: 18px;
            }

            .gallery {
                margin-top: 20px;
            }

            .gallery h3 {
                font-size: 15px;
                margin-bottom: 10px;
            }

            .gallery-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 8px;
            }

            .gallery-grid img {
                height: 80px;
                border-radius: 8px;
            }

            .info-card h2 {
                font-size: 18px;
                margin-bottom: 12px;
            }

            .info-card p {
                font-size: 13px;
                line-height: 1.6;
                margin-bottom: 10px;
            }

            .timeline {
                margin-top: 25px;
                padding-left: 12px;
                border-left-width: 2px;
            }

            .timeline h3 {
                font-size: 15px;
                margin-bottom: 12px;
            }

            .timeline-item {
                margin-bottom: 18px;
            }

            .timeline-item::before {
                left: -19px;
                width: 7px;
                height: 7px;
                top: 4px;
            }

            .timeline-item span {
                font-size: 11px;
                margin-bottom: 3px;
            }

            .timeline-item h4 {
                font-size: 13px;
                margin-bottom: 3px;
            }

            .timeline-item p {
                font-size: 12px;
                line-height: 1.5;
            }

            .practical {
                margin-top: 25px;
                gap: 8px;
            }

            .box {
                padding: 12px;
                border-radius: 8px;
            }

            .box small {
                font-size: 10px;
                margin-bottom: 3px;
            }

            .box strong {
                font-size: 13px;
            }

            .cta {
                margin-top: 25px;
                gap: 10px;
            }

            .btn {
                padding: 10px 16px;
                font-size: 13px;
                border-radius: 8px;
                text-align: center;
            }
        }

        /* Très petits écrans (320px et moins) */
        @media (max-width: 320px) {
            .header h1 {
                font-size: 18px;
            }

            .gallery-grid {
                grid-template-columns: 1fr;
            }

            .gallery-grid img {
                height: 120px;
            }

            .info-card {
                padding: 15px;
            }

            .info-card h2 {
                font-size: 16px;
            }

            .info-card p {
                font-size: 12px;
            }

            .timeline-item p {
                font-size: 11px;
            }

            .box {
                padding: 10px;
            }

            .btn {
                padding: 9px 14px;
                font-size: 12px;
            }
        }
    </style>
@endsection
