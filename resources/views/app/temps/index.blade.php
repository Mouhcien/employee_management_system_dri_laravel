<x-layout>
    @section('title', 'Gestion des intérims - HR Management')

    <div class="container-fluid py-4 px-md-5">
        {{-- Futurist Page Header --}}
        <div class="mb-5">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <nav aria-label="breadcrumb" class="mb-2">
                        <ol class="breadcrumb mb-0 extra-small text-uppercase fw-bold ls-1">
                            <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted">Gouvernance</a></li>
                            <li class="breadcrumb-item active text-primary" aria-current="page">Commandement Intérimaire</li>
                        </ol>
                    </nav>
                    <h1 class="fw-bold text-dark display-6 mb-1">Gestion des <span class="text-primary-gradient">Intérims</span></h1>
                    <p class="text-muted mb-0">Supervision des délégations de signature et responsabilités temporaires</p>
                </div>
                <div class="col-md-5 text-md-end mt-4 mt-md-0">
                    <div class="d-flex justify-content-md-end gap-2">
                        <button class="btn btn-glass shadow-sm rounded-pill px-4 fw-bold transition-base" data-bs-toggle="modal" data-bs-target="#bulkActions">
                            <i class="bi bi-cloud-arrow-down me-2 text-primary"></i>Export
                        </button>
                        <a class="btn btn-futurist shadow-lg rounded-pill px-4 fw-bold transition-base" href="{{ route('temps.create') }}">
                            <i class="bi bi-plus-circle-fill me-2"></i>Nommer un Intérimaire
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Glass Stats Deck --}}
        <div class="row g-4 mb-5">
            @php
                $stats = [
                    ['label' => 'Intérims Actifs', 'count' => $temps->count(), 'color' => '#6366f1', 'icon' => 'bi-stopwatch-fill'],
                    ['label' => 'Total Direction', 'count' => $chefs->count() , 'color' => '#8b5cf6', 'icon' => 'bi-diagram-3-fill'],
                    ['label' => 'Sites Couverts', 'count' => 0, 'color' => '#0ea5e9', 'icon' => 'bi-geo-alt-fill'],
                    ['label' => 'Délégations', 'count' => 0, 'color' => '#10b981', 'icon' => 'bi-patch-check-fill']
                ];
            @endphp
            @foreach($stats as $stat)
                <div class="col-xl-3 col-sm-6">
                    <div class="card border-0 shadow-sm rounded-4 glass-card h-100">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
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
            {{-- Search & Control Sidebar --}}
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 2rem;">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-4 d-flex align-items-center text-dark">
                            <i class="bi bi-funnel me-2 text-primary"></i>Filtres de Recherche
                        </h6>
                        <form method="GET" action="{{ route('entities.index') }}">
                            <div class="mb-4">
                                <label class="input-label">Recherche PPR / Nom</label>
                                <div class="input-group-futurist">
                                    <input type="text" name="search" value="{{ request('search') }}" class="form-control futurist-input" placeholder="ID ou Nom...">
                                    <i class="bi bi-search input-icon"></i>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="input-label">Département d'origine</label>
                                <select name="department" class="form-select futurist-input">
                                    <option value="">Tous les services</option>
                                    @foreach($chefs as $chef)
                                        <option value="{{ $chef->id }}" {{ request('chef') == $chef->id ? 'selected' : '' }}>{{ $chef->employee->lastname }} {{ $chef->employee->firstname }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-dark w-100 rounded-3 py-2 fw-bold shadow-sm transition-base">
                                <i class="bi bi-filter me-2"></i>Appliquer
                            </button>
                            <a href="{{ route('temps.index') }}" class="btn btn-link w-100 text-decoration-none text-muted small mt-2 text-center">Réinitialiser</a>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Main Table --}}
            <div class="col-lg-9">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white">
                    <div class="card-header bg-white py-4 px-4 border-bottom-0 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark d-flex align-items-center">
                            Registre des Intérims
                            <span class="badge-cyber active ms-3">{{ $temps->total() }} Actifs</span>
                        </h5>
                    </div>

                    <div class="table-responsive" style="min-height: 500px">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                            <tr class="bg-light-subtle">
                                <th class="ps-4 py-3 text-muted small text-uppercase ls-1 fw-bold border-0">Intérimaire</th>
                                <th class="py-3 text-muted small text-uppercase ls-1 fw-bold border-0">Affectation Ciblée</th>
                                <th class="py-3 text-muted small text-uppercase ls-1 fw-bold border-0">Durée / Cycle</th>
                                <th class="py-3 text-muted small text-uppercase ls-1 fw-bold border-0 text-center">Acte PDF</th>
                                <th class="pe-4 py-3 text-muted small text-uppercase ls-1 fw-bold border-0 text-end">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($temps as $temp)
                                <tr class="hover-row transition-base">
                                    <td class="ps-4 py-4">
                                        <div class="d-flex align-items-center">
                                            <div class="position-relative me-3">
                                                @if($temp->employee->photo && Storage::disk('public')->exists($temp->employee->photo))
                                                    <img src="{{ Storage::url($temp->employee->photo) }}" class="avatar-biometric" width="48" height="48">
                                                @else
                                                    <div class="avatar-biometric-placeholder">
                                                        {{ substr($temp->employee->firstname, 0, 1) }}{{ substr($temp->employee->lastname, 0, 1) }}
                                                    </div>
                                                @endif
                                                <span class="status-ring bg-{{ $temp->employee->gender == 'M' ? 'primary' : 'info' }}"></span>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark fs-6">{{ $temp->employee->lastname }} {{ $temp->employee->firstname }}</div>
                                                <code class="extra-small text-muted text-uppercase">PPR-{{ $temp->employee->id }}</code>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4">
                                        @if($temp->chef->section)
                                            <div class="d-flex flex-column">
                                                <span class="badge-node mb-1">Section: {{ $temp->chef->section->title }}</span>
                                                <span class="extra-small text-muted fw-bold"><i class="bi bi-diagram-3"></i> {{ $temp->chef->section->entity->title }}</span>
                                            </div>
                                        @elseif($temp->chef->sector)
                                            <span class="badge-node sector">Secteur: {{ $temp->chef->sector->title }}</span>
                                        @elseif($temp->chef->entity)
                                            <span class="badge-node entity">Entité: {{ $temp->chef->entity->title }}</span>
                                        @elseif($temp->chef->service)
                                            <span class="badge-node service">Service: {{ $temp->chef->service->title }}</span>
                                        @endif
                                    </td>
                                    <td class="py-4">
                                        @php
                                            $start = \Carbon\Carbon::parse($temp->starting_date);
                                            $end = $temp->finished_date ? \Carbon\Carbon::parse($temp->finished_date) : now();
                                            $interval = $start->diff($end);
                                        @endphp
                                        <div class="d-flex flex-column">
                                            <span class="small fw-bold text-dark">{{ $interval->y }}Y {{ $interval->m }}M {{ $interval->d }}D</span>
                                            <div class="d-flex align-items-center gap-2 mt-1">
                                                <span class="extra-small text-muted">{{ $start->format('d/m/y') }}</span>
                                                <i class="bi bi-arrow-right text-primary opacity-50" style="font-size: 10px;"></i>
                                                <span class="extra-small text-muted">{{ $temp->finished_date ? $end->format('d/m/y') : '...' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 text-center">
                                        @if($temp->file)
                                            <a href="{{ Storage::url($temp->file) }}" target="_blank" class="btn btn-action-circle shadow-xs">
                                                <i class="bi bi-file-earmark-pdf text-danger"></i>
                                            </a>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger extra-small fw-bold">ABSENT</span>
                                        @endif
                                    </td>
                                    <td class="pe-4 py-4 text-end">
                                        <div class="dropdown">
                                            <button class="btn btn-action-circle" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-2">
                                                <li><a class="dropdown-item rounded-3 py-2" href="{{ route('temps.edit', $temp) }}"><i class="bi bi-pencil-square me-2 text-warning"></i>Éditer Intérim</a></li>
                                                <li><a class="dropdown-item rounded-3 py-2" href="{{ route('temps.decision', $temp) }}" target="_blank"><i class="bi bi-file-check me-2 text-info"></i>Décision</a></li>
                                                <li><hr class="dropdown-divider opacity-50"></li>
                                                <li><button class="dropdown-item rounded-3 py-2 text-danger fw-bold" data-bs-toggle="modal" data-bs-target="#deleteChefTempModal-{{ $temp->id }}"><i class="bi bi-trash3 me-2"></i>Supprimer</button></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="opacity-25 mb-3"><i class="bi bi-stopwatch fs-1"></i></div>
                                        <h6 class="text-muted fw-bold">Aucun intérim répertorié</h6>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if(isset($temps) && $temps->hasPages())
                        <div class="card-footer bg-white border-top-0 py-4 px-4">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                                <div class="text-muted small">Vue {{ $temps->firstItem() }} à {{ $temps->lastItem() }} / {{ $temps->total() }}</div>
                                <div class="modern-pagination">
                                    {{ $temps->links() }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Modals --}}
    @foreach($temps as $temp)
        <x-delete-model
            href="{{ route('temps.delete', $temp->id) }}"
            message="Attention : La suppression de cet intérim est irréversible."
            title="Avertissement Gouvernance"
            target="deleteChefTempModal-{{ $temp->id }}" />
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

        .badge-node { background: #f1f5f9; color: #475569; padding: 4px 10px; border-radius: 8px; font-size: 0.7rem; font-weight: 700; }

        .btn-futurist {
            background: var(--primary-gradient); color: white; border: none;
            box-shadow: 0 10px 20px -5px rgba(99, 102, 241, 0.3);
        }
        .btn-futurist:hover { color: white; transform: translateY(-2px); filter: brightness(1.1); }

        .btn-action-circle {
            width: 38px; height: 38px; border-radius: 50%; border: none; background: #f8fafc;
            color: #94a3b8; transition: all 0.2s; display: inline-flex; align-items: center; justify-content: center;
        }
        .btn-action-circle:hover { background: #eef2ff; color: #6366f1; transform: scale(1.1); }

        .ls-1 { letter-spacing: 0.05em; }
        .extra-small { font-size: 0.7rem; }

        .table td {
            position: relative; /* Helps with z-index positioning */
        }

        /* Optional: Ensure the menu stays above other rows */
        .dropup .dropdown-menu {
            z-index: 1050;
        }
    </style>
</x-layout>
