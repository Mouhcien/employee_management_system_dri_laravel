<x-layout>
    @section('title', 'Gestion des villes - HR Management')

        <div class="d-flex flex-column gap-4">
            {{-- Page Header --}}
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3">
                <div>
                    <h1 class="h2 fw-bold text-dark mb-1">Gestion des villes de la région</h1>
                    <p class="text-muted mb-0">Gérez efficacement vos villes et leurs locaux associés</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-primary d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#createCityModal">
                        <i class="bi bi-plus-circle me-2"></i>
                        Nouvelle Ville
                    </button>
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
                            <div class="h2 fw-bold text-primary mb-1">{{ $total ?? 0 }}</div>
                            <div class="text-muted small">Villes totales</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="h2 fw-bold text-success mb-1">{{ $total_locals ?? 0 }}</div>
                            <div class="text-muted small">Locaux</div>
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
                            <div class="h2 fw-bold text-warning mb-1">{{ $activeCities ?? 0 }}</div>
                            <div class="text-muted small">Villes actives</div>
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
                    <form method="GET" action="{{ route('cities.index') }}" class="row g-3">
                        <div class="col-lg-4 col-md-6">
                            <label class="form-label small fw-semibold text-muted">Recherche</label>
                            <div class="position-relative">
                                <div class="position-absolute top-50 start-0 translate-middle-y ps-3">
                                    <i class="bi bi-search text-muted"></i>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}"
                                       class="form-control ps-5" placeholder="Nom de ville ou local...">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <label class="form-label small fw-semibold text-muted">Filtrer par local</label>
                            <select name="department" class="form-select">
                                <option value="">Tous les locaux</option>
                                @foreach($locals as $local)
                                    <option value="{{ $local->id }}" {{ request('department') == $local->id ? 'selected' : '' }}>
                                        {{ $local->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-6 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-primary flex-fill">
                                <i class="bi bi-funnel me-1"></i> Filtrer
                            </button>
                            <a href="{{ route('cities.index') }}" class="btn btn-outline-secondary">
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
                            <i class="bi bi-geo-alt-fill text-primary me-2"></i>
                            Liste des villes ({{ $cities->total() ?? 0 }})
                        </h5>
                        <div class="d-flex gap-2">
                            <div class="dropdown">
                                <button class="btn btn-outline-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                    <i class="bi bi-download me-1"></i>Exporter
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="#" class="dropdown-item text-success"><i class="bi bi-file-earmark-excel me-2"></i>Excel</a></li>
                                    <li><a href="#" class="dropdown-item text-success"><i class="bi bi-file-earmark-excel me-2"></i>Statistiques Excel</a></li>
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
                            <th class="border-0 py-3 px-4 text-start small fw-semibold text-muted text-uppercase ls-1">Ville</th>
                            <th class="border-0 py-3 px-4 text-start small fw-semibold text-muted text-uppercase ls-1">Locaux</th>
                            <th class="border-0 py-3 px-4 text-start small fw-semibold text-muted text-uppercase ls-1">Employés</th>
                            <th class="border-0 py-3 px-4 text-end small fw-semibold text-muted text-uppercase ls-1">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="border-top">
                        @forelse($cities ?? [] as $city)
                            <tr class="hover-table-row">
                                <td class="py-3 px-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3">
                                            <i class="bi bi-geo-alt fs-6"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark small">{{ $city->title }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    @if($city->locals->count() > 0)
                                        <div class="d-flex flex-column gap-1">
                                            @foreach($city->locals as $local)
                                                <span class="badge bg-light text-dark small px-2 py-1 rounded-pill">
                                                    {{ $local->title }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="badge bg-secondary small px-3 py-2">Aucun local</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-success small px-3 py-2">{{ $city->employees_count ?? 0 }} employés</span>
                                        <span class="badge bg-info small">{{ $city->active_employees ?? 0 }} actifs</span>
                                    </div>
                                </td>
                                <td class="py-3 px-4 text-end">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('cities.show', $city) }}" class="btn btn-sm btn-outline-primary" title="Voir">
                                            <i class="bi bi-eye"></i>
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
                                                    <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteCityModal">
                                                        <i class="bi bi-trash me-2"></i>Supprimer
                                                    </button>
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
                                            <i class="bi bi-geo-alt-fill fs-1 text-muted"></i>
                                        </div>
                                        <div>
                                            <h3 class="h4 fw-semibold text-muted mb-1">Aucune ville trouvée</h3>
                                            <p class="text-muted mb-0">Commencez par ajouter votre première ville</p>
                                        </div>
                                        <button class="btn btn-primary d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#createCityModal">
                                            <i class="bi bi-plus-circle me-2"></i>
                                            Nouvelle Ville
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if(isset($cities) && $cities->hasPages())
                    <div class="card-footer bg-white border-top py-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="small text-muted">
                                    Affichage de {{ $cities->firstItem() }} à {{ $cities->lastItem() }}
                                    sur {{ $cities->total() }} résultats
                                </div>
                            </div>
                            <div class="col-md-6">
                                <nav aria-label="Pagination">
                                    {{--
                                    {{ $cities->appends(request()->query())->links([
                                        'class' => 'pagination-sm justify-content-end mb-0'
                                    ]) }}
                                    --}}
                                    {{ $cities->links() }}
                                </nav>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        @foreach($cities as $city)
            <x-delete-model
                href="{{ route('cities.delete', $city->id) }}"
                message="Voulez-vous vraiment supprimer cette ville ?"
                title="Confiramtion"
                target="deleteCityModal" />
        @endforeach

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
                                    <small class="text-muted">Toutes les villes et statistiques</small>
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

        {{-- Create City Modal --}}
        <div class="modal fade" id="createCityModal" tabindex="-1" aria-labelledby="createCityModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <form action="{{ route('cities.store') }}" method="POST">
                        @csrf

                        <div class="modal-header border-0 pb-0">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3">
                                    <i class="bi bi-geo-alt-fill text-primary fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="modal-title fw-bold mb-0" id="createCityModalLabel">Nouvelle Ville</h5>
                                    <small class="text-muted">Ajoutez une nouvelle ville à votre structure</small>
                                </div>
                            </div>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body pt-0 px-4">
                            {{-- Title Field --}}
                            <div class="mb-4">
                                <label for="cityTitle" class="form-label fw-semibold text-dark mb-2">
                                    Nom de la ville <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-lg">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-geo-alt text-primary"></i>
                            </span>
                                    <input type="text"
                                           class="form-control form-control-lg border-start-0 shadow-sm @error('title') is-invalid @enderror"
                                           id="cityTitle"
                                           name="title"
                                           placeholder="Ex: Casablanca, Rabat, Marrakech..."
                                           value="{{ old('title') }}"
                                           required>
                                    @error('title')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted mt-1">Le nom doit être unique et descriptif</small>
                            </div>

                            {{-- Quick Preview --}}
                            <div class="bg-light rounded-3 p-3 mb-3 d-none" id="previewSection">
                                <small class="text-muted mb-2 d-block">Aperçu:</small>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-2">
                                        <i class="bi bi-geo-alt-fill text-primary"></i>
                                    </div>
                                    <div class="fw-semibold text-dark" id="previewTitle">Tapez un nom...</div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer border-0 bg-light px-4 py-3 rounded-bottom">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                <i class="bi bi-x-circle me-1"></i>Annuler
                            </button>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-check-circle me-2"></i>
                                Créer la ville
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const titleInput = document.getElementById('cityTitle');
                    const previewSection = document.getElementById('previewSection');
                    const previewTitle = document.getElementById('previewTitle');

                    titleInput.addEventListener('input', function() {
                        const value = this.value.trim();
                        previewTitle.textContent = value || 'Tapez un nom...';
                        previewSection.classList.toggle('d-none', !value);
                    });
                });
            </script>
        @endpush

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
