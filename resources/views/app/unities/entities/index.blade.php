<x-layout>
    @section('title', 'Gestion des entités - HR Management')

    <div class="container-fluid py-4 px-md-5">
        {{-- Futurist Page Header --}}
        <div class="mb-5">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <nav aria-label="breadcrumb" class="mb-2">
                        <ol class="breadcrumb mb-0 extra-small text-uppercase fw-bold ls-1">
                            <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted">Structure</a></li>
                            <li class="breadcrumb-item active text-primary" aria-current="page">Architecture Entités</li>
                        </ol>
                    </nav>
                    <h1 class="fw-bold text-dark display-6 mb-1">Architecture des <span class="text-primary-gradient">Entités</span></h1>
                    <p class="text-muted mb-0">Segmentation opérationnelle et hiérarchique de votre organisation</p>
                </div>
                <div class="col-md-5 text-md-end mt-4 mt-md-0">
                    <div class="d-flex justify-content-md-end gap-2">
                        @php
                            $query = 'query';
                            if (request('search')) $query .= '&search='.request('search');
                            if (request('cat')) $query .= '&cat='.request('cat');
                            if (request('srv')) $query .= '&srv='.request('srv');
                        @endphp
                        <a class="btn btn-glass shadow-sm rounded-pill px-4 fw-bold transition-base" href="{{ route('entities.download') }}{{ (request('srv') || request('cat') || request('search')) ? '?'.$query : '' }}">
                            <i class="bi bi-cloud-arrow-down me-2"></i>Export
                        </a>
                        <a href="{{ route('entities.create') }}" class="btn btn-futurist shadow-lg rounded-pill px-4 fw-bold transition-base">
                            <i class="bi bi-plus-lg me-2"></i>Nouvelle Entité
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Glass Stats Deck --}}
        <div class="row g-4 mb-5">
            @php
                $stats = [
                    ['label' => 'Entités Totales', 'count' => $entities->total(), 'color' => '#6366f1', 'icon' => 'bi-diagram-2-fill'],
                    ['label' => 'Services', 'count' => $total_service - 1, 'color' => '#10b981', 'icon' => 'bi-diagram-3-fill'],
                    ['label' => 'Secteurs', 'count' => $total_sector, 'color' => '#0ea5e9', 'icon' => 'bi-grid-1x2'],
                    ['label' => 'Sections', 'count' => $total_section, 'color' => '#f59e0b', 'icon' => 'bi-layers']
                ];
            @endphp
            @foreach($stats as $stat)
                <div class="col-xl-3 col-sm-6">
                    <div class="card border-0 shadow-sm rounded-4 glass-card h-100">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="icon-box-futur" style="background: {{ $stat['color'] }}20; color: {{ $stat['color'] }}">
                                    <i class="bi {{ $stat['icon'] }} fs-4"></i>
                                </div>
                                <div class="pulse-indicator" style="background-color: {{ $stat['color'] }}"></div>
                            </div>
                            <h3 class="fw-bold mb-1 text-dark">{{ $stat['count'] ?? 0 }}</h3>
                            <p class="text-muted small mb-0 fw-bold text-uppercase ls-1">{{ $stat['label'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Advanced Filter Sidebar + Table Layout --}}
        <div class="row g-4">
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 2rem;">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3 d-flex align-items-center text-dark">
                            <i class="bi bi-funnel me-2 text-primary"></i>Filtres Segment
                        </h6>
                        <form method="GET" action="{{ route('entities.index') }}">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted text-uppercase ls-1">Recherche</label>
                                <div class="input-group-futurist">
                                    <input type="text" name="search" value="{{ request('search') }}" class="form-control futurist-input" placeholder="Nom ou service...">
                                    <i class="bi bi-search input-icon"></i>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted text-uppercase ls-1">Service</label>
                                <select name="srv" class="form-select futurist-input fw-bold">
                                    <option value="-1">Tous les services</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}" {{ $service_id == $service->id ? 'selected' : '' }}>{{ $service->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="form-label small fw-bold text-muted text-uppercase ls-1">Catégorie</label>
                                <select name="cat" class="form-select futurist-input fw-bold">
                                    <option value="-1">Toutes catégories</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type->id }}" {{ $type_id == $type->id ? 'selected' : '' }}>{{ $type->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-dark w-100 rounded-3 py-2 fw-bold shadow-sm transition-base">
                                <i class="bi bi-filter-left me-2"></i>Actualiser
                            </button>
                            <a href="{{ route('entities.index') }}" class="btn btn-link w-100 text-decoration-none text-muted small mt-2 text-center">Réinitialiser</a>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white">
                    <div class="card-header bg-white py-4 px-4 border-bottom-0 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark d-flex align-items-center">
                            Répertoire des Entités
                            <span class="badge-cyber active ms-3">{{ $entities->total() }} Entités</span>
                        </h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                            <tr class="bg-light-subtle">
                                <th class="ps-4 py-3 text-muted small text-uppercase ls-1 fw-bold border-0">Catégorie</th>
                                <th class="py-3 text-muted small text-uppercase ls-1 fw-bold border-0">Désignation</th>
                                <th class="py-3 text-muted small text-uppercase ls-1 fw-bold border-0 text-center">Rattachement</th>
                                <th class="pe-4 py-3 text-muted small text-uppercase ls-1 fw-bold border-0 text-end">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($entities as $entity)
                                <tr class="hover-row transition-base">
                                    <td class="ps-4 py-4">
                                            <span class="badge-cyber">
                                                {{ $entity->type->title ?? 'Générale' }}
                                            </span>
                                    </td>
                                    <td class="py-4">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-shape-futur me-3">
                                                <i class="bi bi-diagram-2-fill"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark fs-6">{{ $entity->title }}</div>
                                                @if($entity->chefs->where('state', true)->isNotEmpty())
                                                    @foreach($entity->chefs->where('state', true) as $chef)
                                                        <a href="{{ Storage::url($chef->decision_file) }}" target="_blank" class="extra-small text-primary fw-bold text-decoration-none">
                                                            <i class="bi bi-person-badge-fill me-1"></i>{{ $chef->employee->lastname }} {{ $chef->employee->firstname }}
                                                        </a>
                                                    @endforeach
                                                @else
                                                    <span class="extra-small text-muted italic">Sans responsable</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 text-center">
                                            <span class="badge-node">
                                                <i class="bi bi-building me-1"></i>{{ $entity->service->title ?? 'Indépendant' }}
                                            </span>
                                    </td>
                                    <td class="pe-4 py-4 text-end">
                                        <div class="dropdown">
                                            <button class="btn btn-action-circle" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-2">
                                                <li><a class="dropdown-item rounded-3 py-2" href="{{ route('entities.show', $entity) }}"><i class="bi bi-eye-fill me-2 text-primary"></i>Détails</a></li>
                                                <li><a class="dropdown-item rounded-3 py-2" href="{{ route('entities.edit', $entity) }}"><i class="bi bi-pencil-fill me-2 text-success"></i>Modifier</a></li>
                                                <li><hr class="dropdown-divider opacity-50"></li>
                                                <li><button class="dropdown-item rounded-3 py-2 text-danger fw-bold" data-bs-toggle="modal" data-bs-target="#deleteEntityModal-{{ $entity->id }}"><i class="bi bi-trash3 me-2"></i>Supprimer</button></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div class="opacity-25 mb-3"><i class="bi bi-diagram-2 fs-1"></i></div>
                                        <h6 class="text-muted fw-bold">Aucune entité détectée</h6>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if(isset($entities) && $entities->hasPages())
                        <div class="card-footer bg-white border-top-0 py-4 px-4">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                                <div class="text-muted small">Entités {{ $entities->firstItem() }} à {{ $entities->lastItem() }} sur {{ $entities->total() }}</div>
                                <div class="modern-pagination">
                                    {{ $entities->links() }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Individual Modals preserved --}}
    @foreach($entities as $entity)
        <x-delete-model
            href="{{ route('entities.delete', $entity->id) }}"
            message="Confirmation : Retirer '{{ $entity->title }}' de l'architecture ?"
            title="Avertissement Structurel"
            target="deleteEntityModal-{{ $entity->id }}" />
    @endforeach

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            --accent-glow: rgba(99, 102, 241, 0.15);
        }

        body { background-color: #f8fafc; }

        .text-primary-gradient {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(226, 232, 240, 0.8) !important;
        }

        .icon-box-futur {
            width: 48px; height: 48px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 14px;
        }

        .pulse-indicator {
            width: 8px; height: 8px; border-radius: 50%;
            animation: pulse-glow 2s infinite;
        }

        @keyframes pulse-glow {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.5); opacity: 0.5; }
            100% { transform: scale(1); opacity: 1; }
        }

        .btn-futurist {
            background: var(--primary-gradient);
            color: white; border: none;
            box-shadow: 0 10px 20px -5px rgba(99, 102, 241, 0.3);
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
            color: #f59e0b; display: flex; align-items: center; justify-content: center;
            border-radius: 12px; transition: all 0.3s ease;
        }
        .hover-row:hover .icon-shape-futur { background: #fef3c7; transform: scale(1.1); }

        .badge-cyber {
            background: #f8fafc; color: #475569; border: 1.5px solid #e2e8f0;
            padding: 6px 14px; border-radius: 50px; font-weight: 700; font-size: 0.75rem;
        }
        .badge-cyber.active { background: #eef2ff; color: #6366f1; border-color: #c7d2fe; }

        .badge-node {
            background: #f1f5f9; color: #475569; padding: 4px 10px;
            border-radius: 8px; font-size: 0.72rem; font-weight: 600;
        }

        .btn-action-circle {
            width: 38px; height: 38px; border-radius: 50%; border: none; background: transparent; color: #94a3b8; transition: all 0.2s;
        }
        .btn-action-circle:hover { background: #f1f5f9; color: #6366f1; }

        .ls-1 { letter-spacing: 0.05em; }
        .extra-small { font-size: 0.72rem; }
    </style>
</x-layout>
