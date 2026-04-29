@extends('layouts.main')

@section('content')
    <section class="activities-section">
        <div class="container">
            <h1 class="section-title">@lang('activity.sec_title')</h1>
            {{-- Section Activités - Carrousel Vertical --}}
            <div class="activities-carousel-wrapper">
                <div class="activities-parent">
                    {{-- Activité 1 - Dispensaire --}}
                    <a href="">
                        <div class="activity-card">
                            <div class="activity-image-wrapper">
                                <img src="{{ asset('assets/images/activity/activity2/akany_tia_zaza_dispensaire.jpg') }}"
                                    alt="Dispensaire médical" class="activity-image">
                                <div class="activity-overlay">
                                    <span class="activity-badge">Santé</span>
                                </div>
                            </div>
                            <div class="activity-content">
                                <h2 class="activity-title">Dispensaire médical communautaire</h2>
                                <p class="activity-description">
                                    Notre dispensaire offre des consultations médicales gratuites aux familles vulnérables.
                                    Nous assurons le suivi sanitaire des enfants, les vaccinations essentielles et la
                                    distribution
                                    de médicaments de base pour garantir leur bien-être et leur santé.
                                </p>
                            </div>
                        </div>
                    </a>
                    {{-- Activité 2 - Événement communautaire --}}
                    <a href="">
                        <div class="activity-card">
                            <div class="activity-image-wrapper">
                                <img src="{{ asset('assets/images/activity/activity2/FB_IMG_1721502775778.jpg') }}"
                                    alt="Événement communautaire" class="activity-image">
                                <div class="activity-overlay">
                                    <span class="activity-badge">Social</span>
                                </div>
                            </div>
                            {{-- --}}
                            <div class="activity-content">
                                <h2 class="activity-title">Rassemblements communautaires</h2>
                                <p class="activity-description">
                                    Organisation d'événements festifs et surtout <strong>Séance de prière à
                                        l'église</strong>
                                    réunissant les familles bénéficiaires et l'équipe ATZ.
                                    Ces moments de partage renforcent les liens communautaires, célèbrent les réussites des
                                    enfants
                                    et créent un environnement de soutien mutuel essentiel au développement.
                                </p>
                            </div>
                        </div>
                    </a>

                    {{-- Activité 3 - Éducation --}}
                    <a href="">
                        <div class="activity-card">
                            <div class="activity-image-wrapper">
                                <img src="{{ asset('assets/images/activity/activity2/education.jpg') }}"
                                    alt="Éducation scolaire" class="activity-image">
                                <div class="activity-overlay">
                                    <span class="activity-badge">Éducation</span>
                                </div>
                            </div>
                            <div class="activity-content">
                                <h2 class="activity-title">Soutien scolaire et académique</h2>
                                <p class="activity-description">
                                    Programme de parrainage éducatif permettant aux enfants d'accéder à une scolarité de
                                    qualité.
                                    Nous prenons en charge les frais scolaires, fournissons le matériel nécessaire et
                                    assurons
                                    un accompagnement pédagogique personnalisé pour la réussite de chaque élève.
                                </p>
                            </div>
                        </div>
                    </a>

                    {{-- Activité 4 - Distribution alimentaire --}}
                    <a href="">
                        <div class="activity-card">
                            <div class="activity-image-wrapper">
                                <img src="{{ asset('assets/images/activity/activity2/582070073_25012989738371722_68473913590103708_n.jpg ') }}"
                                    alt="Distribution alimentaire" class="activity-image">
                                <div class="activity-overlay">
                                    <span class="activity-badge">Nutrition</span>
                                </div>
                            </div>
                            <div class="activity-content">
                                <h2 class="activity-title">Distribution de vivres alimentaires</h2>
                                <p class="activity-description">
                                    Distribution mensuelle de colis alimentaires aux familles dans le besoin. Nous
                                    fournissons
                                    des denrées de base essentielles pour assurer une alimentation équilibrée et lutter
                                    contre
                                    la malnutrition infantile dans notre communauté.
                                </p>
                            </div>
                        </div>
                    </a>

                    {{-- Activité 5 - Fournitures scolaires --}}
                    <a href="">
                        <div class="activity-card">
                            <div class="activity-image-wrapper">
                                <img src="{{ asset('assets/images/activity/activity2/fourniture2.jpg') }}"
                                    alt="Fournitures scolaires" class="activity-image">
                                <div class="activity-overlay">
                                    <span class="activity-badge">Éducation</span>
                                </div>
                            </div>
                            <div class="activity-content">
                                <h2 class="activity-title">Distribution de fournitures scolaires</h2>
                                <p class="activity-description">
                                    À chaque rentrée scolaire, nous distribuons des kits complets de fournitures aux élèves
                                    parrainés.
                                    Cahiers, stylos, cartables et uniformes sont fournis pour permettre à chaque enfant de
                                    débuter
                                    l'année dans les meilleures conditions d'apprentissage.
                                </p>
                            </div>
                        </div>
                    </a>

                    {{-- Activité 6 - Hygiène --}}
                    <a href="">
                        <div class="activity-card">
                            <div class="activity-image-wrapper">
                                <img src="{{ asset('assets/images/activity/activity2/savony.jpg') }}" alt="Hygiène et savon"
                                    class="activity-image">
                                <div class="activity-overlay">
                                    <span class="activity-badge">Hygiène</span>
                                </div>
                            </div>
                            <div class="activity-content">
                                <h2 class="activity-title">Programme d'hygiène et sanitation</h2>
                                <p class="activity-description">
                                    Sensibilisation aux bonnes pratiques d'hygiène et distribution régulière de kits
                                    sanitaires
                                    comprenant savon, dentifrice et produits d'hygiène de base. Nous organisons des ateliers
                                    éducatifs sur l'importance de l'hygiène pour la santé des enfants.
                                </p>
                            </div>
                        </div>
                    </a>

                    {{-- Activité 7 - Sports --}}
                    <a href="">
                        <div class="activity-card">
                            <div class="activity-image-wrapper">
                                <img src="{{ asset('assets/images/activity/activity2/sports.jpg') }}"
                                    alt="Activités sportives" class="activity-image">
                                <div class="activity-overlay">
                                    <span class="activity-badge">Sport</span>
                                </div>
                            </div>
                            <div class="activity-content">
                                <h2 class="activity-title">Activités sportives et récréatives</h2>
                                <p class="activity-description">
                                    Organisation de tournois de football et d'activités physiques pour promouvoir le
                                    bien-être
                                    et l'esprit d'équipe. Le sport permet aux jeunes de développer leurs capacités
                                    physiques,
                                    leur confiance en soi et de créer des liens d'amitié durables.
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            {{-- End Section Activités --}}
        </div>
    </section>



    <script>
        /**
         * ============================================
         * ACTIVITÉS CARROUSEL VERTICAL AUTOMATIQUE
         * ============================================
         *
         * Carrousel vertical pour les activités ATZ
         * - Défilement automatique
         * - Pause au hover
         * - Navigation par indicateurs
         */

        document.addEventListener('DOMContentLoaded', function() {

            // ====================
            // 1. SÉLECTION DES ÉLÉMENTS DOM
            // ====================
            const carouselWrapper = document.querySelector('.activities-parent');
            const activityCards = document.querySelectorAll('.activity-card');

            // Vérification de l'existence des éléments
            if (!carouselWrapper || !activityCards || activityCards.length === 0) {
                console.error('❌ Éléments du carrousel non trouvés');
                return;
            }

            console.log(`✅ ${activityCards.length} activités trouvées`);

            // ====================
            // 2. VARIABLES PRINCIPALES
            // ====================
            let currentIndex = 0; // Index de la carte active
            let autoplayInterval; // Timer pour l'autoplay
            const SLIDE_DURATION = 5000; // 5 secondes par slide
            const TRANSITION_DURATION = 800; // 0.8s de transition
            let isPaused = false; // État de pause

            // ====================
            // 3. CRÉATION DES INDICATEURS DE PROGRESSION
            // ====================
            function createIndicators() {
                // Créer le container des indicateurs
                const indicatorsContainer = document.createElement('div');
                indicatorsContainer.classList.add('activity-indicators');

                // Créer un indicateur pour chaque carte
                activityCards.forEach((card, index) => {
                    const indicator = document.createElement('div');
                    indicator.classList.add('activity-indicator');

                    // Marquer le premier comme actif
                    if (index === 0) {
                        indicator.classList.add('active');
                    }

                    // Ajouter un event listener pour la navigation au clic
                    indicator.addEventListener('click', () => {
                        goToSlide(index);
                    });

                    indicatorsContainer.appendChild(indicator);
                });

                carouselWrapper.appendChild(indicatorsContainer);
                console.log('✅ Indicateurs créés');
            }

            // ====================
            // 4. MISE À JOUR DES INDICATEURS
            // ====================
            function updateIndicators() {
                const indicators = document.querySelectorAll('.activity-indicator');
                indicators.forEach((indicator, index) => {
                    if (index === currentIndex) {
                        indicator.classList.add('active');
                    } else {
                        indicator.classList.remove('active');
                    }
                });
            }

            // ====================
            // 5. AFFICHAGE D'UNE CARTE SPÉCIFIQUE
            // ====================
            /**
             * Affiche la carte à l'index donné
             * @param {number} index - Index de la carte à afficher
             */
            function showSlide(index) {
                // Retirer les classes de toutes les cartes
                activityCards.forEach(card => {
                    card.classList.remove('active', 'prev');
                });

                // Activer la carte cible
                activityCards[index].classList.add('active');

                // Mettre à jour les indicateurs
                updateIndicators();

                console.log(`🖼️ Activité ${index + 1}/${activityCards.length} affichée`);
            }

            // ====================
            // 6. NAVIGATION VERS LA CARTE SUIVANTE
            // ====================
            function nextSlide() {
                // Marquer la carte actuelle comme "prev"
                const prevIndex = currentIndex;
                activityCards[prevIndex].classList.add('prev');

                // Calculer le prochain index (avec boucle)
                currentIndex = (currentIndex + 1) % activityCards.length;

                // Afficher la nouvelle carte
                showSlide(currentIndex);
            }

            // ====================
            // 7. NAVIGATION VERS LA CARTE PRÉCÉDENTE
            // ====================
            function prevSlide() {
                const prevIndex = currentIndex;
                activityCards[prevIndex].classList.add('prev');

                // Calculer l'index précédent (avec boucle)
                currentIndex = (currentIndex - 1 + activityCards.length) % activityCards.length;

                showSlide(currentIndex);
            }

            // ====================
            // 8. ALLER À UNE CARTE SPÉCIFIQUE
            // ====================
            /**
             * Navigation directe vers une carte
             * @param {number} index - Index de destination
             */
            function goToSlide(index) {
                if (index === currentIndex) return;

                const prevIndex = currentIndex;
                activityCards[prevIndex].classList.add('prev');

                currentIndex = index;
                showSlide(currentIndex);

                // Redémarrer l'autoplay après navigation manuelle
                if (!isPaused) {
                    stopAutoplay();
                    startAutoplay();
                }
            }

            // ====================
            // 9. DÉMARRAGE DE L'AUTOPLAY
            // ====================
            function startAutoplay() {
                // Arrêter l'autoplay existant si présent
                if (autoplayInterval) {
                    clearInterval(autoplayInterval);
                }

                // Démarrer un nouveau timer
                autoplayInterval = setInterval(() => {
                    if (!isPaused) {
                        nextSlide();
                    }
                }, SLIDE_DURATION);

                console.log(`▶️ Autoplay démarré (${SLIDE_DURATION / 1000}s par slide)`);
            }

            // ====================
            // 10. ARRÊT DE L'AUTOPLAY
            // ====================
            function stopAutoplay() {
                if (autoplayInterval) {
                    clearInterval(autoplayInterval);
                    autoplayInterval = null;
                    console.log('⏸️ Autoplay arrêté');
                }
            }

            // ====================
            // 11. GESTION DU HOVER (PAUSE/RESUME)
            // ====================
            function setupHoverListeners() {
                // Pause quand la souris entre
                carouselWrapper.addEventListener('mouseenter', () => {
                    isPaused = true;
                    carouselWrapper.classList.add('paused');
                    console.log('🖱️ Souris détectée - Pause');
                });

                // Reprend quand la souris sort
                carouselWrapper.addEventListener('mouseleave', () => {
                    isPaused = false;
                    carouselWrapper.classList.remove('paused');
                    console.log('🖱️ Souris sortie - Reprise');
                });
            }

            // ====================
            // 12. NAVIGATION AU CLAVIER (OPTIONNEL)
            // ====================
            function setupKeyboardNavigation() {
                document.addEventListener('keydown', (e) => {
                    // Vérifier si le carrousel est visible
                    const rect = carouselWrapper.getBoundingClientRect();
                    const isVisible = rect.top < window.innerHeight && rect.bottom > 0;

                    if (!isVisible) return;

                    switch (e.key) {
                        case 'ArrowUp':
                        case 'ArrowLeft':
                            e.preventDefault();
                            prevSlide();
                            break;
                        case 'ArrowDown':
                        case 'ArrowRight':
                            e.preventDefault();
                            nextSlide();
                            break;
                    }
                });

                console.log('⌨️ Navigation clavier activée (Flèches)');
            }

            // ====================
            // 13. DÉTECTION DE VISIBILITÉ (Intersection Observer)
            // ====================
            function setupVisibilityDetection() {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            // Le carrousel est visible
                            if (!isPaused && !autoplayInterval) {
                                startAutoplay();
                            }
                        } else {
                            // Le carrousel n'est plus visible
                            stopAutoplay();
                        }
                    });
                }, {
                    threshold: 0.3 // Déclenche quand 30% est visible
                });

                observer.observe(carouselWrapper);
                console.log('👁️ Détection de visibilité activée');
            }

            // ====================
            // 14. GESTION DU SWIPE TACTILE (MOBILE)
            // ====================
            function setupTouchGestures() {
                let touchStartY = 0;
                let touchEndY = 0;

                carouselWrapper.addEventListener('touchstart', (e) => {
                    touchStartY = e.changedTouches[0].screenY;
                }, {
                    passive: true
                });

                carouselWrapper.addEventListener('touchend', (e) => {
                    touchEndY = e.changedTouches[0].screenY;
                    handleSwipe();
                }, {
                    passive: true
                });

                function handleSwipe() {
                    const swipeDistance = touchStartY - touchEndY;
                    const minSwipeDistance = 50; // pixels

                    if (Math.abs(swipeDistance) < minSwipeDistance) return;

                    if (swipeDistance > 0) {
                        // Swipe vers le haut -> Suivant
                        nextSlide();
                    } else {
                        // Swipe vers le bas -> Précédent
                        prevSlide();
                    }
                }

                console.log('📱 Gestes tactiles activés');
            }

            // ====================
            // 15. STATISTIQUES DES ACTIVITÉS
            // ====================
            function logActivityStats() {
                const stats = {
                    total: activityCards.length,
                    categories: {}
                };

                activityCards.forEach(card => {
                    const badge = card.querySelector('.activity-badge');
                    if (badge) {
                        const category = badge.textContent.trim();
                        stats.categories[category] = (stats.categories[category] || 0) + 1;
                    }
                });

                console.log('📊 Statistiques des activités:', stats);
            }

            // ====================
            // 16. INITIALISATION PRINCIPALE
            // ====================
            function init() {
                console.log('🚀 Initialisation du carrousel d\'activités...');

                // Créer les indicateurs
                createIndicators();

                // Afficher la première carte
                showSlide(currentIndex);

                // Configurer les événements
                setupHoverListeners();
                setupKeyboardNavigation();
                setupTouchGestures();
                setupVisibilityDetection();

                // Démarrer l'autoplay après un délai
                setTimeout(() => {
                    startAutoplay();
                }, SLIDE_DURATION);

                // Afficher les stats
                logActivityStats();

                console.log('✅ Carrousel d\'activités prêt!');
            }

            // Lancer l'initialisation
            init();

            // ====================
            // 17. EXPOSER LES FONCTIONS GLOBALEMENT
            // ====================
            window.ActivitiesCarousel = {
                next: nextSlide,
                prev: prevSlide,
                goto: goToSlide,
                stop: stopAutoplay,
                start: startAutoplay,
                getCurrentIndex: () => currentIndex,
                getTotalSlides: () => activityCards.length
            };

            console.log('💡 API disponible: ActivitiesCarousel.next(), .prev(), .goto(index), etc.');
        });

        /**
         * ============================================
         * EXEMPLES D'UTILISATION DANS LA CONSOLE
         * ============================================
         *
         * // Aller à la carte suivante
         * ActivitiesCarousel.next();
         *
         * // Aller à la carte précédente
         * ActivitiesCarousel.prev();
         *
         * // Aller à une carte spécifique (index 0-6)
         * ActivitiesCarousel.goto(3);
         *
         * // Arrêter l'autoplay
         * ActivitiesCarousel.stop();
         *
         * // Redémarrer l'autoplay
         * ActivitiesCarousel.start();
         *
         * // Obtenir l'index actuel
         * ActivitiesCarousel.getCurrentIndex();
         *
         * // Obtenir le nombre total d'activités
         * ActivitiesCarousel.getTotalSlides();
         */
    </script>
@endsection
