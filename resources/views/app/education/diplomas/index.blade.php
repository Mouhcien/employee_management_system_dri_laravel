<x-layout>
    @section('title', 'Gestion des Diplômes - HR Management')

    <div class="container-fluid py-4">
        {{-- Header Premium avec effet de profondeur --}}
        <div class="card border-0 shadow-lg rounded-4 mb-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="bg-primary bg-gradient p-4 text-white position-relative">
                    {{-- Icône de fond décorative --}}
                    <div class="position-absolute top-0 end-0 p-4 opacity-10">
                        <i class="bi bi-mortarboard-fill" style="font-size: 8rem;"></i>
                    </div>
                    <div class="row align-items-center position-relative">
                        <div class="col-md-8">
                            <h2 class="fw-bold mb-1 text-white">Référentiel des Diplômes</h2>
                            <p class="text-white text-opacity-75 mb-0 fw-medium">
                                <i class="bi bi-patch-check me-2"></i>Gestion des filières et des qualifications académiques des agents
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <button class="btn btn-white btn-rounded shadow-sm fw-bold px-4 me-2 transition-base" data-bs-toggle="modal" data-bs-target="#createDiplomaModal">
                                <i class="bi bi-plus-circle-fill me-2"></i>Nouveau Diplôme
                            </button>
                            <button class="btn btn-primary-light btn-rounded shadow-sm" data-bs-toggle="modal" data-bs-target="#bulkActions">
                                <i class="bi bi-cloud-download"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Advanced Filters Bar --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                <form method="GET" action="{{ route('diplomas.index') }}" class="row g-3 align-items-end">
                    <div class="col-lg-9 col-md-8">
                        <label class="form-label small fw-bold text-muted text-uppercase ls-1">Recherche par intitulé</label>
                        <div class="input-group bg-light border-0 rounded-3">
                            <span class="input-group-text bg-transparent border-0"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control bg-transparent border-0 shadow-none py-2" placeholder="Ex: Master en Gestion, Licence Pro, Doctorat...">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-dark flex-fill rounded-3 py-2 fw-bold transition-base shadow-sm">
                                <i class="bi bi-filter-left me-2"></i>Filtrer
                            </button>
                            <a href="{{ route('diplomas.index') }}" class="btn btn-outline-secondary rounded-3 py-2 shadow-sm">
                                <i class="bi bi-arrow-clockwise"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Main Table Card --}}
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-header bg-white py-4 px-4 border-bottom-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark d-flex align-items-center">
                    <span class="bg-primary-subtle text-primary rounded-3 p-2 me-3">
                        <i class="bi bi-book fs-5"></i>
                    </span>
                    Liste des Filières ({{ $diplomas->total() ?? 0 }})
                </h5>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light-subtle">
                    <tr>
                        <th class="ps-4 py-3 text-muted small text-uppercase ls-1 fw-bold border-0">Intitulé du Diplôme</th>
                        <th class="py-3 text-muted small text-uppercase ls-1 fw-bold border-0">Agents Titulaires</th>
                        <th class="py-3 text-muted small text-uppercase ls-1 fw-bold border-0">Filières </th>
                        <th class="pe-4 py-3 text-muted small text-uppercase ls-1 fw-bold border-0 text-end">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($diplomas as $diploma)
                        <tr class="hover-row transition-base">
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary-subtle text-primary rounded-circle p-2 me-3 shadow-xs d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="bi bi-mortarboard fs-5"></i>
                                    </div>
                                    <div class="fw-bold text-dark">{{ $diploma->title }}</div>
                                </div>
                            </td>
                            <td class="py-3">
                                @if($diploma->qualifications->count() > 0)
                                    <div class="d-flex flex-wrap gap-1">
                                        <span class="badge bg-light text-muted rounded-pill extra-small px-2 py-1">
                                            {{ $diploma->qualifications->count()}}
                                        </span>
                                    </div>
                                @else
                                    <span class="text-muted italic small opacity-75">Aucun titulaire</span>
                                @endif
                            </td>
                            <td class="py-3">
                                @if($diploma->qualifications->count() > 0)
                                    <div class="d-flex flex-wrap gap-1">
                                        <span class="badge bg-light text-muted rounded-pill extra-small px-2 py-1">
                                            {{ $diploma->qualifications->pluck('option_id')->unique()->count() }}
                                        </span>
                                    </div>
                                @else
                                    <span class="text-muted italic small opacity-75">Aucun titulaire</span>
                                @endif
                            </td>
                            <td class="pe-4 py-3 text-end">
                                <div class="d-flex justify-content-end gap-1">
                                    <a href="{{ route('diplomas.show', $diploma) }}" class="btn btn-sm btn-outline-primary border-0 rounded-circle p-2" title="Consulter">
                                        <i class="bi bi-eye-fill fs-5"></i>
                                    </a>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light border-0 shadow-xs rounded-circle p-2" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical fs-5"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 overflow-hidden">
                                            <li><a class="dropdown-item py-2 small" href="#"><i class="bi bi-envelope me-2 text-info"></i>Informer les titulaires</a></li>
                                            <li><a class="dropdown-item py-2 small" href="{{ route('diplomas.download', $diploma) }}"><i class="bi bi-file-earmark-excel me-2 text-success"></i>Export du grade</a></li>
                                            <li><hr class="dropdown-divider opacity-50"></li>
                                            <li>
                                                <button class="dropdown-item py-2 small text-danger fw-bold" data-bs-toggle="modal" data-bs-target="#deleteDiplomaModal-{{ $diploma->id }}">
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
                            <td colspan="3" class="text-center py-5">
                                <i class="bi bi-mortarboard fs-1 text-muted opacity-25"></i>
                                <h5 class="mt-3 text-muted fw-bold">Aucun diplôme n'est encore enregistré</h5>
                                <button class="btn btn-primary rounded-pill px-4 mt-3" data-bs-toggle="modal" data-bs-target="#createDiplomaModal">Initialiser le référentiel</button>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination Footer --}}
            @if(isset($diplomas) && $diplomas->hasPages())
                <div class="card-footer bg-white border-top-0 py-4 px-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                        <div class="text-muted small order-2 order-md-1">
                            Diplômes <span class="fw-bold">{{ $diplomas->firstItem() }}</span> - <span class="fw-bold">{{ $diplomas->lastItem() }}</span> sur <span class="fw-bold">{{ $diplomas->total() }}</span>
                        </div>
                        <div class="order-1 order-md-2">
                            {{ $diplomas->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Modals de Suppression Individuels --}}
    @foreach($diplomas as $diploma)
        <x-delete-model
            href="{{ route('diplomas.delete', $diploma->id) }}"
            message="Attention : La suppression du diplôme '{{ $diploma->title }}' supprimera l'historique académique des agents liés. Confirmer ?"
            title="Confirmation"
            target="deleteDiplomaModal-{{ $diploma->id }}" />
    @endforeach

    {{-- Create Diploma Modal --}}
    <div class="modal fade" id="createDiplomaModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <form action="{{ route('diplomas.store') }}" method="POST">
                    @csrf
                    <div class="modal-header border-0 bg-primary bg-gradient p-4 text-white">
                        <div class="d-flex align-items-center">
                            <div class="bg-white bg-opacity-20 p-2 rounded-circle me-3 shadow-sm">
                                <i class="bi bi-mortarboard-fill fs-3 text-white"></i>
                            </div>
                            <div>
                                <h5 class="modal-title fw-bold mb-0">Définir un Diplôme</h5>
                                <small class="text-white text-opacity-75">Ajout au référentiel académique</small>
                            </div>
                        </div>
                        <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body p-4 bg-white">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Intitulé de la filière <span class="text-danger">*</span></label>
                            <div class="input-group input-group-lg border rounded-3 overflow-hidden shadow-sm transition-base">
                                <span class="input-group-text bg-white border-0 text-primary"><i class="bi bi-book"></i></span>
                                <input type="text" class="form-control border-0 bg-white shadow-none @error('title') is-invalid @enderror" id="categoryTitle" name="title" placeholder="Ex: Licence en Informatique, Master RH..." required>
                            </div>
                            @error('title') <div class="text-danger extra-small mt-1 fw-bold">{{ $message }}</div> @enderror
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
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm transition-base">Créer le diplôme</button>
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
                        <a href="{{ route('diplomas.download') }}" class="list-group-item list-group-item-action d-flex align-items-center p-4 border-0 border-bottom transition-base">
                            <i class="bi bi-file-earmark-excel-fill text-success fs-2 me-4"></i>
                            <div>
                                <div class="fw-bold">Données Excel (.xlsx)</div>
                                <small class="text-muted">Tableau complet des diplômes </small>
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

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const titleInput = document.getElementById('categoryTitle'); // Correction de l'ID ici
                const previewSection = document.getElementById('previewSection');
                const previewTitle = document.getElementById('previewTitle');

                titleInput.addEventListener('input', function() {
                    const value = this.value.trim();
                    previewTitle.textContent = value;
                    previewSection.classList.toggle('d-none', !value);
                });
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
            .bg-info-subtle { background-color: #ecfeff !important; }
            .bg-primary-subtle { background-color: #eef2ff !important; }
        </style>
    @endpush
</x-layout>
