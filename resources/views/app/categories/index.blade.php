<x-layout>
    @push('styles')
        <style>
            :root {
                --sidebar-indigo: #4f46e5;
                --surface-glass: rgba(255, 255, 255, 0.85);
                --border-subtle: rgba(226, 232, 240, 0.8);
            }

            body { background-color: #fcfdfe; }

            /* Professional Typography & Shadows */
            .text-display { letter-spacing: -0.01em; font-weight: 700; color: #0f172a; }
            .shadow-soft { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.04), 0 4px 6px -4px rgba(0, 0, 0, 0.02); }

            /* Glassmorphism Navigation & Header */
            .glass-header {
                background: var(--surface-glass);
                backdrop-filter: blur(10px);
                border-bottom: 1px solid var(--border-subtle);
                z-index: 1020;
            }

            /* Modern Table Aesthetics */
            .table-modern thead th {
                background-color: #f8fafc;
                text-transform: uppercase;
                font-size: 0.7rem;
                letter-spacing: 0.05em;
                color: #64748b;
                padding: 1.25rem 1rem;
                border-bottom: 1px solid #e2e8f0;
            }

            .table-modern tbody tr {
                transition: all 0.2s ease;
                border-bottom: 1px solid #f1f5f9;
            }

            .table-modern tbody tr:hover {
                background-color: #f8fbff !important;
                transform: scale(0.998);
            }

            /* Category Tag Style */
            .category-indicator {
                width: 4px;
                height: 24px;
                border-radius: 2px;
                background: var(--sidebar-indigo);
            }

            /* Interactive Elements */
            .btn-action {
                width: 32px;
                height: 32px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 8px;
                transition: all 0.2s;
                background: transparent;
                border: 1px solid transparent;
            }

            .btn-action:hover {
                background: #fff;
                border-color: #e2e8f0;
                box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
            }
        </style>
    @endpush

    @section('title', 'Référentiel - HR Management')

    <div class="container-fluid py-4 px-lg-5">

        {{-- Futurist Header: Minimalist & Direct --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-5">
            <div class="mb-3 mb-md-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item small fw-bold text-muted text-uppercase ls-1">Paramétrage</li>
                        <li class="breadcrumb-item small fw-bold text-primary text-uppercase ls-1 active">Référentiel</li>
                    </ol>
                </nav>
                <h1 class="text-display h3 mb-0">Registre des <span class="text-primary">Catégories</span></h1>
                <p class="text-muted small mb-0">Gestion structurelle des groupements professionnels</p>
            </div>

            <div class="d-flex gap-3">
                <div class="dropdown">
                    <button class="btn btn-white border shadow-sm px-3 rounded-3 fw-bold" data-bs-toggle="dropdown">
                        <i class="bi bi-cloud-arrow-down me-2"></i>Exporter
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-3">
                        <li><a class="dropdown-item py-2" href="#"><i class="bi bi-filetype-xls text-success me-2"></i>Excel</a></li>
                        <li><a class="dropdown-item py-2" href="#"><i class="bi bi-filetype-pdf text-danger me-2"></i>PDF</a></li>
                    </ul>
                </div>
                <button class="btn btn-dark shadow-dark px-4 rounded-3 fw-bold" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                    <i class="bi bi-plus-lg me-2"></i>Définir une catégorie
                </button>
            </div>
        </div>

        {{-- Filter Section: Sleek Card --}}
        <div class="bg-white rounded-4 shadow-soft p-3 mb-4 border border-light">
            <form method="GET" action="{{ route('categories.index') }}" class="row g-2 align-items-center">
                <div class="col-md-9">
                    <div class="input-group input-group-merge border-0 bg-light rounded-3 px-2">
                        <span class="input-group-text bg-transparent border-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="search" value="{{ request('search') }}"
                               class="form-control bg-transparent border-0 shadow-none py-2"
                               placeholder="Filtrer par intitulé ou code analytique...">
                    </div>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100 rounded-3 fw-bold">Rechercher</button>
                    <a href="{{ route('categories.index') }}" class="btn btn-light rounded-3 px-3"><i class="bi bi-arrow-clockwise"></i></a>
                </div>
            </form>
        </div>

        {{-- Data Grid --}}
        <div class="card border-0 shadow-soft rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-modern align-middle mb-0">
                    <thead>
                    <tr>
                        <th class="ps-4">Classification Administrative</th>
                        <th class="text-center">Effectif Actuel</th>
                        <th class="text-center">Distribution</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="category-indicator me-3"></div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $category->title }}</div>
                                        <div class="extra-small text-muted text-uppercase fw-medium">CODE-{{ str_pad($category->id, 4, '0', STR_PAD_LEFT) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                    <span class="badge bg-indigo-subtle text-primary border border-primary-subtle rounded-pill px-3 fw-bold">
                                        {{ $category->employees->count() }} Agents
                                    </span>
                            </td>
                            <td class="text-center" style="min-width: 150px;">
                                @php
                                    $percent =  floor((count($category->employees) * 100) / $employee_total);
                                @endphp
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <div class="progress rounded-pill flex-grow-1" style="height: 4px; max-width: 80px;">
                                        <div class="progress-bar bg-primary" style="width: {{ $percent }}%"></div>
                                    </div>
                                    <span class="small text-muted fw-bold">{{ $percent }}%</span>
                                </div>
                            </td>
                            <td class="pe-4 text-end">
                                <style>
                                    /* Professional Action Container */
                                    .action-group {
                                        background: #ffffff;
                                        border: 1px solid #e2e8f0;
                                        padding: 4px;
                                        border-radius: 10px;
                                        display: inline-flex;
                                        gap: 4px;
                                        box-shadow: 0 1px 2px rgba(0,0,0,0.03);
                                    }

                                    /* Futurist Button Base */
                                    .btn-table-action {
                                        width: 32px;
                                        height: 32px;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        border-radius: 7px;
                                        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
                                        color: #64748b; /* Muted Slate by default */
                                        background: transparent;
                                        border: none;
                                        position: relative;
                                    }

                                    /* Individual Hover States - Defined by Intent */
                                    .btn-table-action:hover {
                                        transform: translateY(-1px);
                                    }

                                    /* View/Dashboard - Primary Soft */
                                    .action-view:hover {
                                        background-color: #eef2ff;
                                        color: #4f46e5;
                                    }

                                    /* Edit - Warning Soft */
                                    .action-edit:hover {
                                        background-color: #fffbeb;
                                        color: #d97706;
                                    }

                                    /* Delete - Danger Soft */
                                    .action-delete:hover {
                                        background-color: #fef2f2;
                                        color: #dc2626;
                                    }

                                    /* Tooltip styling for a cleaner look */
                                    .btn-table-action i {
                                        font-size: 1.1rem;
                                    }
                                </style>

                                <div class="d-flex justify-content-end">
                                    <div class="action-group">
                                        {{-- View / Dashboard --}}
                                        <a href="{{ route('categories.show', $category) }}"
                                           class="btn-table-action action-view"
                                           data-bs-toggle="tooltip"
                                           data-bs-placement="top"
                                           title="Consulter le Dashboard">
                                            <i class="bi bi-arrow-up-right-square"></i>
                                        </a>

                                        {{-- Edit --}}
                                        <button class="btn-table-action action-edit"
                                                data-bs-toggle="tooltip"
                                                title="Modifier les paramètres">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        {{-- Divider --}}
                                        <div class="vr mx-1 my-1 opacity-25"></div>

                                        {{-- Delete --}}
                                        <button class="btn-table-action action-delete"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteCategoryModal-{{ $category->id }}"
                                                data-bs-toggle="tooltip"
                                                title="Supprimer la catégorie">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-layers text-muted opacity-25" style="font-size: 3rem;"></i>
                                    <p class="text-muted mt-3">Aucun résultat ne correspond à votre recherche.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Clean Pagination --}}
            @if($categories->hasPages())
                <div class="p-4 bg-light-subtle border-top">
                    {{ $categories->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>

    {{-- Modal Create: Refined --}}
    <div class="modal fade" id="createCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 pb-0 pe-4 pt-4">
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4 pt-2">
                        <div class="text-center mb-4">
                            <div class="bg-primary-subtle text-primary d-inline-flex p-3 rounded-circle mb-3">
                                <i class="bi bi-plus-circle fs-3"></i>
                            </div>
                            <h4 class="fw-bold">Nouvelle Catégorie</h4>
                            <p class="text-muted small">Enregistrement d'un nouveau segment de personnel</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">INTITULÉ OFFICIEL</label>
                            <input type="text" name="title" class="form-control form-control-lg border-2 rounded-3 fs-6"
                                   placeholder="ex: Personnel d'Encadrement" required>
                        </div>

                        <div class="alert alert-info border-0 rounded-3 small mb-0">
                            <i class="bi bi-info-circle-fill me-2"></i> Cette catégorie sera immédiatement disponible pour l'affectation des agents.
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-light px-4 rounded-3 fw-bold" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary px-4 rounded-3 fw-bold shadow-sm">Créer la catégorie</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-layout>
