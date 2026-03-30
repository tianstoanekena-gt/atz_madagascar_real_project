<aside class="admin-sidebar">
    <div class="sidebar-header">
        <div class="logo-wrapper">
            <div class="logo-placeholder">
                <figure><img class="logo" src="{{ asset('assets/images/logo.jpg') }}" alt="logo"></figure>
            </div>
            <span class="logo-text">Admin Panel</span>
        </div>
    </div>

    <nav class="sidebar-nav">
        <ul class="nav-list">
            <!-- Dashboard -->
            <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="nav-link">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="nav-text">Tableau de bord</span>
                </a>
            </li>

            <!-- Pages -->
            <li class="nav-item">
            <li
                class="nav-item has-submenu {{ request()->routeIs('admin.hero-slides.*') || request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <a href="#" class="nav-link">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="nav-text">Pages</span>
                </a>

                <!-- Sous-menu -->
                <ul class="submenu">
                    <li><a href="{{ route('admin.hero-slides.index') }}" class="submenu-link">Hero_Slide</a></li>
                    <li><a href="{{ route('admin.logos.index') }}" class="submenu-link">Logo</a></li>
                    <li><a href="{{ route('admin.about-videos.index') }}" class="submenu-link">Vidéo About</a></li>
                    <li><a href="{{ route('admin.about-texts.index') }}" class="submenu-link">Textes About</a></li>
                    <li><a href="{{ route('admin.about-cards.index') }}" class="submenu-link">About value cards</a></li>
                    <li>
                        <a href="{{ route('admin.about-interventions.index') }}" class="submenu-link">About
                            interventions cartes</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.contact-types.index') }}" class="submenu-link">Types de contacts</a>
                    </li>
                </ul>
            </li>
        </ul>
        </li>
        </li>

        <!-- Activités -->
        <li class="nav-item">
            <a href="#" class="nav-link">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M9 11V9a2 2 0 012-2h2a2 2 0 012 2v2" />
                </svg>
                <span class="nav-text">Activités</span>
            </a>
        </li>

        <!-- Projets -->
        <li class="nav-item">
            <a href="#" class="nav-link">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                </svg>
                <span class="nav-text">Projets</span>
            </a>
        </li>

        <!-- Parrainages -->
        <li class="nav-item">
            <a href="#" class="nav-link">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span class="nav-text">Parrainages</span>
            </a>
        </li>

        <!-- Partenaires -->
        <li class="nav-item">
            <a href="#" class="nav-link">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <span class="nav-text">Partenaires</span>
            </a>
        </li>

        <li class="nav-item has-submenu">
            <a href="" class="nav-link">
                <i class="nav-icon fas fa-user-cog"></i>
                <span class="nav-text">Staff Technique</span>
            </a>

            <ul class="sub-menu">
                <li class="nav-item">
                    <a href="{{ route('admin.staff-members.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <span class="nav-text">Bureaucrate</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-hands-helping"></i>
                        <span class="nav-text">Bénévole</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Sponsors -->
        <li class="nav-item">
            <a href="#" class="nav-link">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="nav-text">Sponsors</span>
            </a>
        </li>

        <!-- Utilisateurs -->
        <li class="nav-item">
            <a href="#" class="nav-link">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span class="nav-text">Utilisateurs</span>
            </a>
        </li>
        </ul>
    </nav>

    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <svg class="logout-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span>Déconnexion</span>
            </button>
        </form>
    </div>
</aside>



<script>
    // Détecter automatiquement la page active
    document.addEventListener('DOMContentLoaded', function() {
        const currentPath = window.location.pathname;

        document.querySelectorAll('.nav-link').forEach(link => {
            if (link.getAttribute('href') === currentPath) {
                link.closest('.nav-item').classList.add('active');
            }
        });
    });
</script>
