{{-- resources/views/components/top-nav.blade.php --}}
<nav class="navbar navbar-expand-lg bg-white border-bottom py-2 shadow-sm sticky-top">
    <div class="container-fluid px-4">

        <a class="navbar-brand d-flex align-items-center me-5" href="{{ route('dashboard0') }}" style="text-decoration: none;">
            <div class="brand-accent border-start border-primary border-4 ps-3">
                <div class="brand-text">
                <span class="d-block fw-bold text-dark lh-sm" style="font-size: 0.95rem;">
                    DIRECTION RÉGIONALE
                </span>
                    <span class="d-block fw-semibold text-primary" style="font-size: 0.85rem; letter-spacing: 0.5px;">
                    Des Impôts Marrakech
                </span>
                </div>
            </div>
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
                        <li><a class="dropdown-item rounded-3 py-2 {{ request()->routeIs('employees.index') ? 'active' : '' }}" href="{{ route('employees.index') }}"><i class="bi bi-list me-1 fs-4"></i>Annuaire</a></li>
                        <li><a class="dropdown-item rounded-3 py-2 {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}"><i class="bi bi-person me-1 fs-4"></i>Catégories</a></li>
                        <li><a class="dropdown-item rounded-3 py-2 {{ request()->routeIs('employees.status') ? 'active' : '' }}" href="{{ route('employees.status') }}"><i class="bi bi-layers me-1 fs-4"></i>Status</a></li>
                    </ul>
                </li>

                {{-- Dropdown: NOMENCLATURE --}}
                @if (auth()->user()->profile_id == 1 || auth()->user()->profile_id == 5)
                <li class="nav-item dropdown">
                    @php $isReferencial = request()->routeIs('occupations.*') || request()->routeIs('grades.*') || request()->routeIs('diplomas.*') || request()->routeIs('options.*'); @endphp
                    <a class="nav-link px-3 py-2 d-flex align-items-center rounded-3 dropdown-toggle transition-base
                              {{ $isReferencial ? 'active-link' : 'text-secondary' }}"
                       href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-bookmark-star-fill me-2"></i>
                        <span class="fw-semibold">Nomenclature</span>
                    </a>
                    <ul class="dropdown-menu border-0 shadow-lg p-2 rounded-4 mt-2">
                        <li><a class="dropdown-item rounded-3 py-2 {{ request()->routeIs('occupations.*') ? 'active' : '' }}" href="{{ route('occupations.index') }}"><i class="bi bi-briefcase me-1 fs-4"></i>Fonctions</a></li>
                        <li><a class="dropdown-item rounded-3 py-2 {{ request()->routeIs('grades.*') ? 'active' : '' }}" href="{{ route('grades.index') }}"><i class="bi bi-patch-check me-1 fs-4"></i>Grades</a></li>
                        <li><a class="dropdown-item rounded-3 py-2 {{ request()->routeIs('diplomas.*') ? 'active' : '' }}" href="{{ route('diplomas.index') }}"><i class="bi bi-award me-1 fs-4"></i>Diplômes</a></li>
                        <li><a class="dropdown-item rounded-3 py-2 {{ request()->routeIs('options.*') ? 'active' : '' }}" href="{{ route('options.index') }}"><i class="bi bi-journals me-1 fs-4"></i>Filières</a></li>
                    </ul>
                </li>
                @endif

                {{-- Dropdown: LOCALISATION --}}
                @if (auth()->user()->profile_id == 1 || auth()->user()->profile_id == 5)
                <li class="nav-item dropdown">
                    <a class="nav-link px-3 py-2 d-flex align-items-center rounded-3 dropdown-toggle transition-base
                              {{ request()->routeIs('locals.*') || request()->routeIs('cities.*') ? 'active-link' : 'text-secondary' }}"
                       href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-geo-alt-fill me-2"></i>
                        <span class="fw-semibold">Localisation</span>
                    </a>
                    <ul class="dropdown-menu border-0 shadow-lg p-2 rounded-4 mt-2">
                        <li><a class="dropdown-item rounded-3 py-2 {{ request()->routeIs('locals.*') ? 'active' : '' }}" href="{{ route('locals.index') }}"><i class="bi bi-building me-1 fs-4"></i>Locaux</a></li>
                        <li><a class="dropdown-item rounded-3 py-2 {{ request()->routeIs('cities.*') ? 'active' : '' }}" href="{{ route('cities.index') }}"><i class="bi bi-geo-alt me-1 fs-4"></i>Villes</a></li>
                    </ul>
                </li>
                @endif

                {{-- Dropdown: UNITÉS --}}
                @if (auth()->user()->profile_id == 1 || auth()->user()->profile_id == 5)
                <li class="nav-item dropdown">
                    @php $isOrg = request()->routeIs('services.*') || request()->routeIs('entities.*') || request()->routeIs('sectors.*') || request()->routeIs('sections.*'); @endphp
                    <a class="nav-link px-3 py-2 d-flex align-items-center rounded-3 dropdown-toggle transition-base
                              {{ $isOrg ? 'active-link' : 'text-secondary' }}"
                       href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-diagram-3-fill me-2"></i>
                        <span class="fw-semibold">Unités</span>
                    </a>
                    <ul class="dropdown-menu border-0 shadow-lg p-2 rounded-4 mt-2">
                        <li><a class="dropdown-item rounded-3 py-2 {{ request()->routeIs('services.*') ? 'active' : '' }}" href="{{ route('services.index') }}"><i class="bi bi-diagram-3 me-1 fs-4"></i>Services</a></li>
                        <li><a class="dropdown-item rounded-3 py-2 {{ request()->routeIs('entities.*') ? 'active' : '' }}" href="{{ route('entities.index') }}"><i class="bi bi-diagram-2 me-1 fs-4"></i>Entités</a></li>
                        <li><a class="dropdown-item rounded-3 py-2 {{ request()->routeIs('sectors.*') ? 'active' : '' }}" href="{{ route('sectors.index') }}"><i class="bi bi-grid-1x2 me-1 fs-4"></i>Secteurs</a></li>
                        <li><a class="dropdown-item rounded-3 py-2 {{ request()->routeIs('sections.*') ? 'active' : '' }}" href="{{ route('sections.index') }}"><i class="bi bi-list-nested me-1 fs-4"></i>Sections</a></li>
                    </ul>
                </li>
                @endif

                {{-- Dropdown: HIÉRARCHIE --}}
                @if (auth()->user()->profile_id == 1 || auth()->user()->profile_id == 5)
                <li class="nav-item dropdown">
                    <a class="nav-link px-3 py-2 d-flex align-items-center rounded-3 dropdown-toggle transition-base
                              {{ request()->routeIs('chefs.*') || request()->routeIs('temps.*') ? 'active-link' : 'text-secondary' }}"
                       href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-workspace me-2"></i>
                        <span class="fw-semibold">Hiérarchie</span>
                    </a>
                    <ul class="dropdown-menu border-0 shadow-lg p-2 rounded-4 mt-2">
                        <li><a class="dropdown-item rounded-3 py-2 {{ request()->routeIs('chefs.*') ? 'active' : '' }}" href="{{ route('chefs.index') }}"><i class="bi bi-person-workspace me-1 fs-4"></i>Chefs</a></li>
                        <li><a class="dropdown-item rounded-3 py-2 {{ request()->routeIs('temps.*') ? 'active' : '' }}" href="{{ route('temps.index') }}"><i class="bi bi-hourglass-split me-1 fs-4"></i>Intérimaires</a></li>
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
                            <li><a class="dropdown-item rounded-3 py-2 {{ request()->routeIs('audit.tables.*') ? 'active' : '' }}" href="{{ route('audit.tables.index') }}"><i class="bi bi-table me-1 fs-4"></i>Tableaux de suivi</a></li>
                            <li><a class="dropdown-item rounded-3 py-2 {{ request()->routeIs('audit.periods.*') ? 'active' : '' }}" href="{{ route('audit.periods.index') }}"><i class="bi bi-calendar-check me-1 fs-4"></i>Périodes de suivi</a></li>
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
                            <li><a class="dropdown-item rounded-3 py-2 {{ request()->routeIs('audit.values.index') ? 'active' : '' }}" href="{{ route('audit.values.index') }}"><i class="bi bi-database-add me-1 fs-4"></i>Évaluations Périodiques</a></li>
                            <li><a class="dropdown-item rounded-3 py-2 {{ request()->routeIs('audit.values.consult') ? 'active' : '' }}" href="{{ route('audit.values.consult') }}"><i class="bi bi-bar-chart-steps me-1 fs-4"></i>Consulter l'évaluation</a></li>
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
                            <li><a class="dropdown-item rounded-3 py-2 {{ request()->routeIs('audit.values.select') ? 'active' : '' }}" href="{{ route('audit.values.select') }}"><i class="bi bi-person-workspace me-1 fs-4"></i>Superviser l'évaluation</a></li>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('mainSearch');
        const resultBox = document.getElementById('box_result_search');
        const resultContent = document.getElementById('searchContent');

        function debounce(func, timeout = 300) {
            let timer;
            return (...args) => {
                clearTimeout(timer);
                timer = setTimeout(() => {
                    func.apply(this, args);
                }, timeout);
            };
        }

        async function performSearch(query) {
            // Trim whitespace to prevent empty searches
            const cleanQuery = query.trim();

            if (cleanQuery.length < 2) {
                resultBox.classList.add('d-none');
                return;
            }

            try {
                const response = await fetch(`/search/?q=${encodeURIComponent(cleanQuery)}`);
                if (!response.ok) throw new Error('Network response error');

                const data = await response.json();

                // Reveal the box before rendering
                resultBox.classList.remove('d-none');
                renderCategorizedResults(data);
            } catch (error) {
                console.error("Erreur:", error);
                resultContent.innerHTML = '<div class="p-3 text-danger small">Erreur de connexion.</div>';
                resultBox.classList.remove('d-none');
            }
        }

        const processChange = debounce((e) => performSearch(e.target.value));
        searchInput.addEventListener('input', processChange);

        function renderCategorizedResults(matches) {
            if (matches.length === 0) {
                resultContent.innerHTML = '<div class="p-3 text-muted text-center">Aucun résultat trouvé.</div>';
                return;
            }

            const grouped = matches.reduce((acc, obj) => {
                const key = obj.display_category || 'Autres';
                if (!acc[key]) acc[key] = [];
                acc[key].push(obj);
                return acc;
            }, {});

            let html = '';

            for (const category in grouped) {
                const categoryItems = grouped[category];
                html += `
            <div class="row w-100 py-2 m-0 align-items-start">
                <div class="col-4 fw-bold text-secondary text-uppercase" style="font-size: 0.75rem;">
                    ${category} <span class="badge bg-info ms-1">${categoryItems.length}</span>
                </div>
                <div class="col-8">
                    ${categoryItems.map(item => {
                    // Secure the JSON string for the onclick attribute
                    const safeData = JSON.stringify(item).replace(/"/g, '&quot;');
                    return `
                            <div class="search-result-item mb-2 p-2 rounded"
                                 style="cursor:pointer;"
                                 onclick="handleSelect(${safeData})">
                                <div class="fw-bold text-dark" style="font-size: 0.9rem;">
                                <a href="${item.url}" >${item.display_name}</a>
                                </div>
                                <div class="text-muted" style="font-size: 0.8rem;">${item.display_info}</div>
                            </div>`;
                }).join('')}
                </div>
            </div>
            <hr class="my-1 text-secondary opacity-25">
        `;
            }

            resultContent.innerHTML = html;
        }
    });
</script>
