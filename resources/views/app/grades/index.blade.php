<x-layout>
    @section('title', 'Gestion des grades - HR Management')

    <div class="container-fluid py-4">
        {{-- Header Premium avec effet de profondeur --}}
        <div class="card border-0 shadow-lg rounded-4 mb-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="bg-primary bg-gradient p-4 text-white position-relative">
                    {{-- Icône de fond décorative --}}
                    <div class="position-absolute top-0 end-0 p-4 opacity-10">
                        <i class="bi bi-award-fill" style="font-size: 8rem;"></i>
                    </div>
                    <div class="row align-items-center position-relative">
                        <div class="col-md-8">
                            <h2 class="fw-bold mb-1 text-white">Nomenclature des Grades</h2>
                            <p class="text-white text-opacity-75 mb-0 fw-medium">
                                <i class="bi bi-shield-check me-2"></i>Administration du cadre statutaire et des échelles
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <button class="btn btn-white btn-rounded shadow-sm fw-bold px-4 me-2 transition-base" data-bs-toggle="modal" data-bs-target="#createGradeModal">
                                <i class="bi bi-plus-circle-fill me-2"></i>Nouveau Grade
                            </button>
                            <button class="btn btn-primary-light btn-rounded shadow-sm" data-bs-toggle="modal" data-bs-target="#bulkActions">
                                <i class="bi bi-cloud-download"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Grid de Statistiques Interactives --}}
        <div class="row g-4 mb-4">
            @php
                $stats = [
                    ['label' => 'Total Grades', 'count' => $grades->total(), 'color' => 'primary', 'icon' => 'bi-award-fill'],
                    ['label' => 'Entités liées', 'count' => $total_entity ?? 0, 'color' => 'success', 'icon' => 'bi-diagram-3-fill'],
                    ['label' => 'Secteurs', 'count' => $total_sector ?? 0, 'color' => 'info', 'icon' => 'bi-grid-3x3-gap-fill'],
                    ['label' => 'Total Sections', 'count' => $total_section ?? 0, 'color' => 'warning', 'icon' => 'bi-bounding-box-circles']
                ];
            @endphp
            @foreach($stats as $stat)
                <div class="col-xl-3 col-sm-6">
                    <div class="card border-0 shadow-sm rounded-4 hover-lift h-100 border-start border-4 border-{{ $stat['color'] }}">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="bg-{{ $stat['color'] }}-subtle text-{{ $stat['color'] }} rounded-3 p-2">
                                    <i class="bi {{ $stat['icon'] }} fs-4"></i>
                                </div>
                                <i class="bi bi-arrow-up-right text-muted opacity-50"></i>
                            </div>
                            <h3 class="fw-bold mb-0 text-dark">{{ $stat['count'] }}</h3>
                            <p class="text-muted small mb-0 fw-bold text-uppercase ls-1">{{ $stat['label'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Filtres de Recherche Modernes --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                <form method="GET" action="{{ route('grades.index') }}" class="row g-3 align-items-end">
                    <div class="col-lg-10 col-md-8">
                        <label class="form-label small fw-bold text-muted text-uppercase ls-1">Filtrer par intitulé</label>
                        <div class="input-group bg-light border-0 rounded-3">
                            <span class="input-group-text bg-transparent border-0"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control bg-transparent border-0 shadow-none py-2" placeholder="Rechercher un grade (ex: Administrateur)...">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4">
                        <button type="submit" class="btn btn-dark w-100 rounded-3 py-2 fw-bold transition-base shadow-sm">
                            <i class="bi bi-filter-left me-2"></i>Filtrer
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Table Card avec Design Épuré --}}
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-header bg-white py-4 px-4 border-bottom-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark d-flex align-items-center">
                    <span class="bg-primary-subtle text-primary rounded-3 p-2 me-3">
                        <i class="bi bi-journal-check fs-5"></i>
                    </span>
                    Répertoire Statutaire
                </h5>
                <span class="badge bg-light text-primary border border-primary-subtle rounded-pill px-3 py-2 fw-bold small">
                    {{ $grades->total() }} Grades enregistrés
                </span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light-subtle">
                    <tr>
                        <th class="ps-4 py-3 text-muted small text-uppercase ls-1 fw-bold border-0">Grade officiel</th>
                        <th class="py-3 text-muted small text-uppercase ls-1 fw-bold border-0 text-center">Échelle indiciaire</th>
                        <th class="py-3 text-muted small text-uppercase ls-1 fw-bold border-0 text-center">Occupation</th>
                        <th class="pe-4 py-3 text-muted small text-uppercase ls-1 fw-bold border-0 text-end">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($grades as $grade)
                        <tr class="hover-row transition-base">
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-info-subtle text-info rounded-circle p-2 me-3 shadow-xs d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                        <i class="bi bi-award"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $grade->title }}</div>
                                        <small class="text-muted extra-small">Grade de catégorie {{ $grade->scale >= 10 ? 'A' : 'B' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 text-center">
                                <span class="badge bg-primary rounded-pill px-3 py-2 fw-bold shadow-sm" style="min-width: 90px;">
                                    Échelle {{ $grade->scale }}
                                </span>
                            </td>
                            <td class="py-3 text-center">
                                @php $count = count($grade->classements ?? []); @endphp
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <div class="progress rounded-pill flex-grow-0" style="height: 6px; width: 80px; background: #eee;">
                                        <div class="progress-bar bg-info" style="width: {{ $count > 0 ? '70' : '0' }}%"></div>
                                    </div>
                                    <span class="small fw-bold text-muted">{{ $count }}</span>
                                </div>
                            </td>
                            <td class="pe-4 py-3 text-end">
                                <div class="d-flex justify-content-end gap-1">
                                    <a href="{{ route('grades.show', $grade) }}" class="btn btn-sm btn-outline-primary border-0 rounded-circle p-2" title="Gérer">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light border-0 shadow-xs rounded-circle p-2" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 overflow-hidden">
                                            <li><a class="dropdown-item py-2 small" href="#"><i class="bi bi-envelope me-2 text-info"></i>Informer les agents</a></li>
                                            <li><hr class="dropdown-divider opacity-50"></li>
                                            <li>
                                                <button class="dropdown-item py-2 small text-danger fw-bold" data-bs-toggle="modal" data-bs-target="#deleteGradeModal-{{ $grade->id }}">
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
                                <i class="bi bi-award fs-1 text-muted opacity-25"></i>
                                <h5 class="mt-3 text-muted fw-bold">Aucun grade n'est encore configuré</h5>
                                <button class="btn btn-primary rounded-pill px-4 mt-3" data-bs-toggle="modal" data-bs-target="#createGradeModal">Initialiser le premier grade</button>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Footer Pagination --}}
            @if(isset($grades) && $grades->hasPages())
                <div class="card-footer bg-white border-top-0 py-4 px-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                        <div class="text-muted small order-2 order-md-1">
                            Grades <span class="fw-bold">{{ $grades->firstItem() }}</span> - <span class="fw-bold">{{ $grades->lastItem() }}</span> sur <span class="fw-bold">{{ $grades->total() }}</span>
                        </div>
                        <div class="order-1 order-md-2">
                            {{ $grades->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Modals de Suppression Individuels --}}
    @foreach($grades as $grade)
        <x-delete-model
            href="{{ route('grades.delete', $grade->id) }}"
            message="Attention : La suppression du grade '{{ $grade->title }}' désaffectera les agents liés. Confirmez-vous l'action ?"
            title="Confirmation Statutaire"
            target="deleteGradeModal-{{ $grade->id }}" />
    @endforeach

    {{-- Modal de Création --}}
    <div class="modal fade" id="createGradeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <form action="{{ route('grades.store') }}" method="POST">
                    @csrf
                    <div class="modal-header border-0 bg-primary bg-gradient p-4 text-white">
                        <div class="d-flex align-items-center">
                            <div class="bg-white bg-opacity-20 p-2 rounded-circle me-3 shadow-sm">
                                <i class="bi bi-award-fill fs-3"></i>
                            </div>
                            <div>
                                <h5 class="modal-title fw-bold mb-0">Définir un Grade</h5>
                                <small class="text-white text-opacity-75">Paramétrage du cadre indiciaire</small>
                            </div>
                        </div>
                        <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body p-4 bg-white">
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Intitulé du grade <span class="text-danger">*</span></label>
                            <div class="input-group input-group-lg border rounded-3 overflow-hidden shadow-sm transition-base">
                                <span class="input-group-text bg-white border-0 text-primary"><i class="bi bi-award"></i></span>
                                <input type="text" class="form-control border-0 bg-white shadow-none @error('title') is-invalid @enderror" name="title" placeholder="Ex: Administrateur 2ème grade..." required>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Échelle de rémunération <span class="text-danger">*</span></label>
                            <div class="input-group input-group-lg border rounded-3 overflow-hidden shadow-sm transition-base">
                                <span class="input-group-text bg-white border-0 text-primary"><i class="bi bi-list-nested"></i></span>
                                <select name="scale" class="form-select border-0 bg-white shadow-none" required>
                                    <option value="" disabled selected>Sélectionner l'échelle...</option>
                                    @foreach([12, 11, 10, 9, 8, 7, 6, 0] as $scale)
                                        <option value="{{ $scale }}">Échelle {{ $scale }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-0 bg-light px-4 py-3">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm transition-base">Enregistrer le grade</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal d'Exportation --}}
    <div class="modal fade" id="bulkActions" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header bg-dark text-white p-4">
                    <h5 class="modal-title fw-bold"><i class="bi bi-cloud-arrow-down me-2 text-info"></i>Exporter les Grades</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center p-4 border-0 border-bottom transition-base">
                            <i class="bi bi-file-earmark-excel-fill text-success fs-2 me-4"></i>
                            <div>
                                <div class="fw-bold">Données Excel (.xlsx)</div>
                                <small class="text-muted">Tableau complet des grades et échelles</small>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center p-4 border-0 transition-base">
                            <i class="bi bi-file-earmark-pdf-fill text-danger fs-2 me-4"></i>
                            <div>
                                <div class="fw-bold">Référentiel PDF</div>
                                <small class="text-muted">Document officiel de la hiérarchie statutaire</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
            .shadow-xs { box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
            .bg-light-subtle { background-color: #f9fafb !important; }
        </style>
    @endpush
</x-layout>
