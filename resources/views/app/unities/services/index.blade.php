<x-layout>
    @section('title', 'Architecture des Services - HR Management')

    <div class="container-fluid py-4 px-md-5">
        {{-- Futurist Page Header --}}
        <div class="mb-5">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <nav aria-label="breadcrumb" class="mb-2">
                        <ol class="breadcrumb mb-0 extra-small text-uppercase fw-bold ls-1">
                            <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted">Organisation</a></li>
                            <li class="breadcrumb-item active text-primary" aria-current="page">Architecture</li>
                        </ol>
                    </nav>
                    <h1 class="fw-bold text-dark display-6 mb-1">Architecture des <span class="text-primary-gradient">Services</span></h1>
                    <p class="text-muted mb-0">Modélisation et pilotage des unités administratives de la structure</p>
                </div>
                <div class="col-md-5 text-md-end mt-4 mt-md-0">
                    <div class="d-flex justify-content-md-end gap-2">
                        <a class="btn btn-glass shadow-sm rounded-pill px-4 fw-bold transition-base" href="{{ route('services.download') }}">
                            <i class="bi bi-cloud-arrow-down me-2"></i>Export
                        </a>
                        <button class="btn btn-futurist shadow-lg rounded-pill px-4 fw-bold transition-base" data-bs-toggle="modal" data-bs-target="#createServiceModal">
                            <i class="bi bi-plus-lg me-2"></i>Nouveau Service
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Glass Stats Deck --}}
        <div class="row g-4 mb-5">
            @php
                $stats = [
                    ['label' => 'Total Services', 'count' => $services->total() - 1, 'color' => '#6366f1', 'icon' => 'bi-diagram-3-fill'],
                    ['label' => 'Entités', 'count' => $total_entity, 'color' => '#8b5cf6', 'icon' => 'bi-diagram-2-fill'],
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

        <div class="row g-4">
            {{-- Search & Filter Sidebar --}}
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 2rem;">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3 d-flex align-items-center">
                            <i class="bi bi-search me-2 text-primary"></i>Exploration
                        </h6>
                        <form method="GET" action="{{ route('services.index') }}">
                            <div class="mb-4">
                                <label class="form-label small fw-bold text-muted text-uppercase ls-1">Libellé du Service</label>
                                <div class="input-group-futurist">
                                    <input type="text" name="search" value="{{ $filter }}" class="form-control futurist-input" placeholder="Ex: Ressources Humaines...">
                                    <i class="bi bi-tag input-icon"></i>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-dark w-100 rounded-3 py-2 fw-bold shadow-sm transition-base">
                                <i class="bi bi-funnel me-2"></i>Actualiser
                            </button>
                            @if($filter)
                                <a href="{{ route('services.index') }}" class="btn btn-link w-100 text-decoration-none text-muted small mt-2 text-center">Réinitialiser</a>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

            {{-- Services Registry --}}
            <div class="col-lg-9">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white">
                    <div class="card-header bg-white py-4 px-4 border-bottom-0 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark d-flex align-items-center">
                            Registre des Unités
                            <span class="badge-cyber active ms-3">{{ $services->total() - 1 }} Services</span>
                        </h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                            <tr class="bg-light-subtle">
                                <th class="ps-4 py-3 text-muted small text-uppercase ls-1 fw-bold border-0">Service & ID</th>
                                <th class="py-3 text-muted small text-uppercase ls-1 fw-bold border-0">Responsable</th>
                                <th class="py-3 text-muted small text-uppercase ls-1 fw-bold border-0 text-center">Effectif</th>
                                <th class="pe-4 py-3 text-muted small text-uppercase ls-1 fw-bold border-0 text-end">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($services as $service)
                                <tr class="hover-row transition-base">
                                    <td class="ps-4 py-4">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-shape-futur me-3">
                                                <i class="bi bi-diagram-3-fill"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark fs-6">{{ $service->title }}</div>
                                                <code class="extra-small text-primary">UNIT-{{ str_pad($service->id, 3, '0', STR_PAD_LEFT) }}</code>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4">
                                        @if($service->chefs->where('state', true)->isNotEmpty())
                                            @foreach($service->chefs->where('state', true) as $chef)
                                                <div class="d-flex align-items-center">
                                                    <div class="management-pill">
                                                        <i class="bi bi-person-badge-fill me-2 text-primary"></i>
                                                        <a href="{{ Storage::url($chef->decision_file) }}" target="_blank" class="text-decoration-none text-dark fw-bold small">
                                                            {{ $chef->employee->lastname }}
                                                        </a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <span class="badge-cyber">Vacant</span>
                                        @endif
                                    </td>
                                    <td class="py-4 text-center">
                                        @php $count = is_null($service->affectations) ? 0 : count($service->affectations); @endphp
                                        <div class="d-inline-flex flex-column align-items-center">
                                            <span class="fw-bold text-dark mb-0">{{ $count }}</span>
                                            <div class="progress rounded-pill mt-1" style="height: 3px; width: 40px;">
                                                <div class="progress-bar gradient-progress" style="width: {{ $count > 0 ? '75%' : '0' }}"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="pe-4 py-4 text-end">
                                        <div class="dropdown">
                                            <button class="btn btn-action-circle" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-2">
                                                <li><a class="dropdown-item rounded-3 py-2" href="{{ route('services.show', $service) }}"><i class="bi bi-eye-fill me-2 text-primary"></i>Explorer</a></li>
                                                <li><a class="dropdown-item rounded-3 py-2" href="#"><i class="bi bi-envelope-at me-2 text-info"></i>Notifier</a></li>
                                                <li><hr class="dropdown-divider opacity-50"></li>
                                                <li><button class="dropdown-item rounded-3 py-2 text-danger fw-bold" data-bs-toggle="modal" data-bs-target="#deleteServiceModal-{{ $service->id }}"><i class="bi bi-trash3 me-2"></i>Supprimer</button></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div class="opacity-25 mb-3"><i class="bi bi-folder-x fs-1"></i></div>
                                        <h6 class="text-muted fw-bold">Architecture vide</h6>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if(isset($services) && $services->hasPages())
                        <div class="card-footer bg-white border-top-0 py-4 px-4">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                                <div class="text-muted small">Unités {{ $services->firstItem() }} à {{ $services->lastItem() }} sur {{ $services->total() }}</div>
                                <div class="modern-pagination">
                                    {{ $services->links() }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Individual Modals --}}
    @foreach($services as $service)
        <x-delete-model
            href="{{ route('services.delete', $service->id) }}"
            message="Confirmation : Dissocier toutes les entités du service '{{ $service->title }}' ?"
            title="Avertissement Architecture"
            target="deleteServiceModal-{{ $service->id }}" />
    @endforeach

    {{-- Create Modal --}}
    <div class="modal fade" id="createServiceModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-2xl rounded-5 overflow-hidden">
                <form action="{{ route('services.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-5">
                        <div class="text-center mb-4">
                            <div class="bg-primary-subtle text-primary d-inline-flex p-3 rounded-circle mb-3">
                                <i class="bi bi-plus-lg fs-3"></i>
                            </div>
                            <h4 class="fw-bold">Nouvelle Unité</h4>
                            <p class="text-muted small">Extension de la classification administrative</p>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Intitulé du Service</label>
                            <input type="text" id="categoryTitle" name="title" class="form-control form-control-lg bg-light border-0 rounded-4" placeholder="Ex: Service Logistique..." required>
                        </div>
                        <button type="submit" class="btn btn-futurist w-100 py-3 rounded-4 fw-bold shadow">Valider la création</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
            color: #6366f1; display: flex; align-items: center; justify-content: center;
            border-radius: 12px; transition: all 0.3s ease;
        }
        .hover-row:hover .icon-shape-futur { background: var(--primary-gradient); color: white; }

        .management-pill {
            background: #f8fafc; border: 1.5px solid #e2e8f0;
            padding: 6px 12px; border-radius: 10px; transition: all 0.2s;
        }
        .management-pill:hover { border-color: #6366f1; background: #eef2ff; }

        .badge-cyber {
            background: #f8fafc; color: #475569; border: 1.5px solid #e2e8f0;
            padding: 6px 14px; border-radius: 50px; font-weight: 700; font-size: 0.75rem;
        }
        .badge-cyber.active { background: #eef2ff; color: #6366f1; border-color: #c7d2fe; }

        .gradient-progress { background: var(--primary-gradient) !important; }

        .btn-action-circle {
            width: 38px; height: 38px; border-radius: 50%; border: none; background: transparent; color: #94a3b8; transition: all 0.2s;
        }
        .btn-action-circle:hover { background: #f1f5f9; color: #6366f1; }

        .ls-1 { letter-spacing: 0.05em; }
        .extra-small { font-size: 0.72rem; }
        .shadow-2xl { box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15); }
    </style>
</x-layout>
