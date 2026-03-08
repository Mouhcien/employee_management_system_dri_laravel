<x-layout>
    @section('title', 'Employees - HR Management')

    <div class="container-fluid py-4">
        {{-- Page Header with Gradient Background --}}
        <div class="bg-gradient-primary-to-secondary rounded-4 p-4 mb-4 text-white shadow-lg">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3">
                <div>
                    <h1 class="h3 mb-1 fw-bold"><i class="bi bi-people-fill me-2"></i>Gestion des catégories des employées</h1>
                    <p class="text-white-50 small mb-0"><i class="bi bi-geo-alt-fill me-1"></i>DRI-Marrakech | Administration du personnel</p>
                </div>
                <a href="{{ route('employees.create') }}" class="btn btn-light btn-lg d-inline-flex align-items-center shadow-sm fw-semibold" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                    <i class="bi bi-plus-circle-fill me-2 text-primary"></i>
                    Nouveau Catégories
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
                            <h6 class="card-title text-muted small mb-1 text-uppercase">Total catégories de employés</h6>
                            <h4 class="mb-0 fw-bold text-primary">{{ $categories->total() ?? 0 }}</h4>
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
                            <h4 class="mb-0 fw-bold" style="color:#d63384;">{{  0 }}</h4>
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
                            <h4 class="mb-0 fw-bold text-info">{{  0 }}</h4>
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
                            <h4 class="mb-0 fw-bold text-warning">{{  0 }}</h4>
                        </div>
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
                <form method="GET" action="{{ route('categories.index') }}" class="row g-3">
                    <div class="col-lg-8 col-md-6">
                        <label class="form-label small fw-semibold text-muted">Recherche</label>
                        <div class="position-relative">
                            <div class="position-absolute top-50 start-0 translate-middle-y ps-3">
                                <i class="bi bi-search text-muted"></i>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                   class="form-control ps-5" placeholder="Nom de ville ou local...">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary flex-fill">
                            <i class="bi bi-funnel me-1"></i> Filtrer
                        </button>
                        <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
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
                        Liste des catégories ({{ $categories->total() ?? 0 }})
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
                        <th class="border-0 py-3 px-4 text-start small fw-semibold text-muted text-uppercase ls-1">Catégorie</th>
                        <th class="border-0 py-3 px-4 text-start small fw-semibold text-muted text-uppercase ls-1">Employés</th>
                        <th class="border-0 py-3 px-4 text-end small fw-semibold text-muted text-uppercase ls-1">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="border-top">
                    @forelse($categories ?? [] as $category)
                        <tr class="hover-table-row">
                            <td class="py-3 px-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3">
                                        <i class="bi bi-geo-alt fs-6"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold text-dark small">{{ $category->title }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                @if($category->employees->count() > 0)
                                    <div class="d-flex flex-column gap-1">
                                        @foreach($category->employees as $employee)
                                            <span class="badge bg-light text-dark small px-2 py-1 rounded-pill">
                                                {{ $employee->ppr }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="badge bg-secondary small px-3 py-2">Aucun employé</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-end">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('categories.show', $category) }}" class="btn btn-sm btn-outline-primary" title="Voir">
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
                                                <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteCategoryModal-{{ $category->id }}">
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
            @if(isset($categories) && $categories->hasPages())
                <div class="card-footer bg-white border-top py-4">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="small text-muted">
                                Affichage de {{ $categories->firstItem() }} à {{ $categories->lastItem() }}
                                sur {{ $categories->total() }} résultats
                            </div>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="Pagination">
                                {{--
                                {{ $categories->appends(request()->query())->links([
                                    'class' => 'pagination-sm justify-content-end mb-0'
                                ]) }}
                                --}}
                                {{ $categories->links() }}
                            </nav>
                        </div>
                    </div>
                </div>
            @endif
        </div>



        @foreach($categories as $category)
            <x-delete-model
                href="{{ route('categories.delete', $category->id) }}"
                message="Voulez-vous vraiment supprimer ce catégorie ?"
                title="Confiramtion"
                target="deleteCategoryModal-{{ $category->id }}" />
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
        <div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCityModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf

                        <div class="modal-header border-0 pb-0">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3">
                                    <i class="bi bi-geo-alt-fill text-primary fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="modal-title fw-bold mb-0" id="createCityModalLabel">Nouveau Catégories</h5>
                                    <small class="text-muted">Ajoutez un nouveau catégorie d'employé à votre structure</small>
                                </div>
                            </div>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body pt-0 px-4">
                            {{-- Title Field --}}
                            <div class="mb-4">
                                <label for="cityTitle" class="form-label fw-semibold text-dark mb-2">
                                    Nom de la catégoire <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-lg">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-geo-alt text-primary"></i>
                            </span>
                                    <input type="text"
                                           class="form-control form-control-lg border-start-0 shadow-sm @error('title') is-invalid @enderror"
                                           id="categoryTitle"
                                           name="title"
                                           placeholder="Ex: Fonctionnaire, Agent..."
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
                                Créer la catégorie
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

    </div>
</x-layout>
