@extends('layouts.main')

@section('content')
    <section id="faq" class="faq-section">
        <div class="faq-container">
            {{-- En-tête de la page --}}
            <div class="section-header">
                <h2 class="section-title">@lang('faq.categories.all')</h2>
                <div class="title-underline"></div>
                <p class="section-subtitle">@lang('faq.not_found_text')</p>
            </div>

            {{-- Barre de recherche --}}
            <div class="faq-search-wrapper">
                <div class="faq-search-container">
                    <i class="fa-solid fa-magnifying-glass search-icon"></i>
                    <input type="text" class="faq-search" placeholder="@lang('faq.search_placeholder')" id="faqSearch">
                    <button class="search-clear" id="clearSearch">
                        <i class="fa-solid fa-times"></i>
                    </button>
                </div>
            </div>

            {{-- Catégories FAQ --}}
            <div class="faq-categories">
                <button class="category-btn active" data-category="all">@lang('faq.categories.all')</button>
                <button class="category-btn" data-category="general">@lang('faq.categories.general')</button>
                {{-- <button class="category-btn" data-category="membership">@lang('faq.categories.membership')</button> --}}
                <button class="category-btn" data-category="donation">@lang('faq.categories.donation')</button>
                <button class="category-btn" data-category="activities">@lang('faq.categories.activities')</button>
                <button class="category-btn" data-category="contact">@lang('faq.categories.contact')</button>
            </div>

            {{-- Grille FAQ --}}
            <div class="faq-grid">
                @forelse($faqsByCategory as $category => $faqs)
                    <div class="faq-category-group" data-category="{{ $category }}">
                        <h3 class="faq-category-title">
                            <i class="fa-regular {{ $faqs->first()->category_icon }}"></i>
                            {{ __('faq.categories.' . $category) }}
                        </h3>

                        @foreach ($faqs as $faq)
                            <div class="faq-item">
                                <div class="faq-question">
                                    <div class="question-content">
                                        <i class="fa-regular fa-comment"></i>
                                        <span>{{ $faq->question }}</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-down faq-toggle"></i>
                                </div>
                                <div class="faq-answer">
                                    {!! $faq->answer !!}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @empty
                    {{-- État vide --}}
                    <div class="text-center py-16">
                        <i class="fa-regular fa-circle-question" style="font-size:4rem;color:#ccc;margin-bottom:20px"></i>
                        <p class="text-gray-500 text-lg">@lang('faq.no_results')</p>
                    </div>
                @endforelse
            </div>

            {{-- Section "Vous n'avez pas trouvé?" --}}
            <div class="faq-no-answer">
                <div class="no-answer-content">
                    <i class="fa-regular fa-message-question"></i>
                    <h3>@lang('faq.not_found_title')</h3>
                    <p>@lang('faq.not_found_text')</p>
                    <a href="{{ localized_route('contact') }}" class="contact-btn">
                        @lang('faq.contact_btn')
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- CSS : ON GARDE TON CODE ORIGINAL INTACT --}}
    <style coped>
        /* ============================================
                                                                                                                                                   PAGE FAQ - STYLES AVEC VOS COULEURS
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
        }

        .faq-section {
            padding: 4rem 0;
            background: linear-gradient(135deg, #ffffff 0%, var(--color-background) 100%);
            min-height: 100vh;
        }

        .faq-container {
            max-width: 1200px;
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
                                                                                                                                                   BARRE DE RECHERCHE
                                                                                                                                                   ============================================ */
        .faq-search-wrapper {
            max-width: 600px;
            margin: 40px auto 30px;
            opacity: 0;
            transform: translateY(20px);
            animation: searchFadeIn 0.6s ease forwards;
        }

        @keyframes searchFadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .faq-search-container {
            position: relative;
            width: 100%;
        }

        .search-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--color-blue);
            font-size: 1.2rem;
            z-index: 1;
        }

        .faq-search {
            width: 100%;
            padding: 18px 50px 18px 55px;
            border: 2px solid transparent;
            border-radius: 60px;
            font-size: 1.1rem;
            background: white;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            color: var(--color-text);
        }

        .faq-search:focus {
            outline: none;
            border-color: var(--color-blue);
            box-shadow: 0 10px 40px rgba(13, 163, 216, 0.15);
        }

        .faq-search::placeholder {
            color: #999;
            font-style: italic;
        }

        .search-clear {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #999;
            cursor: pointer;
            font-size: 1.2rem;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .search-clear.visible {
            opacity: 1;
        }

        .search-clear:hover {
            color: var(--color-red);
        }

        /* ============================================
                                                                                                                                                   CATÉGORIES
                                                                                                                                                   ============================================ */
        .faq-categories {
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
            margin: 40px 0 50px;
            opacity: 0;
            transform: translateY(20px);
            animation: categoriesFadeIn 0.6s ease 0.2s forwards;
        }

        @keyframes categoriesFadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .category-btn {
            padding: 12px 24px;
            border: none;
            background: white;
            color: var(--color-text);
            font-weight: 600;
            border-radius: 40px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            border: 2px solid transparent;
            font-size: 0.95rem;
        }

        .category-btn:hover {
            transform: translateY(-3px);
            border-color: var(--color-blue);
            box-shadow: 0 8px 25px rgba(13, 163, 216, 0.1);
        }

        .category-btn.active {
            background: var(--color-blue);
            color: white;
            box-shadow: 0 8px 25px rgba(13, 163, 216, 0.3);
        }

        /* ============================================
                                                                                                                                                   GRILLE FAQ
                                                                                                                                                   ============================================ */
        .faq-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 40px;
            margin-bottom: 60px;
        }

        .faq-category-group {
            opacity: 0;
            transform: translateY(30px);
            animation: groupFadeIn 0.6s ease forwards;
        }

        .faq-category-group:nth-child(1) {
            animation-delay: 0.3s;
        }

        .faq-category-group:nth-child(2) {
            animation-delay: 0.4s;
        }

        .faq-category-group:nth-child(3) {
            animation-delay: 0.5s;
        }

        .faq-category-group:nth-child(4) {
            animation-delay: 0.6s;
        }

        .faq-category-group:nth-child(5) {
            animation-delay: 0.7s;
        }

        @keyframes groupFadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .faq-category-title {
            font-size: 1.6rem;
            color: var(--color-blue);
            margin-bottom: 25px;
            padding-bottom: 10px;
            border-bottom: 3px solid var(--color-primary);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .faq-category-title i {
            font-size: 1.8rem;
            color: var(--color-primary);
        }

        /* ============================================
                                                                                                                                                   ITEMS FAQ
                                                                                                                                                   ============================================ */
        .faq-item {
            background: white;
            border-radius: 16px;
            margin-bottom: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            border: 1px solid rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .faq-item:hover {
            box-shadow: 0 8px 25px rgba(13, 163, 216, 0.1);
            border-color: var(--color-blue);
        }

        .faq-question {
            padding: 20px 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .question-content {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 600;
            color: var(--color-text);
            font-size: 1.1rem;
        }

        .question-content i {
            color: var(--color-blue);
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .faq-toggle {
            font-size: 1.2rem;
            color: var(--color-blue);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .faq-item.active .faq-toggle {
            transform: rotate(180deg);
            color: var(--color-primary);
        }

        .faq-item.active .faq-question {
            background: linear-gradient(90deg, rgba(13, 163, 216, 0.03), transparent);
        }

        .faq-answer {
            max-height: 0;
            padding: 0 25px;
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(254, 237, 2, 0.02);
        }

        .faq-item.active .faq-answer {
            max-height: 500px;
            padding: 0 25px 25px 25px;
        }

        .faq-answer p {
            color: #666;
            line-height: 1.8;
            margin-bottom: 15px;
        }

        .faq-answer ul {
            list-style: none;
            padding: 0;
        }

        .faq-answer li {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #555;
            margin-bottom: 10px;
            padding: 8px 12px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        }

        .faq-answer li i {
            color: var(--color-green);
            font-size: 1rem;
        }

        /* ============================================
                                                                                                                                                   ÉLÉMENTS SPÉCIAUX DANS LES RÉPONSES
                                                                                                                                                   ============================================ */
        .faq-highlight {
            background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
            color: var(--color-text);
            padding: 15px 20px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 15px;
            margin-top: 15px;
            font-weight: 600;
        }

        .faq-highlight i {
            font-size: 1.5rem;
            color: var(--color-text);
        }

        .faq-contact-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
            transition: all 0.3s ease;
        }

        .contact-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(13, 163, 216, 0.1);
        }

        .contact-item i {
            color: var(--color-blue);
            font-size: 1.2rem;
        }

        .faq-social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .social-link {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            background: white;
            border-radius: 12px;
            text-decoration: none;
            color: var(--color-text);
            font-weight: 600;
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .social-link:hover {
            transform: translateY(-3px);
            border-color: var(--color-blue);
            color: var(--color-blue);
            box-shadow: 0 8px 20px rgba(13, 163, 216, 0.1);
        }

        .social-link i {
            font-size: 1.2rem;
            color: var(--color-blue);
        }

        /* ============================================
                                                                                                                                                   SECTION "VOUS N'AVEZ PAS TROUVÉ?"
                                                                                                                                                   ============================================ */
        .faq-no-answer {
            margin: 80px 0 40px;
            padding: 60px 40px;
            background: linear-gradient(135deg, rgba(13, 163, 216, 0.05), rgba(254, 237, 2, 0.05));
            border-radius: 40px;
            text-align: center;
            opacity: 0;
            transform: translateY(30px);
            animation: noAnswerFadeIn 0.6s ease 0.8s forwards;
        }

        @keyframes noAnswerFadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .no-answer-content {
            max-width: 500px;
            margin: 0 auto;
        }

        .no-answer-content i {
            font-size: 4rem;
            color: var(--color-blue);
            margin-bottom: 20px;
        }

        .no-answer-content h3 {
            font-size: 2rem;
            color: var(--color-text);
            margin-bottom: 15px;
        }

        .no-answer-content p {
            color: #666;
            margin-bottom: 30px;
            font-size: 1.1rem;
        }

        .contact-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 16px 40px;
            background: var(--color-blue);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .contact-btn:hover {
            background: white;
            color: var(--color-blue);
            border-color: var(--color-blue);
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(13, 163, 216, 0.3);
        }

        /* ============================================
                                                                                                                                                   RECHERCHE HIGHLIGHT
                                                                                                                                                   ============================================ */
        .faq-item.highlight {
            animation: highlightPulse 1s ease 2;
            border-color: var(--color-primary);
        }

        @keyframes highlightPulse {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(254, 237, 2, 0.4);
            }

            50% {
                box-shadow: 0 0 0 10px rgba(254, 237, 2, 0);
            }
        }

        /* ============================================
                                                                                                                                                   RESPONSIVE
                                                                                                                                                   ============================================ */

        /* Tablettes (1024px) */
        @media (max-width: 1024px) {
            .faq-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }
        }

        /* Tablettes (768px) */
        @media (max-width: 768px) {
            .faq-section {
                padding: 3rem 0;
            }

            .section-title {
                font-size: 2rem;
            }

            .faq-categories {
                gap: 8px;
                margin: 30px 0 40px;
            }

            .category-btn {
                padding: 10px 18px;
                font-size: 0.9rem;
            }

            .faq-category-title {
                font-size: 1.4rem;
                margin-bottom: 20px;
            }

            .faq-question {
                padding: 18px 20px;
            }

            .question-content {
                font-size: 1rem;
            }

            .faq-no-answer {
                margin: 60px 0 30px;
                padding: 40px 30px;
            }

            .no-answer-content h3 {
                font-size: 1.6rem;
            }
        }

        /* Smartphones (480px) */
        @media (max-width: 480px) {
            .faq-section {
                padding: 2rem 0;
            }

            .section-title {
                font-size: 1.8rem;
            }

            .section-subtitle {
                font-size: 1rem;
            }

            .faq-search {
                padding: 15px 40px 15px 45px;
                font-size: 1rem;
            }

            .search-icon {
                left: 15px;
                font-size: 1rem;
            }

            .faq-categories {
                flex-direction: row;
                overflow-x: auto;
                padding-bottom: 10px;
                justify-content: flex-start;
                -webkit-overflow-scrolling: touch;
            }

            .category-btn {
                flex: 0 0 auto;
                padding: 8px 16px;
                font-size: 0.85rem;
            }

            .faq-category-title {
                font-size: 1.3rem;
            }

            .faq-category-title i {
                font-size: 1.4rem;
            }

            .question-content {
                font-size: 0.95rem;
                gap: 8px;
            }

            .faq-answer p {
                font-size: 0.9rem;
            }

            .faq-answer li {
                font-size: 0.9rem;
                padding: 6px 10px;
            }

            .faq-highlight {
                flex-direction: column;
                text-align: center;
                padding: 15px;
            }

            .faq-contact-info {
                grid-template-columns: 1fr;
            }

            .faq-social-links {
                flex-direction: column;
            }

            .social-link {
                justify-content: center;
            }

            .faq-no-answer {
                margin: 40px 0 20px;
                padding: 30px 20px;
            }

            .no-answer-content i {
                font-size: 3rem;
            }

            .no-answer-content h3 {
                font-size: 1.4rem;
            }

            .no-answer-content p {
                font-size: 1rem;
            }

            .contact-btn {
                padding: 14px 30px;
                font-size: 1rem;
            }
        }
    </style>

    {{-- JS : ON GARDE TON CODE ORIGINAL INTACT --}}
    <script>
        // ============================================
        // FAQ - INTERACTIVITÉ
        // ============================================
        document.addEventListener('DOMContentLoaded', function() {

            // ============================================
            // ACCORDÉON FAQ
            // ============================================
            const faqItems = document.querySelectorAll('.faq-item');

            faqItems.forEach(item => {
                const question = item.querySelector('.faq-question');

                question.addEventListener('click', function() {
                    item.classList.toggle('active');
                });
            });

            // ============================================
            // FILTRAGE PAR CATÉGORIE
            // ============================================
            const categoryButtons = document.querySelectorAll('.category-btn');
            const categoryGroups = document.querySelectorAll('.faq-category-group');

            categoryButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const category = this.dataset.category;

                    categoryButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');

                    categoryGroups.forEach(group => {
                        if (category === 'all' || group.dataset.category === category) {
                            group.style.display = 'block';
                            group.style.animation = 'none';
                            group.offsetHeight;
                            group.style.animation = 'groupFadeIn 0.6s ease forwards';
                        } else {
                            group.style.display = 'none';
                        }
                    });

                    const searchInput = document.getElementById('faqSearch');
                    if (searchInput) {
                        searchInput.value = '';
                        document.querySelector('.search-clear').classList.remove('visible');
                        resetSearchHighlights();
                    }
                });
            });

            // ============================================
            // RECHERCHE DANS LA FAQ
            // ============================================
            const searchInput = document.getElementById('faqSearch');
            const clearButton = document.getElementById('clearSearch');

            if (searchInput && clearButton) {

                function resetSearchHighlights() {
                    document.querySelectorAll('.faq-item').forEach(item => {
                        item.classList.remove('highlight');
                    });
                }

                function performSearch() {
                    const searchTerm = searchInput.value.toLowerCase().trim();
                    const allFaqItems = document.querySelectorAll('.faq-item');
                    let hasResults = false;

                    resetSearchHighlights();

                    if (searchTerm === '') {
                        const activeCategory = document.querySelector('.category-btn.active').dataset.category;
                        document.querySelectorAll('.faq-category-group').forEach(group => {
                            if (activeCategory === 'all' || group.dataset.category === activeCategory) {
                                group.style.display = 'block';
                            }
                        });

                        allFaqItems.forEach(item => {
                            item.style.display = 'block';
                        });

                        clearButton.classList.remove('visible');
                        return;
                    }

                    clearButton.classList.add('visible');

                    allFaqItems.forEach(item => {
                        const question = item.querySelector('.question-content span').textContent
                            .toLowerCase();
                        const answer = item.querySelector('.faq-answer').textContent.toLowerCase();
                        const category = item.closest('.faq-category-group');

                        if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                            if (category) category.style.display = 'block';
                            item.style.display = 'block';
                            item.classList.add('highlight');
                            hasResults = true;
                        } else {
                            item.style.display = 'none';
                        }
                    });

                    document.querySelectorAll('.faq-category-group').forEach(group => {
                        const visibleItems = group.querySelectorAll('.faq-item[style="display: block;"]');
                        if (visibleItems.length === 0) {
                            group.style.display = 'none';
                        }
                    });

                    if (hasResults) {
                        document.querySelectorAll('.faq-item.highlight').forEach(item => {
                            item.classList.add('active');
                        });
                    }
                }

                searchInput.addEventListener('input', performSearch);

                clearButton.addEventListener('click', function() {
                    searchInput.value = '';
                    this.classList.remove('visible');

                    const activeCategory = document.querySelector('.category-btn.active').dataset.category;
                    document.querySelectorAll('.faq-category-group').forEach(group => {
                        if (activeCategory === 'all' || group.dataset.category === activeCategory) {
                            group.style.display = 'block';
                        } else {
                            group.style.display = 'none';
                        }
                    });

                    document.querySelectorAll('.faq-item').forEach(item => {
                        item.style.display = 'block';
                        item.classList.remove('highlight', 'active');
                    });
                });
            }

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const clearBtn = document.getElementById('clearSearch');
                    if (clearBtn) {
                        if (this.value.length > 0) {
                            clearBtn.classList.add('visible');
                        } else {
                            clearBtn.classList.remove('visible');
                        }
                    }
                });
            }
        });
    </script>
@endsection
