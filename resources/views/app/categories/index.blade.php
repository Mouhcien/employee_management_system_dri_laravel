<x-layout>
    @section('title', 'Gestion des Catégories - HR Management')

    <div class="container-fluid py-4">
        {{-- Header Premium avec effet de profondeur --}}
        <div class="card border-0 shadow-lg rounded-4 mb-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="bg-primary bg-gradient p-4 text-white position-relative">
                    {{-- Icône décorative en filigrane --}}
                    <div class="position-absolute top-0 end-0 p-4 opacity-10">
                        <i class="bi bi-tags-fill" style="font-size: 8rem;"></i>
                    </div>
                    <div class="row align-items-center position-relative">
                        <div class="col-md-8">
                            <h2 class="fw-bold mb-1 text-white">Référentiel des Catégories</h2>
                            <p class="text-white text-opacity-75 mb-0 fw-medium">
                                <i class="bi bi-shield-check me-2"></i>Administration des classes et groupements professionnels
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <button class="btn btn-white btn-rounded shadow-sm fw-bold px-4 transition-base" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                                <i class="bi bi-plus-circle-fill me-2"></i>Nouvelle Catégorie
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Grid de Statistiques avec bordures colorées --}}
        <div class="row g-4 mb-4">
            @php
                $stats = [
                    ['label' => 'Total Catégories', 'count' => $categories->total(), 'color' => 'primary', 'icon' => 'bi-list-ul'],
                    ['label' => 'Effectif Féminin', 'count' => 0, 'color' => 'danger', 'icon' => 'bi-gender-female'], // Couleur danger pour le rose
                    ['label' => 'Effectif Masculin', 'count' => 0, 'color' => 'info', 'icon' => 'bi-gender-male'],
                    ['label' => 'Locaux Actifs', 'count' => 0, 'color' => 'warning', 'icon' => 'bi-building']
                ];
            @endphp
            @foreach($stats as $stat)
                <div class="col-xl-3 col-sm-6">
                    <div class="card border-0 shadow-sm rounded-4 hover-lift h-100 border-start border-4 border-{{ $stat['color'] }}">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-{{ $stat['color'] }} bg-opacity-10 rounded-3 p-3 text-{{ $stat['color'] }}">
                                    <i class="bi {{ $stat['icon'] }} fs-3"></i>
                                </div>
                                <div class="ms-3">
                                    <h4 class="fw-bold mb-0 text-dark">{{ $stat['count'] }}</h4>
                                    <p class="text-muted small mb-0 fw-bold text-uppercase ls-1">{{ $stat['label'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Barre de recherche et filtres --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                <form method="GET" action="{{ route('categories.index') }}" class="row g-3 align-items-end">
                    <div class="col-lg-9 col-md-8">
                        <label class="form-label small fw-bold text-muted text-uppercase ls-1">Filtrer par libellé</label>
                        <div class="input-group bg-light border-0 rounded-3">
                            <span class="input-group-text bg-transparent border-0"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control bg-transparent border-0 shadow-none py-2" placeholder="Rechercher une catégorie (ex: Fonctionnaire)...">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-dark flex-fill rounded-3 py-2 fw-bold transition-base shadow-sm">
                                <i class="bi bi-filter-left me-2"></i>Filtrer
                            </button>
                            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary rounded-3 py-2">
                                <i class="bi bi-arrow-clockwise"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Table Card Premium --}}
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-header bg-white py-4 px-4 border-bottom-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark d-flex align-items-center">
                    <span class="bg-primary-subtle text-primary rounded-3 p-2 me-3">
                        <i class="bi bi-bookmark-star fs-5"></i>
                    </span>
                    Registre des Catégories
                </h5>
                <div class="dropdown">
                    <button class="btn btn-outline-primary btn-sm rounded-pill px-3 dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="bi bi-download me-1"></i>Exporter
                    </button>
                    <ul class="dropdown-menu shadow border-0 rounded-4 overflow-hidden">
                        <li><a href="#" class="dropdown-item text-success py-2 small"><i class="bi bi-file-earmark-excel me-2"></i>Format Excel</a></li>
                        <li><a href="#" class="dropdown-item text-danger py-2 small"><i class="bi bi-file-earmark-pdf me-2"></i>Format PDF</a></li>
                    </ul>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light-subtle">
                    <tr>
                        <th class="ps-4 py-3 text-muted small text-uppercase ls-1 fw-bold border-0">Libellé</th>
                        <th class="py-3 text-muted small text-uppercase ls-1 fw-bold border-0 text-center">Occupation Relative</th>
                        <th class="py-3 text-muted small text-uppercase ls-1 fw-bold border-0 text-center">Nombre d'agents</th>
                        <th class="pe-4 py-3 text-muted small text-uppercase ls-1 fw-bold border-0 text-end">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($categories as $category)
                        <tr class="hover-row transition-base">
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary-subtle text-primary rounded-circle p-2 me-3 shadow-xs d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="bi bi-tag"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark fs-6">{{ $category->title }}</div>
                                        <small class="text-muted extra-small">ID: #CAT-{{ $category->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 text-center">
                                @php $count = $category->employees->count(); @endphp
                                <div class="d-flex align-items-center justify-content-center px-4">
                                    <div class="progress rounded-pill flex-grow-1" style="height: 6px; max-width: 100px; background-color: #eee;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $count > 0 ? '75' : '0' }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 text-center">
                                    <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill px-3 py-2 fw-bold">
                                        <i class="bi bi-people-fill me-1"></i> {{ $count }} Agents
                                    </span>
                            </td>
                            <td class="pe-4 py-3 text-end">
                                <div class="d-flex justify-content-end gap-1">
                                    <a href="{{ route('categories.show', $category) }}" class="btn btn-sm btn-outline-primary border-0 rounded-circle p-2" title="Gérer">
                                        <i class="bi bi-eye-fill fs-5"></i>
                                    </a>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light border-0 shadow-xs rounded-circle p-2" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical fs-5"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 overflow-hidden">
                                            <li><a class="dropdown-item py-2 small" href="#"><i class="bi bi-pencil-square me-2 text-warning"></i>Éditer</a></li>
                                            <li><hr class="dropdown-divider opacity-50"></li>
                                            <li>
                                                <button class="dropdown-item py-2 small text-danger fw-bold" data-bs-toggle="modal" data-bs-target="#deleteCategoryModal-{{ $category->id }}">
                                                    <i class="bi bi-trash3 me-2"></i>Supprimer
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
                                <i class="bi bi-tag-x fs-1 text-muted opacity-25"></i>
                                <h5 class="mt-3 text-muted fw-bold">Aucune catégorie n'est encore définie</h5>
                                <button class="btn btn-primary rounded-pill px-4 mt-3" data-bs-toggle="modal" data-bs-target="#createCategoryModal">Commencer le paramétrage</button>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination Footer --}}
            @if(isset($categories) && $categories->hasPages())
                <div class="card-footer bg-white border-top-0 py-4 px-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                        <div class="text-muted small order-2 order-md-1">
                            Classification <span class="fw-bold">{{ $categories->firstItem() }}</span> à <span class="fw-bold">{{ $categories->lastItem() }}</span> sur <span class="fw-bold">{{ $categories->total() }}</span>
                        </div>
                        <div class="order-1 order-md-2">
                            {{ $categories->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Modals de Suppression Individuels --}}
        @foreach($categories as $category)
            <x-delete-model
                href="{{ route('categories.delete', $category->id) }}"
                message="Attention : La suppression de la catégorie '{{ $category->title }}' entraînera la désaffectation de tous les employés associés. Continuer ?"
                title="Confirmation Statutaire"
                target="deleteCategoryModal-{{ $category->id }}" />
        @endforeach

        {{-- Create Category Modal --}}
        <div class="modal fade" id="createCategoryModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf
                        <div class="modal-header border-0 bg-primary bg-gradient p-4 text-white">
                            <div class="d-flex align-items-center">
                                <div class="bg-white bg-opacity-20 p-2 rounded-circle me-3 shadow-sm text-dark">
                                    <i class="bi bi-plus-lg fs-3"></i>
                                </div>
                                <div>
                                    <h5 class="modal-title fw-bold mb-0">Définir une Catégorie</h5>
                                    <small class="text-white text-opacity-75">Classification administrative du personnel</small>
                                </div>
                            </div>
                            <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body p-4 bg-white">
                            <div class="mb-4">
                                <label class="form-label small fw-bold text-muted text-uppercase ls-1">Intitulé de la catégorie <span class="text-danger">*</span></label>
                                <div class="input-group input-group-lg border rounded-3 overflow-hidden shadow-sm transition-base">
                                    <span class="input-group-text bg-white border-0 text-primary"><i class="bi bi-tag"></i></span>
                                    <input type="text" class="form-control border-0 bg-white shadow-none @error('title') is-invalid @enderror" id="categoryTitle" name="title" placeholder="Ex: Agent de Maîtrise, Cadre..." required>
                                </div>
                            </div>

                            <div class="bg-primary-subtle rounded-4 p-3 d-none" id="previewSection">
                                <div class="d-flex align-items-center text-primary fw-bold">
                                    <i class="bi bi-check2-circle me-2"></i>
                                    <span id="previewTitle" class="small"></span>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer border-0 bg-light px-4 py-3">
                            <button type="button" class="btn btn-outline-secondary rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm transition-base">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const titleInput = document.getElementById('categoryTitle');
                const previewSection = document.getElementById('previewSection');
                const previewTitle = document.getElementById('previewTitle');

                if(titleInput) {
                    titleInput.addEventListener('input', function() {
                        const value = this.value.trim();
                        previewTitle.textContent = value;
                        previewSection.classList.toggle('d-none', !value);
                    });
                }
            });
        </script>
    @endpush

    @push('styles')
        <style>
            .hover-row:hover { background-color: #f8fbff !important; }
            .transition-base { transition: all 0.2s ease-in-out; }
            .hover-lift:hover { transform: translateY(-4px); box-shadow: 0 15px 30px rgba(0,0,0,0.08) !important; }
            .btn-white { background: #fff; color: #4f46e5; border: none; }
            .btn-white:hover { background: #f3f4f6; color: #4338ca; }
            .btn-primary-light { background: rgba(255,255,255,0.15); border: none; color: #fff; }
            .btn-primary-light:hover { background: rgba(255,255,255,0.25); }
            .btn-rounded { border-radius: 50px; }
            .ls-1 { letter-spacing: 0.5px; }
            .extra-small { font-size: 0.7rem; }
            .shadow-xs { box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
            .bg-light-subtle { background-color: #f9fafb !important; }
            .bg-primary-subtle { background-color: #eef2ff !important; }
            .bg-info-subtle { background-color: #e0f2fe !important; }
        </style>
    @endpush
</x-layout>
