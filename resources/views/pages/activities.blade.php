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
                <div class="activities-parent">
                    @if ($activities->isNotEmpty())
                        @foreach ($activities as $activity)
                            <a href="{{ route('activities.show', ['locale' => app()->getLocale(), 'slug' => $activity->slug]) }}"
                                class="activity-link block">
                                <div
                                    class="activity-card rounded-3xl shadow-lg overflow-hidden transition-all duration-500 hover:shadow-2xl hover:-translate-y-2 border">
                                    <div class="activity-image-wrapper">
                                        @if ($activity->hero_image)
                                            <img src="{{ Storage::url($activity->hero_image) }}"
                                                alt="{{ $activity->title }}"
                                                class="activity-image w-full h-full object-cover transition-transform duration-700 hover:scale-110">
                                        @else
                                            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                                <i class="fas fa-image text-5xl text-gray-400"></i>
                                            </div>
                                        @endif
                                        <div
                                            class="activity-overlay absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent">
                                        </div>
                                        <span class="text-red-500 font-bold">
                                            {{ $activity->category }}
                                        </span>
                                    </div>
                                    <div class="activity-content p-6 md:p-8">
                                        <h2 class="activity-title">
                                            "{{ $activity->title }}"
                                        </h2>
                                        <p class="activity-description">
                                            {{ Str::limit(strip_tags($activity->description), 150) }}
                                        </p>
                                        <div class="read_more">
                                            <span>@lang('activity.read_more')</span>
                                            <i
                                                class="fas fa-arrow-right ml-2 transition-transform duration-300 group-hover:translate-x-2"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    @else
                        <div class="text-center py-20 bg-white rounded-3xl shadow-sm border border-dashed border-gray-300">
                            <i class="fas fa-hands-helping text-6xl text-gray-300 mb-6"></i>
                            <p class="text-gray-500 text-xl font-medium">@lang('activity.empty')</p>
                        </div>
                    @endif
                </div>
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
            const carouselWrapper = document.querySelector('.activities-parent');
            const activityCards = document.querySelectorAll('.activity-card');

            if (!carouselWrapper || !activityCards || activityCards.length === 0) {
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
                activityCards.forEach((card, index) => {
                    const indicator = document.createElement('div');
                    indicator.classList.add('activity-indicator');
                    if (index === 0) indicator.classList.add('active');
                    indicator.addEventListener('click', () => goToSlide(index));
                    indicatorsContainer.appendChild(indicator);
                });
                carouselWrapper.appendChild(indicatorsContainer);
            }

            function updateIndicators() {
                const indicators = document.querySelectorAll('.activity-indicator');
                indicators.forEach((indicator, index) => {
                    indicator.classList.toggle('active', index === currentIndex);
                });
            }

            function showSlide(index) {
                activityCards.forEach(card => card.classList.remove('active', 'prev'));
                activityCards[index].classList.add('active');
                updateIndicators();
            }

            function nextSlide() {
                activityCards[currentIndex].classList.add('prev');
                currentIndex = (currentIndex + 1) % activityCards.length;
                showSlide(currentIndex);
            }

            function prevSlide() {
                activityCards[currentIndex].classList.add('prev');
                currentIndex = (currentIndex - 1 + activityCards.length) % activityCards.length;
                showSlide(currentIndex);
            }

            function goToSlide(index) {
                if (index === currentIndex) return;
                activityCards[currentIndex].classList.add('prev');
                currentIndex = index;
                showSlide(currentIndex);
                if (!isPaused) {
                    stopAutoplay();
                    startAutoplay();
                }
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
                let touchStartY = 0;
                carouselWrapper.addEventListener('touchstart', (e) => {
                    touchStartY = e.changedTouches[0].screenY;
                }, {
                    passive: true
                });
                carouselWrapper.addEventListener('touchend', (e) => {
                    const swipeDistance = touchStartY - e.changedTouches[0].screenY;
                    if (Math.abs(swipeDistance) > 50) {
                        swipeDistance > 0 ? nextSlide() : prevSlide();
                    }
                }, {
                    passive: true
                });
            }

            function init() {
                createIndicators();
                showSlide(currentIndex);
                setupHoverListeners();
                setupTouchGestures();
                setTimeout(startAutoplay, SLIDE_DURATION);
            }

            init();
        });
    </script>
@endsection
