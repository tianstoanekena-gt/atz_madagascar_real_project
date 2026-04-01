{{-- Section Bénévoles --}}
<section id="volunteers" class="volunteers-section">
    <div class="container">
        {{-- Titre de la section --}}
        <div class="section-header">
            <h2 class="section-title">@lang('staff.sec_title_benevol')</h2>
            <div class="title-underline"></div>
        </div>

        {{-- Grille des cartes bénévoles --}}
        <div class="volunteers-grid">
            @php
                use App\Models\Volunteer;
                use Illuminate\Support\Facades\Storage;

                $currentLang = app()->getLocale();

                // Récupérer tous les bénévoles actifs triés par ordre
                $volunteers = Volunteer::with(['translations', 'allContacts.contactType'])
                    ->active()
                    ->ordered()
                    ->get();
            @endphp

            @foreach ($volunteers as $volunteer)
                @php
                    $translation = $volunteer->translation($currentLang);
                @endphp

                <div class="volunteer-card" data-volunteer="{{ $volunteer->id }}">
                    <div class="volunteer-image">
                        @if ($volunteer->photo && Storage::disk('public')->exists($volunteer->photo))
                            <img src="{{ Storage::url($volunteer->photo) }}" alt="{{ $volunteer->name }}">
                        @else
                            <img src="{{ asset('assets/images/personnel/default-avatar.jpg') }}"
                                alt="{{ $volunteer->name }}">
                        @endif
                        <div class="image-overlay">
                            @if ($volunteer->is_active)
                                <span class="volunteer-status">Actif</span>
                            @else
                                <span class="volunteer-status inactive">Inactif</span>
                            @endif
                        </div>
                    </div>
                    <div class="volunteer-info">
                        <div class="volunteer-coord">
                            <h4 class="volunteer-name">{{ $volunteer->name }}</h4>

                            @if ($volunteer->allContacts->count() > 0)
                                <ul>
                                    @foreach ($volunteer->allContacts as $contact)
                                        @php
                                            $url = $contact->url;
                                            $dataType = $contact->type_slug;

                                            // Mapping icônes PNG (selon ton design)
                                            $iconMap = [
                                                'email' => 'email.png',
                                                'facebook' => 'facebook.png',
                                                'instagram' => 'instagram.png',
                                                'messenger' => 'messenger.png',
                                                'whatsapp' => 'whatsapp.png',
                                                'linkedin' => 'linkedin.png',
                                                'phone' => 'phone.png',
                                                'website' => 'website.png',
                                                'twitter' => 'twitter.png',
                                                'tiktok' => 'tiktok.png',
                                                'other' => 'link.png',
                                            ];
                                            $iconFile = $iconMap[$dataType] ?? 'link.png';
                                        @endphp

                                        <li>
                                            <a href="{{ $url }}" target="_blank" rel="noopener">
                                                <img src="{{ asset('assets/images/icons/' . $iconFile) }}"
                                                    alt="{{ $dataType }}">
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        <p class="volunteer-role">{{ $translation->role ?? 'Bénévole' }}</p>
                        <span class="volunteer-since">@lang('staff.sincere_benevol') {{ $volunteer->volunteer_since }}</span>
                    </div>
                </div>
            @endforeach


        </div>
    </div>
</section>




<script setup>
    document.addEventListener('DOMContentLoaded', function() {

        // ====================
        // 1. INTERSECTION OBSERVER - Animation au scroll
        // ====================
        const initScrollAnimation = () => {
            const volunteerCards = document.querySelectorAll('.volunteer-card');

            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        // Réactiver l'animation quand la carte entre dans la vue
                        entry.target.style.animationPlayState = 'running';
                        entry.target.classList.add('is-visible');
                    }
                });
            }, observerOptions);

            volunteerCards.forEach(card => {
                // Pause l'animation par défaut jusqu'à ce qu'elle soit visible
                card.style.animationPlayState = 'paused';
                observer.observe(card);
            });

            console.log(`✅ Animation au scroll initialisée pour ${volunteerCards.length} bénévoles`);
        };

        // ====================
        // 2. EFFET DE PULSE SUR LES BADGES "DEPUIS"
        // ====================
        const addBadgeHoverEffect = () => {
            const badges = document.querySelectorAll('.volunteer-since');

            badges.forEach(badge => {
                badge.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.1)';
                    this.style.transition = 'transform 0.2s ease';
                });

                badge.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                });
            });

            console.log(`✅ Effet pulse ajouté sur ${badges.length} badges`);
        };

        // ====================
        // 3. COMPTEUR DE BÉNÉVOLES ACTIFS
        // ====================
        const displayVolunteerCount = () => {
            const volunteerCards = document.querySelectorAll('.volunteer-card');
            const totalVolunteers = volunteerCards.length;

            console.log(`👥 ${totalVolunteers} bénévoles actifs dans l'association`);

            return totalVolunteers;
        };

        // ====================
        // 4. ANIMATION DE L'IMAGE AU CLIC (FLASH)
        // ====================
        const addClickFlashEffect = () => {
            const volunteerCards = document.querySelectorAll('.volunteer-card');

            volunteerCards.forEach(card => {
                card.addEventListener('click', function() {
                    const image = this.querySelector('.volunteer-image img');

                    if (image) {
                        // Effet de flash
                        image.style.animation = 'flash 0.5s ease';

                        // Retirer l'animation après qu'elle soit terminée
                        setTimeout(() => {
                            image.style.animation = 'none';
                        }, 500);
                    }
                });
            });

            console.log('✅ Effet flash au clic activé');
        };

        // ====================
        // 5. HOVER EFFECT SUR LES CARTES
        // ====================
        const addCardHoverTracking = () => {
            const volunteerCards = document.querySelectorAll('.volunteer-card');

            volunteerCards.forEach((card, index) => {
                card.addEventListener('mouseenter', function() {
                    const name = this.querySelector('.volunteer-name').textContent;
                    console.log(`🖱️ Survol de la carte: ${name}`);
                });
            });

            console.log('✅ Tracking des hovers activé');
        };

        // ====================
        // 6. STATISTIQUES PAR ANNÉE
        // ====================
        const calculateYearStats = () => {
            const volunteerCards = document.querySelectorAll('.volunteer-card');
            const yearStats = {};

            volunteerCards.forEach(card => {
                const sinceText = card.querySelector('.volunteer-since').textContent;
                const year = sinceText.match(/\d{4}/);

                if (year) {
                    const yearValue = year[0];
                    yearStats[yearValue] = (yearStats[yearValue] || 0) + 1;
                }
            });

            console.log('📊 Statistiques des bénévoles par année:');
            Object.entries(yearStats)
                .sort((a, b) => b[0] - a[0])
                .forEach(([year, count]) => {
                    console.log(`   ${year}: ${count} bénévole(s)`);
                });

            return yearStats;
        };

        // ====================
        // 7. FILTRE PAR ANNÉE (Fonction utilitaire)
        // ====================
        const filterByYear = (year) => {
            const volunteerCards = document.querySelectorAll('.volunteer-card');

            volunteerCards.forEach(card => {
                const sinceText = card.querySelector('.volunteer-since').textContent;

                if (year === 'all' || sinceText.includes(year.toString())) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });

            console.log(`🔍 Filtre appliqué: ${year === 'all' ? 'Tous' : 'Année ' + year}`);
        };

        // ====================
        // 8. RECHERCHE PAR NOM (Fonction utilitaire)
        // ====================
        const searchVolunteer = (searchTerm) => {
            const volunteerCards = document.querySelectorAll('.volunteer-card');
            const term = searchTerm.toLowerCase().trim();
            let resultsCount = 0;

            volunteerCards.forEach(card => {
                const name = card.querySelector('.volunteer-name').textContent.toLowerCase();
                const role = card.querySelector('.volunteer-role').textContent.toLowerCase();

                if (term === '' || name.includes(term) || role.includes(term)) {
                    card.style.display = 'flex';
                    resultsCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            console.log(`🔍 Recherche "${searchTerm}": ${resultsCount} résultat(s)`);
            return resultsCount;
        };

        // ====================
        // 9. ANIMATION DES NOMS AU SURVOL
        // ====================
        const addNameAnimation = () => {
            const volunteerCards = document.querySelectorAll('.volunteer-card');

            volunteerCards.forEach(card => {
                const name = card.querySelector('.volunteer-name');

                card.addEventListener('mouseenter', function() {
                    if (name) {
                        name.style.transform = 'translateX(5px)';
                        name.style.transition = 'transform 0.3s ease';
                    }
                });

                card.addEventListener('mouseleave', function() {
                    if (name) {
                        name.style.transform = 'translateX(0)';
                    }
                });
            });

            console.log('✅ Animation des noms au survol activée');
        };

        // ====================
        // 10. EXPORT DES DONNÉES (Pour développement)
        // ====================
        const exportVolunteerData = () => {
            const volunteerCards = document.querySelectorAll('.volunteer-card');
            const volunteerData = [];

            volunteerCards.forEach(card => {
                const data = {
                    name: card.querySelector('.volunteer-name').textContent,
                    role: card.querySelector('.volunteer-role').textContent,
                    since: card.querySelector('.volunteer-since').textContent,
                    id: card.getAttribute('data-volunteer')
                };
                volunteerData.push(data);
            });

            console.log('📋 Données des bénévoles:', volunteerData);
            return volunteerData;
        };

        // ====================
        // INITIALISATION PRINCIPALE
        // ====================
        const init = () => {
            console.log('🚀 Initialisation de la section Bénévoles...');

            // Initialiser toutes les fonctionnalités
            initScrollAnimation();
            addBadgeHoverEffect();
            const totalVolunteers = displayVolunteerCount();
            addClickFlashEffect();
            addCardHoverTracking();
            calculateYearStats();
            addNameAnimation();

            console.log('✅ Section Bénévoles initialisée avec succès!');
            console.log(`📊 Total: ${totalVolunteers} bénévoles actifs`);
        };

        // Lancer l'initialisation
        init();

        // ====================
        // EXPOSER LES FONCTIONS UTILITAIRES GLOBALEMENT
        // ====================
        window.VolunteersSection = {
            filterByYear: filterByYear,
            searchVolunteer: searchVolunteer,
            exportData: exportVolunteerData,
            getTotalCount: displayVolunteerCount
        };

        console.log('💡 Fonctions utilitaires disponibles via window.VolunteersSection');
    });

    /**
     * ============================================
     * EXEMPLES D'UTILISATION (Dans la console)
     * ============================================
     *
     * // Filtrer par année
     * VolunteersSection.filterByYear(2023);
     * VolunteersSection.filterByYear('all');
     *
     * // Rechercher un bénévole
     * VolunteersSection.searchVolunteer('rakoto');
     * VolunteersSection.searchVolunteer('coach');
     *
     * // Exporter les données
     * const data = VolunteersSection.exportData();
     *
     * // Obtenir le total
     * const total = VolunteersSection.getTotalCount();
     *
     * ============================================
     */
</script>
{{-- End Section Bénévoles --}}
