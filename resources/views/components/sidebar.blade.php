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
                    <i class="fas fa-home nav-icon"></i>
                    <span class="nav-text">Tableau de bord</span>
                </a>
            </li>

            <!-- Pages avec sous-menu -->
            <li
                class="nav-item has-submenu {{ request()->routeIs('admin.hero-slides.*') || request()->routeIs('admin.logos.*') || request()->routeIs('admin.about-videos.*') || request()->routeIs('admin.about-texts.*') || request()->routeIs('admin.about-cards.*') || request()->routeIs('admin.about-interventions.*') || request()->routeIs('admin.contact-types.*') ? 'active open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="fas fa-file-alt nav-icon"></i>
                    <span class="nav-text">Pages</span>
                    <i class="fas fa-chevron-down submenu-arrow"></i>
                </a>

                <!-- Sous-menu -->
                <ul class="submenu">
                    <li>
                        <a href="{{ route('admin.hero-slides.index') }}"
                            class="submenu-link {{ request()->routeIs('admin.hero-slides.*') ? 'active' : '' }}">
                            <i class="fas fa-images"></i>
                            Hero Slides
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.logos.index') }}"
                            class="submenu-link {{ request()->routeIs('admin.logos.*') ? 'active' : '' }}">
                            <i class="fas fa-image"></i>
                            Logo
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.about-videos.index') }}"
                            class="submenu-link {{ request()->routeIs('admin.about-videos.*') ? 'active' : '' }}">
                            <i class="fas fa-video"></i>
                            Vidéo About
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.about-texts.index') }}"
                            class="submenu-link {{ request()->routeIs('admin.about-texts.*') ? 'active' : '' }}">
                            <i class="fas fa-align-left"></i>
                            Textes About
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.about-cards.index') }}"
                            class="submenu-link {{ request()->routeIs('admin.about-cards.*') ? 'active' : '' }}">
                            <i class="fas fa-th-large"></i>
                            About Value Cards
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.about-interventions.index') }}"
                            class="submenu-link {{ request()->routeIs('admin.about-interventions.*') ? 'active' : '' }}">
                            <i class="fas fa-hands-helping"></i>
                            About Interventions
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.contact-types.index') }}"
                            class="submenu-link {{ request()->routeIs('admin.contact-types.*') ? 'active' : '' }}">
                            <i class="fas fa-address-book"></i>
                            Types de Contact
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Activités -->
            <li class="nav-item {{ request()->routeIs('admin.activities.*') ? 'active' : '' }}">
                <a href="#" class="nav-link">
                    <i class="fas fa-calendar-check nav-icon"></i>
                    <span class="nav-text">Activités</span>
                </a>
            </li>

            <!-- Projets -->
            <li class="nav-item {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
                <a href="#" class="nav-link">
                    <i class="fas fa-project-diagram nav-icon"></i>
                    <span class="nav-text">Projets</span>
                </a>
            </li>

            <!-- Parrainages -->
            <li class="nav-item {{ request()->routeIs('admin.sponsorships.*') ? 'active' : '' }}">
                <a href="#" class="nav-link">
                    <i class="fas fa-user-friends nav-icon"></i>
                    <span class="nav-text">Parrainages</span>
                </a>
            </li>

            <!-- Staff Technique avec sous-menu -->
            <li
                class="nav-item has-submenu {{ request()->routeIs('admin.staff-members.*') || request()->routeIs('admin.volunteers.*') ? 'active open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="fas fa-user-cog nav-icon"></i>
                    <span class="nav-text">Staff Technique</span>
                    <i class="fas fa-chevron-down submenu-arrow"></i>
                </a>

                <ul class="submenu">
                    <li>
                        <a href="{{ route('admin.staff-members.index') }}"
                            class="submenu-link {{ request()->routeIs('admin.staff-members.*') ? 'active' : '' }}">
                            <i class="fas fa-user-tie"></i>
                            Bureaucrate
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.volunteers.index') }}"
                            class="submenu-link {{ request()->routeIs('admin.volunteers.*') ? 'active' : '' }}">
                            <i class="fas fa-hands-helping"></i>
                            Bénévole
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item {{ request()->routeIs('admin.documents.*') ? 'active' : '' }}">
                <a href="{{ route('admin.documents.index') }}" class="nav-link">
                    <i class="fas fa-file-alt nav-icon"></i>
                    <span class="nav-text">Documents</span>
                </a>
            </li>

            <!-- Sponsors -->
            <li class="nav-item {{ request()->routeIs('admin.sponsors.*') ? 'active' : '' }}">
                <a href="{{ route('admin.sponsors.index') }}" class="nav-link">
                    <i class="fas fa-donate nav-icon"></i>
                    <span class="nav-text">Sponsors</span>
                </a>
            </li>

            <!-- Utilisateurs -->
            <li class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <a href="#" class="nav-link">
                    <i class="fas fa-users nav-icon"></i>
                    <span class="nav-text">Utilisateurs</span>
                </a>
            </li>
        </ul>
    </nav>

    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt logout-icon"></i>
                <span>Déconnexion</span>
            </button>
        </form>
    </div>
</aside>


<!-- ============================================
     CSS - UNIQUEMENT SIDEBAR (Copie dans ton fichier CSS)
     ============================================ -->

<style>
    /* ========== SIDEBAR UNIQUEMENT ========== */

    /* Animations d'entrée */
    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Sidebar */
    .admin-sidebar {
        width: 260px;
        background: var(--color-text);
        color: white;
        display: block;
        transition: transform 0.3s ease;
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
        overflow-y: auto;
        z-index: 1000;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
    }

    /* Scrollbar personnalisée */
    .admin-sidebar::-webkit-scrollbar {
        width: 6px;
    }

    .admin-sidebar::-webkit-scrollbar-track {
        background: var(--color-text);
    }

    .admin-sidebar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 3px;
    }

    .admin-sidebar::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    .sidebar-header {
        padding: 1.5rem 1.25rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        animation: slideInLeft 0.5s ease;
    }

    .logo-wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .logo {
        width: 20px;
    }

    .logo-placeholder {
        width: 36px;
        height: 36px;
        background-color: var(--color-background);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.1rem;
    }

    .logo-text {
        font-size: 1.1rem;
        font-weight: 600;
        opacity: 0.9;
    }

    .sidebar-nav {
        flex: 1;
        padding: 1.25rem 0;
    }

    .nav-list {
        list-style: none;
    }

    .nav-item {
        margin: 0 1rem 0.25rem;
        position: relative;
        opacity: 0;
        animation: slideInLeft 0.5s ease forwards;
    }

    /* Animation en cascade */
    .nav-item:nth-child(1) {
        animation-delay: 0.1s;
    }

    .nav-item:nth-child(2) {
        animation-delay: 0.15s;
    }

    .nav-item:nth-child(3) {
        animation-delay: 0.2s;
    }

    .nav-item:nth-child(4) {
        animation-delay: 0.25s;
    }

    .nav-item:nth-child(5) {
        animation-delay: 0.3s;
    }

    .nav-item:nth-child(6) {
        animation-delay: 0.35s;
    }

    .nav-item:nth-child(7) {
        animation-delay: 0.4s;
    }

    .nav-item:nth-child(8) {
        animation-delay: 0.45s;
    }

    .nav-item:nth-child(9) {
        animation-delay: 0.5s;
    }

    .nav-item:nth-child(10) {
        animation-delay: 0.55s;
    }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 0.875rem 1.25rem;
        color: rgba(255, 255, 255, 0.85);
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    /* Barre latérale active (à gauche) */
    .nav-link::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 0;
        background: var(--color-primary);
        border-radius: 0 4px 4px 0;
        transition: height 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* État HOVER */
    .nav-link:hover {
        background: rgba(254, 237, 2, 0.15);
        color: white;
        padding-left: 1.5rem;
    }

    .nav-link:hover .nav-icon {
        transform: scale(1.15) rotate(5deg);
        color: var(--color-primary);
    }

    /* État ACTIVE */
    .nav-item.active .nav-link {
        background: rgba(254, 237, 2, 0.2);
        color: white;
        font-weight: 600;
    }

    .nav-item.active .nav-link::before {
        height: 100%;
    }

    .nav-item.active .nav-icon {
        color: var(--color-primary);
        transform: scale(1.1);
    }

    .nav-icon {
        width: 20px;
        height: 20px;
        font-size: 18px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .nav-text {
        flex: 1;
    }

    /* Sous-menu */
    .nav-item.has-submenu .nav-link {
        justify-content: space-between;
    }

    .submenu-arrow {
        font-size: 12px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        margin-left: auto;
    }

    .nav-item.has-submenu.open .submenu-arrow {
        transform: rotate(180deg);
        color: var(--color-primary);
    }

    .submenu {
        list-style: none;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        background: rgba(0, 0, 0, 0.2);
        border-radius: 0 0 8px 8px;
        margin-top: 4px;
    }

    .nav-item.has-submenu.open .submenu {
        max-height: 500px;
        padding: 0.5rem 0;
    }

    .submenu-link {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 0.625rem 1.25rem 0.625rem 3rem;
        color: rgba(255, 255, 255, 0.75);
        text-decoration: none;
        font-size: 0.9rem;
        transition: all 0.2s;
        position: relative;
    }

    /* Point indicateur */
    .submenu-link::before {
        content: '';
        position: absolute;
        left: 2rem;
        top: 50%;
        transform: translateY(-50%);
        width: 6px;
        height: 6px;
        background: rgba(255, 255, 255, 0.4);
        border-radius: 50%;
        transition: all 0.2s;
    }

    .submenu-link:hover {
        background: rgba(254, 237, 2, 0.1);
        color: white;
        padding-left: 3.25rem;
    }

    .submenu-link:hover::before {
        background: var(--color-primary);
        width: 8px;
        height: 8px;
    }

    .submenu-link i {
        font-size: 14px;
        width: 16px;
        text-align: center;
    }

    /* Submenu ACTIVE */
    .submenu-link.active {
        background: rgba(254, 237, 2, 0.2);
        color: white;
        font-weight: 600;
        padding-left: 3.25rem;
    }

    .submenu-link.active::before {
        background: var(--color-primary);
        width: 8px;
        height: 8px;
    }

    .submenu-link.active i {
        color: var(--color-primary);
    }

    /* Footer sidebar */
    .sidebar-footer {
        padding: 1.25rem 1.25rem 1.5rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        animation: slideInLeft 0.5s ease 0.6s backwards;
    }

    .logout-btn {
        display: flex;
        align-items: center;
        gap: 12px;
        background: transparent;
        color: rgba(255, 255, 255, 0.85);
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 0.75rem 1rem;
        border-radius: 8px;
        cursor: pointer;
        font-size: 0.95rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        width: 100%;
        text-align: left;
    }

    .logout-btn:hover {
        background: rgba(200, 0, 0, 0.2);
        border-color: var(--color-red);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(200, 0, 0, 0.2);
    }

    .logout-icon {
        width: 18px;
        height: 18px;
        font-size: 16px;
    }

    /* Effet ripple au clic */
    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: scale(0);
        animation: ripple-animation 0.6s ease-out;
        pointer-events: none;
    }

    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
</style>


<!-- ============================================
     JAVASCRIPT - GESTION DU SOUS-MENU ET ACTIVE
     ============================================ -->

<script>
    document.addEventListener('DOMContentLoaded', function() {

        // ===== GESTION DES SOUS-MENUS =====
        const submenuItems = document.querySelectorAll('.nav-item.has-submenu');

        submenuItems.forEach(item => {
            const link = item.querySelector('.nav-link');

            link.addEventListener('click', function(e) {
                e.preventDefault();

                // Toggle le sous-menu actuel
                item.classList.toggle('open');

                // Optionnel : Fermer les autres sous-menus
                submenuItems.forEach(otherItem => {
                    if (otherItem !== item) {
                        otherItem.classList.remove('open');
                    }
                });
            });
        });


        // ===== EFFET RIPPLE AU CLIC =====
        function createRipple(event) {
            const button = event.currentTarget;

            // Ne pas créer de ripple sur les liens avec #
            if (button.getAttribute('href') === '#') {
                return;
            }

            const ripple = document.createElement('span');
            const rect = button.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = event.clientX - rect.left - size / 2;
            const y = event.clientY - rect.top - size / 2;

            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');

            button.appendChild(ripple);

            setTimeout(() => {
                ripple.remove();
            }, 600);
        }

        // Ajouter l'effet ripple à tous les liens
        document.querySelectorAll('.nav-link, .submenu-link, .logout-btn').forEach(link => {
            link.style.position = 'relative';
            link.style.overflow = 'hidden';
            link.addEventListener('click', createRipple);
        });
    });
</script>
