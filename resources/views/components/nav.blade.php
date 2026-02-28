{{-- resources/views/components/sidebar-nav.blade.php --}}
<nav class="sidebar bg-white border-end d-flex flex-column p-3">

    {{-- Section title --}}
    <div class="sidebar-section-title mt-2 mb-1">HOME</div>

    {{-- Tableau de bord --}}
    <a
        href="{{ route('dashboard0') }}"
        class="nav-link sidebar-link rounded-2 px-3 py-2 d-flex align-items-center
               @if(request()->routeIs('dashboard*')) active @endif"
        role="button"
    >
        <i class="bi bi-grid-1x2-fill me-2 fs-5"></i>
        <span class="text-truncate fw-medium sidebar-text">Tableau de bord</span>
    </a>

    {{-- Section title --}}
    <div class="sidebar-section-title mt-4 mb-1">EMPLOYÉS</div>

    {{-- Employés avec sous-menu --}}
    <div class="mt-1">
        <button
            class="btn sidebar-toggle w-100 d-flex align-items-center justify-content-between px-3 py-2 rounded-2
                   @if(request()->routeIs('employees.*')) active @endif"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#menuEmployees"
            aria-expanded="{{ request()->routeIs('employees.*') ? 'true' : 'false' }}"
        >
            <span class="d-flex align-items-center">
                <i class="bi bi-people-fill me-2 fs-5"></i>
                <span class="text-truncate fw-medium sidebar-text">Employés</span>
            </span>
            <i class="bi bi-chevron-down small"></i>
        </button>

        <div class="collapse @if(request()->routeIs('employees.*')) show @endif" id="menuEmployees">
            <ul class="nav flex-column ms-3 mt-2">
                <li class="nav-item">
                    <a
                        href="{{ route('employees.index') }}"
                        class="nav-link sidebar-link-nested rounded-2 px-3 py-2 d-flex align-items-center small
                               @if(request()->routeIs('employees.index')) active @endif"
                    >
                        <i class="bi bi-people me-2 fs-6"></i>
                        <span class="sidebar-text">Liste des employés</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        href="{{ route('employees.create') }}"
                        class="nav-link sidebar-link-nested rounded-2 px-3 py-2 d-flex align-items-center small
                               @if(request()->routeIs('employees.create')) active @endif"
                    >
                        <i class="bi bi-plus-lg me-2 fs-6"></i>
                        <span class="sidebar-text">Gestion des fonctions</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        href=""
                        class="nav-link sidebar-link-nested rounded-2 px-3 py-2 d-flex align-items-center small
                               @if(request()->routeIs('grades.*')) active @endif"
                    >
                        <i class="bi bi-award me-2 fs-6"></i>
                        <span class="sidebar-text">Gestion des Grades</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        href=""
                        class="nav-link sidebar-link-nested rounded-2 px-3 py-2 d-flex align-items-center small
                               @if(request()->routeIs('echelons.*')) active @endif"
                    >
                        <i class="bi bi-arrow-up-right-square me-2 fs-6"></i>
                        <span class="sidebar-text">Gestion des Échelons</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    {{-- Section title --}}
    <div class="sidebar-section-title mt-4 mb-1">LOCAUX</div>

    {{-- Locaux avec sous-menu --}}
    <div class="mt-1">
        <button
            class="btn sidebar-toggle w-100 d-flex align-items-center justify-content-between px-3 py-2 rounded-2
                   @if(request()->routeIs('locaux.*')) active @endif"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#menuLocaux"
            aria-expanded="{{ request()->routeIs('locaux.*') ? 'true' : 'false' }}"
        >
            <span class="d-flex align-items-center">
                <i class="bi bi-building me-2 fs-5"></i>
                <span class="text-truncate fw-medium sidebar-text">Locaux</span>
            </span>
            <i class="bi bi-chevron-down small"></i>
        </button>

        <div class="collapse @if(request()->routeIs('locaux.*')) show @endif" id="menuLocaux">
            <ul class="nav flex-column ms-3 mt-2">
                <li class="nav-item">
                    <a
                        href="{{ route('locals.index') }}"
                        class="nav-link sidebar-link-nested rounded-2 px-3 py-2 d-flex align-items-center small
                               @if(request()->routeIs('locaux.index')) active @endif"
                    >
                        <i class="bi bi-building me-2 fs-6"></i>
                        <span class="sidebar-text">Locaux</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        href="{{ route('cities.index') }}"
                        class="nav-link sidebar-link-nested rounded-2 px-3 py-2 d-flex align-items-center small
                               @if(request()->routeIs('locaux.cities*')) active @endif"
                    >
                        <i class="bi bi-geo-alt-fill me-2 fs-6"></i>
                        <span class="sidebar-text">Villes</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    {{-- Section title --}}
    <div class="sidebar-section-title mt-4 mb-1">UNITÉS STRUCTURELLE</div>

    {{-- Unités structurelle avec sous-menu --}}
    <div class="mt-1">
        <button
            class="btn sidebar-toggle w-100 d-flex align-items-center justify-content-between px-3 py-2 rounded-2
                   @if(request()->routeIs('unites.*')) active @endif"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#menuUnites"
            aria-expanded="{{ request()->routeIs('unites.*') ? 'true' : 'false' }}"
        >
            <span class="d-flex align-items-center">
                <i class="bi bi-diagram-3-fill me-2 fs-5"></i>
                <span class="text-truncate fw-medium sidebar-text">Unités structurelle</span>
            </span>
            <i class="bi bi-chevron-down small"></i>
        </button>

        <div class="collapse @if(request()->routeIs('unites.*')) show @endif" id="menuUnites">
            <ul class="nav flex-column ms-3 mt-2">
                <li class="nav-item">
                    <a
                        href="{{ route('services.index') }}"
                        class="nav-link sidebar-link-nested rounded-2 px-3 py-2 d-flex align-items-center small
                               @if(request()->routeIs('unites.index')) active @endif"
                    >
                        <i class="bi bi-journal-text me-2 fs-6"></i>
                        <span class="sidebar-text">Services</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        href="{{ route('entities.index') }}"
                        class="nav-link sidebar-link-nested rounded-2 px-3 py-2 d-flex align-items-center small
                               @if(request()->routeIs('unites.entities*')) active @endif"
                    >
                        <i class="bi bi-journal-text me-2 fs-6"></i>
                        <span class="sidebar-text">Entités</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        href="{{ route('sectors.index') }}"
                        class="nav-link sidebar-link-nested rounded-2 px-3 py-2 d-flex align-items-center small
                               @if(request()->routeIs('unites.sectors*')) active @endif"
                    >
                        <i class="bi bi-diagram-3 me-2 fs-6"></i>
                        <span class="sidebar-text">Secteurs</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        href="{{ route('sections.index') }}"
                        class="nav-link sidebar-link-nested rounded-2 px-3 py-2 d-flex align-items-center small
                               @if(request()->routeIs('unites.sections*')) active @endif"
                    >
                        <i class="bi bi-journal-text me-2 fs-6"></i>
                        <span class="sidebar-text">Sections</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    {{-- Section title --}}
    <div class="sidebar-section-title mt-4 mb-1">CHEFS</div>

    {{-- Chefs avec sous-menu --}}
    <div class="mt-1 mb-3">
        <button
            class="btn sidebar-toggle w-100 d-flex align-items-center justify-content-between px-3 py-2 rounded-2
                   @if(request()->routeIs('chefs.*')) active @endif"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#menuChefs"
            aria-expanded="{{ request()->routeIs('chefs.*') ? 'true' : 'false' }}"
        >
            <span class="d-flex align-items-center">
                <i class="bi bi-shield-check me-2 fs-5"></i>
                <span class="text-truncate fw-medium sidebar-text">Chefs</span>
            </span>
            <i class="bi bi-chevron-down small"></i>
        </button>

        <div class="collapse @if(request()->routeIs('chefs.*')) show @endif" id="menuChefs">
            <ul class="nav flex-column ms-3 mt-2">
                <li class="nav-item">
                    <a
                        href=""
                        class="nav-link sidebar-link-nested rounded-2 px-3 py-2 d-flex align-items-center small
                               @if(request()->routeIs('chefs.index')) active @endif"
                    >
                        <i class="bi bi-eye-fill me-2 fs-6"></i>
                        <span class="sidebar-text">Consulter</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        href=""
                        class="nav-link sidebar-link-nested rounded-2 px-3 py-2 d-flex align-items-center small
                               @if(request()->routeIs('chefs.create')) active @endif"
                    >
                        <i class="bi bi-plus-lg me-2 fs-6"></i>
                        <span class="sidebar-text">Créer</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>


<style>
    /* Sidebar in full mode: keep text visible */
    .sidebar-open .sidebar-text {
        display: inline-block;
    }

    /* Sidebar in mini mode: hide text, keep icons only */
    .sidebar-compressed .sidebar-text {
        display: none;
    }

    .sidebar {
        width: 260px;
        min-height: 100vh;
        background-color: #ffffff;
        border-right: 1px solid #e5e7eb;
        overflow-y: auto;
        font-size: 0.935rem;
    }

    .sidebar-section-title {
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #9ca3af;
    }

    /* Base link styles */
    .sidebar-link,
    .sidebar-toggle,
    .sidebar-link-nested {
        color: #4b5563;
        background-color: transparent;
        border-radius: 0.5rem;
        transition: background-color 0.15s ease, color 0.15s ease;
    }

    /* Top level link hover */
    .sidebar-link:hover,
    .sidebar-toggle:hover {
        background-color: #f3f4f6;
        color: #111827;
    }

    /* Nested link hover */
    .sidebar-link-nested:hover {
        background-color: #eef2ff;
        color: #1d4ed8;
    }

    /* Active states (we only add/remove `active` in Blade) */
    .sidebar-link.active,
    .sidebar-toggle.active,
    .sidebar-link-nested.active {
        background-color: #2563eb;
        color: #ffffff;
    }

    /* Icons inside active items */
    .sidebar-link.active i,
    .sidebar-toggle.active i,
    .sidebar-link-nested.active i {
        color: inherit;
    }

    /* Text color for inactive */
    .sidebar .nav-link,
    .sidebar .btn {
        text-align: left;
    }

    /* Chevron rotation when open */
    .sidebar-toggle .bi-chevron-down {
        transition: transform 0.15s ease;
    }

    .sidebar-toggle[aria-expanded="true"] .bi-chevron-down {
        transform: rotate(180deg);
    }

    /* Nested list spacing */
    .sidebar .nav.flex-column .nav-item + .nav-item {
        margin-top: 0.15rem;
    }


</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar   = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('sidebarToggle');
        const brandFull = document.getElementById('sidebarBrandFull');
        const brandMini = document.getElementById('sidebarBrandMini');

        let sidebarOpen = true;

        toggleBtn.addEventListener('click', function () {
            sidebarOpen = !sidebarOpen;

            if (sidebarOpen) {
                sidebar.style.width = '250px';
                sidebar.classList.remove('sidebar-compressed');
                sidebar.classList.add('sidebar-open');
                brandFull.classList.remove('d-none');
                brandMini.classList.add('d-none');
            } else {
                sidebar.style.width = '120px';
                sidebar.classList.remove('sidebar-open');
                sidebar.classList.add('sidebar-compressed');
                brandFull.classList.add('d-none');
                brandMini.classList.remove('d-none');
            }
        });
    });
</script>
