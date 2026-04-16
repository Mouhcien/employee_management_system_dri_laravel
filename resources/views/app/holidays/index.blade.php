<x-layout>
    <div class="container-fluid py-4 px-5">
        <div class="row align-items-center mb-4">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1 text-uppercase small">
                        <li class="breadcrumb-item">Ressources Humaines</li>
                        <li class="breadcrumb-item active">Gestion des Absences</li>
                    </ol>
                </nav>
                <h2 class="fw-bold text-dark">
                    <i class="bi bi-compass text-primary me-2"></i>Suivi des Congés : Agents Communaux & Détachés
                </h2>
            </div>
            <div class="col-auto">
                <button class="btn btn-outline-secondary me-2 shadow-sm">
                    <i class="bi bi-download me-1"></i> Exporter (PDF)
                </button>
                <a href="{{ route('holidays.create') }}" class="btn btn-primary px-4 shadow-sm fw-bold">
                    <i class="bi bi-plus-lg me-1"></i> Enregistrer un Arrêté
                </a>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm border-start border-primary border-4">
                    <div class="card-body">
                        <h6 class="text-muted small text-uppercase fw-bold">Agents Communaux</h6>
                        <div class="d-flex align-items-center mt-2">
                            <i class="bi bi-person-badge fs-3 text-primary me-3"></i>
                            <span class="h3 mb-0 fw-bold">{{ $holidays->where('employee.category_id', 2)->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm border-start border-info border-4">
                    <div class="card-body">
                        <h6 class="text-muted small text-uppercase fw-bold">Agents en Détachement</h6>
                        <div class="d-flex align-items-center mt-2">
                            <i class="bi bi-arrow-left-right fs-3 text-info me-3"></i>
                            <span class="h3 mb-0 fw-bold">{{ $holidays->where('employee.category_id', 3)->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm border-start border-warning border-4">
                    <div class="card-body">
                        <h6 class="text-muted small text-uppercase fw-bold">Total Jours à Apurer</h6>
                        <div class="d-flex align-items-center mt-2">
                            <i class="bi bi-hourglass-split fs-3 text-warning me-3"></i>
                            <span class="h3 mb-0 fw-bold text-warning">{{ $holidays->sum('total_rest') }}j</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="card-header bg-white py-3 border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-secondary">Registres de l'année {{ now()->year }}</h5>
                    <div class="d-flex gap-2">
                        <div class="input-group input-group-sm" style="width: 300px;">
                            <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                            <input type="text" id="searchInput" class="form-control" placeholder="Nom, Prénom, PPR ou CIN...">
                        </div>

                        <select class="form-select form-select-sm" id="filterCategory" style="width: 180px;">
                            <option value="all">Tous les statuts</option>
                            <option value="2">Agents Communaux</option>
                            <option value="3">Agents Détachés</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="holidaysTable">
                    <thead class="table-light">
                    <tr class="text-muted small">
                        <th class="ps-4">AGENT / MATRICULE</th>
                        <th>STATUT</th>
                        <th>ANNÉE</th>
                        <th class="text-center">DROIT INITIAL</th>
                        <th class="text-center">UTILISÉ</th>
                        <th>RELIQUAT DISPONIBLE</th>
                        <th>DATE EFFET</th>
                        <th class="text-end pe-4">ACTION</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($holidays as $holiday)
                        <tr class="holiday-row"
                            data-category="{{ $holiday->employee->category_id }}"
                            data-search="{{ strtolower($holiday->employee->lastname . ' ' . $holiday->employee->firstname . ' ' . $holiday->employee->ppr . ' ' . $holiday->employee->cin) }}">
                            <td class="ps-4">
                                @include('app.employees.partials.employee_panel', ['employee' => $holiday->employee])
                            </td>
                            <td>
                                @if($holiday->employee->category_id == 3)
                                    <span class="badge rounded-pill bg-info-soft text-info border border-info border-opacity-25">Détaché</span>
                                @else
                                    <span class="badge rounded-pill bg-primary-soft text-primary border border-primary border-opacity-25">Communal</span>
                                @endif
                            </td>
                            <td class="text-muted">{{ $holiday->year }}</td>
                            <td class="text-center fw-bold text-dark">{{ $holiday->total_year }}j</td>
                            <td class="text-center text-danger fw-semibold">-{{ $holiday->demand }}j</td>
                            <td>
                                <span class="fw-bold {{ $holiday->total_rest < 3 ? 'text-danger' : 'text-success' }}">
                                    {{ $holiday->total_rest }} jours
                                </span>
                            </td>
                            <td>
                                <span class="text-muted"><i class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($holiday->starting_date)->format('d/m/Y') }}</span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('employees.holiday.certificate', $holiday->employee->id) }}" class="btn btn-sm btn-light border" target="_blank">
                                    <i class="bi bi-eye me-1"></i> Décision
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        .bg-primary-soft { background-color: rgba(13, 110, 253, 0.1); }
        .bg-info-soft { background-color: rgba(13, 202, 240, 0.1); }
        .table thead th { border-top: none; }
        .breadcrumb-item + .breadcrumb-item::before { content: "›"; }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
                const filterSelect = document.getElementById('filterCategory');
                const searchInput = document.getElementById('searchInput');
                const rows = document.querySelectorAll('.holiday-row');

                function filterTable() {
                    const categoryValue = filterSelect.value;
                    const searchTerm = searchInput.value.toLowerCase().trim();

                    rows.forEach(row => {
                        const rowCategory = row.getAttribute('data-category');
                        const searchData = row.getAttribute('data-search');

                        // Vérification de la catégorie
                        const matchCategory = (categoryValue === 'all' || rowCategory === categoryValue);

                        // Vérification du texte (Nom, Prénom, PPR, CIN)
                        const matchSearch = (searchTerm === '' || searchData.includes(searchTerm));

                        // On affiche la ligne seulement si les deux conditions sont vraies
                        if (matchCategory && matchSearch) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                }

                // Écouteurs d'événements
                filterSelect.addEventListener('change', filterTable);
                searchInput.addEventListener('input', filterTable);
            });
    </script>
</x-layout>
