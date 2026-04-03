<x-layout>
    @section('title', 'Gestion des fonctions - HR Management')

    <div class="container-fluid py-4 px-md-5">
        {{-- Futurist Page Header --}}
        <div class="mb-5">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <nav aria-label="breadcrumb" class="mb-2">
                        <ol class="breadcrumb mb-0 extra-small text-uppercase fw-bold ls-1">
                            <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted">Dashboard</a></li>
                            <li class="breadcrumb-item active text-primary" aria-current="page">Fonctions</li>
                        </ol>
                    </nav>
                    <h1 class="fw-bold text-dark display-6 mb-1">Répertoire des <span class="text-primary-gradient">Fonctions</span></h1>
                    <p class="text-muted mb-0">Définition et suivi des rôles opérationnels de votre organisation</p>
                </div>
                <div class="col-md-5 text-md-end mt-4 mt-md-0">
                    <div class="d-flex justify-content-md-end gap-2">
                        <button class="btn btn-glass shadow-sm rounded-pill px-4 fw-bold transition-base" data-bs-toggle="modal" data-bs-target="#bulkActions">
                            <i class="bi bi-download me-2"></i>Export
                        </button>
                        <button class="btn btn-futurist shadow-lg rounded-pill px-4 fw-bold transition-base" data-bs-toggle="modal" data-bs-target="#createServiceModal">
                            <i class="bi bi-plus-lg me-2"></i>Nouvelle Fonction
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Modern Filter Sidebar (Desktop) / Top bar (Mobile) --}}
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 2rem;">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3 d-flex align-items-center">
                            <i class="bi bi-sliders2-vertical me-2 text-primary"></i>Filtres Avancés
                        </h6>
                        <form method="GET" action="{{ route('occupations.index') }}">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted text-uppercase ls-1">Recherche</label>
                                <div class="input-group bg-light border rounded-3 p-1">
                                    <span class="input-group-text bg-transparent border-0"><i class="bi bi-search text-muted"></i></span>
                                    <input type="text" name="search" value="{{ request('search') }}" class="form-control bg-transparent border-0 shadow-none py-2" placeholder="Ex: Chef, Analyste...">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-dark w-100 rounded-3 py-2 fw-bold transition-base shadow-sm">
                                Appliquer
                            </button>
                            @if(request('search'))
                                <a href="{{ route('occupations.index') }}" class="btn btn-link w-100 text-decoration-none text-muted small mt-2">Réinitialiser</a>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

            {{-- Main Table Container --}}
            <div class="col-lg-9">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white">
                    <div class="card-header bg-white py-4 px-4 border-bottom-0 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark d-flex align-items-center">
                            Registre des métiers
                            <span class="badge bg-primary-subtle text-primary rounded-pill ms-2 px-3">{{ $occupations->total() }}</span>
                        </h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                            <tr class="bg-light-subtle">
                                <th class="ps-4 py-3 text-muted small text-uppercase ls-1 fw-bold border-0">Nom de la Fonction</th>
                                <th class="py-3 text-muted small text-uppercase ls-1 fw-bold border-0">Occupation</th>
                                <th class="py-3 text-muted small text-uppercase ls-1 fw-bold border-0 text-center">Effectif</th>
                                <th class="pe-4 py-3 text-muted small text-uppercase ls-1 fw-bold border-0 text-end">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($occupations as $occupation)
                                <tr class="hover-row transition-base">
                                    <td class="ps-4 py-4">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-shape-futur me-3">
                                                <i class="bi bi-briefcase"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark fs-6">{{ $occupation->title }}</div>
                                                <code class="extra-small text-primary">#FUNC-{{ $occupation->id }}</code>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4" style="min-width: 200px;">
                                        @php $count = count($occupation->works); @endphp
                                        <div class="d-flex align-items-center">
                                            <div class="progress rounded-pill flex-grow-1" style="height: 6px; background-color: #f1f5f9;">
                                                <div class="progress-bar gradient-progress shadow-sm" role="progressbar" style="width: {{ min(($count / 50) * 100, 100) }}%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 text-center">
                                            <span class="badge badge-futur">
                                                {{ $count }} Agents
                                            </span>
                                    </td>
                                    <td class="pe-4 py-4 text-end">
                                        <div class="dropdown">
                                            <button class="btn btn-action-circle" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-2">
                                                <li><a class="dropdown-item rounded-3 py-2" href="{{ route('occupations.show', $occupation) }}"><i class="bi bi-eye-fill me-2 text-primary"></i>Consulter</a></li>
                                                <li><a class="dropdown-item rounded-3 py-2" href="{{ route('occupations.download', $occupation) }}"><i class="bi bi-file-earmark-excel-fill me-2 text-success"></i>Télécharger</a></li>
                                                <li><hr class="dropdown-divider opacity-50"></li>
                                                <li><button class="dropdown-item rounded-3 py-2 text-danger fw-bold" data-bs-toggle="modal" data-bs-target="#deleteServiceModal-{{ $occupation->id }}"><i class="bi bi-trash3 me-2"></i>Supprimer</button></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div class="opacity-50 mb-3">
                                            <i class="bi bi-inbox fs-1"></i>
                                        </div>
                                        <h5 class="text-muted fw-bold">Aucune donnée trouvée</h5>
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
                                    Affichage de <span class="text-dark fw-bold">{{ $occupations->firstItem() }}-{{ $occupations->lastItem() }}</span> sur <span class="text-dark fw-bold">{{ $occupations->total() }}</span>
                                </div>
                                <div class="modern-pagination">
                                    {{ $occupations->links() }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Modals remain logically the same but wrapped in modern CSS classes --}}
    @foreach($occupations as $occupation)
        <x-delete-model
            href="{{ route('occupations.delete', $occupation->id) }}"
            message="Supprimer définitivement '{{ $occupation->title }}' ?"
            title="Avertissement de sécurité"
            target="deleteServiceModal-{{ $occupation->id }}" />
    @endforeach

    {{-- Create Modal --}}
    <div class="modal fade" id="createServiceModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-2xl rounded-5 overflow-hidden">
                <form action="{{ route('occupations.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-5">
                        <div class="text-center mb-4">
                            <div class="bg-primary-subtle text-primary d-inline-flex p-3 rounded-circle mb-3">
                                <i class="bi bi-briefcase fs-3"></i>
                            </div>
                            <h4 class="fw-bold">Nouvelle Fonction</h4>
                            <p class="text-muted small">Ajoutez un nouveau rôle au catalogue organisationnel</p>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Intitulé de la fonction</label>
                            <input type="text" class="form-control form-control-lg bg-light border-0 rounded-4 @error('title') is-invalid @enderror" name="title" placeholder="Ex: Lead Developer..." required>
                            @error('title') <div class="text-danger extra-small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-futurist py-3 rounded-4 fw-bold shadow">Enregistrer</button>
                            <button type="button" class="btn btn-link text-muted text-decoration-none small" data-bs-dismiss="modal">Annuler</button>
                        </div>
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
                        <a href="{{ route('occupations.download') }}" class="list-group-item list-group-item-action d-flex align-items-center p-4 border-0 border-bottom transition-base">
                            <i class="bi bi-file-earmark-excel-fill text-success fs-2 me-4"></i>
                            <div>
                                <div class="fw-bold">Données Brutes (Excel)</div>
                                <small class="text-muted">Génération d'un tableau complet pour retraitement</small>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center p-4 border-0 transition-base">
                            <i class="bi bi-file-earmark-pdf-fill text-danger fs-2 me-4"></i>
                            <div>
                                <div class="fw-bold">Referentiel Métiers (PDF)</div>
                                <small class="text-muted">Document officiel de la nomenclature RH</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- CSS Styles for Futurist Feel --}}
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            --glass-bg: rgba(255, 255, 255, 0.8);
        }

        body { background-color: #f8fafc; }

        .text-primary-gradient {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .btn-futurist {
            background: var(--primary-gradient);
            color: white;
            border: none;
            box-shadow: 0 10px 20px -5px rgba(99, 102, 241, 0.4);
        }
        .btn-futurist:hover {
            color: white;
            filter: brightness(1.1);
            transform: translateY(-2px);
        }

        .btn-glass {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(226, 232, 240, 0.8);
            color: #475569;
        }

        .icon-shape-futur {
            width: 42px;
            height: 42px;
            background: #f1f5f9;
            color: #6366f1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .hover-row:hover .icon-shape-futur {
            background: var(--primary-gradient);
            color: white;
            transform: scale(1.1);
        }

        .gradient-progress {
            background: var(--primary-gradient) !important;
        }

        .badge-futur {
            background: #f8fafc;
            color: #475569;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            padding: 8px 12px;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .btn-action-circle {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            background: transparent;
            color: #94a3b8;
            transition: all 0.2s ease;
        }
        .btn-action-circle:hover {
            background: #f1f5f9;
            color: #6366f1;
        }

        .ls-1 { letter-spacing: 0.05em; }
        .extra-small { font-size: 0.75rem; }
        .shadow-2xl { box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15); }
    </style>
</x-layout>
