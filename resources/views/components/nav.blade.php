<nav class="navbar">
    <div class="nav-links">

        <div class="logo-parent">
            <a href="{{ route('home') }}">
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
                <option value="fr" {{ app()->getLocale() == 'fr' ? 'selected' : '' }}>🇫🇷 FRANÇAIS</option>
                <option value="mg" {{ app()->getLocale() == 'mg' ? 'selected' : '' }}>🇲🇬 MALAGASY</option>
                <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>🇺🇸 ANGLAIS</option>
            </select>
            @if (Auth::check())
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">Déconnexion</button>
                </form>
            @endif
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
            });
        });

    })();

    document.getElementById('language').addEventListener('change', function() {
        const selectedLang = this.value;
        const currentPath = window.location.pathname;

        // Remplace la locale actuelle dans l'URL
        const newPath = currentPath.replace(/^\/(fr|mg|en)/, '/' + selectedLang);

        // Redirige vers la nouvelle URL
        window.location.href = newPath + window.location.search;
    });
</script>
