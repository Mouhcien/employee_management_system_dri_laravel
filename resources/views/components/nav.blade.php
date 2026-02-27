{{-- resources/views/components/sidebar-nav.blade.php --}}
<nav class="nav nav-pills flex-column mb-auto">

    {{-- Tableau de bord --}}
    <a href="{{ route('dashboard0') }}"
       class="nav-link d-flex align-items-center px-3 py-2 text-white @if(request()->routeIs('dashboard')) active bg-primary @else text-opacity-75 @endif">
        <i class="bi bi-grid-1x2-fill me-2"></i>
        <span class="text-truncate">Tableau de bord</span>
    </a>

    {{-- Employés avec sous-menu --}}
    <div class="mt-1">
        <button class="btn w-100 d-flex align-items-center justify-content-between px-3 py-2 text-start text-white
                       @if(request()->routeIs('employees.*')) bg-primary @else bg-transparent @endif"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#menuEmployees"
                aria-expanded="{{ request()->routeIs('employees.*') ? 'true' : 'false' }}">
            <span class="d-flex align-items-center">
                <i class="bi bi-people-fill me-2"></i>
                <span class="text-truncate">Employés</span>
            </span>
            <i class="bi bi-chevron-down small"></i>
        </button>

        <div class="collapse @if(request()->routeIs('employees.*')) show @endif" id="menuEmployees">
            <ul class="nav flex-column ms-4 border-start border-secondary ps-2">
                <li class="nav-item">
                    <a href="{{ route('employees.index') }}"
                       class="nav-link d-flex align-items-center px-3 py-2 small
                              @if(request()->routeIs('employees.index')) active bg-primary text-white @else text-white-50 @endif">
                        <i class="bi bi-people-fill me-2"></i>
                        <span>Liste des employés</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('employees.create') }}"
                       class="nav-link d-flex align-items-center px-3 py-2 small
                              @if(request()->routeIs('employees.create')) active bg-primary text-white @else text-white-50 @endif">
                        <i class="bi bi-plus-lg me-2"></i>
                        <span>Gestion des fonctions</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('employees.create') }}"
                       class="nav-link d-flex align-items-center px-3 py-2 small
                              @if(request()->routeIs('employees.create')) active bg-primary text-white @else text-white-50 @endif">
                        <i class="bi bi-plus-lg me-2"></i>
                        <span>Gestion des Grades</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('employees.create') }}"
                       class="nav-link d-flex align-items-center px-3 py-2 small
                              @if(request()->routeIs('employees.create')) active bg-primary text-white @else text-white-50 @endif">
                        <i class="bi bi-plus-lg me-2"></i>
                        <span>Gestion des Echellons</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    {{-- Locaux avec sous-menu --}}
    <div class="mt-1">
        <button class="btn w-100 d-flex align-items-center justify-content-between px-3 py-2 text-start text-white
                       @if(request()->routeIs('locaux.*')) bg-primary @else bg-transparent @endif"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#menuLocaux"
                aria-expanded="{{ request()->routeIs('locaux.*') ? 'true' : 'false' }}">
            <span class="d-flex align-items-center">
                <i class="bi bi-building me-2"></i>
                <span class="text-truncate">Locaux</span>
            </span>
            <i class="bi bi-chevron-down small"></i>
        </button>

        <div class="collapse @if(request()->routeIs('locaux.*')) show @endif" id="menuLocaux">
            <ul class="nav flex-column ms-4 border-start border-secondary ps-2">
                <li class="nav-item">
                    <a href="{{ route('locals.index') }}"
                       class="nav-link d-flex align-items-center px-3 py-2 small
                              @if(request()->routeIs('locaux.index')) active bg-primary text-white @else text-white-50 @endif">
                        <i class="bi bi-building me-2"></i>
                        <span>Locaux</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('cities.index') }}"
                       class="nav-link d-flex align-items-center px-3 py-2 small
                              @if(request()->routeIs('locaux.create')) active bg-primary text-white @else text-white-50 @endif">
                        <i class="bi bi-geo-alt-fill me-2"></i>
                        <span>Villes</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    {{-- Unités structurelle avec sous-menu --}}
    <div class="mt-1">
        <button class="btn w-100 d-flex align-items-center justify-content-between px-3 py-2 text-start text-white
                       @if(request()->routeIs('unites.*')) bg-primary @else bg-transparent @endif"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#menuUnites"
                aria-expanded="{{ request()->routeIs('unites.*') ? 'true' : 'false' }}">
            <span class="d-flex align-items-center">
                <i class="bi bi-diagram-3-fill me-2"></i>
                <span class="text-truncate">Unités structurelle</span>
            </span>
            <i class="bi bi-chevron-down small"></i>
        </button>

        <div class="collapse @if(request()->routeIs('unites.*')) show @endif" id="menuUnites">
            <ul class="nav flex-column ms-4 border-start border-secondary ps-2">
                <li class="nav-item">
                    <a href="{{ route('services.index') }}"
                       class="nav-link d-flex align-items-center px-3 py-2 small
                              @if(request()->routeIs('unites.index')) active bg-primary text-white @else text-white-50 @endif">
                        <i class="bi bi-journal-text me-2"></i>
                        <span>Services</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('entities.index') }}"
                       class="nav-link d-flex align-items-center px-3 py-2 small
                              @if(request()->routeIs('unites.create')) active bg-primary text-white @else text-white-50 @endif">
                        <i class="bi bi-journal-text me-2"></i>
                        <span>Entités</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('sectors.index') }}"
                       class="nav-link d-flex align-items-center px-3 py-2 small
                              @if(request()->routeIs('unites.create')) active bg-primary text-white @else text-white-50 @endif">
                        <i class="bi bi-journal-text me-2"></i>
                        <span>Secteurs</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('sections.index') }}"
                       class="nav-link d-flex align-items-center px-3 py-2 small
                              @if(request()->routeIs('unites.create')) active bg-primary text-white @else text-white-50 @endif">
                        <i class="bi bi-journal-text me-2"></i>
                        <span>Sections</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    {{-- Chefs avec sous-menu --}}
    <div class="mt-1">
        <button class="btn w-100 d-flex align-items-center justify-content-between px-3 py-2 text-start text-white
                       @if(request()->routeIs('chefs.*')) bg-primary @else bg-transparent @endif"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#menuChefs"
                aria-expanded="{{ request()->routeIs('chefs.*') ? 'true' : 'false' }}">
            <span class="d-flex align-items-center">
                <i class="bi bi-shield-check me-2"></i>
                <span class="text-truncate">Chefs</span>
            </span>
            <i class="bi bi-chevron-down small"></i>
        </button>

        <div class="collapse @if(request()->routeIs('chefs.*')) show @endif" id="menuChefs">
            <ul class="nav flex-column ms-4 border-start border-secondary ps-2">
                <li class="nav-item">
                    <a href=""
                       class="nav-link d-flex align-items-center px-3 py-2 small
                              @if(request()->routeIs('chefs.index')) active bg-primary text-white @else text-white-50 @endif">
                        <i class="bi bi-eye-fill me-2"></i>
                        <span>Consulter</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href=""
                       class="nav-link d-flex align-items-center px-3 py-2 small
                              @if(request()->routeIs('chefs.create')) active bg-primary text-white @else text-white-50 @endif">
                        <i class="bi bi-plus-lg me-2"></i>
                        <span>Créer</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
