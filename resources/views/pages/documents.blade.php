@extends('layouts.main')

@section('content')
    <section id="documents" class="documents-section">
        <div class="documents-container">
            {{-- En-tête de la page --}}
            <div class="section-header">
                <h2 class="section-title">@lang('documents.section_title')</h2>
                <div class="title-underline"></div>
                <p class="section-subtitle">@lang('documents.section_subtitle')</p>
            </div>

            {{-- Filtres par catégorie --}}
            <div class="documents-filters">
                <button class="filter-btn active" data-filter="all">@lang('documents.filter_all')</button>
                <button class="filter-btn" data-filter="pdf">PDF</button>
                <button class="filter-btn" data-filter="word">Word</button>
                <button class="filter-btn" data-filter="excel">Excel</button>
                <button class="filter-btn" data-filter="powerpoint">PowerPoint</button>
            </div>

            {{-- Grille des documents --}}
            <div class="documents-grid">
                @forelse($documents as $document)
                    <div class="document-card" data-category="{{ $document->file_type }}">
                        <div class="card-icon {{ $document->type_class }}">
                            <i class="fa-regular {{ $document->icon }}"></i>
                        </div>
                        <div class="card-content">
                            <h3 class="doc-title">{{ $document->title }}</h3>
                            <p class="doc-description">
                                {{ $document->description }}
                            </p>
                            <div class="doc-meta">
                                <span><i class="fa-regular fa-calendar"></i>
                                    {{ $document->created_at->format('d M Y') }}</span>
                                <span><i class="fa-regular fa-file"></i> {{ strtoupper($document->file_type) }},
                                    {{ $document->formatted_size }}</span>
                            </div>
                            <div class="doc-actions">
                                @if ($document->file_type === 'pdf')
                                    <a href="{{ Storage::url($document->file_path) }}" class="btn-preview" target="_blank">
                                        <i class="fa-regular fa-eye"></i> @lang('documents.cta_view')
                                    </a>
                                @else
                                    <span class="btn-preview" style="opacity:0.6;cursor:not-allowed">
                                        <i class="fa-regular fa-eye"></i> @lang('documents.cta_view')
                                    </span>
                                @endif
                                <a href="{{ route('documents.download', ['locale' => app()->getLocale(), 'document' => $document->id]) }}"
                                    class="btn-download" download>
                                    <i class="fa-regular fa-circle-down"></i> @lang('documents.cta_download')
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- État vide : on affiche un message --}}
                    <div class="document-card" style="grid-column:1/-1;justify-self:center">
                        <div class="card-content" style="text-align:center;padding:40px">
                            <i class="fa-regular fa-folder-open" style="font-size:3rem;color:#ccc;margin-bottom:15px"></i>
                            <p style="color:#666">@lang('documents.no_documents')</p>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Section statistiques des documents --}}
            <div class="documents-stats">
                <div class="stat-item">
                    <i class="fa-regular fa-file-pdf"></i>
                    <span class="stat-number">{{ $stats['pdf'] }}</span>
                    <span class="stat-label">@lang('documents.filter_pdf')</span>
                </div>
                <div class="stat-item">
                    <i class="fa-regular fa-file-word"></i>
                    <span class="stat-number">{{ $stats['word'] }}</span>
                    <span class="stat-label">@lang('documents.filter_word')</span>
                </div>
                <div class="stat-item">
                    <i class="fa-regular fa-file-excel"></i>
                    <span class="stat-number">{{ $stats['excel'] }}</span>
                    <span class="stat-label">@lang('documents.filter_excel')</span>
                </div>
                <div class="stat-item">
                    <i class="fa-regular fa-file-powerpoint"></i>
                    <span class="stat-number">{{ $stats['powerpoint'] }}</span>
                    <span class="stat-label">@lang('documents.filter_powerpoint')</span>
                </div>
            </div>
        </div>
    </section>

    {{-- CSS : ON GARDE TON CODE ORIGINAL INTACT --}}
    <style>
        /* ============================================
                                                                                                                                                                                                                                                                                                                                                                                               PAGE DOCUMENTS - STYLES
                                                                                                                                                                                                                                                                                                                                                                                               ============================================ */

        .documents-section {
            padding: 4rem 0;
            background: linear-gradient(135deg, #f5f7fa 0%, #ffffff 100%);
            min-height: 100vh;
        }

        .documents-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .section-subtitle {
            color: var(--color-text);
            font-size: 1.2rem;
            margin-top: 1rem;
            opacity: 0.8;
        }

        /* ============================================
                                                                                                                                                                                                                                                                                                                                                                                               FILTRES
                                                                                                                                                                                                                                                                                                                                                                                               ============================================ */
        .documents-filters {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
            margin: 40px 0 50px;
        }

        .filter-btn {
            padding: 12px 28px;
            border: none;
            background: white;
            color: var(--color-text);
            font-weight: 600;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 2px solid transparent;
            font-size: 0.95rem;
            letter-spacing: 0.3px;
        }

        .filter-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(13, 163, 216, 0.15);
            border-color: var(--color-blue);
        }

        .filter-btn.active {
            background: var(--color-blue);
            color: white;
            box-shadow: 0 8px 25px rgba(13, 163, 216, 0.3);
        }

        /* ============================================
                                                                                                                                                                                                                                                                                                                                                                                               GRILLE DES DOCUMENTS
                                                                                                                                                                                                                                                                                                                                                                                               ============================================ */
        .documents-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 30px;
            margin-bottom: 60px;
        }

        /* ============================================
                                                                                                                                                                                                                                                                                                                                                                                               CARTE DOCUMENT - STYLE DE BASE
                                                                                                                                                                                                                                                                                                                                                                                               ============================================ */
        .document-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            display: flex;
            flex-direction: column;
            opacity: 0;
            transform: translateY(30px);
            animation: cardAppear 0.6s ease forwards;
        }

        .document-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .document-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .document-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .document-card:nth-child(4) {
            animation-delay: 0.4s;
        }

        .document-card:nth-child(5) {
            animation-delay: 0.5s;
        }

        .document-card:nth-child(6) {
            animation-delay: 0.6s;
        }

        .document-card:nth-child(7) {
            animation-delay: 0.7s;
        }

        .document-card:nth-child(8) {
            animation-delay: 0.8s;
        }

        @keyframes cardAppear {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .document-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }

        .document-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 20px;
            padding: 2px;
            background: linear-gradient(45deg, var(--color-blue), var(--color-primary));
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            opacity: 0;
            transition: opacity 0.4s ease;
            pointer-events: none;
        }

        .document-card:hover::before {
            opacity: 1;
        }

        /* ============================================
                                                                                                                                                                                                                                                                                                                                                                                               ICÔNE DE LA CARTE
                                                                                                                                                                                                                                                                                                                                                                                               ============================================ */
        .card-icon {
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3.5rem;
            color: white;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .card-icon::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: rgba(255, 255, 255, 0.1);
            transform: rotate(45deg);
            transition: all 0.6s ease;
            opacity: 0;
        }

        .document-card:hover .card-icon::after {
            opacity: 1;
            transform: rotate(45deg) translate(10%, 10%);
        }

        .pdf-bg {
            background: linear-gradient(135deg, #f40f02, #b71c1c);
        }

        .word-bg {
            background: linear-gradient(135deg, #2b5797, #1e3f6e);
        }

        .excel-bg {
            background: linear-gradient(135deg, #217346, #0e5c2e);
        }

        .ppt-bg {
            background: linear-gradient(135deg, #d35230, #b33e1f);
        }

        /* ============================================
                                                                                                                                                                                                                                                                                                                                                                                               CONTENU DE LA CARTE
                                                                                                                                                                                                                                                                                                                                                                                               ============================================ */
        .card-content {
            padding: 25px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .doc-title {
            font-size: 1.4rem;
            font-weight: bold;
            color: var(--color-text);
            margin-bottom: 12px;
            transition: color 0.3s ease;
            position: relative;
            display: inline-block;
        }

        .doc-title::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 3px;
            background: var(--color-blue);
            transition: width 0.3s ease;
        }

        .document-card:hover .doc-title::after {
            width: 50px;
        }

        .doc-description {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 20px;
            flex: 1;
        }

        /* ============================================
                                                                                                                                                                                                                                                                                                                                                                                               MÉTADONNÉES
                                                                                                                                                                                                                                                                                                                                                                                               ============================================ */
        .doc-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 20px;
            padding: 15px 0;
            border-top: 1px solid #eee;
            border-bottom: 1px solid #eee;
        }

        .doc-meta span {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.85rem;
            color: #777;
            transition: all 0.3s ease;
        }

        .doc-meta span i {
            color: var(--color-blue);
            font-size: 1rem;
        }

        .document-card:hover .doc-meta span {
            color: var(--color-text);
        }

        /* ============================================
                                                                                                                                                                                                                                                                                                                                                                                               BOUTONS D'ACTION
                                                                                                                                                                                                                                                                                                                                                                                               ============================================ */
        .doc-actions {
            display: flex;
            gap: 12px;
            margin-top: auto;
        }

        .btn-preview,
        .btn-download {
            flex: 1;
            padding: 12px 0;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .btn-preview {
            background: #f0f7ff;
            color: var(--color-blue);
        }

        .btn-preview:hover {
            background: var(--color-blue);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(13, 163, 216, 0.3);
        }

        .btn-download {
            background: white;
            color: var(--color-text);
            border: 2px solid #e0e0e0;
        }

        .btn-download:hover {
            border-color: var(--color-blue);
            color: var(--color-blue);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .btn-preview:active,
        .btn-download:active {
            transform: translateY(-1px) scale(0.98);
        }

        /* ============================================
                                                                                                                                                                                                                                                                                                                                                                                               STATISTIQUES
                                                                                                                                                                                                                                                                                                                                                                                               ============================================ */
        .documents-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            margin-top: 60px;
            padding: 40px;
            background: white;
            border-radius: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .stat-item {
            text-align: center;
            padding: 20px;
            border-radius: 20px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, var(--color-blue), var(--color-primary));
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 0;
        }

        .stat-item:hover::before {
            opacity: 0.1;
        }

        .stat-item i {
            font-size: 2.5rem;
            color: var(--color-blue);
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .stat-item:hover i {
            transform: scale(1.2) rotate(360deg);
        }

        .stat-number {
            display: block;
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--color-text);
            margin-bottom: 5px;
        }

        .stat-label {
            color: #777;
            font-size: 1rem;
        }

        /* ============================================
                                                                                                                                                                                                                                                                                                                                                                                               ANIMATIONS SUPPLÉMENTAIRES
                                                                                                                                                                                                                                                                                                                                                                                               ============================================ */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-5px);
            }
        }

        .document-card:hover .card-icon i {
            animation: float 2s ease infinite;
        }

        .filter-btn {
            position: relative;
            overflow: hidden;
        }

        .filter-btn::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .filter-btn:active::after {
            width: 200px;
            height: 200px;
        }

        /* ============================================
                                                                                                                                                                                                                                                                                                                                                                                               RESPONSIVE
                                                                                                                                                                                                                                                                                                                                                                                               ============================================ */
        @media (max-width: 1024px) {
            .documents-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .documents-stats {
                padding: 30px;
                gap: 20px;
            }
        }

        @media (max-width: 768px) {
            .documents-section {
                padding: 3rem 0;
            }

            .documents-grid {
                grid-template-columns: 1fr;
                gap: 25px;
            }

            .documents-filters {
                gap: 10px;
                margin: 30px 0 40px;
            }

            .filter-btn {
                padding: 10px 20px;
                font-size: 0.9rem;
            }

            .documents-stats {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
                padding: 25px;
            }

            .stat-item i {
                font-size: 2rem;
            }

            .stat-number {
                font-size: 2rem;
            }
        }

        @media (max-width: 480px) {
            .documents-section {
                padding: 2rem 0;
            }

            .section-title {
                font-size: 2rem;
            }

            .section-subtitle {
                font-size: 1rem;
            }

            .documents-filters {
                flex-direction: row;
                overflow-x: auto;
                padding-bottom: 10px;
                justify-content: flex-start;
                -webkit-overflow-scrolling: touch;
            }

            .filter-btn {
                flex: 0 0 auto;
                padding: 8px 16px;
                font-size: 0.85rem;
            }

            .document-card {
                margin: 0 5px;
            }

            .card-icon {
                height: 80px;
                font-size: 2.5rem;
            }

            .card-content {
                padding: 20px;
            }

            .doc-title {
                font-size: 1.2rem;
            }

            .doc-description {
                font-size: 0.9rem;
            }

            .doc-meta {
                gap: 10px;
                padding: 12px 0;
            }

            .doc-meta span {
                font-size: 0.8rem;
            }

            .doc-actions {
                flex-direction: column;
                gap: 8px;
            }

            .btn-preview,
            .btn-download {
                padding: 10px 0;
                font-size: 0.9rem;
            }

            .documents-stats {
                grid-template-columns: 1fr;
                gap: 15px;
                padding: 20px;
                margin-top: 40px;
            }

            .stat-item {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 15px;
                padding: 15px;
            }

            .stat-item i {
                margin-bottom: 0;
                font-size: 1.8rem;
            }

            .stat-number {
                font-size: 1.8rem;
                margin-bottom: 0;
            }
        }

        @media (max-width: 350px) {
            .filter-btn {
                padding: 6px 12px;
                font-size: 0.8rem;
            }

            .card-icon {
                height: 70px;
                font-size: 2rem;
            }

            .card-content {
                padding: 15px;
            }

            .doc-title {
                font-size: 1.1rem;
            }

            .doc-meta {
                flex-direction: column;
                gap: 5px;
            }

            .stat-item {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>

    {{-- JS : ON GARDE TON CODE ORIGINAL INTACT --}}
    <script>
        // ============================================
        // FILTRAGE DES DOCUMENTS
        // ============================================
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.filter-btn');
            const documentCards = document.querySelectorAll('.document-card');

            function filterDocuments(category) {
                documentCards.forEach(card => {
                    card.style.animation = 'none';
                    card.offsetHeight;
                    if (category === 'all' || card.dataset.category === category) {
                        card.style.display = 'flex';
                        card.style.animation = 'cardAppear 0.6s ease forwards';
                    } else {
                        card.style.display = 'none';
                    }
                });
                filterButtons.forEach(btn => {
                    btn.classList.remove('active');
                    if (btn.dataset.filter === category) {
                        btn.classList.add('active');
                    }
                });
            }

            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const category = this.dataset.filter;
                    filterDocuments(category);
                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = 'scale(1)';
                    }, 200);
                });
            });

            const statsSection = document.querySelector('.documents-stats');
            if (statsSection) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.style.animation = 'fadeInUp 0.8s ease forwards';
                            const statNumbers = entry.target.querySelectorAll('.stat-number');
                            statNumbers.forEach(number => {
                                const finalValue = number.innerText;
                                if (!isNaN(finalValue)) {
                                    animateValue(number, 0, parseInt(finalValue), 1500);
                                }
                            });
                        }
                    });
                }, {
                    threshold: 0.5
                });
                observer.observe(statsSection);
            }

            function animateValue(element, start, end, duration) {
                const range = end - start;
                const increment = range / (duration / 16);
                let current = start;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= end) {
                        element.innerText = end;
                        clearInterval(timer);
                    } else {
                        element.innerText = Math.floor(current);
                    }
                }, 16);
            }

            const style = document.createElement('style');
            style.innerHTML = `
                @keyframes fadeInUp {
                    from { opacity: 0; transform: translateY(30px); }
                    to { opacity: 1; transform: translateY(0); }
                }
            `;
            document.head.appendChild(style);
        });
    </script>
@endsection
