{{-- resources/views/components/sidebar-nav.blade.php --}}
<nav class="nav flex-column mb-4">

    {{-- Tableau de bord --}}
    <a
        href="{{ route('dashboard0') }}"
        class="nav-link rounded-2 px-3 py-2 d-flex align-items-center
               @if(request()->routeIs('dashboard*')) bg-primary text-white @else bg-transparent text-white-75 @endif"
        role="button"
    >
        <i class="bi bi-grid-1x2-fill me-2 fs-5"></i>
        <span class="text-truncate fw-medium sidebar-text">Tableau de bord</span>
    </a>

    {{-- Employés avec sous-menu --}}
    <div class="mt-3">
        <button
            class="btn w-100 d-flex align-items-center justify-content-between px-3 py-2 rounded-2
                   @if(request()->routeIs('employees.*')) bg-primary text-white @else text-white-75 bg-transparent @endif"
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
                        class="nav-link rounded-2 px-3 py-2 d-flex align-items-center small
                               @if(request()->routeIs('employees.index')) bg-primary text-white @else text-white-50 @endif"
                    >
                        <i class="bi bi-people me-2 fs-6"></i>
                        <span class="sidebar-text">Liste des employés</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        href="{{ route('employees.create') }}"
                        class="nav-link rounded-2 px-3 py-2 d-flex align-items-center small
                               @if(request()->routeIs('employees.create')) bg-primary text-white @else text-white-50 @endif"
                    >
                        <i class="bi bi-plus-lg me-2 fs-6"></i>
                        <span class="sidebar-text">Gestion des fonctions</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        href=""
                        class="nav-link rounded-2 px-3 py-2 d-flex align-items-center small
                               @if(request()->routeIs('grades.*')) bg-primary text-white @else text-white-50 @endif"
                    >
                        <i class="bi bi-award me-2 fs-6"></i>
                        <span class="sidebar-text">Gestion des Grades</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        href=""
                        class="nav-link rounded-2 px-3 py-2 d-flex align-items-center small
                               @if(request()->routeIs('echelons.*')) bg-primary text-white @else text-white-50 @endif"
                    >
                        <i class="bi bi-arrow-up-right-square me-2 fs-6"></i>
                        <span class="sidebar-text">Gestion des Échelons</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    {{-- Locaux avec sous-menu --}}
    <div class="mt-3">
        <button
            class="btn w-100 d-flex align-items-center justify-content-between px-3 py-2 rounded-2
                   @if(request()->routeIs('locaux.*')) bg-primary text-white @else text-white-75 bg-transparent @endif"
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
                        class="nav-link rounded-2 px-3 py-2 d-flex align-items-center small
                               @if(request()->routeIs('locaux.index')) bg-primary text-white @else text-white-50 @endif"
                    >
                        <i class="bi bi-building me-2 fs-6"></i>
                        <span class="sidebar-text">Locaux</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        href="{{ route('cities.index') }}"
                        class="nav-link rounded-2 px-3 py-2 d-flex align-items-center small
                               @if(request()->routeIs('locaux.cities*')) bg-primary text-white @else text-white-50 @endif"
                    >
                        <i class="bi bi-geo-alt-fill me-2 fs-6"></i>
                        <span class="sidebar-text">Villes</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    {{-- Unités structurelle avec sous-menu --}}
    <div class="mt-3">
        <button
            class="btn w-100 d-flex align-items-center justify-content-between px-3 py-2 rounded-2
                   @if(request()->routeIs('unites.*')) bg-primary text-white @else text-white-75 bg-transparent @endif"
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
                        class="nav-link rounded-2 px-3 py-2 d-flex align-items-center small
                               @if(request()->routeIs('unites.index')) bg-primary text-white @else text-white-50 @endif"
                    >
                        <i class="bi bi-journal-text me-2 fs-6"></i>
                        <span class="sidebar-text">Services</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        href="{{ route('entities.index') }}"
                        class="nav-link rounded-2 px-3 py-2 d-flex align-items-center small
                               @if(request()->routeIs('unites.entities*')) bg-primary text-white @else text-white-50 @endif"
                    >
                        <i class="bi bi-journal-text me-2 fs-6"></i>
                        <span class="sidebar-text">Entités</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        href="{{ route('sectors.index') }}"
                        class="nav-link rounded-2 px-3 py-2 d-flex align-items-center small
                               @if(request()->routeIs('unites.sectors*')) bg-primary text-white @else text-white-50 @endif"
                    >
                        <i class="bi bi-diagram-3 me-2 fs-6"></i>
                        <span class="sidebar-text">Secteurs</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        href="{{ route('sections.index') }}"
                        class="nav-link rounded-2 px-3 py-2 d-flex align-items-center small
                               @if(request()->routeIs('unites.sections*')) bg-primary text-white @else text-white-50 @endif"
                    >
                        <i class="bi bi-journal-text me-2 fs-6"></i>
                        <span class="sidebar-text">Sections</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    {{-- Chefs avec sous-menu --}}
    <div class="mt-3">
        <button
            class="btn w-100 d-flex align-items-center justify-content-between px-3 py-2 rounded-2
                   @if(request()->routeIs('chefs.*')) bg-primary text-white @else text-white-75 bg-transparent @endif"
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
                        class="nav-link rounded-2 px-3 py-2 d-flex align-items-center small
                               @if(request()->routeIs('chefs.index')) bg-primary text-white @else text-white-50 @endif"
                    >
                        <i class="bi bi-eye-fill me-2 fs-6"></i>
                        <span class="sidebar-text">Consulter</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        href=""
                        class="nav-link rounded-2 px-3 py-2 d-flex align-items-center small
                               @if(request()->routeIs('chefs.create')) bg-primary text-white @else text-white-50 @endif"
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
