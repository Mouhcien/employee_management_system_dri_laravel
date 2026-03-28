{{-- resources/views/components/sidebar-nav.blade.php --}}
<nav id="sidebar" class="sidebar sidebar-open bg-white border-end d-flex flex-column p-3 transition-base">

    {{-- Section: HOME --}}
    <div class="sidebar-section-title mt-2 mb-1 px-3">Principal</div>
    <a href="{{ route('dashboard0') }}"
       class="nav-link sidebar-link rounded-3 px-3 py-2 d-flex align-items-center mb-1 transition-base
              {{ request()->routeIs('dashboard0*') ? 'shadow-sm text-primary bg-primary-subtle' : '' }}">
        <i class="bi bi-grid-1x2-fill me-2 fs-5"></i>
        <span class="sidebar-text fw-semibold">Tableau de bord</span>
    </a>

    {{-- Section: EMPLOYÉS --}}
    <div class="sidebar-section-title mt-3 mb-1 px-3">Ressources Humaines</div>
    <div class="sidebar-group mb-1">
        <button class="btn sidebar-toggle w-100 d-flex align-items-center justify-content-between px-3 py-2 rounded-3 transition-base {{ request()->routeIs('employees.*') || request()->routeIs('categories.*') ? 'text-primary bg-primary-subtle' : '' }}"
                type="button" data-bs-toggle="collapse" data-bs-target="#menuEmployees"
                aria-expanded="{{ request()->routeIs('employees.*') || request()->routeIs('categories.*') ? 'true' : 'false' }}">
            <span class="d-flex align-items-center">
                <i class="bi bi-people-fill me-2 fs-5"></i>
                <span class="sidebar-text fw-semibold">Employés</span>
            </span>
            <i class="bi bi-chevron-down small transition-base"></i>
        </button>
        <div class="collapse {{ request()->routeIs('employees.*') || request()->routeIs('categories.*') ? 'show' : '' }}" id="menuEmployees">
            <ul class="nav flex-column ms-2 mt-1">
                <li class="nav-item">
                    <a href="{{ route('employees.index') }}"
                       class="nav-link sidebar-link-nested rounded-3 px-3 py-2 d-flex align-items-center small {{ request()->routeIs('employees.index') ? 'active fw-bold' : '' }}">
                        <i class="bi bi-dot me-1 fs-4"></i><span class="sidebar-text">Annuaire</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('categories.index') }}"
                       class="nav-link sidebar-link-nested rounded-3 px-3 py-2 d-flex align-items-center small {{ request()->routeIs('categories.index') ? 'active fw-bold' : '' }}">
                        <i class="bi bi-dot me-1 fs-4"></i><span class="sidebar-text">Catégories</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    {{-- Section: RÉFÉRENTIELS --}}
    @if (auth()->user()->profile_id != 3)
    <div class="sidebar-section-title mt-3 mb-1 px-3">Référentiels</div>
    <div class="sidebar-group mb-1">
        @php $isReferencial = request()->routeIs('occupations.*') || request()->routeIs('grades.*') || request()->routeIs('diplomas.*') || request()->routeIs('options.*'); @endphp
        <button class="btn sidebar-toggle w-100 d-flex align-items-center justify-content-between px-3 py-2 rounded-3 transition-base {{ $isReferencial ? 'text-primary bg-primary-subtle' : '' }}"
                type="button" data-bs-toggle="collapse" data-bs-target="#menuReferenciel" aria-expanded="{{ $isReferencial ? 'true' : 'false' }}">
            <span class="d-flex align-items-center">
                <i class="bi bi-bookmark-star-fill me-2 fs-5"></i>
                <span class="sidebar-text fw-semibold">Nomenclature</span>
            </span>
            <i class="bi bi-chevron-down small transition-base"></i>
        </button>
        <div class="collapse {{ $isReferencial ? 'show' : '' }}" id="menuReferenciel">
            <ul class="nav flex-column ms-2 mt-1">
                <li><a href="{{ route('occupations.index') }}" class="nav-link sidebar-link-nested rounded-3 px-3 py-2 small {{ request()->routeIs('occupations.*') ? 'active' : '' }}"><i class="bi bi-dot me-1 fs-4"></i>Fonctions</a></li>
                <li><a href="{{ route('grades.index') }}" class="nav-link sidebar-link-nested rounded-3 px-3 py-2 small {{ request()->routeIs('grades.*') ? 'active' : '' }}"><i class="bi bi-dot me-1 fs-4"></i>Grades</a></li>
                <li><a href="{{ route('diplomas.index') }}" class="nav-link sidebar-link-nested rounded-3 px-3 py-2 small {{ request()->routeIs('diplomas.*') ? 'active' : '' }}"><i class="bi bi-dot me-1 fs-4"></i>Diplômes</a></li>
                <li><a href="{{ route('options.index') }}" class="nav-link sidebar-link-nested rounded-3 px-3 py-2 small {{ request()->routeIs('options.*') ? 'active' : '' }}"><i class="bi bi-dot me-1 fs-4"></i>Options</a></li>
            </ul>
        </div>
    </div>
    @endif

    {{-- Section: INFRASTRUCTURES --}}
    @if (auth()->user()->profile_id != 3)
    <div class="sidebar-section-title mt-3 mb-1 px-3">Infrastructures</div>
    <div class="sidebar-group mb-1">
        <button class="btn sidebar-toggle w-100 d-flex align-items-center justify-content-between px-3 py-2 rounded-3 transition-base {{ request()->routeIs('locals.*') || request()->routeIs('cities.*') ? 'text-primary bg-primary-subtle' : '' }}"
                type="button" data-bs-toggle="collapse" data-bs-target="#menuLocaux">
            <span class="d-flex align-items-center">
                <i class="bi bi-geo-alt-fill me-2 fs-5"></i>
                <span class="sidebar-text fw-semibold">Localisation</span>
            </span>
            <i class="bi bi-chevron-down small transition-base"></i>
        </button>
        <div class="collapse {{ request()->routeIs('locals.*') || request()->routeIs('cities.*') ? 'show' : '' }}" id="menuLocaux">
            <ul class="nav flex-column ms-2 mt-1">
                <li><a href="{{ route('locals.index') }}" class="nav-link sidebar-link-nested rounded-3 px-3 py-2 small {{ request()->routeIs('locals.*') ? 'active' : '' }}"><i class="bi bi-dot me-1 fs-4"></i>Locaux</a></li>
                <li><a href="{{ route('cities.index') }}" class="nav-link sidebar-link-nested rounded-3 px-3 py-2 small {{ request()->routeIs('cities.*') ? 'active' : '' }}"><i class="bi bi-dot me-1 fs-4"></i>Villes</a></li>
            </ul>
        </div>
    </div>
    @endif

    {{-- Section: STRUCTURE --}}
    @if (auth()->user()->profile_id != 3)
    <div class="sidebar-section-title mt-3 mb-1 px-3">Organisation</div>
    <div class="sidebar-group mb-1">
        @php $isOrg = request()->routeIs('services.*') || request()->routeIs('entities.*') || request()->routeIs('sectors.*') || request()->routeIs('sections.*'); @endphp
        <button class="btn sidebar-toggle w-100 d-flex align-items-center justify-content-between px-3 py-2 rounded-3 transition-base {{ $isOrg ? 'text-primary bg-primary-subtle' : '' }}"
                type="button" data-bs-toggle="collapse" data-bs-target="#menuUnites">
            <span class="d-flex align-items-center">
                <i class="bi bi-diagram-3-fill me-2 fs-5"></i>
                <span class="sidebar-text fw-semibold">Unités</span>
            </span>
            <i class="bi bi-chevron-down small transition-base"></i>
        </button>
        <div class="collapse {{ $isOrg ? 'show' : '' }}" id="menuUnites">
            <ul class="nav flex-column ms-2 mt-1">
                <li><a href="{{ route('services.index') }}" class="nav-link sidebar-link-nested rounded-3 px-3 py-2 small {{ request()->routeIs('services.*') ? 'active' : '' }}"><i class="bi bi-dot me-1 fs-4"></i>Services</a></li>
                <li><a href="{{ route('entities.index') }}" class="nav-link sidebar-link-nested rounded-3 px-3 py-2 small {{ request()->routeIs('entities.*') ? 'active' : '' }}"><i class="bi bi-dot me-1 fs-4"></i>Entités</a></li>
                <li><a href="{{ route('sectors.index') }}" class="nav-link sidebar-link-nested rounded-3 px-3 py-2 small {{ request()->routeIs('sectors.*') ? 'active' : '' }}"><i class="bi bi-dot me-1 fs-4"></i>Secteurs</a></li>
                <li><a href="{{ route('sections.index') }}" class="nav-link sidebar-link-nested rounded-3 px-3 py-2 small {{ request()->routeIs('sections.*') ? 'active' : '' }}"><i class="bi bi-dot me-1 fs-4"></i>Sections</a></li>
            </ul>
        </div>
    </div>
    @endif

    {{-- Section: CHEFS --}}
    @if (auth()->user()->profile_id != 3)
    <div class="sidebar-section-title mt-3 mb-1 px-3">Hiérarchie</div>
    <div class="sidebar-group mb-3">
        <button class="btn sidebar-toggle w-100 d-flex align-items-center justify-content-between px-3 py-2 rounded-3 transition-base {{ request()->routeIs('chefs.*') ? 'text-primary bg-primary-subtle' : '' }}"
                type="button" data-bs-toggle="collapse" data-bs-target="#menuChefs">
            <span class="d-flex align-items-center">
                <i class="bi bi-person-workspace me-2 fs-5"></i>
                <span class="sidebar-text fw-semibold">Chefs & Responsables</span>
            </span>
            <i class="bi bi-chevron-down small transition-base"></i>
        </button>
        <div class="collapse {{ request()->routeIs('chefs.*') ? 'show' : '' }}" id="menuChefs">
            <ul class="nav flex-column ms-2 mt-1">
                <li><a href="{{ route('chefs.index') }}" class="nav-link sidebar-link-nested rounded-3 px-3 py-2 small {{ request()->routeIs('chefs.index') ? 'active' : '' }}"><i class="bi bi-dot me-1 fs-4"></i>Consulter les chefs</a></li>
                <li><a href="{{ route('temps.index') }}" class="nav-link sidebar-link-nested rounded-3 px-3 py-2 small {{ request()->routeIs('temps.index') ? 'active' : '' }}"><i class="bi bi-dot me-1 fs-4"></i>Consulter les intérimaires</a></li>
            </ul>
        </div>
    </div>
    @endif

    @if (auth()->user()->profile_id == 3)
        <div class="sidebar-section-title mt-3 mb-1 px-3">Configuration</div>
        <div class="sidebar-group mb-3">
            <button class="btn sidebar-toggle w-100 d-flex align-items-center justify-content-between px-3 py-2 rounded-3 transition-base {{ request()->routeIs('suivis.*') ? 'text-primary bg-primary-subtle' : '' }}"
                    type="button" data-bs-toggle="collapse" data-bs-target="#menuSuivi">
            <span class="d-flex align-items-center">
                <i class="bi bi-person-workspace me-2 fs-5"></i>
                <span class="sidebar-text fw-semibold">Gestion de suivi</span>
            </span>
                <i class="bi bi-chevron-down small transition-base"></i>
            </button>
            <div class="collapse {{ request()->routeIs('suivis.*') ? 'show' : '' }}" id="menuSuivi">
                <ul class="nav flex-column ms-2 mt-1">
                    <li><a href="{{ route('chefs.index') }}" class="nav-link sidebar-link-nested rounded-3 px-3 py-2 small {{ request()->routeIs('chefs.index') ? 'active' : '' }}"><i class="bi bi-dot me-1 fs-4"></i>Tableaux de suivi</a></li>
                    <li><a href="{{ route('temps.index') }}" class="nav-link sidebar-link-nested rounded-3 px-3 py-2 small {{ request()->routeIs('temps.index') ? 'active' : '' }}"><i class="bi bi-dot me-1 fs-4"></i>Consulter les intérimaires</a></li>
                </ul>
            </div>
        </div>
    @endif

    @if (auth()->user()->profile_id == 3)
        <div class="sidebar-section-title mt-3 mb-1 px-3">Performance</div>
        <div class="sidebar-group mb-3">
            <button class="btn sidebar-toggle w-100 d-flex align-items-center justify-content-between px-3 py-2 rounded-3 transition-base {{ request()->routeIs('performances.*') ? 'text-primary bg-primary-subtle' : '' }}"
                    type="button" data-bs-toggle="collapse" data-bs-target="#menuPerformance">
            <span class="d-flex align-items-center">
                <i class="bi bi-person-workspace me-2 fs-5"></i>
                <span class="sidebar-text fw-semibold">Évaluations Périodiques</span>
            </span>
                <i class="bi bi-chevron-down small transition-base"></i>
            </button>
            <div class="collapse {{ request()->routeIs('performances.*') ? 'show' : '' }}" id="menuPerformance">
                <ul class="nav flex-column ms-2 mt-1">
                    <li><a href="{{ route('chefs.index') }}" class="nav-link sidebar-link-nested rounded-3 px-3 py-2 small {{ request()->routeIs('chefs.index') ? 'active' : '' }}"><i class="bi bi-dot me-1 fs-4"></i>Remplir les tableaux</a></li>
                    <li><a href="{{ route('temps.index') }}" class="nav-link sidebar-link-nested rounded-3 px-3 py-2 small {{ request()->routeIs('temps.index') ? 'active' : '' }}"><i class="bi bi-dot me-1 fs-4"></i>Consulter l'évaluation</a></li>
                </ul>
            </div>
        </div>
    @endif


</nav>

<style>
    .transition-base { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .sidebar-section-title { font-size: 0.65rem; font-weight: 800; letter-spacing: 0.1em; text-transform: uppercase; color: #adb5bd; transition: 0.3s ease; }
    .sidebar-link, .sidebar-toggle { color: #4b5563; text-decoration: none; font-size: 0.9rem; white-space: nowrap; }
    .sidebar-link:hover, .sidebar-toggle:hover { background-color: #f8fafc; color: var(--primary-SaaS); }
    .sidebar-link.active { background: linear-gradient(135deg, var(--primary-SaaS) 0%, #7c3aed 100%); color: #ffffff !important; }
    .sidebar-link-nested { color: #6b7280; text-decoration: none; font-size: 0.85rem; }
    .sidebar-toggle[aria-expanded="true"] .arrow-icon { transform: rotate(180deg); }
    .bg-primary-subtle { background-color: #eef2ff !important; }

    /* Logic for compressed state inside the Nav */
    .sidebar-compressed .sidebar-text,
    .sidebar-compressed .sidebar-section-title span,
    .sidebar-compressed .arrow-icon {
        opacity: 0;
        visibility: hidden;
        width: 0;
        display: none;
    }

    .sidebar-compressed .sidebar-link,
    .sidebar-compressed .sidebar-toggle {
        justify-content: center !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    .sidebar-compressed .sidebar-section-title {
        text-align: center;
        border-bottom: 1px solid #f1f5f9;
        margin: 10px 0;
        height: 1px;
    }
</style>
