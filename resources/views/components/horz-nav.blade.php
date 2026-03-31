{{-- resources/views/components/top-nav.blade.php --}}
<nav class="navbar navbar-expand-lg bg-white border-bottom py-2 shadow-sm sticky-top">
    <div class="container-fluid px-4">

        <a class="navbar-brand fw-bold text-primary me-4" href="{{ route('dashboard0') }}">
            <i class="bi bi-layers-half me-2"></i>RH App
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#topNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="topNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-1">

                {{-- Item: DASHBOARD --}}
                <li class="nav-item">
                    <a href="{{ route('dashboard0') }}"
                       class="nav-link px-3 py-2 d-flex align-items-center rounded-3 transition-base
                              {{ request()->routeIs('dashboard0*') ? 'active-link' : 'text-secondary' }}">
                        <i class="bi bi-grid-1x2-fill me-2"></i>
                        <span class="fw-semibold">Tableau de bord</span>
                    </a>
                </li>

                {{-- Dropdown: RH --}}
                <li class="nav-item dropdown">
                    <a class="nav-link px-3 py-2 d-flex align-items-center rounded-3 dropdown-toggle transition-base
                              {{ request()->routeIs('employees.*') || request()->routeIs('categories.*') ? 'active-link' : 'text-secondary' }}"
                       href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-people-fill me-2"></i>
                        <span class="fw-semibold">RH</span>
                    </a>
                    <ul class="dropdown-menu border-0 shadow-lg p-2 rounded-4 mt-2">
                        <li><h6 class="dropdown-header text-uppercase opacity-50 small fw-bold">Ressources Humaines</h6></li>
                        <li><a class="dropdown-item rounded-3 py-2 {{ request()->routeIs('employees.*') ? 'active' : '' }}" href="{{ route('employees.index') }}">Annuaire</a></li>
                        <li><a class="dropdown-item rounded-3 py-2 {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">Catégories</a></li>
                    </ul>
                </li>

                {{-- Dropdown: NOMENCLATURE --}}
                @if (auth()->user()->profile_id != 3)
                <li class="nav-item dropdown">
                    @php $isReferencial = request()->routeIs('occupations.*') || request()->routeIs('grades.*') || request()->routeIs('diplomas.*') || request()->routeIs('options.*'); @endphp
                    <a class="nav-link px-3 py-2 d-flex align-items-center rounded-3 dropdown-toggle transition-base
                              {{ $isReferencial ? 'active-link' : 'text-secondary' }}"
                       href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-bookmark-star-fill me-2"></i>
                        <span class="fw-semibold">Nomenclature</span>
                    </a>
                    <ul class="dropdown-menu border-0 shadow-lg p-2 rounded-4 mt-2">
                        <li><a class="dropdown-item rounded-3 py-2" href="{{ route('occupations.index') }}">Fonctions</a></li>
                        <li><a class="dropdown-item rounded-3 py-2" href="{{ route('grades.index') }}">Grades</a></li>
                        <li><a class="dropdown-item rounded-3 py-2" href="{{ route('diplomas.index') }}">Diplômes</a></li>
                        <li><a class="dropdown-item rounded-3 py-2" href="{{ route('options.index') }}">Options</a></li>
                    </ul>
                </li>
                @endif

                {{-- Dropdown: LOCALISATION --}}
                @if (auth()->user()->profile_id != 3)
                <li class="nav-item dropdown">
                    <a class="nav-link px-3 py-2 d-flex align-items-center rounded-3 dropdown-toggle transition-base
                              {{ request()->routeIs('locals.*') || request()->routeIs('cities.*') ? 'active-link' : 'text-secondary' }}"
                       href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-geo-alt-fill me-2"></i>
                        <span class="fw-semibold">Localisation</span>
                    </a>
                    <ul class="dropdown-menu border-0 shadow-lg p-2 rounded-4 mt-2">
                        <li><a class="dropdown-item rounded-3 py-2" href="{{ route('locals.index') }}">Locaux</a></li>
                        <li><a class="dropdown-item rounded-3 py-2" href="{{ route('cities.index') }}">Villes</a></li>
                    </ul>
                </li>
                @endif

                {{-- Dropdown: UNITÉS --}}
                @if (auth()->user()->profile_id != 3)
                <li class="nav-item dropdown">
                    @php $isOrg = request()->routeIs('services.*') || request()->routeIs('entities.*') || request()->routeIs('sectors.*') || request()->routeIs('sections.*'); @endphp
                    <a class="nav-link px-3 py-2 d-flex align-items-center rounded-3 dropdown-toggle transition-base
                              {{ $isOrg ? 'active-link' : 'text-secondary' }}"
                       href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-diagram-3-fill me-2"></i>
                        <span class="fw-semibold">Unités</span>
                    </a>
                    <ul class="dropdown-menu border-0 shadow-lg p-2 rounded-4 mt-2">
                        <li><a class="dropdown-item rounded-3 py-2" href="{{ route('services.index') }}">Services</a></li>
                        <li><a class="dropdown-item rounded-3 py-2" href="{{ route('entities.index') }}">Entités</a></li>
                        <li><a class="dropdown-item rounded-3 py-2" href="{{ route('sectors.index') }}">Secteurs</a></li>
                        <li><a class="dropdown-item rounded-3 py-2" href="{{ route('sections.index') }}">Sections</a></li>
                    </ul>
                </li>
                @endif

                {{-- Dropdown: HIÉRARCHIE --}}
                @if (auth()->user()->profile_id != 3)
                <li class="nav-item dropdown">
                    <a class="nav-link px-3 py-2 d-flex align-items-center rounded-3 dropdown-toggle transition-base
                              {{ request()->routeIs('chefs.*') || request()->routeIs('temps.*') ? 'active-link' : 'text-secondary' }}"
                       href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-workspace me-2"></i>
                        <span class="fw-semibold">Hiérarchie</span>
                    </a>
                    <ul class="dropdown-menu border-0 shadow-lg p-2 rounded-4 mt-2">
                        <li><a class="dropdown-item rounded-3 py-2" href="{{ route('chefs.index') }}">Chefs</a></li>
                        <li><a class="dropdown-item rounded-3 py-2" href="{{ route('temps.index') }}">Intérimaires</a></li>
                    </ul>
                </li>
                @endif

                @if (auth()->user()->profile_id == 3)
                    <li class="nav-item dropdown">
                        <a class="nav-link px-3 py-2 d-flex align-items-center rounded-3 dropdown-toggle transition-base
                              {{ request()->routeIs('audit.tables.*') || request()->routeIs('audit.periods.*') ? 'active-link' : 'text-secondary' }}"
                           href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-workspace me-2"></i>
                            <span class="fw-semibold">Gestion de suivi</span>
                        </a>
                        <ul class="dropdown-menu border-0 shadow-lg p-2 rounded-4 mt-2">
                            <li><a class="dropdown-item rounded-3 py-2" href="{{ route('audit.tables.index') }}">Tableaux de suivi</a></li>
                            <li><a class="dropdown-item rounded-3 py-2" href="{{ route('audit.periods.index') }}">Périodes de suivi</a></li>
                        </ul>
                    </li>
                @endif

                @if (auth()->user()->profile_id == 3)
                    <li class="nav-item dropdown">
                        <a class="nav-link px-3 py-2 d-flex align-items-center rounded-3 dropdown-toggle transition-base
                              {{ request()->routeIs('audit.values.*') ? 'active-link' : 'text-secondary' }}"
                           href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-workspace me-2"></i>
                            <span class="fw-semibold">Performance</span>
                        </a>
                        <ul class="dropdown-menu border-0 shadow-lg p-2 rounded-4 mt-2">
                            <li><a class="dropdown-item rounded-3 py-2" href="{{ route('audit.values.index') }}">Évaluations Périodiques</a></li>
                            <li><a class="dropdown-item rounded-3 py-2" href="{{ route('audit.values.consult') }}">Consulter l'évaluation</a></li>
                        </ul>
                    </li>
                @endif

                @if (auth()->user()->profile_id == 4)
                    <li class="nav-item dropdown">
                        <a class="nav-link px-3 py-2 d-flex align-items-center rounded-3 dropdown-toggle transition-base
                              {{ request()->routeIs('performances.*') || request()->routeIs('temps.*') ? 'active-link' : 'text-secondary' }}"
                           href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-workspace me-2"></i>
                            <span class="fw-semibold">Évaluations Périodiques</span>
                        </a>
                        <ul class="dropdown-menu border-0 shadow-lg p-2 rounded-4 mt-2">
                            <li><a class="dropdown-item rounded-3 py-2" href="{{ route('audit.values.select') }}">Superviser l'évaluation</a></li>
                        </ul>
                    </li>

                @endif

            </ul>
        </div>

        {{-- search bar --}}
        <div class="d-flex align-items-center ms-lg-3 position-relative me-4" style="min-width: 270px; max-width: 400px;">
            <div class="input-group bg-light rounded-3 overflow-hidden border border-light-subtle shadow-sm">
                <span class="input-group-text bg-transparent border-0 text-muted px-2">
                    <i class="bi bi-search"></i>
                </span>
                    <input type="text" id="mainSearch"
                           class="form-control bg-transparent border-0 shadow-none py-2 text-dark"
                           placeholder="Recherche...">
                </div>

            <div id="box_result_search"
                 class="d-none shadow-lg rounded-3 border bg-white text-dark p-0 position-absolute w-100 mt-2"
                 style="z-index: 1050; max-height: 400px; overflow-y: auto; top: 100%;">
                <div id="searchContent">
                    {{-- Results will load here --}}
                </div>
            </div>
        </div>

        {{-- profil --}}

        <x-profil />

    </div>
</nav>

<style>
    .transition-base { transition: all 0.2s ease-in-out; }

    /* Active Link Styling */
    .active-link {
        background-color: #eef2ff !important;
        color: #4f46e5 !important;
    }

    .nav-link:hover {
        background-color: #f8fafc;
        color: #4f46e5;
    }

    /* Modern Dropdown Design */
    .dropdown-menu {
        min-width: 200px;
        animation: slideUp 0.3s ease-out;
    }

    .dropdown-item:hover {
        background-color: #f1f5f9;
        color: #4f46e5;
    }

    .dropdown-item.active {
        background-color: #4f46e5 !important;
        color: white !important;
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Custom scrollbar for dropdowns if they get long */
    .dropdown-menu { max-height: 80vh; overflow-y: auto; }
</style>
