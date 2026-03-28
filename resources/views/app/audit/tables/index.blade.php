<x-layout>
    <style>
        /* --- SaaS Consolidated Styles --- */
        :root {
            --saas-primary: #0061f2;
            --saas-secondary: #0a2351;
            --saas-bg-soft: #f8f9fa;
        }

        /* Header Gradient & Card Shapes */
        .profile-header-custom {
            background: linear-gradient(135deg, var(--saas-primary) 0%, var(--saas-secondary) 100%);
            border-radius: 16px;
        }

        .card-saas {
            border: 1px solid rgba(0,0,0,.05);
            border-radius: 12px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card-saas:hover {
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08) !important;
        }

        /* Typography & Badges */
        .text-tracking { letter-spacing: 0.5px; }
        .x-small { font-size: 0.75rem; }

        .bg-success-soft { background-color: rgba(25, 135, 84, 0.1); color: #198754; }
        .bg-info-soft { background-color: rgba(13, 202, 240, 0.1); color: #0dcaf0; }

        .btn-white {
            background: white;
            color: var(--saas-primary);
            border: 1px solid transparent;
        }
        .btn-white:hover { background: #f1f4f9; }

        /* Table & Lists */
        .hover-bg-light:hover { background-color: var(--saas-bg-soft); }
        .border-dashed { border-style: dashed !important; border-width: 2px !important; }

        /* Skeleton Loader for SaaS feel */
        .skeleton-line {
            height: 10px;
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
            border-radius: 4px;
            width: 60%;
        }

        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
    </style>

    <div class="card profile-header-custom border-0 shadow-sm mb-4 text-white overflow-hidden">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-7 d-flex align-items-center">
                    <div class="bg-primary bg-opacity-20 p-3 rounded-3 me-3">
                        <i class="bi bi-grid-3x3-gap-fill fs-3"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-0">Tableaux de Suivi</h3>
                        <p class="mb-0 text-white-50 small">Gestion centralisée de vos structures de données</p>
                    </div>
                </div>
                <div class="col-md-5 text-md-end mt-3 mt-md-0">
                    <a href="{{ route('audit.tables.create') }}" class="btn btn-white fw-bold shadow-sm px-4">
                        <i class="bi bi-plus-lg me-2"></i>Nouveau tableau
                    </a>
                    <button class="btn btn-outline-light border-0 ms-1" title="Exporter">
                        <i class="bi bi-download"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-saas shadow-sm border-0">
        <div class="card-header bg-transparent border-bottom py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-dark">Répertoire des Tableaux</h5>
            <span class="badge bg-info-soft px-3 py-2 rounded-pill fw-bold">{{ $tables->count() }} total</span>
        </div>

        <div class="card-body p-0">
            @forelse($tables as $table)
                <div class="p-4 border-bottom hover-bg-light transition">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <span class="badge bg-success-soft rounded-pill px-3 py-2 fw-semibold">
                                    <i class="bi bi-table me-2"></i>{{ $table->title }}
                                </span>
                            </div>
                            <p class="text-muted small mb-0 d-none d-md-block">
                                <i class="bi bi-info-circle me-1"></i> {{ $table->description ?: 'Sans description' }}
                            </p>
                        </div>

                        <div class="dropdown">
                            <button class="btn btn-light btn-sm rounded-circle shadow-sm" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg">
                                <li><a class="dropdown-item py-2" href="{{ route('audit.tables.edit', $table) }}"><i class="bi bi-pencil me-2 text-muted"></i>Modifier</a></li>
                                <li><hr class="dropdown-divider opacity-50"></li>
                                <li><a class="dropdown-item py-2 text-danger" href="#"><i class="bi bi-trash me-2"></i>Supprimer</a></li>
                            </ul>
                        </div>
                    </div>

                    @if ($table->relations->count() != 0)
                        <div class="table-responsive rounded-3 border border-light-subtle bg-white p-1">
                            <table class="table table-hover mb-0 align-middle">
                                <thead class="table-light">
                                <tr>
                                    @foreach($table->relations->unique('column_id') as $relation)
                                        <th class="text-uppercase x-small fw-bold text-secondary text-tracking px-4 py-3">
                                            {{ $relation->column->title }}
                                        </th>
                                    @endforeach
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    @foreach($table->relations->unique('column_id') as $relation)
                                        <td class="px-4 py-3">
                                            <div class="skeleton-line"></div>
                                        </td>
                                    @endforeach
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="bg-light rounded-4 p-4 text-center border border-dashed border-secondary-subtle">
                            <i class="bi bi-layout-sidebar-inset text-muted opacity-50 fs-2"></i>
                            <p class="text-muted mb-0 mt-2 small">Aucune colonne n'a été attribuée à ce tableau.</p>
                            <button class="btn btn-sm btn-link fw-bold text-decoration-none mt-1">Ajouter des colonnes</button>
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center py-5">
                    <img src="https://illustrations.popsy.co/gray/data-report.svg" alt="Empty" style="width: 140px;" class="mb-3 opacity-50">
                    <h5 class="text-muted fw-bold">Aucun tableau trouvé</h5>
                    <p class="small text-secondary mb-0">Commencez par créer votre premier tableau de suivi.</p>
                </div>
            @endforelse
        </div>

        @if($tables instanceof \Illuminate\Pagination\AbstractPaginator && $tables->hasPages())
            <div class="card-footer bg-transparent border-top-0 py-4 px-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                    <div class="text-muted small">
                        Affichage de <span class="fw-bold text-dark">{{ $tables->firstItem() }}</span> à <span class="fw-bold text-dark">{{ $tables->lastItem() }}</span> sur <span class="fw-bold text-dark">{{ $tables->total() }}</span>
                    </div>
                    <div>
                        {{ $tables->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-layout>
