<nav class="navbar">
    <div class="nav-links">

        <div class="logo-parent">
            <a href="{{ localized_route('home') }}">
                @if (isset($globalLogo) && $globalLogo && \Illuminate\Support\Facades\Storage::disk('public')->exists($globalLogo->logo))
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($globalLogo->logo) }}" alt="Logo du site"
                        class="logo">
                @else
                    <img src="{{ asset('assets/images/logo-atz.png') }}" alt="Logo par défaut" class="logo">
                @endif
            </a>
        </div>

        <!-- Burger Mobile -->
        <button class="nav-toggle" id="navToggle" aria-label="Menu">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <!-- Menu -->
        <div class="nav-link" id="navMenu">
            <ul>
                @php
                    $navItems = [
                        ['route' => 'home', 'label' => 'navigation.home'],
                        ['route' => 'about', 'label' => 'navigation.about'],
                        ['route' => 'activities', 'label' => 'navigation.activities'],
                        ['route' => 'projects', 'label' => 'navigation.projects'],
                        ['route' => 'contact', 'label' => 'navigation.contact'],
                    ];
                @endphp

                @foreach ($navItems as $item)
                    <li>
                        <a class="nav-link-child {{ request()->routeIs($item['route']) ? 'active' : '' }}"
                            href="{{ localized_route($item['route']) }}">
                            {{ __($item['label']) }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="nav-lang">
            <select name="language" id="language" class="language-select">
                <option value="fr" {{ app()->getLocale() == 'fr' ? 'selected' : '' }} data-flag="🇫🇷">
                    <span class="flag-mobile">🇫🇷</span>
                    <span class="text-desktop">🇫🇷 FRANÇAIS</span>
                </option>
                <option value="mg" {{ app()->getLocale() == 'mg' ? 'selected' : '' }} data-flag="🇲🇬">
                    <span class="flag-mobile">🇲🇬</span>
                    <span class="text-desktop">🇲🇬 MALAGASY</span>
                </option>
                <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }} data-flag="🇺🇸">
                    <span class="flag-mobile">🇺🇸</span>
                    <span class="text-desktop">🇺🇸 ANGLAIS</span>
                </option>
            </select>
        </div>


    </div>
</nav>




<script>
    (function navbarSetup() {

        const toggle = document.getElementById('navToggle');
        const menu = document.getElementById('navMenu');

        if (!toggle || !menu) return;

        toggle.addEventListener('click', () => {
            menu.classList.toggle('open');
            toggle.classList.toggle('active');
        });

        // Close menu when clicking link (mobile UX)
        document.querySelectorAll('.nav-link-child').forEach(link => {
            link.addEventListener('click', () => {
                menu.classList.remove('open');
                toggle.classList.remove('active');
            });
        });

    })();

    // Changement de langue
    document.getElementById('language').addEventListener('change', function() {
        const selectedLang = this.value;
        const currentPath = window.location.pathname;

        // Remplace la locale actuelle dans l'URL
        const newPath = currentPath.replace(/^\/(fr|mg|en)/, '/' + selectedLang);

        // Redirige vers la nouvelle URL
        window.location.href = newPath + window.location.search;
    });

    // Afficher uniquement le drapeau sur mobile
    (function updateLanguageDisplay() {
        const select = document.getElementById('language');
        const selectedOption = select.options[select.selectedIndex];
        const flag = selectedOption.getAttribute('data-flag');

        function updateSelectText() {
            const isMobile = window.innerWidth <= 768;

            if (isMobile) {
                // Afficher uniquement le drapeau
                select.style.fontSize = '1.5rem';
                select.style.padding = '0.3rem 0.5rem';
                select.style.width = '60px';
                select.style.textAlign = 'center';

                // Changer le texte des options en drapeau uniquement
                Array.from(select.options).forEach(option => {
                    const optionFlag = option.getAttribute('data-flag');
                    option.textContent = optionFlag;
                });
            } else {
                // Afficher drapeau + texte
                select.style.fontSize = '0.9rem';
                select.style.padding = '0.4rem 0.8rem';
                select.style.width = 'auto';
                select.style.textAlign = 'left';

                // Restaurer le texte complet
                Array.from(select.options).forEach(option => {
                    const lang = option.value;
                    const optionFlag = option.getAttribute('data-flag');
                    const langMap = {
                        'fr': optionFlag + ' FRANÇAIS',
                        'mg': optionFlag + ' MALAGASY',
                        'en': optionFlag + ' ANGLAIS'
                    };
                    option.textContent = langMap[lang];
                });
            }
        }

        // Appliquer au chargement
        updateSelectText();

        // Réappliquer au resize
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(updateSelectText, 200);
        });
    })();
</script>
