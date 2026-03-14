<x-layout>
    @section('title', 'Gestion des fonctions - HR Management')

    <div class="container-fluid py-4">
        {{-- Glassmorphic Page Header --}}
        <div class="card border-0 shadow-lg rounded-4 mb-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="bg-primary bg-gradient p-4 text-white position-relative">
                    <div class="position-absolute top-0 end-0 p-4 opacity-10">
                        <i class="bi bi-briefcase-fill" style="font-size: 8rem;"></i>
                    </div>
                    <div class="row align-items-center position-relative">
                        <div class="col-md-8">
                            <h2 class="fw-bold mb-1 text-white">Répertoire des Fonctions</h2>
                            <p class="text-white text-opacity-75 mb-0">Définition et suivi des rôles opérationnels de votre organisation</p>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <button class="btn btn-white btn-rounded shadow-sm fw-bold px-4 me-2 transition-base" data-bs-toggle="modal" data-bs-target="#createServiceModal">
                                <i class="bi bi-plus-circle-dotted me-2"></i>Nouvelle Fonction
                            </button>
                            <button class="btn btn-primary-light btn-rounded shadow-sm" data-bs-toggle="modal" data-bs-target="#bulkActions">
                                <i class="bi bi-download"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Interactive Metric Grid --}}
        <div class="row g-4 mb-4">
            @php
                $stats = [
                    ['label' => 'Total Fonctions', 'count' => $occupations->total(), 'color' => 'primary', 'icon' => 'bi-journal-bookmark-fill', 'trend' => 'Référentiel'],
                    ['label' => 'Entités Actives', 'count' => $total_entity ?? 0, 'color' => 'success', 'icon' => 'bi-diagram-3-fill', 'trend' => 'Structures'],
                    ['label' => 'Secteurs', 'count' => $total_sector ?? 0, 'color' => 'info', 'icon' => 'bi-grid-3x3-gap-fill', 'trend' => 'Opérationnel'],
                    ['label' => 'Total Sections', 'count' => $total_section ?? 0, 'color' => 'warning', 'icon' => 'bi-bounding-box-circles', 'trend' => 'Unités']
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
                                <span class="badge bg-light text-dark extra-small rounded-pill px-2">{{ $stat['trend'] }}</span>
                            </div>
                            <h3 class="fw-bold mb-0 text-dark">{{ $stat['count'] }}</h3>
                            <p class="text-muted small mb-0 fw-medium text-uppercase ls-1">{{ $stat['label'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Filter Section --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                <form method="GET" action="{{ route('occupations.index') }}" class="row g-3 align-items-end">
                    <div class="col-lg-10 col-md-8">
                        <label class="form-label small fw-bold text-muted text-uppercase ls-1">Filtrer par intitulé</label>
                        <div class="input-group bg-light border-0 rounded-3">
                            <span class="input-group-text bg-transparent border-0"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control bg-transparent border-0 shadow-none py-2" placeholder="Ex: Chef de division, Analyste, Secrétaire...">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4">
                        <button type="submit" class="btn btn-dark w-100 rounded-3 py-2 fw-bold transition-base">
                            <i class="bi bi-filter me-2"></i>Filtrer
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Table Container --}}
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-header bg-white py-4 px-4 border-bottom-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark d-flex align-items-center">
                    <span class="bg-primary-subtle text-primary rounded-3 p-2 me-3">
                        <i class="bi bi-journal-text fs-5"></i>
                    </span>
                    Registre des métiers ({{ $occupations->total() }})
                </h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light-subtle">
                    <tr>
                        <th class="ps-4 py-3 text-muted small text-uppercase ls-1 fw-bold border-0">Nom de la Fonction</th>
                        <th class="py-3 text-muted small text-uppercase ls-1 fw-bold border-0 text-center">Occupation Relative</th>
                        <th class="py-3 text-muted small text-uppercase ls-1 fw-bold border-0 text-center">Effectif</th>
                        <th class="pe-4 py-3 text-muted small text-uppercase ls-1 fw-bold border-0 text-end">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($occupations as $occupation)
                        <tr class="hover-row transition-base">
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-info-subtle text-info rounded-circle p-2 me-3 shadow-xs d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                        <i class="bi bi-briefcase small"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $occupation->title }}</div>
                                        <small class="text-muted extra-small">ID: #FUNC-{{ $occupation->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3">
                                @php $count = count($occupation->works); @endphp
                                <div class="d-flex align-items-center px-4">
                                    <div class="progress rounded-pill flex-grow-1" style="height: 6px; background-color: #eee;">
                                        <div class="progress-bar bg-primary shadow-sm" role="progressbar" style="width: {{ min(($count / 50) * 100, 100) }}%"></div>
                                    </div>
                                    <span class="ms-3 small text-muted fw-bold">{{ $count }} pts</span>
                                </div>
                            </td>
                            <td class="py-3 text-center">
                                <span class="badge bg-info-subtle text-info rounded-pill px-3 py-2 fw-bold border border-info-subtle">
                                    {{ $count }} Agents
                                </span>
                            </td>
                            <td class="pe-4 py-3 text-end">
                                <div class="d-flex justify-content-end gap-1">
                                    <a href="{{ route('occupations.show', $occupation) }}" class="btn btn-sm btn-outline-primary border-0 rounded-circle p-2" title="Gérer">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light border-0 shadow-xs rounded-circle p-2" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 overflow-hidden">
                                            <li><a class="dropdown-item py-2 small" href="#"><i class="bi bi-envelope me-2 text-info"></i>Notifier les titulaires</a></li>
                                            <li><a class="dropdown-item py-2 small" href="#"><i class="bi bi-file-earmark-pdf me-2 text-danger"></i>Export de fonction</a></li>
                                            <li><hr class="dropdown-divider opacity-50"></li>
                                            <li>
                                                <button class="dropdown-item py-2 small text-danger fw-bold" data-bs-toggle="modal" data-bs-target="#deleteServiceModal-{{ $occupation->id }}">
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
                                <div class="py-4">
                                    <i class="bi bi-journal-x fs-1 text-muted opacity-25"></i>
                                    <h5 class="mt-3 text-muted fw-bold">Aucune fonction n'est répertoriée</h5>
                                    <button class="btn btn-primary rounded-pill px-4 mt-3" data-bs-toggle="modal" data-bs-target="#createServiceModal">Créer un nouveau rôle</button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if(isset($occupations) && $occupations->hasPages())
                <div class="card-footer bg-white border-top-0 py-4 px-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                        <div class="text-muted small">
                            Éléments <span class="fw-bold">{{ $occupations->firstItem() }}</span> à <span class="fw-bold">{{ $occupations->lastItem() }}</span> sur <span class="fw-bold">{{ $occupations->total() }}</span>
                        </div>
                        <div>
                            {{ $occupations->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Individual Modals for Deletion --}}
    @foreach($occupations as $occupation)
        <x-delete-model
            href="{{ route('occupations.delete', $occupation->id) }}"
            message="Êtes-vous sûr de vouloir supprimer la fonction '{{ $occupation->title }}' ? Les agents rattachés devront être réaffectés."
            title="Confirmation de Suppression"
            target="deleteServiceModal-{{ $occupation->id }}" />
    @endforeach

    {{-- Create Modal --}}
    <div class="modal fade" id="createServiceModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <form action="{{ route('occupations.store') }}" method="POST">
                    @csrf
                    <div class="modal-header border-0 bg-primary bg-gradient p-4 text-white">
                        <div class="d-flex align-items-center">
                            <div class="bg-white bg-opacity-20 p-2 rounded-circle me-3 shadow-sm">
                                <i class="bi bi-plus-lg fs-4"></i>
                            </div>
                            <div>
                                <h5 class="modal-title fw-bold mb-0">Définir une Fonction</h5>
                                <small class="text-white text-opacity-75">Ajouter un titre de poste au référentiel</small>
                            </div>
                        </div>
                        <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4 bg-white">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Intitulé officiel <span class="text-danger">*</span></label>
                            <div class="input-group input-group-lg border rounded-3 overflow-hidden shadow-sm transition-base">
                                <span class="input-group-text bg-white border-0 text-primary"><i class="bi bi-briefcase"></i></span>
                                <input type="text" class="form-control border-0 bg-white shadow-none @error('title') is-invalid @enderror" name="title" placeholder="Ex: Développeur Senior, Chef de Bureau..." required>
                            </div>
                            @error('title') <div class="text-danger extra-small mt-1 fw-bold">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="modal-footer border-0 bg-light px-4 py-3">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm transition-base">Enregistrer la fonction</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Export Modal --}}
    <div class="modal fade" id="bulkActions" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header bg-dark text-white p-4">
                    <h5 class="modal-title fw-bold"><i class="bi bi-cloud-download me-2 text-info"></i>Exportation Avancée</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center p-4 border-0 border-bottom transition-base">
                            <i class="bi bi-file-earmark-excel-fill text-success fs-2 me-4"></i>
                            <div><div class="fw-bold">Données Brutes (Excel)</div><small class="text-muted">Génération d'un tableau complet pour retraitement</small></div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center p-4 border-0 transition-base">
                            <i class="bi bi-file-earmark-pdf-fill text-danger fs-2 me-4"></i>
                            <div><div class="fw-bold">Referentiel Métiers (PDF)</div><small class="text-muted">Document officiel de la nomenclature RH</small></div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
        .border-success-subtle { border-color: #d1fae5 !important; }
        .border-info-subtle { border-color: #e0f2fe !important; }
    </style>
</x-layout>
