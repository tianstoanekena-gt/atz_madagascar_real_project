@extends('layouts.main')

@section('content')
    <!-- ========== HERO SECTION ATZ MADAGASCAR ========== -->
    <section id="hero-atz-madagascar" class="hero-section">
        <div>
            <div>
                <h1>@lang('hero.hero_message')<span class="title-blue">AKANY</span> <span class="title-red">TIA</span>
                    <span class="title-yellow">ZAZA</span>
                </h1>
                <p class="hero-text">@lang('hero.hero_description')</p>
            </div>
            <div class="btn-zone">
                <a href="{{ localized_route('about') }}" class="hero-btn">@lang('hero.cta_button')</a>
                {{-- <a href="" class="hero-btn">@lang('hero.become_sponsor')</a> --}}
                <a href="{{ localized_route('contact') }}" class="hero-btn">@lang('hero.support_us')</a>
            </div>
        </div>
        <div class="hero-img-parent">
            @foreach ($heroSlides as $slide)
                <img class="hero-img hero-slide-image" src="{{ Storage::url($slide->image_path) }}"
                    alt="Hero ATZ Madagascar">
            @endforeach
        </div>


    </section>


    <script>
        /**
         * ============================================
         * HERO CARROUSEL VERTICAL AUTOMATIQUE
         * ============================================
         */

        document.addEventListener('DOMContentLoaded', function() {

            // ====================
            // 1. FANANGONANA NY SARY REHETRA (Collecting all images)
            // ====================
            // Makany ny sary rehetra ao anaty .hero-img-parent
            const heroContainer = document.querySelector('.hero-img-parent');
            const slides = document.querySelectorAll('.hero-slide-image');

            // Raha tsy misy sary, mijanona ny script
            if (!slides || slides.length === 0) {
                console.error('aucun image trouvé pour le carrousel');
                return;
            }

            console.log(` image ${slides.length} existent pour le carrousel`);

            // ====================
            // 2. VARIABLES PRINCIPALE (Main variables)
            // ====================
            let currentIndex = 0; // Index an'ilay sary hita ankehitriny
            let autoplayInterval; // Variable fitahirizana ny interval
            const SLIDE_DURATION = 3000; // Fotoana isehoan'ny sary tsirairay (4 segondra)
            const TRANSITION_DURATION = 800; // Fotoana fifindran'ny sary (0.8 segondra)

            /**
             * FANAZAVANA ALGORITHM:
             * ====================
             * currentIndex: Ity no mitahiry ny laharan'ny sary hita amin'izao fotoana izao
             * Ohatra: raha currentIndex = 0, dia ny sary voalohany no hita
             *         raha currentIndex = 1, dia ny sary faharoa no hita
             */

            // ====================
            // 3. FONCTION MAMPISEHO SARY (Show slide function)
            // ====================
            /**
             * Asa: Mampiseho ny sary araka ny index nomena
             *
             * ALGORITHM (Gasy):
             * -----------------
             * 1. Manala ny class "active" sy "prev" amin'ny sary rehetra
             * 2. Manampy "active" amin'ilay sary tokony hiseho
             * 3. Manampy "prev" amin'ilay sary teo aloha mba hivoaka
             */
            function showSlide(index) {
                // Aloha, esorina ny class rehetra
                slides.forEach(slide => {
                    slide.classList.remove('active', 'prev');
                });

                // Avy eo, asiana "active" ilay sary vaovao
                slides[index].classList.add('active');

                console.log(` images ${index + 1}/${slides.length} existe `);
            }

            // ====================
            // 4. FONCTION MANDALO MANKANY AMIN'NY SARY MANARAKA (Next slide)
            // ====================
            /**
             * Asa: Mandalo mankany amin'ny sary manaraka
             *
             * ALGORITHM (Gasy):
             * -----------------
             * 1. Marihina ilay sary hita ankehitriny ho "prev" (sary teo aloha)
             * 2. Ampiana 1 ny currentIndex (mandalo mankany amin'ny manaraka)
             * 3. Raha tonga amin'ny farany, miverina any amin'ny voalohany
             *    (modulo operator % dia manampy an'ity)
             * 4. Asehoy ilay sary vaovao
             *
             * OHATRA:
             * -------
             * Raha misy sary 10:
             * - currentIndex = 0, manaraka = 1
             * - currentIndex = 9, manaraka = 0 (miverina amin'ny voalohany)
             */
            function nextSlide() {
                // Marihina ilay sary ankehitriny ho "prev"
                const prevIndex = currentIndex;
                slides[prevIndex].classList.add('prev');

                // Kajy ny index manaraka
                // Modulo (%) dia mamadika ho 0 rehefa mihoatra ny isa farany
                currentIndex = (currentIndex + 1) % slides.length;

                // Asehoy ilay sary vaovao
                showSlide(currentIndex);
            }

            // ====================
            // 5. FONCTION MANOMBOKA NY AUTOPLAY (Start autoplay)
            // ====================
            /**
             * Asa: Manomboka ny carousel otomatika
             *
             * ALGORITHM (Gasy):
             * -----------------
             * 1. Mampiasa setInterval() izay miantso fonction isaky ny X milliseconds
             * 2. Isaky ny antso, miantso nextSlide()
             * 3. Miditra ao anaty variable "autoplayInterval" mba azo ajanona rehefa ilaina
             *
             * FANAZAVANA setInterval():
             * -------------------------
             * setInterval(fonction, fotoana) dia manao zavatra miverimberina
             * Ohatra: setInterval(() => console.log("Hello"), 1000)
             *         => Hanoratra "Hello" isaky ny 1 segondra
             */
            function startAutoplay() {
                // Ajanona aloha raha efa mandeha
                if (autoplayInterval) {
                    clearInterval(autoplayInterval);
                }

                // Manomboka ny carousel otomatika
                autoplayInterval = setInterval(() => {
                    nextSlide();
                }, SLIDE_DURATION);

                console.log('Carrousel automatique (à chaque ' + (SLIDE_DURATION / 1000) + ' seconde)');
            }

            // ====================
            // 6. FONCTION MANAJANONA NY AUTOPLAY (Stop autoplay)
            // ====================
            /**
             * Asa: Manajanona ny carousel otomatika
             *
             * Ampiasaina clearInterval() mba hanajanona ny setInterval()
             */
            function stopAutoplay() {
                if (autoplayInterval) {
                    clearInterval(autoplayInterval);
                    console.log('Carrousel automatique désactiver');
                }
            }

            // ====================
            // 7. INITIALIZATION (Fanombohana)
            // ====================
            /**
             * ALGORITHM INITIALIZATION (Gasy):
             * --------------------------------
             * 1. Asehoy ny sary voalohany (index 0)
             * 2. Manomboka ny autoplay
             * 3. Mihaino ny "mouseover" sy "mouseleave" events
             *    - Raha miditra ny souris: manajanona
             *    - Raha mivoaka ny souris: manomboka indray
             */
            function init() {
                console.log(' commencement du carrousel vertical...');

                // Asehoy ny sary voalohany
                showSlide(currentIndex);

                // Andraso kely alohan'ny hanombohana ny autoplay
                // mba hahita tsara ny sary voalohany
                setTimeout(() => {
                    startAutoplay();
                }, SLIDE_DURATION);

                // Event listeners: Manajanona rehefa miditra ny souris
                heroContainer.addEventListener('mouseenter', () => {
                    stopAutoplay();
                    console.log('survol, carrousel en pause');
                });

                // Manomboka indray rehefa mivoaka ny souris
                heroContainer.addEventListener('mouseleave', () => {
                    startAutoplay();
                    console.log('souri sorti, carrousel redémarer');
                });

                console.log('Carrousel vertical foncionnelle');
            }

            // ====================
            // 8. MIANTSO NY INITIALIZATION (Call initialization)
            // ====================
            init();

            // ====================
            // BONUS: FONCTION MIVERINA ANY AMIN'NY SARY TALOHA (Previous slide)
            // ====================
            /**
             * Ity fonction ity dia tsy ampiasaina fa misy eto raha ilaina
             * mandalo mihemotra (mankany amin'ny sary taloha)
             */
            function prevSlide() {
                const prevIndex = currentIndex;
                slides[prevIndex].classList.add('prev');

                // Mihena 1, ary raha lasa -1, mandalo mankany amin'ny farany
                currentIndex = (currentIndex - 1 + slides.length) % slides.length;

                showSlide(currentIndex);
            }

            // ====================
            // EXPOSE FUNCTIONS (Fonctions disponibles ivelan'ny script)
            // ====================
            // Afaka ampiasaina amin'ny console io fonctions io
            window.HeroCarousel = {
                next: nextSlide,
                prev: prevSlide,
                stop: stopAutoplay,
                start: startAutoplay,
                goto: showSlide
            };

            console.log('Fonctions disponibles: HeroCarousel.next(), .prev(), .stop(), .start()');
        });

        /**
         * ============================================
         * FAMINTINANA ALGORITHM (Résumé en Malagasy)
         * ============================================
         *
         * 1. FANANGONANA SARY:
         *    - Makana ny sary rehetra ao anaty container
         *    - Mitahiry ao anaty array "slides"
         *
         * 2. INITIALIZATION:
         *    - Asehoy ny sary voalohany (index 0)
         *    - Manomboka ny timer otomatika (setInterval)
         *
         * 3. AUTOPLAY:
         *    - Isaky ny 4 segondra, miantso nextSlide()
         *    - nextSlide() dia:
         *      a) Manala ny "active" amin'ny sary ankehitriny
         *      b) Manampy "prev" amin'ny sary ankehitriny (hivoaka)
         *      c) Mampitombo ny index: index = index + 1
         *      d) Raha tonga amin'ny farany: index = 0 (modulo)
         *      e) Manampy "active" amin'ny sary vaovao
         *
         * 4. CSS TRANSITION:
         *    - "active" class: opacity 1, translateY(0)
         *    - "prev" class: opacity 0, translateY(-100%)
         *    - Sary vaovao: translateY(100%) -> translateY(0)
         *
         * 5. PAUSE AU HOVER:
         *    - Rehefa miditra ny souris: clearInterval() (manajanona)
         *    - Rehefa mivoaka ny souris: setInterval() (manomboka indray)
         *
         * ============================================
         * OHATRA FAMPIASANA (Exemples d'utilisation)
         * ============================================
         *
         * // Ao anaty console du navigateur:
         * HeroCarousel.next();     // Mandalo mankany amin'ny manaraka
         * HeroCarousel.prev();     // Miverina amin'ny taloha
         * HeroCarousel.stop();     // Manajanona ny autoplay
         * HeroCarousel.start();    // Manomboka indray ny autoplay
         * HeroCarousel.goto(3);    // Mankany amin'ny sary faha-4
         */
    </script>
@endsection
