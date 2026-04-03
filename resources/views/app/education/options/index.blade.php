<x-layout>
    @section('title', 'Gestion des Filières - HR Management')

    <div class="container-fluid py-4 px-md-5">
        {{-- Futurist Page Header --}}
        <div class="mb-5">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <nav aria-label="breadcrumb" class="mb-2">
                        <ol class="breadcrumb mb-0 extra-small text-uppercase fw-bold ls-1">
                            <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted">Formation</a></li>
                            <li class="breadcrumb-item active text-primary" aria-current="page">Référentiel Filières</li>
                        </ol>
                    </nav>
                    <h1 class="fw-bold text-dark display-6 mb-1">Système des <span class="text-primary-gradient">Filières</span></h1>
                    <p class="text-muted mb-0">Administration des spécialités et options académiques de l'organisation</p>
                </div>
                <div class="col-md-5 text-md-end mt-4 mt-md-0">
                    <div class="d-flex justify-content-md-end gap-2">
                        <button class="btn btn-glass shadow-sm rounded-pill px-4 fw-bold transition-base" data-bs-toggle="modal" data-bs-target="#bulkActions">
                            <i class="bi bi-cloud-download me-2"></i>Export
                        </button>
                        <button class="btn btn-futurist shadow-lg rounded-pill px-4 fw-bold transition-base" data-bs-toggle="modal" data-bs-target="#createOptionModal">
                            <i class="bi bi-plus-lg me-2"></i>Nouvelle Filière
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Search & Control Sidebar --}}
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 2rem;">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3 d-flex align-items-center">
                            <i class="bi bi-funnel me-2 text-primary"></i>Recherche Avancée
                        </h6>
                        <form method="GET" action="{{ route('options.index') }}">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted text-uppercase ls-1">Libellé Filière</label>
                                <div class="input-group-futurist">
                                    <input type="text" name="q" value="{{ request('q') }}" class="form-control futurist-input" placeholder="Ex: Informatique...">
                                    <i class="bi bi-search input-icon"></i>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-dark w-100 rounded-3 py-2 fw-bold transition-base shadow-sm mt-2">
                                Filtrer la liste
                            </button>
                            <button type="button" class="btn btn-outline-success w-100 rounded-3 py-2 fw-bold mt-3 border-2" data-bs-toggle="modal" data-bs-target="#importOptionModal">
                                <i class="bi bi-database-fill-up me-2"></i>Import Massif
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Main Table Container --}}
            <div class="col-lg-9">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white">
                    <div class="card-header bg-white py-4 px-4 border-bottom-0 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark d-flex align-items-center">
                            Registre Statutaire
                            <span class="badge bg-primary-subtle text-primary rounded-pill ms-2 px-3">{{ $options->total() ?? 0 }} Options</span>
                        </h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                            <tr class="bg-light-subtle">
                                <th class="ps-4 py-3 text-muted small text-uppercase ls-1 fw-bold border-0">UID</th>
                                <th class="py-3 text-muted small text-uppercase ls-1 fw-bold border-0">Désignation</th>
                                <th class="py-3 text-muted small text-uppercase ls-1 fw-bold border-0 text-center">Effectif</th>
                                <th class="pe-4 py-3 text-muted small text-uppercase ls-1 fw-bold border-0 text-end">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($options as $option)
                                <tr class="hover-row transition-base">
                                    <td class="ps-4 py-4">
                                        <span class="badge-uid">#{{ str_pad($option->id, 3, '0', STR_PAD_LEFT) }}</span>
                                    </td>
                                    <td class="py-4">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-shape-futur me-3">
                                                <i class="bi bi-layers"></i>
                                            </div>
                                            <div class="fw-bold text-dark fs-6">{{ $option->title }}</div>
                                        </div>
                                    </td>
                                    <td class="py-4 text-center">
                                        @php $qCount = $option->qualifications->count(); @endphp
                                        <span class="badge-cyber {{ $qCount > 0 ? 'active' : '' }}">
                                                {{ $qCount }} {{ Str::plural('Titulaire', $qCount) }}
                                            </span>
                                    </td>
                                    <td class="pe-4 py-4 text-end">
                                        <div class="dropdown">
                                            <button class="btn btn-action-circle" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-2">
                                                <li><a class="dropdown-item rounded-3 py-2" href="{{ route('options.show', $option) }}"><i class="bi bi-eye-fill me-2 text-primary"></i>Détails</a></li>
                                                <li><a class="dropdown-item rounded-3 py-2" href="{{ route('options.download', $option) }}"><i class="bi bi-file-excel-fill me-2 text-success"></i>Télécharger</a></li>
                                                <li><hr class="dropdown-divider opacity-50"></li>
                                                <li><button class="dropdown-item rounded-3 py-2 text-danger fw-bold" data-bs-toggle="modal" data-bs-target="#deleteOptionModal-{{ $option->id }}"><i class="bi bi-trash3 me-2"></i>Supprimer</button></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div class="opacity-25 mb-3">
                                            <i class="bi bi-journal-x fs-1"></i>
                                        </div>
                                        <h6 class="text-muted fw-bold">Référentiel vide</h6>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if(isset($options) && $options->hasPages())
                        <div class="card-footer bg-white border-top-0 py-4 px-4">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                                <div class="text-muted small">Vue {{ $options->firstItem() }} - {{ $options->lastItem() }} sur {{ $options->total() }}</div>
                                <div class="modern-pagination">
                                    {{ $options->appends(request()->query())->links() }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Individual Modals and logic --}}
    @foreach($options as $option)
        <x-delete-model
            href="{{ route('options.delete', $option->id) }}"
            message="Confirmation : Retirer '{{ $option->title }}' du référentiel ?"
            title="Action Irréversible"
            target="deleteOptionModal-{{ $option->id }}" />
    @endforeach

    {{-- Create Modal --}}
    <div class="modal fade" id="createOptionModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-2xl rounded-5 overflow-hidden">
                <form action="{{ route('options.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-5">
                        <div class="text-center mb-4">
                            <div class="bg-primary-subtle text-primary d-inline-flex p-3 rounded-circle mb-3">
                                <i class="bi bi-bookmark-plus fs-3"></i>
                            </div>
                            <h4 class="fw-bold">Nouvelle Filière</h4>
                            <p class="text-muted small">Nomenclature académique de l'entreprise</p>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Titre de l'option</label>
                            <input type="text" class="form-control form-control-lg bg-light border-0 rounded-4" name="title" placeholder="Ex: Finance & Comptabilité..." required>
                        </div>
                        <button type="submit" class="btn btn-futurist w-100 py-3 rounded-4 fw-bold">Valider la création</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Import Modal --}}
    <div class="modal fade" id="importOptionModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-5 overflow-hidden">
                <form action="{{ route('options.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header border-0 bg-success bg-gradient p-4 text-white">
                        <h5 class="modal-title fw-bold">Import Data</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-5">
                        <label class="form-label small fw-bold text-muted text-uppercase mb-3">Source Excel / CSV</label>
                        <input type="file" name="file" class="form-control bg-light border-0 rounded-3 py-3" required>
                    </div>
                    <div class="modal-footer border-0 p-4">
                        <button type="submit" class="btn btn-success w-100 rounded-pill py-2 fw-bold">Démarrer le traitement</button>
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
                        <a href="{{ route('options.download') }}" class="list-group-item list-group-item-action d-flex align-items-center p-4 border-0 border-bottom transition-base">
                            <i class="bi bi-file-earmark-excel-fill text-success fs-2 me-4"></i>
                            <div><div class="fw-bold">Tableau Excel (.xlsx)</div><small class="text-muted">Export complet des spécialités</small></div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center p-4 border-0 transition-base">
                            <i class="bi bi-file-earmark-pdf-fill text-danger fs-2 me-4"></i>
                            <div><div class="fw-bold">Référentiel PDF</div><small class="text-muted">Document officiel de nomenclature</small></div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #4f46e5 0%, #10b981 100%);
            --accent-glow: rgba(79, 70, 229, 0.15);
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
            box-shadow: 0 10px 20px -5px rgba(16, 185, 129, 0.3);
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
            border-color: #4f46e5 !important;
            box-shadow: 0 0 0 4px var(--accent-glow) !important;
        }
        .input-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #4f46e5; }

        .icon-shape-futur {
            width: 42px; height: 42px; background: #f1f5f9;
            color: #4f46e5; display: flex; align-items: center; justify-content: center;
            border-radius: 12px; transition: all 0.3s ease;
        }
        .hover-row:hover .icon-shape-futur { background: var(--primary-gradient); color: white; }

        .badge-uid {
            font-family: 'Monaco', 'Consolas', monospace;
            background: #f1f5f9; color: #475569; padding: 4px 8px; border-radius: 6px; font-size: 0.8rem;
        }

        .badge-cyber {
            background: #f8fafc; color: #94a3b8; border: 1.5px solid #e2e8f0;
            padding: 6px 14px; border-radius: 50px; font-weight: 700; font-size: 0.75rem;
        }
        .badge-cyber.active { background: #ecfdf5; color: #059669; border-color: #d1fae5; }

        .btn-action-circle {
            width: 38px; height: 38px; border-radius: 50%; border: none; background: transparent; color: #94a3b8; transition: all 0.2s;
        }
        .btn-action-circle:hover { background: #f1f5f9; color: #4f46e5; }

        .ls-1 { letter-spacing: 0.05em; }
        .extra-small { font-size: 0.72rem; }
        .shadow-2xl { box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15); }
    </style>
</x-layout>
