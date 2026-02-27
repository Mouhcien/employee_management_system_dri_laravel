<x-layout>
    @section('title', 'Gestion des services - HR Management')

    @section('content')
        <div class="d-flex flex-column gap-4">
            {{-- Page Header --}}
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3">
                <div>
                    <h1 class="h2 fw-bold text-dark mb-1">Gestion des services</h1>
                    <p class="text-muted mb-0">Organisez et gérez efficacement votre structure de services</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('services.create') }}" class="btn btn-primary d-inline-flex align-items-center fw-semibold">
                        <i class="bi bi-plus-circle me-2"></i>
                        Nouveau Service
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
                            <div class="h2 fw-bold text-primary mb-1">{{ $services->count() ?? 0 }}</div>
                            <div class="text-muted small">Services total</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="h2 fw-bold text-success mb-1">{{ $totalEntities ?? 0 }}</div>
                            <div class="text-muted small">Entités</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="h2 fw-bold text-info mb-1">{{ $totalSectors ?? 0 }}</div>
                            <div class="text-muted small">Secteurs</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="h2 fw-bold text-warning mb-1">{{ $activeServices ?? 0 }}</div>
                            <div class="text-muted small">Services actifs</div>
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
                    <form method="GET" action="{{ route('services.index') }}" class="row g-3">
                        <div class="col-lg-4 col-md-6">
                            <label class="form-label small fw-semibold text-muted">Recherche</label>
                            <div class="position-relative">
                                <div class="position-absolute top-50 start-0 translate-middle-y ps-3">
                                    <i class="bi bi-search text-muted"></i>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}"
                                       class="form-control ps-5" placeholder="Nom du service...">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label small fw-semibold text-muted">Département</label>
                            <select name="department" class="form-select">
                                <option value="">Tous les départements</option>
                                <option value="engineering" {{ request('department') == 'engineering' ? 'selected' : '' }}>Engineering</option>
                                <option value="sales" {{ request('department') == 'sales' ? 'selected' : '' }}>Sales & Marketing</option>
                                <option value="operations" {{ request('department') == 'operations' ? 'selected' : '' }}>Operations</option>
                                <option value="hr" {{ request('department') == 'hr' ? 'selected' : '' }}>HR & Finance</option>
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
                            <a href="{{ route('services.index') }}" class="btn btn-outline-secondary">
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
                            <i class="bi bi-journal-text text-primary me-2"></i>
                            Liste des services ({{ $services->total() ?? 0 }})
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
                            <th class="border-0 py-3 px-4 text-start small fw-semibold text-muted text-uppercase ls-1">ID</th>
                            <th class="border-0 py-3 px-4 text-start small fw-semibold text-muted text-uppercase ls-1">Service</th>
                            <th class="border-0 py-3 px-4 text-start small fw-semibold text-muted text-uppercase ls-1">Entités</th>
                            <th class="border-0 py-3 px-4 text-end small fw-semibold text-muted text-uppercase ls-1">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="border-top">
                        @forelse($services ?? [] as $service)
                            <tr class="hover-table-row">
                                <td class="py-3 px-4">
                                    <div class="badge bg-light text-dark fs-6 px-3 py-2">{{ $service->id }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3">
                                            <i class="bi bi-journal-text fs-6"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark small">{{ $service->title }}</div>
                                            <div class="text-muted extra-small">{{ $service->created_at->format('d/m/Y') }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="d-flex align-items-center gap-2 flex-wrap">
                                        @if(isset($service->entities_count))
                                            <span class="badge bg-success small px-3 py-2">{{ $service->entities_count }} entités</span>
                                        @endif
                                        @if(isset($service->sectors_count))
                                            <span class="badge bg-info small">{{ $service->sectors_count }} secteurs</span>
                                        @endif
                                        @if(isset($service->sections_count))
                                            <span class="badge bg-warning small">{{ $service->sections_count }} sections</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3 px-4 text-end">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('services.show', $service) }}" class="btn btn-sm btn-outline-primary" title="Voir">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('services.edit', $service) }}" class="btn btn-sm btn-outline-success" title="Modifier">
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
                                                    <form method="POST" action="{{ route('services.delete', $service) }}" class="d-inline" onsubmit="return confirm('Confirmer la suppression?')">
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
                                            <i class="bi bi-journal-text-fill fs-1 text-muted"></i>
                                        </div>
                                        <div>
                                            <h3 class="h4 fw-semibold text-muted mb-1">Aucun service trouvé</h3>
                                            <p class="text-muted mb-0">Commencez par ajouter votre premier service</p>
                                        </div>
                                        <a href="{{ route('services.create') }}" class="btn btn-primary btn-lg px-4">
                                            <i class="bi bi-plus-circle me-2"></i>
                                            Ajouter un service
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if(isset($services) && $services->hasPages())
                    <div class="card-footer bg-white border-top py-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="small text-muted">
                                    Affichage {{ $services->firstItem() }} à {{ $services->lastItem() }}
                                    sur {{ $services->total() }} résultats
                                </div>
                            </div>
                            <div class="col-md-6">
                                <nav aria-label="Pagination">
                                    {{--
                                    {{ $services->appends(request()->query())->links([
                                        'class' => 'pagination pagination-sm justify-content-end mb-0'
                                    ]) }}
                                    --}}
                                    {{ $services->links() }}
                                </nav>
                            </div>
                        </div>
                    </div>
                @endif
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
                                    <small class="text-muted">Tous les services et hiérarchie</small>
                                </div>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                                <i class="bi bi-bar-chart text-success me-3 fs-4"></i>
                                <div>
                                    <div class="fw-semibold">Statistiques Excel</div>
                                    <small class="text-muted">Organigramme et métriques</small>
                                </div>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                                <i class="bi bi-file-earmark-pdf text-danger me-3 fs-4"></i>
                                <div>
                                    <div class="fw-semibold">Rapport PDF</div>
                                    <small class="text-muted">Structure organisationnelle</small>
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
