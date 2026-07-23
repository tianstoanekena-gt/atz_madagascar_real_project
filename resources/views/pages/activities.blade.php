@extends('layouts.main')

@section('content')
    <section class="activities-section py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h1 class="sec_title">@lang('activity.sec_title')</h1>
                <div class="w-24 h-1.5 bg-blue-600 mx-auto rounded-full"></div>
                <p class="text-gray-600 mt-6 max-w-2xl mx-auto text-lg">
                    @lang('activity.subtitle')
                </p>
            </div>

            <div class="activities-carousel-wrapper relative">

                @if ($activities->isNotEmpty())
                    <button type="button" class="carousel-arrow carousel-arrow--prev" id="carouselPrev"
                        aria-label="Précédent">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button type="button" class="carousel-arrow carousel-arrow--next" id="carouselNext"
                        aria-label="Suivant">
                        <i class="fas fa-chevron-right"></i>
                    </button>

                    <div class="activities-parent">
                        @foreach ($activities as $activity)
                            <a href="{{ route('activities.show', ['locale' => app()->getLocale(), 'slug' => $activity->slug]) }}"
                                class="activity-link block {{ $loop->first ? 'active' : '' }}">
                                <div
                                    class="activity-card rounded-3xl shadow-lg overflow-hidden transition-all duration-500 hover:shadow-2xl border">
                                    <div class="activity-image-wrapper relative h-64 overflow-hidden">
                                        @if ($activity->hero_image)
                                            <img src="{{ Storage::url($activity->hero_image) }}"
                                                alt="{{ $activity->title }}"
                                                class="activity-image w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                                <i class="fas fa-image text-5xl text-gray-400"></i>
                                            </div>
                                        @endif
                                        <div class="activity-overlay absolute inset-0"></div>
                                        <span class="activity-badge">{{ $activity->category }}</span>
                                    </div>
                                    <div class="activity-content p-6 md:p-8">
                                        <h2 class="activity-title">{{ $activity->title }}</h2>
                                        <p class="activity-description">
                                            {{ Str::limit(strip_tags($activity->description), 150) }}
                                        </p>
                                        <div class="read_more">
                                            <span>@lang('activity.read_more')</span>
                                            <i class="fas fa-arrow-right ml-2"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-20 bg-white rounded-3xl shadow-sm border border-dashed border-gray-300">
                        <i class="fas fa-hands-helping text-6xl text-gray-300 mb-6"></i>
                        <p class="text-gray-500 text-xl font-medium">@lang('activity.empty')</p>
                    </div>
                @endif

            </div>
        </div>
    </section>

    <style>
        .sec_title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #1F2937;
            margin-bottom: 1rem;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const carouselWrapper = document.querySelector('.activities-carousel-wrapper');
            const activityLinks = document.querySelectorAll('.activity-link');

            if (!carouselWrapper || !activityLinks || activityLinks.length === 0) {
                console.warn('⚠️ Carrousel non initialisé (aucune carte trouvée)');
                return;
            }

            let currentIndex = 0;
            let autoplayInterval;
            const SLIDE_DURATION = 5000;
            let isPaused = false;

            function createIndicators() {
                const indicatorsContainer = document.createElement('div');
                indicatorsContainer.classList.add('activity-indicators');
                activityLinks.forEach((card, index) => {
                    const indicator = document.createElement('div');
                    indicator.classList.add('activity-indicator');
                    if (index === 0) indicator.classList.add('active');
                    indicator.addEventListener('click', () => goToSlide(index));
                    indicatorsContainer.appendChild(indicator);
                });
                document.querySelector('.activities-parent').appendChild(indicatorsContainer);
            }

            function updateIndicators() {
                const indicators = document.querySelectorAll('.activity-indicator');
                indicators.forEach((indicator, index) => {
                    indicator.classList.toggle('active', index === currentIndex);
                });
            }

            function showSlide(index) {
                activityLinks.forEach(link => link.classList.remove('active', 'prev'));
                activityLinks[index].classList.add('active');
                updateIndicators();
            }

            function nextSlide() {
                activityLinks[currentIndex].classList.add('prev');
                currentIndex = (currentIndex + 1) % activityLinks.length;
                showSlide(currentIndex);
            }

            function prevSlide() {
                activityLinks[currentIndex].classList.add('prev');
                currentIndex = (currentIndex - 1 + activityLinks.length) % activityLinks.length;
                showSlide(currentIndex);
            }

            function goToSlide(index) {
                if (index === currentIndex) return;
                activityLinks[currentIndex].classList.add('prev');
                currentIndex = index;
                showSlide(currentIndex);
                restartAutoplay();
            }

            function startAutoplay() {
                if (autoplayInterval) clearInterval(autoplayInterval);
                autoplayInterval = setInterval(() => {
                    if (!isPaused) nextSlide();
                }, SLIDE_DURATION);
            }

            function stopAutoplay() {
                if (autoplayInterval) {
                    clearInterval(autoplayInterval);
                    autoplayInterval = null;
                }
            }

            function restartAutoplay() {
                if (!isPaused) {
                    stopAutoplay();
                    startAutoplay();
                }
            }

            function setupHoverListeners() {
                carouselWrapper.addEventListener('mouseenter', () => {
                    isPaused = true;
                    carouselWrapper.classList.add('paused');
                });
                carouselWrapper.addEventListener('mouseleave', () => {
                    isPaused = false;
                    carouselWrapper.classList.remove('paused');
                });
            }

            function setupTouchGestures() {
                let touchStartX = 0;
                carouselWrapper.addEventListener('touchstart', (e) => {
                    touchStartX = e.changedTouches[0].screenX;
                }, {
                    passive: true
                });
                carouselWrapper.addEventListener('touchend', (e) => {
                    const swipeDistance = touchStartX - e.changedTouches[0].screenX;
                    if (Math.abs(swipeDistance) > 50) {
                        swipeDistance > 0 ? nextSlide() : prevSlide();
                        restartAutoplay();
                    }
                }, {
                    passive: true
                });
            }

            function setupArrows() {
                const prevBtn = document.getElementById('carouselPrev');
                const nextBtn = document.getElementById('carouselNext');
                if (prevBtn) prevBtn.addEventListener('click', () => {
                    prevSlide();
                    restartAutoplay();
                });
                if (nextBtn) nextBtn.addEventListener('click', () => {
                    nextSlide();
                    restartAutoplay();
                });
            }

            function init() {
                createIndicators();
                showSlide(currentIndex);
                setupHoverListeners();
                setupTouchGestures();
                setupArrows();
                startAutoplay();
            }

            init();
        });
    </script>
@endsection
