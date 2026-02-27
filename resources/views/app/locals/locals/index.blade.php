<x-layout>
    @section('title', 'Gestion des locaux - HR Management')

    @section('content')
        <div class="d-flex flex-column gap-4">
            {{-- Page Header --}}
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3">
                <div>
                    <h1 class="h2 fw-bold text-dark mb-1">Gestion des locaux</h1>
                    <p class="text-muted mb-0">Gérez efficacement vos locaux et leurs associations</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('locals.create') }}" class="btn btn-primary d-inline-flex align-items-center fw-semibold">
                        <i class="bi bi-plus-circle me-2"></i>
                        Nouveau Local
                    </a>
                    <button class="btn btn-outline-secondary d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#bulkActions">
                        <i class="bi bi-download me-2"></i>
                        Exporter
                    </button>
                </div>
            </div>

            {{-- Stats Cards --}}
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="h2 fw-bold text-primary mb-1">{{ $locals->count() ?? 0 }}</div>
                            <div class="text-muted small">Locaux total</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="h2 fw-bold text-success mb-1">{{ $totalCities ?? 0 }}</div>
                            <div class="text-muted small">Villes</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="h2 fw-bold text-info mb-1">{{ $totalEmployees ?? 0 }}</div>
                            <div class="text-muted small">Employés</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="h2 fw-bold text-warning mb-1">{{ $activeLocals ?? 0 }}</div>
                            <div class="text-muted small">Locaux actifs</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Advanced Filters --}}
            <div class="card shadow-sm border-0">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h5 class="card-title mb-2"><i class="bi bi-funnel me-2"></i>Filtres & Recherche</h5>
                </div>
                <div class="card-body pt-0">
                    <form method="GET" action="{{ route('locals.index') }}" class="row g-3">
                        <div class="col-lg-4 col-md-6">
                            <label class="form-label small fw-semibold text-muted">Recherche</label>
                            <div class="position-relative">
                                <div class="position-absolute top-50 start-0 translate-middle-y ps-3">
                                    <i class="bi bi-search text-muted"></i>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}"
                                       class="form-control ps-5" placeholder="Nom du local ou ville...">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label small fw-semibold text-muted">Filtrer par ville</label>
                            <select name="department" class="form-select">
                                <option value="">Toutes les villes</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}" {{ request('department') == $city->id ? 'selected' : '' }}>
                                        {{ $city->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <label class="form-label small fw-semibold text-muted">Statut</label>
                            <select name="status" class="form-select">
                                <option value="">Tous</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Actif</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactif</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-6 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-primary flex-fill">
                                <i class="bi bi-funnel me-1"></i> Filtrer
                            </button>
                            <a href="{{ route('locals.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-clockwise"></i>
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Main Table --}}
            <div class="card shadow-lg border-0 overflow-hidden">
                <div class="card-header bg-white border-bottom py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-semibold">
                            <i class="bi bi-building text-primary me-2"></i>
                            Liste des locaux ({{ $locals->total() ?? 0 }})
                        </h5>
                        <div class="d-flex gap-2">
                            <div class="dropdown">
                                <button class="btn btn-outline-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                    <i class="bi bi-download me-1"></i>Exporter
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="#" class="dropdown-item text-success"><i class="bi bi-file-earmark-excel me-2"></i>Excel</a></li>
                                    <li><a href="#" class="dropdown-item text-success"><i class="bi bi-bar-chart me-2"></i>Statistiques Excel</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a href="#" class="dropdown-item text-danger"><i class="bi bi-file-earmark-pdf me-2"></i>PDF</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0 align-middle">
                        <thead class="table-light">
                        <tr>
                            <th class="border-0 py-3 px-4 text-start small fw-semibold text-muted text-uppercase ls-1">Local</th>
                            <th class="border-0 py-3 px-4 text-start small fw-semibold text-muted text-uppercase ls-1">Ville</th>
                            <th class="border-0 py-3 px-4 text-start small fw-semibold text-muted text-uppercase ls-1">Employés</th>
                            <th class="border-0 py-3 px-4 text-end small fw-semibold text-muted text-uppercase ls-1">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="border-top">
                        @forelse($locals ?? [] as $local)
                            <tr class="hover-table-row">
                                <td class="py-3 px-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3">
                                            <i class="bi bi-building fs-6"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark small">{{ $local->title }}</div>
                                            <div class="text-muted extra-small">{{ $local->created_at->format('d/m/Y') }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="fw-semibold text-primary">{{ $local->city->title ?? 'Non assignée' }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-success small px-3 py-2">{{ $local->employees_count ?? 0 }} employés</span>
                                        <span class="badge bg-info small">{{ ($local->employees_count ?? 0) * 0.9 }} actifs</span>
                                    </div>
                                </td>
                                <td class="py-3 px-4 text-end">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('locals.show', $local) }}" class="btn btn-sm btn-outline-primary" title="Voir">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('locals.edit', $local) }}" class="btn btn-sm btn-outline-success" title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a href="#" class="dropdown-item"><i class="bi bi-envelope me-2"></i>Email</a></li>
                                                <li><a href="#" class="dropdown-item"><i class="bi bi-file-earmark-pdf me-2"></i>PDF</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form method="POST" action="{{ route('locals.delete', $local) }}" class="d-inline" onsubmit="return confirm('Confirmer la suppression?')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="bi bi-trash me-2"></i>Supprimer
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center gap-3">
                                        <div class="avatar avatar-lg bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                            <i class="bi bi-building-fill fs-1 text-muted"></i>
                                        </div>
                                        <div>
                                            <h3 class="h4 fw-semibold text-muted mb-1">Aucun local trouvé</h3>
                                            <p class="text-muted mb-0">Commencez par ajouter votre premier local</p>
                                        </div>
                                        <a href="{{ route('locals.create') }}" class="btn btn-primary btn-lg px-4">
                                            <i class="bi bi-plus-circle me-2"></i>
                                            Ajouter un local
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>


                {{-- Pagination --}}
                {{--
                @if(isset($locals) && $locals->hasPages())
                    <div class="card-footer bg-white border-top py-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="small text-muted">
                                    Affichage de {{ $locals->firstItem() }} à {{ $locals->lastItem() }}
                                    sur {{ $locals->total() }} résultats
                                </div>
                            </div>
                            <div class="col-md-6">
                                <nav aria-label="Pagination">
                                    {{ $locals->appends(request()->query())->links([
                                        'class' => 'pagination-sm justify-content-end mb-0'
                                    ]) }}
                                </nav>
                            </div>
                        </div>
                    </div>
                @endif

                --}}
            </div>
        </div>

        {{-- Bulk Actions Modal --}}
        <div class="modal fade" id="bulkActions" tabindex="-1">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Exporter les données</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="list-group list-group-flush">
                            <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                                <i class="bi bi-file-earmark-excel text-success me-3 fs-4"></i>
                                <div>
                                    <div class="fw-semibold">Excel complet</div>
                                    <small class="text-muted">Tous les locaux et statistiques</small>
                                </div>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                                <i class="bi bi-bar-chart text-success me-3 fs-4"></i>
                                <div>
                                    <div class="fw-semibold">Statistiques Excel</div>
                                    <small class="text-muted">Graphiques et résumés</small>
                                </div>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                                <i class="bi bi-file-earmark-pdf text-danger me-3 fs-4"></i>
                                <div>
                                    <div class="fw-semibold">Rapport PDF</div>
                                    <small class="text-muted">Document professionnel</small>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('styles')
        <style>
            .hover-table-row:hover {
                background-color: rgba(0,123,255,.075) !important;
                transform: scale(1.001);
                transition: all 0.2s ease;
            }
            .avatar {
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }
            .avatar-sm { font-size: .875em; }
            .avatar-lg { font-size: 1.25em; }
            .ls-1 { letter-spacing: 0.025em; }
            .extra-small { font-size: .75em; }
            .table th:first-child, .table td:first-child { border-left: 0; }
            .table th:last-child, .table td:last-child { border-right: 0; }
        </style>
    @endpush
</x-layout>
