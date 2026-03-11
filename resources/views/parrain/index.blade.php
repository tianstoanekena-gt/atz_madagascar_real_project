@extends('layouts.auth-layout')

@section('title', 'Devenir Parrain - ATZ Madagascar')

@section('content')
    <section class="parrain_section">
        <div class="parrain_container">

            {{-- Colonne gauche --}}
            <div class="parrain_left">
                <figure class="logo-wrapper">
                    @if (isset($globalLogo) && $globalLogo && \Illuminate\Support\Facades\Storage::disk('public')->exists($globalLogo->logo))
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($globalLogo->logo) }}" alt="Logo du site"
                            class="logo_in_spons">
                    @else
                        <img src="{{ asset('assets/images/logo-atz.png') }}" alt="Logo par défaut" class="logo_in_spons">
                    @endif
                </figure>
                <style>
                    .logo_in_spons {
                        width: 180px;
                        height: auto;
                    }
                </style>

                <nav class="parrain_nav">

                    {{-- REGISTER --}}
                    <a href="{{ route('register') }}" class="nav-link nav-register">
                        <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        <span>{{ __('parrain.nav.register') }}</span>
                    </a>

                    {{-- LOGIN --}}
                    <a href="{{ route('login') }}" class="nav-link nav-login">
                        <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        <span>{{ __('parrain.nav.login') }}</span>
                    </a>

                    {{-- HOME --}}
                    <a href="{{ route('home') }}" class="nav-link nav-home">
                        <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span>{{ __('parrain.nav.home') }}</span>
                    </a>

                </nav>
            </div>

            {{-- Colonne droite --}}
            <div class="parrain_right">
                <div class="content-card">

                    <div class="card-header">
                        <svg class="header-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>

                        <h2 class="card-title">
                            {{ __('parrain.card_title') }}
                        </h2>
                    </div>

                    <p class="intro-text">
                        {!! __('parrain.intro') !!}
                    </p>

                    <div class="info-box">
                        <svg class="info-icon" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>

                        <p class="info-text">
                            {{ __('parrain.info') }}
                        </p>
                    </div>

                    <div class="cta-buttons">

                        <a href="{{ route('register') }}" class="cta-btn cta-primary">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            {{ __('parrain.cta_primary') }}
                        </a>

                        <a href="{{ route('contact') }}" class="cta-btn cta-secondary">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            {{ __('parrain.cta_secondary') }}
                        </a>

                    </div>

                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ==========================================
            // 1. ANIMATION D'APPARITION AU SCROLL
            // ==========================================
            const section = document.querySelector('.parrain_section');
            const leftColumn = document.querySelector('.parrain_left');
            const rightColumn = document.querySelector('.parrain_right');

            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, observerOptions);

            if (leftColumn) observer.observe(leftColumn);
            if (rightColumn) observer.observe(rightColumn);

            // ==========================================
            // 2. EFFET PARALLAX SUR LE LOGO
            // ==========================================
            const logoImg = document.querySelector('.logo-img');

            if (logoImg) {
                section.addEventListener('mousemove', (e) => {
                    const rect = section.getBoundingClientRect();
                    const x = (e.clientX - rect.left) / rect.width - 0.5;
                    const y = (e.clientY - rect.top) / rect.height - 0.5;

                    logoImg.style.transform = `translate(${x * 10}px, ${y * 10}px) scale(1)`;
                });

                section.addEventListener('mouseleave', () => {
                    logoImg.style.transform = 'translate(0, 0) scale(1)';
                });
            }

            // ==========================================
            // 3. ANIMATION DES LIENS DE NAVIGATION
            // ==========================================
            const navLinks = document.querySelectorAll('.nav-link');

            navLinks.forEach((link, index) => {
                // Animation d'apparition progressive
                link.style.animationDelay = `${0.2 + (index * 0.1)}s`;

                // Effet de pulsation au hover
                link.addEventListener('mouseenter', function() {
                    this.style.animation = 'pulse 0.6s ease';
                });

                link.addEventListener('mouseleave', function() {
                    this.style.animation = 'none';
                });
            });

            // ==========================================
            // 4. COMPTEUR ANIMÉ (SI STATISTIQUES)
            // ==========================================
            function animateCounter(element, target) {
                let current = 0;
                const increment = target / 50;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        element.textContent = Math.ceil(target);
                        clearInterval(timer);
                    } else {
                        element.textContent = Math.ceil(current);
                    }
                }, 30);
            }

            // ==========================================
            // 5. EFFET DE TYPING SUR LE TITRE
            // ==========================================
            const cardTitle = document.querySelector('.card-title');

            if (cardTitle) {
                const originalText = cardTitle.textContent;
                cardTitle.textContent = '';

                let charIndex = 0;
                const typingSpeed = 80;

                setTimeout(() => {
                    const typingInterval = setInterval(() => {
                        if (charIndex < originalText.length) {
                            cardTitle.textContent += originalText[charIndex];
                            charIndex++;
                        } else {
                            clearInterval(typingInterval);
                            cardTitle.classList.add('typing-complete');
                        }
                    }, typingSpeed);
                }, 500);
            }

            // ==========================================
            // 6. EFFET RIPPLE SUR LES BOUTONS CTA
            // ==========================================
            const ctaButtons = document.querySelectorAll('.cta-btn');

            ctaButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    const ripple = document.createElement('span');
                    ripple.classList.add('ripple');

                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;

                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = x + 'px';
                    ripple.style.top = y + 'px';

                    this.appendChild(ripple);

                    setTimeout(() => ripple.remove(), 600);
                });
            });

            // ==========================================
            // 7. SMOOTH SCROLL POUR LES ANCRES
            // ==========================================
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // ==========================================
            // 8. DÉTECTION DU SCROLL POUR HEADER STICKY
            // ==========================================
            let lastScroll = 0;

            window.addEventListener('scroll', () => {
                const currentScroll = window.pageYOffset;

                if (currentScroll > lastScroll && currentScroll > 100) {
                    // Scroll vers le bas
                    section.classList.add('scrolled-down');
                } else {
                    // Scroll vers le haut
                    section.classList.remove('scrolled-down');
                }

                lastScroll = currentScroll;
            });

            console.log('✅ Page Parrain initialisée avec succès!');
        });
    </script>
@endsection
