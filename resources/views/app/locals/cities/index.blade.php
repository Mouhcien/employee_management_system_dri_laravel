<x-layout>
    @section('title', 'Gestion des villes - HR Management')

    <div class="container-fluid py-4 px-md-5">
        {{-- Futurist Page Header --}}
        <div class="mb-5">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <nav aria-label="breadcrumb" class="mb-2">
                        <ol class="breadcrumb mb-0 extra-small text-uppercase fw-bold ls-1">
                            <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted">Logistique</a></li>
                            <li class="breadcrumb-item active text-primary" aria-current="page">Déploiement Géo</li>
                        </ol>
                    </nav>
                    <h1 class="fw-bold text-dark display-6 mb-1">Réseau <span class="text-primary-gradient">Géographique</span></h1>
                    <p class="text-muted mb-0">Pilotage des implantations locales et du maillage territorial</p>
                </div>
                <div class="col-md-5 text-md-end mt-4 mt-md-0">
                    <div class="d-flex justify-content-md-end gap-2">
                        <button class="btn btn-glass shadow-sm rounded-pill px-4 fw-bold transition-base" data-bs-toggle="modal" data-bs-target="#bulkActions">
                            <i class="bi bi-cloud-arrow-down me-2"></i>Export
                        </button>
                        <button class="btn btn-futurist shadow-lg rounded-pill px-4 fw-bold transition-base" data-bs-toggle="modal" data-bs-target="#createCityModal">
                            <i class="bi bi-geo-alt-fill me-2"></i>Nouvelle Ville
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Futurist Stats Grid --}}
        <div class="row g-4 mb-5">
            @php
                $stats = [
                    ['label' => 'Villes Répertoriées', 'count' => $cities->total(), 'color' => '#6366f1', 'icon' => 'bi-geo-alt-fill'],
                    ['label' => 'Locaux Actifs', 'count' => $total_locals, 'color' => '#8b5cf6', 'icon' => 'bi-house-door-fill'],
                    ['label' => 'Densité Max', 'count' => 'Chef-lieu', 'color' => '#0ea5e9', 'icon' => 'bi-pin-map-fill'],
                    ['label' => 'Couverture', 'count' => '100%', 'color' => '#10b981', 'icon' => 'bi-shield-check']
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
            {{-- Search & Hub Filter Sidebar --}}
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 2rem;">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3 d-flex align-items-center">
                            <i class="bi bi-funnel me-2 text-primary"></i>Filtres Réseau
                        </h6>
                        <form method="GET" action="{{ route('cities.index') }}">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted text-uppercase ls-1">Ville</label>
                                <div class="input-group-futurist">
                                    <input type="text" name="search" value="{{ $filter }}" class="form-control futurist-input" placeholder="Ville ou site...">
                                    <i class="bi bi-search input-icon"></i>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted text-uppercase ls-1" >Localité</label>
                                <select name="lc" class="form-select futurist-input fw-bold" id="sl_city_local_id">
                                    <option value="-1">Tous les locaux</option>
                                    @foreach($locals as $local)
                                        <option value="{{ $local->id }}" {{ $local_id == $local->id ? 'selected' : '' }}>{{ $local->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-dark w-100 rounded-3 py-2 fw-bold shadow-sm transition-base">
                                <i class="bi bi-filter-left me-2"></i>Actualiser
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Cities Table --}}
            <div class="col-lg-9">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white">
                    <div class="card-header bg-white py-4 px-4 border-bottom-0 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark d-flex align-items-center">
                            Répertoire Géographique
                            <span class="badge-cyber active ms-3">{{ $cities->total() }} Points de présence</span>
                        </h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                            <tr class="bg-light-subtle">
                                <th class="ps-4 py-3 text-muted small text-uppercase ls-1 fw-bold border-0">Ville / Secteur</th>
                                <th class="py-3 text-muted small text-uppercase ls-1 fw-bold border-0">Hubs Rattachés</th>
                                <th class="py-3 text-muted small text-uppercase ls-1 fw-bold border-0 text-center">Population</th>
                                <th class="pe-4 py-3 text-muted small text-uppercase ls-1 fw-bold border-0 text-end">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($cities as $city)
                                <tr class="hover-row transition-base">
                                    <td class="ps-4 py-4">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-shape-futur me-3">
                                                <i class="bi bi-geo-alt"></i>
                                            </div>
                                            <div class="fw-bold text-dark fs-6">{{ $city->title }}</div>
                                        </div>
                                    </td>
                                    <td class="py-4">
                                        @if($city->locals->count() > 0)
                                            <div class="d-flex flex-wrap gap-1">
                                                @foreach($city->locals->take(2) as $local)
                                                    <span class="badge-node">
                                                            <i class="bi bi-circle-fill me-1" style="font-size: 6px;"></i>{{ $local->title }}
                                                        </span>
                                                @endforeach
                                                @if($city->locals->count() > 2)
                                                    <span class="badge-node">+{{ $city->locals->count() - 2 }}</span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-muted extra-small italic fw-medium">Zone blanche</span>
                                        @endif
                                    </td>
                                    <td class="py-4 text-center">
                                        @php $empCount = $city->locals->sum(fn($l) => $l->employees->count()); @endphp
                                        <div class="d-inline-flex flex-column align-items-center">
                                            <span class="fw-bold text-dark mb-0">{{ $empCount }}</span>
                                            <div class="progress rounded-pill mt-1" style="height: 3px; width: 40px;">
                                                <div class="progress-bar gradient-progress" style="width: {{ $empCount > 0 ? '70%' : '0' }}"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="pe-4 py-4 text-end">
                                        <div class="dropdown">
                                            <button class="btn btn-action-circle" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-2">
                                                <li><a class="dropdown-item rounded-3 py-2" href="{{ route('cities.show', $city) }}"><i class="bi bi-eye-fill me-2 text-primary"></i>Détails</a></li>
                                                <li><a class="dropdown-item rounded-3 py-2" href="#"><i class="bi bi-file-earmark-pdf me-2 text-danger"></i>Export PDF</a></li>
                                                <li><hr class="dropdown-divider opacity-50"></li>
                                                <li><button class="dropdown-item rounded-3 py-2 text-danger fw-bold" data-bs-toggle="modal" data-bs-target="#deleteCityModal-{{ $city->id }}"><i class="bi bi-trash3 me-2"></i>Supprimer</button></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div class="opacity-25 mb-3"><i class="bi bi-geo-alt fs-1"></i></div>
                                        <h6 class="text-muted fw-bold">Aucune ville enregistrée</h6>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if(isset($cities) && $cities->hasPages())
                        <div class="card-footer bg-white border-top-0 py-4 px-4">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                                <div class="text-muted small">Hubs {{ $cities->firstItem() }} à {{ $cities->lastItem() }} sur {{ $cities->total() }}</div>
                                <div class="modern-pagination">
                                    {{ $cities->links() }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Individual Delete Modals --}}
    @foreach($cities as $city)
        <x-delete-model
            href="{{ route('cities.delete', $city->id) }}"
            message="Confirmation : Dissocier tous les locaux de la ville '{{ $city->title }}' ?"
            title="Avertissement Géographique"
            target="deleteCityModal-{{ $city->id }}" />
    @endforeach

    {{-- Create Modal --}}
    <div class="modal fade" id="createCityModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-2xl rounded-5 overflow-hidden">
                <form action="{{ route('cities.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-5">
                        <div class="text-center mb-4">
                            <div class="bg-primary-subtle text-primary d-inline-flex p-3 rounded-circle mb-3">
                                <i class="bi bi-geo-alt-fill fs-3"></i>
                            </div>
                            <h4 class="fw-bold">Nouveau Hub</h4>
                            <p class="text-muted small">Ajout d'une ville au réseau opérationnel</p>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Désignation Ville</label>
                            <input type="text" id="cityTitle" name="title" class="form-control form-control-lg bg-light border-0 rounded-4" placeholder="Ex: Casablanca..." required>
                        </div>
                        <button type="submit" class="btn btn-futurist w-100 py-3 rounded-4 fw-bold shadow">Valider la ville</button>
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
                    <h5 class="modal-title fw-bold"><i class="bi bi-cloud-arrow-down me-2 text-info"></i>Export Géo</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="{{ route('cities.download') }}" class="list-group-item list-group-item-action d-flex align-items-center p-4 border-0 border-bottom transition-base">
                            <i class="bi bi-file-earmark-excel-fill text-success fs-2 me-4"></i>
                            <div><div class="fw-bold">Hub_Network.xlsx</div><small class="text-muted">Rapport complet des implantations</small></div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
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
        .hover-row:hover .icon-shape-futur { background: var(--primary-gradient); color: white; transform: rotate(15deg); }

        .badge-cyber {
            background: #f8fafc; color: #475569; border: 1.5px solid #e2e8f0;
            padding: 6px 14px; border-radius: 50px; font-weight: 700; font-size: 0.75rem;
        }
        .badge-cyber.active { background: #eef2ff; color: #6366f1; border-color: #c7d2fe; }

        .badge-node {
            background: #f1f5f9; color: #475569; padding: 4px 10px;
            border-radius: 8px; font-size: 0.72rem; font-weight: 600;
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
