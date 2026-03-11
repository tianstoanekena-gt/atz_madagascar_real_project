@extends('layouts.main')

@section('title', 'Détails Projet - ATZ Madagascar')

@section('content')

    <section class="project-detail-page">

        <div class="containers">

            {{-- HEADER --}}
            <div class="header fade-up">
                <h1>Programme de Parrainage Scolaire 2025 / 2026</h1>

                <div class="project-status completed">
                    Projet réalisé
                </div>

            </div>


            {{-- GRID --}}
            <div class="grid">

                {{-- MEDIA --}}
                <div class="media fade-up delay-1">

                    <div class="image-card hover-lift">
                        <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?w=1200">
                    </div>

                    {{-- KPI --}}
                    <div class="kpi-grid">

                        <div class="kpi-box">
                            <span>Enfants parrainés</span>
                            <strong>18</strong>
                        </div>

                        <div class="kpi-box success">
                            <span>Taux réussite scolaire</span>
                            <strong>92%</strong>
                        </div>

                        <div class="kpi-box accent">
                            <span>Durée projet</span>
                            <strong>2 ans</strong>
                        </div>

                    </div>

                </div>


                {{-- INFOS --}}
                <div class="info fade-up delay-2">

                    <div class="info-card hover-lift">

                        <h2>Présentation du projet</h2>

                        <p>
                            Ce projet vise à soutenir la scolarisation d’enfants issus de familles vulnérables
                            en prenant en charge les frais scolaires, fournitures et accompagnement pédagogique.
                        </p>

                        <p>
                            Grâce à ce programme, les enfants peuvent suivre une scolarité normale
                            et construire un avenir stable.
                        </p>


                        {{-- TIMELINE --}}
                        <div class="timeline">

                            <h3>Évolution du projet</h3>

                            <div class="timeline-item done">
                                <span>Jan 2025</span>
                                <h4>Lancement du programme</h4>
                            </div>

                            <div class="timeline-item done">
                                <span>Sept 2025</span>
                                <h4>Suivi pédagogique renforcé</h4>
                            </div>

                            <div class="timeline-item active">
                                <span>Déc 2026</span>
                                <h4>Clôture et bilan final</h4>
                            </div>

                        </div>


                        {{-- PROGRESS --}}
                        <div class="progress-section">
                            <div class="progress-header">
                                <span>Progression globale</span>
                                <strong>100%</strong>
                            </div>

                            <div class="progress-bar">
                                <div class="progress-fill"></div>
                            </div>
                        </div>


                        {{-- CTA --}}
                        <div class="cta">

                            <a href="{{ route('contact') }}" class="btn primary">
                                Soutenir un futur projet
                            </a>

                            <a href="{{ route('projects') }}" class="btn secondary">
                                Retour aux projets
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>



    <style scoped>
        /* ===== BASE ===== */

        .project-detail-page {
            background: var(--color-background);
            padding: 80px 20px;
            font-family: system-ui;
        }

        .containers {
            /* max-width: 1200px; */
            margin: 40px 50px;
        }

        /* ===== HEADER ===== */

        .header h1 {
            font-size: 38px;
            color: var(--color-text);
        }

        .project-status {
            margin-top: 15px;
            padding: 6px 18px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
        }

        .completed {
            background: rgba(110, 157, 46, 0.15);
            color: var(--color-green);
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
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.08);
        }

        .image-card img {
            width: 100%;
        }

        /* ===== KPI ===== */

        .kpi-grid {
            margin-top: 25px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .kpi-box {
            background: white;
            padding: 20px;
            border-radius: 14px;
            border-top: 4px solid var(--color-primary);
        }

        .kpi-box strong {
            font-size: 26px;
            color: var(--color-text);
        }

        .kpi-box.success {
            border-top-color: var(--color-green);
        }

        .kpi-box.accent {
            border-top-color: var(--color-accent);
        }

        /* ===== CARD ===== */

        .info-card {
            background: white;
            padding: 32px;
            border-radius: 18px;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.05);
        }

        .info-card h2 {
            color: var(--color-text);
        }

        .info-card p {
            color: var(--color-text);
            opacity: .85;
        }

        /* ===== TIMELINE ===== */

        .timeline {
            margin-top: 40px;
            border-left: 3px solid var(--color-secondary);
            padding-left: 20px;
        }

        .timeline-item {
            margin-bottom: 22px;
        }

        .timeline-item.done h4 {
            color: var(--color-green);
        }

        .timeline-item.active h4 {
            color: var(--color-blue);
        }

        /* ===== PROGRESS ===== */

        .progress-section {
            margin-top: 40px;
        }

        .progress-bar {
            height: 10px;
            background: #eee;
            border-radius: 999px;
        }

        .progress-fill {
            height: 100%;
            width: 100%;
            border-radius: 999px;
            background: linear-gradient(90deg,
                    var(--color-primary),
                    var(--color-secondary),
                    var(--color-green));
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
            transition: .3s;
        }

        .primary {
            background: var(--color-primary);
            color: var(--color-text);
        }

        .primary:hover {
            background: var(--color-secondary);
        }

        .secondary {
            border: 1px solid var(--color-text);
            color: var(--color-text);
        }

        /* ===== ANIMATION ===== */

        .fade-up {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp .8s forwards;
        }

        .delay-1 {
            animation-delay: .2s
        }

        .delay-2 {
            animation-delay: .4s
        }

        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hover-lift:hover {
            transform: translateY(-6px);
        }


        /* ============================================
                       RESPONSIVE - PROJECT DETAIL PAGE
                       ============================================ */

        /* Tablettes et petits écrans (768px et moins) */
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

        /* Smartphones moyens (480px) */
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

            .project-status {
                margin-top: 12px;
                padding: 5px 14px;
                font-size: 12px;
            }

            .grid {
                gap: 40px;
            }

            .image-card {
                border-radius: 14px;
            }

            .kpi-grid {
                margin-top: 20px;
                gap: 10px;
            }

            .kpi-box {
                padding: 15px;
                border-radius: 12px;
                border-top-width: 3px;
            }

            .kpi-box span {
                font-size: 12px;
            }

            .kpi-box strong {
                font-size: 22px;
            }

            .info-card {
                padding: 24px;
                border-radius: 14px;
            }

            .info-card h2 {
                font-size: 20px;
                margin-bottom: 15px;
            }

            .info-card p {
                font-size: 14px;
                line-height: 1.6;
            }

            .timeline {
                margin-top: 30px;
                padding-left: 15px;
                border-left-width: 2px;
            }

            .timeline h3 {
                font-size: 16px;
                margin-bottom: 15px;
            }

            .timeline-item {
                margin-bottom: 18px;
            }

            .timeline-item span {
                font-size: 12px;
            }

            .timeline-item h4 {
                font-size: 14px;
            }

            .progress-section {
                margin-top: 30px;
            }

            .progress-header {
                font-size: 14px;
                margin-bottom: 10px;
            }

            .progress-bar {
                height: 8px;
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
            .project-detail-page {
                padding: 40px 10px;
            }

            .containers {
                margin: 10px 5px;
            }

            .header h1 {
                font-size: 20px;
                line-height: 1.3;
            }

            .project-status {
                margin-top: 10px;
                padding: 4px 12px;
                font-size: 11px;
            }

            .grid {
                gap: 30px;
            }

            .image-card {
                border-radius: 12px;
            }

            .kpi-grid {
                margin-top: 15px;
                gap: 8px;
            }

            .kpi-box {
                padding: 12px;
                border-radius: 10px;
            }

            .kpi-box span {
                font-size: 11px;
                display: block;
                margin-bottom: 6px;
            }

            .kpi-box strong {
                font-size: 20px;
                display: block;
            }

            .info-card {
                padding: 18px;
                border-radius: 12px;
            }

            .info-card h2 {
                font-size: 18px;
                margin-bottom: 12px;
            }

            .info-card p {
                font-size: 13px;
                line-height: 1.6;
                margin-bottom: 12px;
            }

            .timeline {
                margin-top: 25px;
                padding-left: 12px;
            }

            .timeline h3 {
                font-size: 15px;
                margin-bottom: 12px;
            }

            .timeline-item {
                margin-bottom: 15px;
            }

            .timeline-item span {
                font-size: 11px;
                display: block;
                margin-bottom: 4px;
            }

            .timeline-item h4 {
                font-size: 13px;
                margin-bottom: 2px;
            }

            .progress-section {
                margin-top: 25px;
            }

            .progress-header {
                font-size: 13px;
                margin-bottom: 8px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .progress-bar {
                height: 7px;
            }

            .cta {
                margin-top: 25px;
                gap: 10px;
            }

            .btn {
                padding: 10px 16px;
                font-size: 13px;
                border-radius: 8px;
            }
        }

        /* Très petits écrans (320px et moins) */
        @media (max-width: 320px) {
            .header h1 {
                font-size: 18px;
            }

            .kpi-box {
                padding: 10px;
            }

            .kpi-box strong {
                font-size: 18px;
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

            .btn {
                padding: 9px 14px;
                font-size: 12px;
            }
    </style>

@endsection
