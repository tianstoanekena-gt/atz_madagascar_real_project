@extends('layouts.main')

@section('content')
    {{-- Chart.js pour le graphique --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <section id="stats" class="stats-section">
        <div class="stats-container">
            <div class="section-header">
                {{-- <span class="section-eyebrow"><i class="fa-solid fa-chart-simple"></i> @lang('stat.title')</span> --}}
                <h2 class="section-title">@lang('stat.title')</h2>
                <div class="title-underline"></div>

                @if ($availableYears->count() > 1)
                    <form method="GET" action="{{ route('stats') }}" class="year-filter-form">
                        <label for="year_select" class="year-filter-label">
                            <i class="fa-regular fa-calendar"></i>
                            @lang('stat.year_label')
                        </label>
                        <div class="year-select-wrapper">
                            <select name="year" id="year_select" onchange="this.form.submit()" class="year-select">
                                @foreach ($availableYears as $year)
                                    <option value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                @else
                    <p class="section-subtitle">@lang('stat.subtitle') {{ $currentYear }}</p>
                @endif
            </div>

            {{-- FALLBACK GLOBAL --}}
            @if ($mainStats->isEmpty() && $educationStats->isEmpty() && $nutritionStats->isEmpty() && $healthStats->isEmpty())
                <div class="global-fallback">
                    <div class="global-fallback-icon">
                        <i class="fa-solid fa-chart-pie"></i>
                    </div>
                    <h3>@lang('stat.global_fallback.title')</h3>
                    <p>@lang('stat.global_fallback.text', ['year' => $currentYear])</p>
                    <a href="{{ route('home') }}" class="global-fallback-btn">
                        <i class="fas fa-home"></i> @lang('stat.global_fallback.btn')
                    </a>
                </div>
            @else
                {{-- ============================================
                     SECTION 1 : STATS PRINCIPALES
                     ============================================ --}}
                @if ($mainStats->isNotEmpty())
                    <div class="stats-grid">
                        @foreach ($mainStats as $stat)
                            <div class="stat-card" data-count="{{ $stat->value }}">
                                <div class="stat-icon">
                                    <i class="fa-solid fa-{{ $stat->icon ?: 'fa-solid fa-chart-line' }}"></i>
                                </div>
                                <div class="stat-content">
                                    <span class="stat-number">0</span>
                                    <span class="stat-label">{{ $stat->label }}</span>
                                    @if ($stat->detail)
                                        <small class="stat-mini-detail">{{ $stat->detail }}</small>
                                    @endif
                                </div>
                                @if ($stat->trend)
                                    <div class="stat-trend positive">
                                        <i class="fa-solid fa-arrow-up"></i> {{ $stat->trend }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- ============================================
                     SECTION 2 : ÉDUCATION (AVEC GRAPHIQUE)
                     ============================================ --}}
                <div class="stats-category">
                    <h3 class="category-title"><i class="fa-solid fa-graduation-cap"></i> @lang('stat.sections.education')</h3>

                    @if ($educationStats->isNotEmpty())
                        {{-- Graphique --}}
                        <div class="chart-container-line">
                            <div class="chart-header">
                                <h4 class="chart-title">
                                    <i class="fa-solid fa-chart-column"></i>
                                    @lang('stat.details.chart_title')
                                </h4>
                                <div class="chart-legend-custom">
                                    <span class="legend-dot"></span>
                                    <span>@lang('stat.sections.education')</span>
                                </div>
                            </div>
                            <div class="chart-canvas-wrapper">
                                <canvas id="educationLineChart"></canvas>
                            </div>
                        </div>

                        {{-- Cartes détaillées en dessous --}}
                        @php
                            $regularStats = $educationStats->whereNotIn('display_type', ['chart_bar']);
                        @endphp

                        {{-- @if ($regularStats->isNotEmpty())
                            <div class="stats-subgrid">
                                @foreach ($regularStats as $stat)
                                    <div class="stat-detailed-card">
                                        <div class="stat-header">
                                            <span class="stat-header-icon">
                                                <i class="fa-solid {{ $stat->icon ?: 'fa-children' }}"></i>
                                            </span>
                                            <h4>{{ $stat->label }}</h4>
                                        </div>

                                        @if ($stat->display_type === 'progress')
                                            <div class="stat-big-number">{{ $stat->value }}</div>
                                            <p class="stat-desc">{{ $stat->detail ?: __('stat.details.goal_reached') }}</p>
                                            <div class="stat-progress">
                                                <div class="progress-bar" style="width: {{ min($stat->value, 100) }}%">
                                                </div>
                                                <span>{{ min($stat->value, 100) }}%</span>
                                            </div>
                                        @elseif($stat->display_type === 'percentage')
                                            <div class="stat-percentage">
                                                <span class="percentage-ring"
                                                    style="--pct: {{ $stat->percentage_value ?? $stat->value }}">
                                                    <span
                                                        class="percentage-value">{{ $stat->percentage_value ?? $stat->value }}%</span>
                                                </span>
                                                <span
                                                    class="percentage-label">{{ $stat->detail ?: __('stat.details.success_rate') }}</span>
                                            </div>
                                        @else
                                            <div class="stat-big-number" data-count="{{ $stat->value }}">0</div>
                                            <p class="stat-desc">{{ $stat->detail ?? '' }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif --}}
                    @else
                        <div class="empty-state">
                            <i class="fa-solid fa-graduation-cap"></i>
                            <p>@lang('stat.fallbacks.education')</p>
                        </div>
                    @endif
                </div>

                {{-- ============================================
                     SECTION 3 : NUTRITION
                     ============================================ --}}
                <div class="stats-category">
                    <h3 class="category-title"><i class="fa-solid fa-utensils"></i> @lang('stat.sections.nutrition')</h3>

                    @if ($nutritionStats->isNotEmpty())
                        <div class="nutrition-grid">
                            @foreach ($nutritionStats as $stat)
                                <div class="nutrition-card">
                                    <div class="nutrition-icon-wrap">
                                        <i class="fa-solid fa-{{ $stat->icon ?: 'fa-bowl-food' }}"></i>
                                    </div>
                                    <span class="nutrition-number" data-count="{{ $stat->value }}">0</span>
                                    <span class="nutrition-label">{{ $stat->label }}</span>
                                    @if ($stat->detail)
                                        <small class="nutrition-detail">{{ $stat->detail }}</small>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fa-solid fa-utensils"></i>
                            <p>@lang('stat.fallbacks.nutrition')</p>
                        </div>
                    @endif
                </div>

                {{-- ============================================
                     SECTION 4 : SANTÉ
                     ============================================ --}}
                <div class="stats-category">
                    <h3 class="category-title"><i class="fa-solid fa-heart-pulse"></i> @lang('stat.sections.health')</h3>

                    @if ($healthStats->isNotEmpty())
                        <div class="health-grid">
                            @foreach ($healthStats as $stat)
                                <div class="health-card" data-count="{{ $stat->value }}">
                                    <i class="fa-solid fa-{{ $stat->icon ?: 'fa-hospital-user' }}"></i>
                                    <span class="health-number">0</span>
                                    <span class="health-label">{{ $stat->label }}</span>
                                    @if ($stat->detail)
                                        <span class="health-detail">{{ $stat->detail }}</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fa-solid fa-heart-pulse"></i>
                            <p>@lang('stat.fallbacks.health')</p>
                        </div>
                    @endif
                </div>

            @endif {{-- Fin du fallback global --}}
        </div>
    </section>

    <style>
        /* ============================================
                                                                               PAGE STATISTIQUES - DESIGN AMÉLIORÉ
                                                                               ============================================ */

        .stats-section {
            padding: 5rem 0 6rem;
            background:
                radial-gradient(circle at 10% 0%, rgba(13, 163, 216, 0.06), transparent 45%),
                radial-gradient(circle at 90% 10%, rgba(254, 237, 2, 0.08), transparent 40%),
                linear-gradient(180deg, #ffffff 0%, var(--color-background) 100%);
            min-height: 100vh;
        }

        .stats-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* ===== HEADER ===== */
        .section-header {
            text-align: center;
            margin-bottom: 3.5rem;
        }

        .section-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--color-blue);
            background: rgba(13, 163, 216, 0.08);
            padding: 6px 16px;
            border-radius: 999px;
            margin-bottom: 1rem;
        }

        .section-title {
            font-size: 2.6rem;
            font-weight: 800;
            color: var(--color-text);
            margin-bottom: 1rem;
            letter-spacing: -0.02em;
        }

        .title-underline {
            width: 5rem;
            height: 5px;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--color-blue), var(--color-primary));
            margin: 0 auto;
        }

        .section-subtitle {
            color: var(--color-text);
            font-size: 1.15rem;
            margin-top: 1.25rem;
            opacity: 0.7;
        }

        /* ===== YEAR FILTER ===== */
        .year-filter-form {
            margin-top: 1.5rem;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: white;
            padding: 8px 10px 8px 18px;
            border-radius: 999px;
            box-shadow: 0 6px 20px rgba(13, 163, 216, 0.1);
            border: 1px solid rgba(13, 163, 216, 0.1);
        }

        .year-filter-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--color-text);
            opacity: 0.75;
        }

        .year-select-wrapper {
            position: relative;
        }

        .year-select {
            appearance: none;
            -webkit-appearance: none;
            background: var(--color-blue);
            color: white;
            font-weight: 700;
            border: none;
            border-radius: 999px;
            padding: 8px 34px 8px 18px;
            cursor: pointer;
            font-size: 0.95rem;
            transition: background 0.25s ease, transform 0.2s ease;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 0.85rem;
        }

        .year-select:hover {
            background-color: #0b8fbd;
            transform: translateY(-1px);
        }

        .year-select:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(13, 163, 216, 0.25);
        }

        /* ===== GLOBAL FALLBACK ===== */
        .global-fallback {
            text-align: center;
            padding: 5rem 2rem;
            background: white;
            border-radius: 28px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            border: 1px dashed rgba(13, 163, 216, 0.25);
        }

        .global-fallback-icon {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: rgba(13, 163, 216, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.75rem;
        }

        .global-fallback-icon i {
            font-size: 2.5rem;
            color: var(--color-blue);
        }

        .global-fallback h3 {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--color-text);
            margin-bottom: 0.75rem;
        }

        .global-fallback p {
            color: #777;
            max-width: 480px;
            margin: 0 auto 1.75rem;
            line-height: 1.6;
        }

        .global-fallback-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--color-blue);
            color: white;
            padding: 12px 26px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.25s ease;
        }

        .global-fallback-btn:hover {
            background: #0b8fbd;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(13, 163, 216, 0.25);
        }

        /* ===== EMPTY STATE (par catégorie) ===== */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            background: #fafbfc;
            border-radius: 18px;
            border: 1px dashed #d8dee3;
        }

        .empty-state i {
            font-size: 2.75rem;
            color: #d0d5da;
            margin-bottom: 0.75rem;
            display: block;
        }

        .empty-state p {
            color: #8a94a0;
            margin: 0;
            font-size: 0.95rem;
        }

        /* ===== STATS PRINCIPALES ===== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
            margin-bottom: 60px;
        }

        .stat-card {
            background: white;
            border-radius: 22px;
            padding: 32px 26px;
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
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            transition: transform 0.35s ease;
        }

        .stat-card:hover .stat-icon {
            transform: scale(1.1) rotate(-4deg);
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
            font-weight: 800;
            color: var(--color-text);
            line-height: 1;
            display: block;
            margin-bottom: 6px;
            font-variant-numeric: tabular-nums;
        }

        .stat-label {
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
            font-weight: 800;
            color: #6b7280;
        }

        .stat-mini-detail {
            display: block;
            color: #9aa3ad;
            margin-top: 6px;
            font-size: 0.85rem;
        }

        .stat-trend {
            font-size: 0.85rem;
            font-weight: 700;
            padding: 5px 12px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .stat-trend.positive {
            background: rgba(110, 157, 46, 0.12);
            color: var(--color-green);
        }

        .stat-trend.stable {
            background: rgba(13, 163, 216, 0.1);
            color: var(--color-blue);
        }

        /* ===== CATEGORY BLOCK ===== */
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
            font-size: 1.7rem;
            font-weight: 700;
            color: var(--color-blue);
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 3px solid var(--color-primary);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .category-title i {
            font-size: 1.9rem;
            color: var(--color-primary);
        }

        /* ===== CHART (nouvelle version lisible) ===== */
        .chart-container-line {
            background: linear-gradient(180deg, #fbfdff 0%, var(--color-background) 100%);
            border-radius: 22px;
            padding: 28px 28px 18px;
            margin-top: 10px;
            width: 100%;
            max-width: 950px;
            margin-left: auto;
            margin-right: auto;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
            border: 1px solid rgba(13, 163, 216, 0.08);
        }

        .chart-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 18px;
        }

        .chart-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--color-text);
            margin: 0;
        }

        .chart-title i {
            color: var(--color-blue);
        }

        .chart-legend-custom {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #6b7280;
            background: white;
            padding: 6px 14px;
            border-radius: 999px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .legend-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--color-blue);
            display: inline-block;
        }

        .chart-canvas-wrapper {
            position: relative;
            height: 340px;
            width: 100%;
        }

        @media (max-width: 768px) {
            .chart-canvas-wrapper {
                height: 280px;
            }
        }

        /* ===== SUBGRID / DETAILED CARDS ===== */
        .stats-subgrid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin-top: 40px;
        }

        .stat-detailed-card {
            background: var(--color-background);
            border-radius: 20px;
            padding: 28px 24px;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }

        .stat-detailed-card:hover {
            transform: scale(1.04);
            box-shadow: 0 15px 30px rgba(13, 163, 216, 0.1);
            border-color: rgba(13, 163, 216, 0.15);
        }

        .stat-header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .stat-header-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: rgba(13, 163, 216, 0.1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .stat-header-icon i {
            font-size: 1.3rem;
            color: var(--color-blue);
        }

        .stat-header h4 {
            font-size: 1.15rem;
            color: var(--color-text);
            font-weight: 700;
            margin: 0;
        }

        .stat-big-number {
            font-size: 3.2rem;
            font-weight: 800;
            color: var(--color-blue);
            line-height: 1;
            margin-bottom: 10px;
            font-variant-numeric: tabular-nums;
        }

        .stat-desc {
            color: #777;
            margin-bottom: 15px;
            font-size: 0.95rem;
        }

        .stat-progress {
            background: #eef1f4;
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
            border-radius: 10px;
        }

        .progress-bar span {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: white;
            font-size: 0.8rem;
            font-weight: 700;
        }

        .stat-percentage {
            margin-top: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .percentage-ring {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: conic-gradient(var(--color-primary) calc(var(--pct, 0) * 1%), #eef1f4 0);
            position: relative;
        }

        .percentage-ring::before {
            content: '';
            position: absolute;
            inset: 8px;
            border-radius: 50%;
            background: var(--color-background);
        }

        .percentage-value {
            position: relative;
            z-index: 1;
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--color-text);
        }

        .percentage-label {
            color: #777;
            font-size: 0.9rem;
        }

        /* ===== NUTRITION ===== */
        .nutrition-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin-bottom: 10px;
        }

        .nutrition-card {
            text-align: center;
            padding: 32px 24px;
            background: linear-gradient(150deg, white, var(--color-background));
            border-radius: 20px;
            transition: all 0.3s ease;
            border: 1px solid rgba(13, 163, 216, 0.06);
        }

        .nutrition-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 30px rgba(13, 163, 216, 0.1);
        }

        .nutrition-icon-wrap {
            width: 70px;
            height: 70px;
            border-radius: 18px;
            background: rgba(254, 237, 2, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
        }

        .nutrition-card i {
            font-size: 2.1rem;
            color: var(--color-primary);
        }

        .nutrition-number {
            font-size: 2.8rem;
            font-weight: 800;
            color: var(--color-blue);
            display: block;
            margin-bottom: 8px;
            font-variant-numeric: tabular-nums;
        }

        .nutrition-label {
            color: #666;
            font-size: 1rem;
            font-weight: 600;
        }

        .nutrition-detail {
            display: block;
            color: #9aa3ad;
            margin-top: 8px;
        }

        /* ===== HEALTH ===== */
        .health-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .health-card {
            background: var(--color-background);
            border-radius: 16px;
            padding: 26px 20px;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }

        .health-card:hover {
            background: var(--color-blue);
            transform: scale(1.05);
            border-color: var(--color-blue);
        }

        .health-card:hover i,
        .health-card:hover .health-number,
        .health-card:hover .health-label,
        .health-card:hover .health-detail {
            color: white;
        }

        .health-card i {
            font-size: 2.4rem;
            color: var(--color-blue);
            margin-bottom: 15px;
            transition: color 0.3s ease;
        }

        .health-number {
            font-size: 2.4rem;
            font-weight: 800;
            color: var(--color-text);
            display: block;
            margin-bottom: 6px;
            transition: color 0.3s ease;
            font-variant-numeric: tabular-nums;
        }

        .health-label {
            color: #666;
            font-size: 0.98rem;
            font-weight: 600;
            display: block;
            margin-bottom: 5px;
            transition: color 0.3s ease;
        }

        .health-detail {
            color: #999;
            font-size: 0.85rem;
            transition: color 0.3s ease;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .stats-subgrid,
            .nutrition-grid,
            .health-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {

            .stats-grid,
            .stats-subgrid,
            .nutrition-grid,
            .health-grid {
                grid-template-columns: 1fr;
            }

            .stats-category {
                padding: 24px 20px;
            }

            .category-title {
                font-size: 1.4rem;
            }

            .section-title {
                font-size: 2rem;
            }

            .stat-number {
                font-size: 2.4rem;
            }

            .chart-container-line {
                padding: 20px 16px 12px;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Animation des compteurs (logique originale conservée)
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

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const counters = entry.target.querySelectorAll(
                            '.stat-number, .stat-big-number, .nutrition-number, .health-number'
                        );

                        counters.forEach(counter => {
                            const parent = counter.closest('[data-count]');
                            const targetValue = parent ? parseFloat(parent.dataset.count) :
                                0;

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

            document.querySelectorAll('.stats-category, .stats-grid').forEach(section => {
                observer.observe(section);
            });

            // 2. Graphique amélioré : barres arrondies + dégradé (plus lisible qu'une ligne fine)
            const chartCanvas = document.getElementById('educationLineChart');
            if (chartCanvas) {
                const eduStats = @json(
                    $educationStats->map(function ($item) {
                        return [
                            'label' => $item->label,
                            'value' => (float) $item->value,
                        ];
                    }));

                const labels = eduStats.map(item => item.label);
                const dataValues = eduStats.map(item => item.value);

                const ctx = chartCanvas.getContext('2d');
                const gradient = ctx.createLinearGradient(0, 0, 0, 320);
                gradient.addColorStop(0, 'rgba(13, 163, 216, 0.95)');
                gradient.addColorStop(1, 'rgba(254, 237, 2, 0.85)');

                new Chart(chartCanvas, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: '{{ __('stat.sections.education') }}',
                            data: dataValues,
                            backgroundColor: gradient,
                            borderRadius: 10,
                            borderSkipped: false,
                            maxBarThickness: 56,
                            hoverBackgroundColor: '#0DA3D8'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        layout: {
                            padding: {
                                top: 10
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: '#0d0c43',
                                titleColor: '#feed02',
                                bodyColor: '#ffffff',
                                titleFont: {
                                    weight: 'bold',
                                    size: 13
                                },
                                bodyFont: {
                                    size: 15,
                                    weight: 'bold'
                                },
                                padding: 12,
                                cornerRadius: 10,
                                displayColors: false,
                                callbacks: {
                                    title: function(items) {
                                        return items[0].label;
                                    },
                                    label: function(context) {
                                        return context.parsed.y.toLocaleString('fr-FR');
                                    }
                                }
                            },
                            // Affiche la valeur au-dessus de chaque barre
                            datalabels: false
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(13, 163, 216, 0.08)',
                                    drawBorder: false
                                },
                                ticks: {
                                    font: {
                                        size: 12,
                                        family: 'sans-serif'
                                    },
                                    color: '#8a94a0',
                                    padding: 8
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 13,
                                        weight: '700',
                                        family: 'sans-serif'
                                    },
                                    color: '#0d0c43'
                                }
                            }
                        },
                        animation: {
                            duration: 900,
                            easing: 'easeOutQuart'
                        }
                    },
                    plugins: [{
                        id: 'valueOnTop',
                        afterDatasetsDraw(chart) {
                            const {
                                ctx,
                                data
                            } = chart;
                            const meta = chart.getDatasetMeta(0);
                            ctx.save();
                            ctx.font = '700 13px sans-serif';
                            ctx.fillStyle = '#0d0c43';
                            ctx.textAlign = 'center';
                            meta.data.forEach((bar, index) => {
                                const value = data.datasets[0].data[index];
                                ctx.fillText(value.toLocaleString('fr-FR'), bar.x, bar.y -
                                    8);
                            });
                            ctx.restore();
                        }
                    }]
                });
            }
        });
    </script>
@endsection
