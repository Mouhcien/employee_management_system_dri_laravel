<x-layout>
    @section('title', 'Gestion des chefs - HR Management')

    <div class="container-fluid py-4 px-md-5">
        {{-- Futurist Page Header --}}
        <div class="mb-5">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <nav aria-label="breadcrumb" class="mb-2">
                        <ol class="breadcrumb mb-0 extra-small text-uppercase fw-bold ls-1">
                            <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted">Gouvernance</a></li>
                            <li class="breadcrumb-item active text-primary" aria-current="page">Responsables</li>
                        </ol>
                    </nav>
                    <h1 class="fw-bold text-dark display-6 mb-1">Gestion <span class="text-primary-gradient">Résponsable</span></h1>
                    <p class="text-muted mb-0">Supervision des têtes de pont et suivi des actes de nomination</p>
                </div>
                <div class="col-md-5 text-md-end mt-4 mt-md-0">
                    <div class="d-flex justify-content-md-end gap-2">
                        <a class="btn btn-glass shadow-sm rounded-pill px-4 fw-bold transition-base" href="{{ route('chefs.download') }}">
                            <i class="bi bi-cloud-arrow-down me-2"></i>Rapport Global
                        </a>
                        <a href="{{ route('chefs.index') }}" class="btn btn-action-circle shadow-sm">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Glass Stats Deck --}}
        <div class="row g-4 mb-5">
            @php
                $stats = [
                    ['label' => 'Services', 'count' => $services->count() - 1, 'color' => '#6366f1', 'icon' => 'bi-diagram-3'],
                    ['label' => 'Entités', 'count' => $entities->count() - 1, 'color' => '#8b5cf6', 'icon' => 'bi-diagram-2'],
                    ['label' => 'Secteurs', 'count' => $sectors->count(), 'color' => '#0ea5e9', 'icon' => 'bi-grid-1x2'],
                    ['label' => 'Sections', 'count' => $sections->count(), 'color' => '#10b981', 'icon' => 'bi-layers']
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
            {{-- Technical Control Sidebar --}}
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 2rem;">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-4 d-flex align-items-center text-dark">
                            <i class="bi bi-funnel me-2 text-primary"></i>Filtres de Structure
                        </h6>
                        <form method="GET" action="{{ route('chefs.index') }}">
                            {{-- Search --}}
                            <div class="mb-3">
                                <label class="input-label">Recherche Nom</label>
                                <div class="input-group-futurist">
                                    <input type="text" name="search" value="{{ $filter }}" class="form-control futurist-input" placeholder="ID ou Nom...">
                                    <i class="bi bi-search input-icon"></i>
                                </div>
                            </div>

                            <hr class="my-4 opacity-50">

                            {{-- Structural Filters --}}
                            <div class="mb-3">
                                <label class="input-label">Service Hub</label>
                                <select name="chef_service_id" class="form-select futurist-input small">
                                    <option value="-1">Tous les services</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}" {{ $service_id == $service->id ? 'selected' : '' }}>{{ $service->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="input-label">Entité Segment</label>
                                <select name="chef_entity_id" class="form-select futurist-input small">
                                    <option value="-1">Toutes les entités</option>
                                    @foreach($entities as $entity)
                                        <option value="{{ $entity->id }}" {{ $entity_id == $entity->id ? 'selected' : '' }}>{{ $entity->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="input-label">Unité / Section</label>
                                <select name="chef_section_id" class="form-select futurist-input small">
                                    <option value="-1">Toutes les sections</option>
                                    @foreach($sections as $section)
                                        <option value="{{ $section->id }}" {{ $section_id == $section->id ? 'selected' : '' }}>{{ $section->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-dark w-100 rounded-3 py-2 fw-bold shadow-sm transition-base">
                                <i class="bi bi-cpu me-2"></i>Traiter les Données
                            </button>
                            <a href="{{ route('chefs.index') }}" class="btn btn-link w-100 text-decoration-none text-muted small mt-2 text-center">Réinitialiser</a>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Main Registry --}}
            <div class="col-lg-9">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white">
                    <div class="card-header bg-white py-4 px-4 border-bottom-0 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark d-flex align-items-center">
                            Effectif Directionnel
                            <span class="badge-cyber active ms-3">{{ $chefs->total() }} Actifs</span>
                        </h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                            <tr class="bg-light-subtle">
                                <th class="ps-4 py-3 text-muted small text-uppercase ls-1 fw-bold border-0">Responsable</th>
                                <th class="py-3 text-muted small text-uppercase ls-1 fw-bold border-0">Entité Administrative</th>
                                <th class="py-3 text-muted small text-uppercase ls-1 fw-bold border-0">Expérience</th>
                                <th class="py-3 text-muted small text-uppercase ls-1 fw-bold border-0 text-center">Acte</th>
                                <th class="pe-4 py-3 text-muted small text-uppercase ls-1 fw-bold border-0 text-end">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($chefs as $chef)
                                <tr class="hover-row transition-base">
                                    <td class="ps-4 py-4">
                                        <div class="d-flex align-items-center">
                                            <div class="position-relative me-3">
                                                @if($chef->employee->photo && Storage::disk('public')->exists($chef->employee->photo))
                                                    <img src="{{ Storage::url($chef->employee->photo) }}" class="avatar-biometric" width="48" height="48">
                                                @else
                                                    <div class="avatar-biometric-placeholder">
                                                        {{ substr($chef->employee->firstname, 0, 1) }}{{ substr($chef->employee->lastname, 0, 1) }}
                                                    </div>
                                                @endif
                                                <span class="status-ring bg-{{ $chef->employee->gender == 'M' ? 'primary' : 'info' }}"></span>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark fs-6">{{ $chef->employee->lastname }} {{ $chef->employee->firstname }}</div>
                                                <code class="extra-small text-muted text-uppercase">PPR-{{ $chef->employee->id }}</code>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4">
                                        @if($chef->section)
                                            <div class="d-flex flex-column">
                                                <span class="badge-node mb-1">Section: {{ $chef->section->title }}</span>
                                                <span class="extra-small text-muted fw-bold"><i class="bi bi-chevron-right"></i> {{ $chef->section->entity->title }}</span>
                                            </div>
                                        @elseif($chef->sector)
                                            <span class="badge-node sector">Secteur: {{ $chef->sector->title }}</span>
                                        @elseif($chef->entity)
                                            <span class="badge-node entity">{{ $chef->entity->title }}</span>
                                        @elseif($chef->service)
                                            <span class="badge-node service">{{ $chef->service->title }}</span>
                                        @endif
                                    </td>
                                    <td class="py-4">
                                        @php
                                            $interval = \Carbon\Carbon::parse($chef->starting_date)->diff(now());
                                        @endphp
                                        <div class="small fw-bold text-dark">{{ $interval->y }}Y {{ $interval->m }}M</div>
                                        <div class="progress rounded-pill mt-1" style="height: 4px; width: 60px;">
                                            <div class="progress-bar gradient-progress" style="width: {{ min(($interval->y * 8) + 10, 100) }}%"></div>
                                        </div>
                                    </td>
                                    <td class="py-4 text-center">
                                        @if($chef->decision_file)
                                            <a href="{{ Storage::url($chef->decision_file) }}" target="_blank" class="btn btn-action-circle shadow-xs">
                                                <i class="bi bi-file-earmark-pdf text-danger"></i>
                                            </a>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger extra-small fw-bold">NO_FILE</span>
                                        @endif
                                    </td>
                                    <td class="pe-4 py-4 text-end">
                                        <div class="dropdown">
                                            <button class="btn btn-action-circle" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-2">
                                                <li><a class="dropdown-item rounded-3 py-2" href="{{ route('chefs.edit', $chef) }}"><i class="bi bi-pencil-square me-2 text-warning"></i>Éditer</a></li>
                                                <li><a class="dropdown-item rounded-3 py-2" href="#"><i class="bi bi-clock-history me-2 text-info"></i>Log Historique</a></li>
                                                <li><hr class="dropdown-divider opacity-50"></li>
                                                <li><button class="dropdown-item rounded-3 py-2 text-danger fw-bold" data-bs-toggle="modal" data-bs-target="#deleteChefModal-{{ $chef->id }}"><i class="bi bi-trash3 me-2"></i>Révoquer</button></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="opacity-25 mb-3"><i class="bi bi-person-x fs-1"></i></div>
                                        <h6 class="text-muted fw-bold">Aucune donnée de direction trouvée</h6>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination Footer --}}
                    @if(isset($chefs) && $chefs->hasPages())
                        <div class="card-footer bg-white border-top-0 py-4 px-4">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                                <div class="text-muted small">Hub {{ $chefs->firstItem() }}-{{ $chefs->lastItem() }} / {{ $chefs->total() }}</div>
                                <div class="modern-pagination">
                                    {{ $chefs->links() }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Modals Preservation --}}
    @foreach($chefs as $chef)
        <x-delete-model
            href="{{ route('entities.delete', $chef->id) }}"
            message="Attention : La révocation de ce responsable est irréversible."
            title="Avertissement Gouvernance"
            target="deleteChefModal-{{ $chef->id }}" />
    @endforeach

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            --accent-glow: rgba(99, 102, 241, 0.15);
        }

        body { background-color: #f8fafc; }
        .text-primary-gradient { background: var(--primary-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }

        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(226, 232, 240, 0.8) !important;
        }

        .icon-box-futur { width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; border-radius: 14px; }
        .pulse-indicator { width: 8px; height: 8px; border-radius: 50%; animation: pulse-glow 2s infinite; }
        @keyframes pulse-glow { 0% { transform: scale(1); opacity: 1; } 50% { transform: scale(1.5); opacity: 0.5; } 100% { transform: scale(1); opacity: 1; } }

        .input-label { font-size: 0.72rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; margin-bottom: 0.5rem; display: block; }
        .input-group-futurist { position: relative; }
        .futurist-input {
            background: #f1f5f9 !important; border: 2px solid transparent !important;
            padding: 8px 12px 8px 40px !important; border-radius: 10px !important; transition: all 0.3s ease;
            font-size: 0.85rem; font-weight: 600;
        }
        .futurist-input:focus { background: white !important; border-color: #6366f1 !important; box-shadow: 0 0 0 4px var(--accent-glow) !important; }
        .input-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #6366f1; }

        .avatar-biometric { border-radius: 14px; border: 2px solid #eef2ff; padding: 2px; background: white; object-fit: cover; }
        .avatar-biometric-placeholder {
            width: 48px; height: 48px; border-radius: 14px; background: #eef2ff; color: #6366f1;
            display: flex; align-items: center; justify-content: center; font-weight: 800; border: 2px solid #eef2ff;
        }
        .status-ring { position: absolute; bottom: -2px; right: -2px; width: 14px; height: 14px; border: 2.5px solid white; border-radius: 50%; }

        .badge-cyber {
            background: #f8fafc; color: #475569; border: 1.5px solid #e2e8f0;
            padding: 6px 14px; border-radius: 50px; font-weight: 700; font-size: 0.75rem;
        }
        .badge-cyber.active { background: #eef2ff; color: #6366f1; border-color: #c7d2fe; }

        .badge-node {
            background: #f1f5f9; color: #475569; padding: 4px 10px; border-radius: 8px; font-size: 0.7rem; font-weight: 700;
        }
        .badge-node.sector { background: #ecfeff; color: #0891b2; }
        .badge-node.entity { background: #fff7ed; color: #ea580c; }
        .badge-node.service { background: #f0f9ff; color: #0284c7; }

        .gradient-progress { background: var(--primary-gradient) !important; }

        .btn-action-circle {
            width: 38px; height: 38px; border-radius: 50%; border: none; background: #f8fafc;
            color: #94a3b8; transition: all 0.2s; display: inline-flex; align-items: center; justify-content: center;
        }
        .btn-action-circle:hover { background: #eef2ff; color: #6366f1; transform: scale(1.1); }

        .ls-1 { letter-spacing: 0.05em; }
        .extra-small { font-size: 0.7rem; }
    </style>
</x-layout>
