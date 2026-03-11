@extends('layouts.main')

@section('content')
    <section id="stats" class="stats-section">
        <div class="stats-container">
            {{-- En-tête de la page --}}
            <div class="section-header">
                <h2 class="section-title">Statistiques ATZ Madagascar</h2>
                <div class="title-underline"></div>
                <p class="section-subtitle">L'impact de nos actions en chiffres - Année 2025</p>
            </div>

            {{-- Cartes statistiques principales avec compteurs --}}
            <div class="stats-grid">
                <div class="stat-card" data-count="260">
                    <div class="stat-icon">
                        <i class="fa-solid fa-house-chimney-user"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-number">0</span>
                        <span class="stat-label">Ménages accompagnés</span>
                    </div>
                    <div class="stat-trend positive">
                        <i class="fa-solid fa-arrow-up"></i> +15% vs 2024
                    </div>
                </div>

                <div class="stat-card" data-count="750">
                    <div class="stat-icon">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-number">0</span>
                        <span class="stat-label">Bénéficiaires directs</span>
                    </div>
                    <div class="stat-trend positive">
                        <i class="fa-solid fa-arrow-up"></i> +12% vs 2024
                    </div>
                </div>

                <div class="stat-card" data-count="24">
                    <div class="stat-icon">
                        <i class="fa-solid fa-hand-heart"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-number">0</span>
                        <span class="stat-label">Bénévoles actifs</span>
                    </div>
                    <div class="stat-trend positive">
                        <i class="fa-solid fa-arrow-up"></i> +4 nouveaux
                    </div>
                </div>

                <div class="stat-card" data-count="2">
                    <div class="stat-icon">
                        <i class="fa-solid fa-briefcase"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-number">0</span>
                        <span class="stat-label">Salariés permanents</span>
                    </div>
                    <div class="stat-trend stable">
                        <i class="fa-solid fa-equals"></i> stable
                    </div>
                </div>
            </div>

            {{-- Section Éducation --}}
            <div class="stats-category">
                <h3 class="category-title">
                    <i class="fa-solid fa-graduation-cap"></i>
                    Éducation & Scolarisation
                </h3>

                <div class="stats-subgrid">
                    <div class="stat-detailed-card">
                        <div class="stat-header">
                            <i class="fa-solid fa-children"></i>
                            <h4>Soutien scolaire</h4>
                        </div>
                        <div class="stat-big-number" data-count="52">0</div>
                        <p class="stat-desc">Élèves en remise à niveau (9ème et 6ème)</p>
                        <div class="stat-progress">
                            <div class="progress-bar" style="width: 100%"></div>
                            <span>100% de réussite</span>
                        </div>
                    </div>

                    <div class="stat-detailed-card">
                        <div class="stat-header">
                            <i class="fa-solid fa-ranking-star"></i>
                            <h4>Baccalauréat 2025</h4>
                        </div>
                        <div class="stat-big-number" data-count="7">0</div>
                        <p class="stat-desc">Candidats reçus sur 13 inscrits</p>
                        <div class="stat-percentage">
                            <span class="percentage-value">54%</span>
                            <span class="percentage-label">Taux de réussite</span>
                        </div>
                    </div>

                    <div class="stat-detailed-card">
                        <div class="stat-header">
                            <i class="fa-solid fa-user-graduate"></i>
                            <h4>Études supérieures</h4>
                        </div>
                        <div class="stat-big-number" data-count="7">0</div>
                        <p class="stat-desc">Jeunes parrainés par le groupe Baobab</p>
                        <div class="stat-badge">
                            <i class="fa-regular fa-star"></i> Programme spécial
                        </div>
                    </div>
                </div>

                {{-- Graphique inscriptions scolaires --}}
                <div class="chart-container">
                    <h4>Inscriptions scolaires 2025-2026</h4>
                    <div class="bar-chart">
                        <div class="chart-bar" data-value="161">
                            <span class="bar-label">Primaire</span>
                            <span class="bar-value">161</span>
                        </div>
                        <div class="chart-bar" data-value="104">
                            <span class="bar-label">Collège</span>
                            <span class="bar-value">104</span>
                        </div>
                        <div class="chart-bar" data-value="29">
                            <span class="bar-label">Lycée</span>
                            <span class="bar-value">29</span>
                        </div>
                    </div>
                    <p class="chart-total">Total: <strong>294 élèves</strong> pris en charge</p>
                </div>

                {{-- Cours de langue --}}
                <div class="stats-highlight">
                    <div class="highlight-item">
                        <i class="fa-solid fa-language"></i>
                        <div>
                            <span class="highlight-number" data-count="20">0</span>
                            <span class="highlight-label">Adolescents en cours de français et anglais</span>
                        </div>
                    </div>
                    <div class="highlight-item">
                        <i class="fa-solid fa-chalkboard-user"></i>
                        <div>
                            <span class="highlight-number" data-count="3">0</span>
                            <span class="highlight-label">Jeunes bénévoles formateurs (Mino, Hasina, Lanto)</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section Nutrition --}}
            <div class="stats-category">
                <h3 class="category-title">
                    <i class="fa-solid fa-utensils"></i>
                    Nutrition & Cantine scolaire
                </h3>

                <div class="nutrition-grid">
                    <div class="nutrition-card">
                        <i class="fa-solid fa-bowl-food"></i>
                        <span class="nutrition-number" data-count="9120">0</span>
                        <span class="nutrition-label">Repas chauds servis en 2025</span>
                    </div>
                    <div class="nutrition-card">
                        <i class="fa-solid fa-child-reaching"></i>
                        <span class="nutrition-number" data-count="160">0</span>
                        <span class="nutrition-label">Enfants nourris quotidiennement</span>
                    </div>
                    <div class="nutrition-card">
                        <i class="fa-solid fa-clock"></i>
                        <span class="nutrition-number">365</span>
                        <span class="nutrition-label">Jours d'ouverture de la cantine</span>
                    </div>
                </div>

                <div class="stats-progress-card">
                    <h4>Réhabilitation de la cantine</h4>
                    <div class="progress-container">
                        <div class="progress-bar-custom" style="width: 85%">
                            <span>85%</span>
                        </div>
                    </div>
                    <p>Travaux en cours : revêtements lavables et système d'évacuation des fumées</p>
                </div>
            </div>

            {{-- Section Santé --}}
            <div class="stats-category">
                <h3 class="category-title">
                    <i class="fa-solid fa-heart-pulse"></i>
                    Santé & Accès aux soins
                </h3>

                <div class="health-grid">
                    <div class="health-card" data-count="9">
                        <i class="fa-solid fa-hospital-user"></i>
                        <span class="health-number">0</span>
                        <span class="health-label">Hospitalisations</span>
                        <span class="health-detail">dont 3 interventions chirurgicales</span>
                    </div>
                    <div class="health-card" data-count="3">
                        <i class="fa-solid fa-baby"></i>
                        <span class="health-number">0</span>
                        <span class="health-label">Accouchements accompagnés</span>
                    </div>
                    <div class="health-card" data-count="9">
                        <i class="fa-solid fa-bandage"></i>
                        <span class="health-number">0</span>
                        <span class="health-label">Soins primaires</span>
                    </div>
                    <div class="health-card">
                        <i class="fa-solid fa-syringe"></i>
                        <span class="health-number">124</span>
                        <span class="health-label">Vaccinations enfants</span>
                    </div>
                </div>

                {{-- Projet dispensaire --}}
                <div class="project-status-card">
                    <div class="project-header">
                        <i class="fa-solid fa-clinic-medical"></i>
                        <h4>Dispensaire ATZ</h4>
                    </div>
                    <div class="project-progress">
                        <div class="progress-item">
                            <span class="progress-label">Travaux de construction</span>
                            <div class="progress-bar-container">
                                <div class="progress-fill" style="width: 98%">98%</div>
                            </div>
                        </div>
                        <div class="progress-item">
                            <span class="progress-label">Puits sécurisé</span>
                            <div class="progress-bar-container">
                                <div class="progress-fill" style="width: 100%">100%</div>
                            </div>
                        </div>
                        <div class="progress-item">
                            <span class="progress-label">Homologation</span>
                            <div class="progress-bar-container">
                                <div class="progress-fill" style="width: 60%">En cours</div>
                            </div>
                        </div>
                    </div>
                    <div class="project-team">
                        <i class="fa-solid fa-user-nurse"></i>
                        <span>Sariaka : Infirmière/sage-femme diplômée, rejoint l'équipe dès obtention de sa carte
                            professionnelle</span>
                    </div>
                </div>
            </div>

            {{-- Section Bénévoles & Ressources humaines --}}
            <div class="stats-category">
                <h3 class="category-title">
                    <i class="fa-solid fa-people-group"></i>
                    Équipe & Bénévolat
                </h3>

                <div class="team-stats">
                    <div class="team-chart">
                        <div class="team-pie">
                            <div class="pie-segment" style="--percentage: 92; --color: var(--color-blue);">
                                <span>92%</span>
                            </div>
                            <div class="pie-segment" style="--percentage: 8; --color: var(--color-green);">
                                <span>8%</span>
                            </div>
                        </div>
                        <div class="team-legend">
                            <div><span class="dot" style="background: var(--color-blue);"></span> Bénévoles (24)</div>
                            <div><span class="dot" style="background: var(--color-green);"></span> Salariés (2)</div>
                        </div>
                    </div>
                    <div class="team-details">
                        <div class="detail-item">
                            <i class="fa-solid fa-user-tie"></i>
                            <span>Bureau exécutif: 5 membres</span>
                        </div>
                        <div class="detail-item">
                            <i class="fa-solid fa-people-arrows"></i>
                            <span>Animateurs de quartier: 8</span>
                        </div>
                        <div class="detail-item">
                            <i class="fa-solid fa-calendar-check"></i>
                            <span>Heures de bénévolat: 4,320h</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section Financière --}}
            <div class="stats-category">
                <h3 class="category-title">
                    <i class="fa-solid fa-coins"></i>
                    Bilan financier 2025
                </h3>

                <div class="financial-grid">
                    <div class="financial-card income">
                        <div class="financial-header">
                            <i class="fa-solid fa-arrow-up"></i>
                            <h4>Recettes</h4>
                        </div>
                        <div class="financial-number" data-count="94212171">0</div>
                        <span class="financial-currency">MGA</span>
                        <div class="financial-euro">≈ 18 090 €</div>
                        <div class="financial-breakdown">
                            <div class="breakdown-item">
                                <span>Paroisse Goxwiller</span>
                                <span>27 483 076 MGA</span>
                            </div>
                            <div class="breakdown-item">
                                <span>Paroisse St Gallen</span>
                                <span>29 711 400 MGA</span>
                            </div>
                            <div class="breakdown-item">
                                <span>VKM</span>
                                <span>17 861 524 MGA</span>
                            </div>
                            <div class="breakdown-item">
                                <span>Mois de Mai ATZ</span>
                                <span>7 804 000 MGA</span>
                            </div>
                        </div>
                    </div>

                    <div class="financial-card expense">
                        <div class="financial-header">
                            <i class="fa-solid fa-arrow-down"></i>
                            <h4>Dépenses</h4>
                        </div>
                        <div class="financial-number" data-count="88942139">0</div>
                        <span class="financial-currency">MGA</span>
                        <div class="financial-euro">≈ 17 078 €</div>
                        <div class="financial-breakdown">
                            <div class="breakdown-item">
                                <span>Travaux dispensaire</span>
                                <span>19 518 500 MGA</span>
                            </div>
                            <div class="breakdown-item">
                                <span>Inscriptions scolaires</span>
                                <span>11 365 000 MGA</span>
                            </div>
                            <div class="breakdown-item">
                                <span>Parrainages</span>
                                <span>27 367 000 MGA</span>
                            </div>
                            <div class="breakdown-item">
                                <span>Cantine</span>
                                <span>5 040 000 MGA</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="financial-result positive">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>Excédent 2025: <strong>5 270 032 MGA</strong> (≈ 1 012 €)</span>
                </div>
            </div>

            {{-- Section Perspectives 2026 --}}
            <div class="stats-category">
                <h3 class="category-title">
                    <i class="fa-solid fa-chart-line"></i>
                    Perspectives 2026
                </h3>

                <div class="perspectives-grid">
                    <div class="perspective-card">
                        <i class="fa-solid fa-laptop-code"></i>
                        <h4>Centre numérique SAYNA</h4>
                        <ul>
                            <li><i class="fa-regular fa-circle-check"></i> Programme professionnalisant</li>
                            <li><i class="fa-regular fa-circle-check"></i> Pour jeunes et femmes</li>
                            <li><i class="fa-regular fa-circle-check"></i> Objectif: 30 premiers apprenants</li>
                        </ul>
                    </div>

                    <div class="perspective-card">
                        <i class="fa-solid fa-futbol"></i>
                        <h4>Club de foot ATZ</h4>
                        <ul>
                            <li><i class="fa-regular fa-circle-check"></i> 2 catégories : juniors et seniors</li>
                            <li><i class="fa-regular fa-circle-check"></i> 40 jeunes encadrés</li>
                            <li><i class="fa-regular fa-circle-check"></i> Championnat paroissial</li>
                        </ul>
                    </div>

                    <div class="perspective-card">
                        <i class="fa-solid fa-stethoscope"></i>
                        <h4>Dispensaire</h4>
                        <ul>
                            <li><i class="fa-regular fa-circle-check"></i> Ouverture prévue: Juin 2026</li>
                            <li><i class="fa-regular fa-circle-check"></i> Capacité: 50 consultations/semaine</li>
                            <li><i class="fa-regular fa-circle-check"></i> Infirmière à plein temps</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <style>
        /* ============================================
                                                       PAGE STATISTIQUES - STYLES
                                                       ============================================ */

        .stats-section {
            padding: 4rem 0;
            background: linear-gradient(135deg, #ffffff 0%, var(--color-background) 100%);
            min-height: 100vh;
        }

        .stats-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .section-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--color-blue);
            margin-bottom: 1rem;
        }

        .title-underline {
            width: 6rem;
            height: 4px;
            background-color: var(--color-primary);
            margin: 0 auto;
        }

        .section-subtitle {
            color: var(--color-text);
            font-size: 1.2rem;
            margin-top: 1rem;
            opacity: 0.8;
        }

        /* ============================================
                                                       STATS GRID PRINCIPALE
                                                       ============================================ */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
            margin-bottom: 60px;
        }

        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 30px 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
            transition: all 0.4s ease;
            opacity: 0;
            transform: translateY(30px);
            animation: cardAppear 0.6s ease forwards;
            border: 1px solid rgba(13, 163, 216, 0.1);
        }

        .stat-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .stat-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .stat-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .stat-card:nth-child(4) {
            animation-delay: 0.4s;
        }

        @keyframes cardAppear {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--color-blue), var(--color-primary));
        }

        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(13, 163, 216, 0.15);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            background: rgba(13, 163, 216, 0.1);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .stat-icon i {
            font-size: 2rem;
            color: var(--color-blue);
        }

        .stat-content {
            margin-bottom: 15px;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: bold;
            color: var(--color-text);
            line-height: 1;
            display: block;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 1rem;
            color: #666;
        }

        .stat-trend {
            font-size: 0.9rem;
            padding: 5px 10px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .stat-trend.positive {
            background: rgba(110, 157, 46, 0.1);
            color: var(--color-green);
        }

        .stat-trend.stable {
            background: rgba(13, 163, 216, 0.1);
            color: var(--color-blue);
        }

        /* ============================================
                                                       CATÉGORIES
                                                       ============================================ */
        .stats-category {
            background: white;
            border-radius: 30px;
            padding: 40px;
            margin-bottom: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
            border: 1px solid rgba(13, 163, 216, 0.05);
            opacity: 0;
            transform: translateY(30px);
            animation: categoryAppear 0.8s ease forwards;
        }

        .stats-category:nth-child(2) {
            animation-delay: 0.2s;
        }

        .stats-category:nth-child(3) {
            animation-delay: 0.3s;
        }

        .stats-category:nth-child(4) {
            animation-delay: 0.4s;
        }

        .stats-category:nth-child(5) {
            animation-delay: 0.5s;
        }

        .stats-category:nth-child(6) {
            animation-delay: 0.6s;
        }

        @keyframes categoryAppear {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .category-title {
            font-size: 1.8rem;
            color: var(--color-blue);
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 3px solid var(--color-primary);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .category-title i {
            font-size: 2rem;
            color: var(--color-primary);
        }

        /* ============================================
                                                       SOUS-GRILLE STATS
                                                       ============================================ */
        .stats-subgrid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-detailed-card {
            background: var(--color-background);
            border-radius: 20px;
            padding: 25px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .stat-detailed-card:hover {
            transform: scale(1.05);
            box-shadow: 0 15px 30px rgba(13, 163, 216, 0.1);
        }

        .stat-header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .stat-header i {
            font-size: 1.5rem;
            color: var(--color-blue);
        }

        .stat-header h4 {
            font-size: 1.2rem;
            color: var(--color-text);
        }

        .stat-big-number {
            font-size: 3.5rem;
            font-weight: bold;
            color: var(--color-blue);
            line-height: 1;
            margin-bottom: 10px;
        }

        .stat-desc {
            color: #666;
            margin-bottom: 15px;
        }

        .stat-progress {
            background: #f0f0f0;
            border-radius: 10px;
            height: 30px;
            position: relative;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--color-green), var(--color-blue));
            transition: width 1.5s ease;
            position: relative;
        }

        .progress-bar span {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: white;
            font-size: 0.8rem;
            font-weight: bold;
        }

        .stat-percentage {
            margin-top: 15px;
        }

        .percentage-value {
            font-size: 2rem;
            font-weight: bold;
            color: var(--color-primary);
            display: block;
        }

        .percentage-label {
            color: #666;
            font-size: 0.9rem;
        }

        .stat-badge {
            background: var(--color-blue);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.9rem;
        }

        /* ============================================
                                                       GRAPHIQUES
                                                       ============================================ */
        .chart-container {
            background: var(--color-background);
            border-radius: 20px;
            padding: 30px;
            margin-top: 30px;
        }

        .chart-container h4 {
            font-size: 1.3rem;
            color: var(--color-text);
            margin-bottom: 25px;
        }

        .bar-chart {
            display: flex;
            justify-content: space-around;
            align-items: flex-end;
            height: 200px;
            margin-bottom: 20px;
        }

        .chart-bar {
            width: 100px;
            background: linear-gradient(180deg, var(--color-blue), var(--color-primary));
            border-radius: 10px 10px 0 0;
            position: relative;
            transition: height 1.5s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-end;
            padding-bottom: 10px;
        }

        .chart-bar[data-value="161"] {
            height: 161px;
        }

        .chart-bar[data-value="104"] {
            height: 104px;
        }

        .chart-bar[data-value="29"] {
            height: 29px;
        }

        .bar-label {
            position: absolute;
            top: -25px;
            left: 50%;
            transform: translateX(-50%);
            font-weight: bold;
            color: var(--color-text);
        }

        .bar-value {
            color: white;
            font-weight: bold;
        }

        .chart-total {
            text-align: center;
            font-size: 1.2rem;
            color: #666;
            margin-top: 20px;
        }

        /* ============================================
                                                       HIGHLIGHTS
                                                       ============================================ */
        .stats-highlight {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-top: 30px;
        }

        .highlight-item {
            background: linear-gradient(135deg, rgba(13, 163, 216, 0.05), rgba(254, 237, 2, 0.05));
            border-radius: 15px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .highlight-item i {
            font-size: 2.5rem;
            color: var(--color-blue);
        }

        .highlight-number {
            font-size: 2rem;
            font-weight: bold;
            color: var(--color-text);
            display: block;
        }

        .highlight-label {
            color: #666;
        }

        /* ============================================
                                                       NUTRITION
                                                       ============================================ */
        .nutrition-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin-bottom: 40px;
        }

        .nutrition-card {
            text-align: center;
            padding: 30px;
            background: linear-gradient(135deg, white, var(--color-background));
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .nutrition-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 30px rgba(13, 163, 216, 0.1);
        }

        .nutrition-card i {
            font-size: 3rem;
            color: var(--color-primary);
            margin-bottom: 20px;
        }

        .nutrition-number {
            font-size: 3rem;
            font-weight: bold;
            color: var(--color-blue);
            display: block;
            margin-bottom: 10px;
        }

        .nutrition-label {
            color: #666;
            font-size: 1rem;
        }

        /* ============================================
                                                       SANTÉ
                                                       ============================================ */
        .health-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }

        .health-card {
            background: var(--color-background);
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .health-card:hover {
            background: var(--color-blue);
            transform: scale(1.05);
        }

        .health-card:hover i,
        .health-card:hover .health-number,
        .health-card:hover .health-label,
        .health-card:hover .health-detail {
            color: white;
        }

        .health-card i {
            font-size: 2.5rem;
            color: var(--color-blue);
            margin-bottom: 15px;
            transition: color 0.3s ease;
        }

        .health-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--color-text);
            display: block;
            margin-bottom: 5px;
            transition: color 0.3s ease;
        }

        .health-label {
            color: #666;
            font-size: 1rem;
            display: block;
            margin-bottom: 5px;
            transition: color 0.3s ease;
        }

        .health-detail {
            color: #999;
            font-size: 0.85rem;
            transition: color 0.3s ease;
        }

        /* ============================================
                                                       PROJET DISPENSAIRE
                                                       ============================================ */
        .project-status-card {
            background: linear-gradient(135deg, rgba(13, 163, 216, 0.02), rgba(254, 237, 2, 0.02));
            border-radius: 20px;
            padding: 30px;
            margin-top: 30px;
        }

        .project-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        .project-header i {
            font-size: 2rem;
            color: var(--color-blue);
        }

        .project-header h4 {
            font-size: 1.4rem;
            color: var(--color-text);
        }

        .project-progress {
            display: grid;
            gap: 20px;
            margin-bottom: 25px;
        }

        .progress-item {
            display: grid;
            grid-template-columns: 150px 1fr;
            align-items: center;
            gap: 20px;
        }

        .progress-label {
            color: #666;
        }

        .progress-bar-container {
            background: #f0f0f0;
            border-radius: 10px;
            height: 30px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--color-green), var(--color-blue));
            color: white;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding-right: 10px;
            font-size: 0.9rem;
            font-weight: bold;
        }

        .project-team {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 20px;
            background: white;
            border-radius: 12px;
            margin-top: 20px;
        }

        .project-team i {
            font-size: 2rem;
            color: var(--color-green);
        }

        /* ============================================
                                                       ÉQUIPE
                                                       ============================================ */
        .team-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: center;
        }

        .team-chart {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        .team-pie {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: conic-gradient(var(--color-blue) 0deg 331deg,
                    var(--color-green) 331deg 360deg);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .team-pie::before {
            content: '';
            position: absolute;
            width: 150px;
            height: 150px;
            background: white;
            border-radius: 50%;
        }

        .team-pie span {
            position: relative;
            z-index: 1;
            font-weight: bold;
            color: var(--color-text);
        }

        .team-legend {
            display: flex;
            gap: 30px;
        }

        .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }

        .team-details {
            display: grid;
            gap: 15px;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background: var(--color-background);
            border-radius: 12px;
        }

        .detail-item i {
            color: var(--color-blue);
            font-size: 1.2rem;
        }

        /* ============================================
                                                       FINANCIER
                                                       ============================================ */
        .financial-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
            margin-bottom: 30px;
        }

        .financial-card {
            padding: 30px;
            border-radius: 20px;
            background: var(--color-background);
        }

        .financial-card.income {
            border-left: 5px solid var(--color-green);
        }

        .financial-card.expense {
            border-left: 5px solid var(--color-red);
        }

        .financial-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .financial-header i {
            font-size: 1.5rem;
        }

        .financial-card.income i {
            color: var(--color-green);
        }

        .financial-card.expense i {
            color: var(--color-red);
        }

        .financial-header h4 {
            font-size: 1.3rem;
            color: var(--color-text);
        }

        .financial-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--color-text);
            display: inline;
            margin-right: 10px;
        }

        .financial-currency {
            font-size: 1rem;
            color: #666;
        }

        .financial-euro {
            color: #666;
            margin-bottom: 20px;
        }

        .financial-breakdown {
            border-top: 1px solid #eee;
            padding-top: 20px;
        }

        .breakdown-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            color: #555;
        }

        .financial-result {
            text-align: center;
            padding: 20px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .financial-result.positive {
            background: rgba(110, 157, 46, 0.1);
            color: var(--color-green);
        }

        .financial-result i {
            font-size: 1.5rem;
        }

        /* ============================================
                                                       PERSPECTIVES
                                                       ============================================ */
        .perspectives-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .perspective-card {
            background: linear-gradient(135deg, white, var(--color-background));
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid rgba(13, 163, 216, 0.1);
        }

        .perspective-card:hover {
            transform: translateY(-10px);
            border-color: var(--color-blue);
            box-shadow: 0 20px 30px rgba(13, 163, 216, 0.1);
        }

        .perspective-card i {
            font-size: 3rem;
            color: var(--color-blue);
            margin-bottom: 20px;
        }

        .perspective-card h4 {
            font-size: 1.3rem;
            color: var(--color-text);
            margin-bottom: 20px;
        }

        .perspective-card ul {
            list-style: none;
            padding: 0;
            text-align: left;
        }

        .perspective-card li {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #555;
            margin-bottom: 10px;
            padding: 5px 0;
        }

        .perspective-card li i {
            font-size: 1rem;
            color: var(--color-green);
            margin: 0;
        }

        /* ============================================
                                                       RESPONSIVE
                                                       ============================================ */
        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .stats-subgrid,
            .nutrition-grid,
            .health-grid,
            .perspectives-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {

            .stats-grid,
            .stats-subgrid,
            .nutrition-grid,
            .health-grid,
            .perspectives-grid,
            .financial-grid,
            .team-stats,
            .stats-highlight {
                grid-template-columns: 1fr;
            }

            .stats-category {
                padding: 25px;
            }

            .category-title {
                font-size: 1.5rem;
            }

            .stat-number {
                font-size: 2.5rem;
            }

            .progress-item {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <script>
        // ============================================
        // COMPTEURS STATISTIQUES
        // ============================================
        document.addEventListener('DOMContentLoaded', function() {

            function animateCounter(element, start, end, duration) {
                const range = end - start;
                const increment = range / (duration / 16);
                let current = start;

                const timer = setInterval(() => {
                    current += increment;
                    if (current >= end) {
                        element.innerText = end.toLocaleString('fr-FR');
                        clearInterval(timer);
                    } else {
                        element.innerText = Math.floor(current).toLocaleString('fr-FR');
                    }
                }, 16);
            }

            // Observer pour les compteurs
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const counters = entry.target.querySelectorAll(
                            '.stat-number, .stat-big-number, .nutrition-number, .health-number, .financial-number, .highlight-number'
                        );

                        counters.forEach(counter => {
                            const targetValue = parseInt(counter.closest('[data-count]')
                                ?.dataset.count ||
                                counter.parentElement?.dataset.count ||
                                counter.innerText.replace(/\s/g, '') ||
                                counter.textContent);

                            if (!isNaN(targetValue)) {
                                counter.innerText = '0';
                                animateCounter(counter, 0, targetValue, 2000);
                            }
                        });

                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.3
            });

            // Observer chaque catégorie
            document.querySelectorAll('.stats-category, .stats-grid').forEach(section => {
                observer.observe(section);
            });

            // Animation des barres de progression
            const progressObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const bars = entry.target.querySelectorAll('.chart-bar');
                        bars.forEach(bar => {
                            bar.style.height = bar.dataset.value + 'px';
                        });
                        progressObserver.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.5
            });

            document.querySelectorAll('.chart-container').forEach(chart => {
                progressObserver.observe(chart);
            });
        });
    </script>
@endsection
