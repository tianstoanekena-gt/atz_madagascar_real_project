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

        <div class="nav-link" id="navMenu">
            <ul>
                @php
                    $navItems = [
                        [
                            'route' => 'home',
                            'label' => 'navigation.home',
                            'children' => [],
                        ],
                        [
                            'route' => 'about',
                            'label' => 'navigation.about',
                            'children' => ['staff', 'documents', 'faq', 'stats', 'sponsors', 'sponsors.show'],
                        ],
                        [
                            'route' => 'activities',
                            'label' => 'navigation.activities',
                            'children' => ['activities.show'],
                        ],
                        [
                            'route' => 'projects',
                            'label' => 'navigation.projects',
                            'children' => ['projects.show'],
                        ],
                        // [
                        //     'route' => 'parrainage.index',
                        //     'label' => 'navigation.parrainage',
                        //     'children' => [],
                        // ],
                        [
                            'route' => 'contact',
                            'label' => 'navigation.contact',
                            'children' => [],
                        ],
                    ];
                @endphp

                @foreach ($navItems as $item)
                    @php
                        $routesToCheck = array_merge([$item['route']], $item['children']);
                        $isActive = request()->routeIs($routesToCheck);
                    @endphp
                    <li>
                        <a class="nav-link-child {{ $isActive ? 'active' : '' }}"
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

        document.querySelectorAll('.nav-link-child').forEach(link => {
            link.addEventListener('click', () => {
                menu.classList.remove('open');
                toggle.classList.remove('active');
            });
        });

    })();

    document.getElementById('language').addEventListener('change', function() {
        const selectedLang = this.value;
        const currentPath = window.location.pathname;
        const newPath = currentPath.replace(/^\/(fr|mg|en)/, '/' + selectedLang);
        window.location.href = newPath + window.location.search;
    });

    (function updateLanguageDisplay() {
        const select = document.getElementById('language');

        function updateSelectText() {
            const isMobile = window.innerWidth <= 768;

            if (isMobile) {
                select.style.fontSize = '1.5rem';
                select.style.padding = '0.3rem 0.5rem';
                select.style.width = '60px';
                select.style.textAlign = 'center';

                Array.from(select.options).forEach(option => {
                    const optionFlag = option.getAttribute('data-flag');
                    option.textContent = optionFlag;
                });
            } else {
                select.style.fontSize = '0.9rem';
                select.style.padding = '0.4rem 0.8rem';
                select.style.width = 'auto';
                select.style.textAlign = 'left';

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

        updateSelectText();

        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(updateSelectText, 200);
        });
    })();
</script>
