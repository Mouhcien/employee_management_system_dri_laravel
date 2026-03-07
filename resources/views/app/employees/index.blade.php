<x-layout>
    {{-- Custom Styles --}}
    <style>

        .details-row td {
            border-top: none;
        }

        .employee-row:hover {
            background-color: rgba(0,0,0,0.02);
        }


        .hover-primary:hover {
            color: #667eea !important;
        }

        .fw-mono {
            font-family: 'SF Mono', Monaco, monospace;
            font-size: 0.85em;
        }

        .object-fit-cover {
            object-fit: cover;
        }

        .dropdown-menu {
            border-radius: 0.75rem;
        }

        .dropdown-item {
            border-radius: 0.5rem;
            margin: 0.125rem 0.5rem;
            padding: 0.5rem 1rem;
        }

        .dropdown-item:hover {
            background-color: rgba(102, 126, 234, 0.1);
        }

        .btn-light {
            background-color: #f8f9fa;
            border-color: #e9ecef;
        }

        .btn-light:hover {
            background-color: #e9ecef;
            border-color: #dee2e6;
        }

        .badge {
            font-weight: 500;
            padding: 0.5em 0.75em;
        }

        .table th {
            letter-spacing: 0.5px;
        }

        .card {
            border-radius: 1rem;
        }

        .card-header {
            border-radius: 1rem 1rem 0 0 !important;
        }

        .rounded-4 {
            border-radius: 1rem !important;
        }

        .table tbody tr {
            border-left: 3px solid transparent;
        }

        .table tbody tr:hover {
            border-left-color: #667eea;
        }


        /* Status indicator pulse animation */
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(25, 135, 84, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(25, 135, 84, 0); }
            100% { box-shadow: 0 0 0 0 rgba(25, 135, 84, 0); }
        }

        .position-absolute.bg-success {
            animation: pulse 2s infinite;
        }

        .table-responsive {
            overflow-x: visible;  /* or hidden, instead of auto */
        }

        #employee-photo-preview {
            position: fixed;
            display: none;
            pointer-events: none;           /* mouse passes through */
            z-index: 2000;                  /* above table & dropdowns */
            padding: 6px;
            background: #fff;
            border-radius: 0.75rem;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.25);
            border: 1px solid rgba(148, 163, 184, 0.5);
        }

        #employee-photo-preview img {
            display: block;
            max-width: 360px;
            max-height: 360px;
            border-radius: 0.75rem;
            object-fit: cover;
        }

    </style>

    @section('title', 'Employees - HR Management')

    <div class="container-fluid py-4">
        {{-- Page Header with Gradient Background --}}
        <div class="bg-gradient-primary-to-secondary rounded-4 p-4 mb-4 text-white shadow-lg">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3">
                <div>
                    <h1 class="h3 mb-1 fw-bold"><i class="bi bi-people-fill me-2"></i>Gestion des Agents</h1>
                    <p class="text-white-50 small mb-0"><i class="bi bi-geo-alt-fill me-1"></i>DRI-Marrakech | Administration du personnel</p>
                </div>
                <a href="{{ route('employees.create') }}" class="btn btn-light btn-lg d-inline-flex align-items-center shadow-sm fw-semibold">
                    <i class="bi bi-plus-circle-fill me-2 text-primary"></i>
                    Nouvel employé
                </a>
            </div>
        </div>

        {{-- Statistics Cards --}}
        <div class="row g-3 mb-4">
            {{-- Total employés --}}
            <div class="col-md-3 col-sm-6">
                <div class="card border-0 shadow-sm h-100 bg-primary bg-opacity-10 border-start border-primary border-4">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-primary bg-opacity-25 rounded-3 p-3 text-primary">
                            <i class="bi bi-people fs-3"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="card-title text-muted small mb-1 text-uppercase">Total employés</h6>
                            <h4 class="mb-0 fw-bold text-primary">{{ $total_employee ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Femmes --}}
            <div class="col-md-3 col-sm-6">
                <div class="card border-0 shadow-sm h-100 bg-pink bg-opacity-10 border-start border-pink border-4">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-pink bg-opacity-25 rounded-3 p-3" style="color:#d63384;">
                            <i class="bi bi-gender-female fs-3"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="card-title text-muted small mb-1 text-uppercase">
                                <a href="#" class="text-decoration-none text-muted" id="sl_employee_female">
                                Femmes
                                </a>
                            </h6>
                            <h4 class="mb-0 fw-bold" style="color:#d63384;">{{ $femaleCount ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Hommes --}}
            <div class="col-md-3 col-sm-6">
                <div class="card border-0 shadow-sm h-100 bg-info bg-opacity-10 border-start border-info border-4">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-info bg-opacity-25 rounded-3 p-3 text-info">
                            <i class="bi bi-gender-male fs-3"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="card-title text-muted small mb-1 text-uppercase">
                                <a href="#" class="text-decoration-none text-muted" id="sl_employee_male">
                                    Hommes
                                </a>
                            </h6>
                            <h4 class="mb-0 fw-bold text-info">{{ $maleCount ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Locaux --}}
            <div class="col-md-3 col-sm-6">
                <div class="card border-0 shadow-sm h-100 bg-warning bg-opacity-10 border-start border-warning border-4">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-warning bg-opacity-25 rounded-3 p-3 text-warning">
                            <i class="bi bi-building fs-3"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="card-title text-muted small mb-1 text-uppercase">Locaux</h6>
                            <h4 class="mb-0 fw-bold text-warning">{{ $locals->count() ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- Filters --}}
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 text-muted"><i class="bi bi-funnel-fill me-2 text-info"></i>Filtres de recherche</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('employees.search') }}" class="row g-3">
                    @csrf
                    <div class="col-lg-3 col-md-6">
                        <label for="search" class="form-label small fw-semibold text-muted">Recherche</label>
                        <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted">
                            <i class="bi bi-search"></i>
                        </span>
                            <input type="text" name="employee_search" id="employee-search" value="{{ $filter_val ? $filter_val : '' }}"
                                   placeholder="Nom, prénom, email, PPR..." class="form-control border-start-0 bg-light">

                            {{-- spinner --}}
                            <span class="input-group-text bg-white" id="search-spinner" style="display:none;">
                                <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-12 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary flex-fill">
                            <i class="bi bi-funnel me-1"></i>Filtrer
                        </button>
                        <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary" title="Réinitialiser">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label for="department" class="form-label small fw-semibold text-muted">Local</label>
                        <select name="employee_id" id="sl_employee_local" class="form-select bg-light">
                            <option value="-1">Tous les locaux</option>
                            @foreach($locals as $local)
                                <option value="{{ $local->id }}" {{ $local_id == $local->id ? 'selected' : '' }}>
                                    {{ $local->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label for="status" class="form-label small fw-semibold text-muted">Ville</label>
                        <select name="city_id" id="sl_employee_city" class="form-select bg-light">
                            <option value=-1"">Toutes les villes</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}" {{ $city_id == $city->id ? 'selected' : '' }}>
                                    {{ $city->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-1 col-md-12 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-success flex-fill" title="Filtrer par untité structurelle">
                            <i class="bi bi-funnel me-1"></i>
                            <i class="bi bi-diagram-3-fill me-1"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Employees Table --}}
        <div class="card shadow border-0">

            <div class="table-responsive">
                @if (request()->has('opt'))
                    @include('app.employees._cards')
                @else
                    @include('app.employees._list')
                @endif
            </div>

            {{-- Pagination --}}
            @if(isset($employees) && $employees->hasPages())
                <div class="card-footer bg-white border-top py-3">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                        <div class="text-muted small">
                            Affichage de <span class="fw-bold text-dark">{{ $employees->firstItem() }}</span> à
                            <span class="fw-bold text-dark">{{ $employees->lastItem() }}</span> sur
                            <span class="fw-bold text-dark">{{ $employees->total() }}</span> employés
                        </div>
                        <div>
                            {{ $employees->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>

        @foreach($employees as $employee)
            <x-delete-model
                href="{{ route('employees.delete', $employee->id) }}"
                message="Voulez-vous vraiment supprimer ce agent ?"
                title="Confiramtion"
                target="deleteEmployeeModal" />
        @endforeach

    </div>

    <div id="employee-photo-preview">
        <img src="" alt="Aperçu employé">
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const previewBox = document.getElementById('employee-photo-preview');
            const previewImg = previewBox.querySelector('img');
            const offsetX = 20;  // distance from cursor
            const offsetY = 20;

            document.querySelectorAll('.employee-photo-thumb').forEach(function (img) {
                img.addEventListener('mouseenter', function (e) {
                    const src = img.dataset.full || img.src;
                    previewImg.src = src;
                    previewBox.style.display = 'block';
                    movePreview(e);
                });

                img.addEventListener('mousemove', function (e) {
                    movePreview(e);
                });

                img.addEventListener('mouseleave', function () {
                    previewBox.style.display = 'none';
                });
            });

            function movePreview(e) {
                const x = e.clientX + offsetX;
                const y = e.clientY + offsetY;

                previewBox.style.left = x + 'px';
                previewBox.style.top  = y + 'px';
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.employee-row').forEach(function (row) {
                row.addEventListener('click', function (e) {
                    // Ignore clicks on dropdown/links
                    if (e.target.closest('.dropdown-menu') || e.target.closest('.dropdown-toggle') || e.target.closest('a')) {
                        return;
                    }
                    const targetId = row.getAttribute('data-bs-target');
                    const detailsRow = document.querySelector(targetId);
                    if (!detailsRow) return;

                    const collapse = new bootstrap.Collapse(detailsRow, { toggle: true });

                    const icon = row.querySelector('.toggle-details i');
                    if (icon) {
                        icon.classList.toggle('bi-chevron-down');
                        icon.classList.toggle('bi-chevron-up');
                    }
                });
            });
        });
    </script>


</x-layout>
