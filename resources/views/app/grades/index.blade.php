<x-layout>
    @section('title', 'Gestion des grades - HR Management')

    <div class="container-fluid py-4 px-md-5">
        {{-- Futurist Page Header --}}
        <div class="mb-5">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <nav aria-label="breadcrumb" class="mb-2">
                        <ol class="breadcrumb mb-0 extra-small text-uppercase fw-bold ls-1">
                            <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted">Statutaire</a></li>
                            <li class="breadcrumb-item active text-primary" aria-current="page">Nomenclature des Grades</li>
                        </ol>
                    </nav>
                    <h1 class="fw-bold text-dark display-6 mb-1">Cadre <span class="text-primary-gradient">Statutaire</span></h1>
                    <p class="text-muted mb-0">Administration des échelles et de la hiérarchie indiciaire</p>
                </div>
                <div class="col-md-5 text-md-end mt-4 mt-md-0">
                    <div class="d-flex justify-content-md-end gap-2">
                        <button class="btn btn-glass shadow-sm rounded-pill px-4 fw-bold transition-base" data-bs-toggle="modal" data-bs-target="#bulkActions">
                            <i class="bi bi-cloud-arrow-down me-2"></i>Export
                        </button>
                        <button class="btn btn-futurist shadow-lg rounded-pill px-4 fw-bold transition-base" data-bs-toggle="modal" data-bs-target="#createGradeModal">
                            <i class="bi bi-plus-lg me-2"></i>Nouveau Grade
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Search & Filter Sidebar --}}
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 2rem;">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3 d-flex align-items-center">
                            <i class="bi bi-funnel me-2 text-primary"></i>Recherche Filtre
                        </h6>
                        <form method="GET" action="{{ route('grades.index') }}">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted text-uppercase ls-1">Désignation</label>
                                <div class="input-group-futurist">
                                    <input type="text" name="q" value="{{ request('q') }}" class="form-control futurist-input" placeholder="Ex: Administrateur...">
                                    <i class="bi bi-search input-icon"></i>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-dark w-100 rounded-3 py-2 fw-bold transition-base shadow-sm mt-2">
                                Actualiser la vue
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Table Container --}}
            <div class="col-lg-9">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white">
                    <div class="card-header bg-white py-4 px-4 border-bottom-0 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark d-flex align-items-center">
                            Répertoire Actif
                            <span class="badge bg-primary-subtle text-primary rounded-pill ms-2 px-3">{{ $grades->total() }} unités</span>
                        </h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                            <tr class="bg-light-subtle">
                                <th class="ps-4 py-3 text-muted small text-uppercase ls-1 fw-bold border-0">Grade Officiel</th>
                                <th class="py-3 text-muted small text-uppercase ls-1 fw-bold border-0 text-center">Hiérarchie</th>
                                <th class="py-3 text-muted small text-uppercase ls-1 fw-bold border-0 text-center">Effectif</th>
                                <th class="pe-4 py-3 text-muted small text-uppercase ls-1 fw-bold border-0 text-end">Options</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($grades as $grade)
                                <tr class="hover-row transition-base">
                                    <td class="ps-4 py-4">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-shape-futur me-3">
                                                <i class="bi bi-award"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark fs-6">{{ $grade->title }}</div>
                                                <code class="extra-small text-primary">SCALE-{{ $grade->scale }}</code>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 text-center">
                                        <div class="d-flex flex-column gap-1 align-items-center">
                                            <span class="badge-cyber w-75">Échelle {{ $grade->scale }}</span>
                                            <span class="extra-small fw-bold text-muted">Échellon: {{ $grade->competences[0]->echellon->title ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 text-center">
                                        @php $count = count($grade->competences ?? []); @endphp
                                        <div class="d-flex flex-column align-items-center">
                                            <div class="progress rounded-pill mb-1" style="height: 4px; width: 60px;">
                                                <div class="progress-bar gradient-progress" style="width: {{ $count > 0 ? '75%' : '0' }}"></div>
                                            </div>
                                            <span class="small fw-bold text-dark">{{ $count }} Agents</span>
                                        </div>
                                    </td>
                                    <td class="pe-4 py-4 text-end">
                                        <div class="dropdown">
                                            <button class="btn btn-action-circle" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-2">
                                                <li><a class="dropdown-item rounded-3 py-2" href="{{ route('grades.show', $grade) }}"><i class="bi bi-eye-fill me-2 text-primary"></i>Gérer</a></li>
                                                <li><a class="dropdown-item rounded-3 py-2" href="{{ route('grades.download', $grade) }}"><i class="bi bi-file-earmark-excel-fill me-2 text-success"></i>Télécharger</a></li>
                                                <li><hr class="dropdown-divider opacity-50"></li>
                                                <li><button class="dropdown-item rounded-3 py-2 text-danger fw-bold" data-bs-toggle="modal" data-bs-target="#deleteGradeModal-{{ $grade->id }}"><i class="bi bi-trash3 me-2"></i>Supprimer</button></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div class="opacity-25 mb-3">
                                            <i class="bi bi-award fs-1"></i>
                                        </div>
                                        <h6 class="text-muted fw-bold">Aucun grade configuré</h6>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if(isset($grades) && $grades->hasPages())
                        <div class="card-footer bg-white border-top-0 py-4 px-4">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                                <div class="text-muted small">Affichage de {{ $grades->firstItem() }} à {{ $grades->lastItem() }}</div>
                                <div class="modern-pagination">
                                    {{ $grades->links() }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- MODALS & STYLES (Kept logically consistent with previous professional style) --}}
    @foreach($grades as $grade)
        <x-delete-model
            href="{{ route('grades.delete', $grade->id) }}"
            message="Supprimer le grade '{{ $grade->title }}' ?"
            title="Confirmation Statutaire"
            target="deleteGradeModal-{{ $grade->id }}" />
    @endforeach

    {{-- Create Modal --}}
    <div class="modal fade" id="createGradeModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-2xl rounded-5 overflow-hidden">
                <form action="{{ route('grades.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-5">
                        <div class="text-center mb-4">
                            <div class="bg-primary-subtle text-primary d-inline-flex p-3 rounded-circle mb-3">
                                <i class="bi bi-award fs-3"></i>
                            </div>
                            <h4 class="fw-bold">Nouveau Grade</h4>
                            <p class="text-muted small">Paramétrage du cadre indiciaire</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Intitulé</label>
                            <input type="text" class="form-control form-control-lg bg-light border-0 rounded-4" name="title" placeholder="Ex: Administrateur..." required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Échelle</label>
                            <select name="scale" class="form-select form-select-lg bg-light border-0 rounded-4" required>
                                @foreach([12, 11, 10, 9, 8, 7, 6] as $s)
                                    <option value="{{ $s }}">Échelle {{ $s }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-futurist w-100 py-3 rounded-4 fw-bold">Enregistrer</button>
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
                    <h5 class="modal-title fw-bold"><i class="bi bi-cloud-arrow-down me-2 text-info"></i>Exportation</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="{{ route('grades.download') }}" class="list-group-item list-group-item-action d-flex align-items-center p-4 border-0 border-bottom transition-base">
                            <i class="bi bi-file-earmark-excel-fill text-success fs-2 me-4"></i>
                            <div><div class="fw-bold">Excel (.xlsx)</div><small class="text-muted">Tableau complet des grades</small></div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center p-4 border-0 transition-base">
                            <i class="bi bi-file-earmark-pdf-fill text-danger fs-2 me-4"></i>
                            <div><div class="fw-bold">Référentiel (PDF)</div><small class="text-muted">Document officiel de hiérarchie</small></div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            --accent-glow: rgba(99, 102, 241, 0.15);
        }

        body { background-color: #f8fafc; }

        .text-primary-gradient {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .btn-futurist {
            background: var(--primary-gradient);
            color: white; border: none;
            box-shadow: 0 10px 20px -5px rgba(79, 70, 229, 0.4);
        }
        .btn-futurist:hover { color: white; transform: translateY(-2px); filter: brightness(1.1); }

        .btn-glass {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid #e2e8f0;
            color: #475569;
        }

        .input-group-futurist { position: relative; }
        .futurist-input {
            background: #f1f5f9 !important;
            border: 2px solid transparent !important;
            padding: 10px 15px 10px 40px !important;
            border-radius: 12px !important;
            transition: all 0.3s ease;
        }
        .futurist-input:focus {
            background: white !important;
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 4px var(--accent-glow) !important;
        }
        .input-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #6366f1; }

        .icon-shape-futur {
            width: 42px; height: 42px; background: #f1f5f9;
            color: #6366f1; display: flex; align-items: center; justify-content: center;
            border-radius: 12px; transition: all 0.3s ease;
        }
        .hover-row:hover .icon-shape-futur { background: var(--primary-gradient); color: white; transform: rotate(-5deg); }

        .badge-cyber {
            background: #f8fafc; color: #4f46e5; border: 1.5px solid #e2e8f0;
            padding: 6px 12px; border-radius: 8px; font-weight: 700; font-size: 0.75rem;
        }

        .gradient-progress { background: var(--primary-gradient) !important; }

        .btn-action-circle {
            width: 38px; height: 38px; border-radius: 50%; border: none; background: transparent; color: #94a3b8; transition: all 0.2s;
        }
        .btn-action-circle:hover { background: #f1f5f9; color: #6366f1; }

        .ls-1 { letter-spacing: 0.05em; }
        .extra-small { font-size: 0.72rem; }
    </style>
</x-layout>
