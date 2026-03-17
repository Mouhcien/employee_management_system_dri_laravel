<x-layout>
    @section('title', 'Gestion des secteurs - HR Management')

    <div class="container-fluid py-4">
        {{-- Glassmorphic Page Header --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="bg-primary bg-gradient p-4 text-white">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="fw-bold mb-1">Architecture des Secteurs</h2>
                            <p class="opacity-75 mb-0">Gérez les sous-unités et la répartition géographique ou technique</p>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <a href="{{ route('sectors.create') }}" class="btn btn-white btn-rounded shadow-sm fw-bold px-4 me-2">
                                <i class="bi bi-plus-lg me-2"></i>Nouveau Secteur
                            </a>
                            @php
                                $query = 'query';
                                if (request('search'))
                                    $query .= '&search='.request('search');
                                if (request('ent'))
                                    $query .= '&ent='.request('ent');
                                if (request('srv'))
                                    $query .= '&srv='.request('srv');
                            @endphp

                            @if (request('srv') ||request('ent') || request('search'))
                                <a class="btn btn-light btn-rounded shadow-sm" href="{{ route('sectors.download') }}?{{ $query }}" >
                                    <i class="bi bi-download"></i>
                                </a>
                            @else
                                <a class="btn btn-light btn-rounded shadow-sm" href="{{ route('sectors.download') }}" >
                                    <i class="bi bi-download"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Dynamic Stats Grid --}}
        <div class="row g-3 mb-4">
            @php
                $stats = [
                    ['label' => 'Secteurs Totaux', 'count' => $sectors->total(), 'color' => 'primary', 'icon' => 'bi-grid-3x3-gap-fill'],
                    ['label' => 'Entités Parentes', 'count' => $total_entity, 'color' => 'success', 'icon' => 'bi-diagram-3-fill'],
                    ['label' => 'Sections Liées', 'count' => $total_section, 'color' => 'info', 'icon' => 'bi-bounding-box-circles'],
                    ['label' => 'Services', 'count' => $total_service - 1, 'color' => 'warning', 'icon' => 'bi-building-fill']
                ];
            @endphp
            @foreach($stats as $stat)
                <div class="col-xl-3 col-sm-6">
                    <div class="card border-0 shadow-sm rounded-4 hover-lift h-100">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-{{ $stat['color'] }}-subtle text-{{ $stat['color'] }} rounded-4 p-3 me-3">
                                    <i class="bi {{ $stat['icon'] }} fs-4"></i>
                                </div>
                                <div>
                                    <h4 class="fw-bold mb-0 text-dark">{{ $stat['count'] ?? 0 }}</h4>
                                    <p class="text-muted small mb-0 fw-medium text-uppercase ls-1">{{ $stat['label'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Advanced Filter Bar --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                <form method="GET" action="{{ route('sectors.index') }}" class="row g-3 align-items-end">
                    <div class="col-lg-4">
                        <label class="form-label fw-bold small text-uppercase text-muted">Recherche</label>
                        <div class="input-group bg-light border-0 rounded-3">
                            <span class="input-group-text bg-transparent border-0"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" value="{{ $filter }}" class="form-control bg-transparent border-0 shadow-none py-2" placeholder="Nom du secteur ou entité...">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Service</label>
                        <select name="srv" id="sl_sector_service_id" class="form-select border-0 bg-light rounded-3 shadow-none">
                            <option value="-1">Tous les services</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ $service_id == $service->id ? 'selected' : '' }}>{{ $service->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Entité</label>
                        <select name="ent" id="sl_sector_entity_id" class="form-select border-0 bg-light rounded-3 shadow-none">
                            <option value="-1">Toutes les entités</option>
                            @foreach($entities as $entity)
                                <option value="{{ $entity->id }}" {{ $entity_id == $entity->id ? 'selected' : '' }}>{{ $entity->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2 d-flex gap-2">
                        <button type="submit" class="btn btn-dark w-100 rounded-3"><i class="bi bi-filter"></i></button>
                        <a href="{{ route('sectors.index') }}" class="btn btn-outline-secondary rounded-3"><i class="bi bi-arrow-clockwise"></i></a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Sectors Table Card --}}
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-header bg-white py-3 px-4 border-bottom-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-grid-3x3 text-primary me-2"></i>Répertoire des Secteurs</h5>
                <span class="badge bg-primary-subtle text-primary rounded-pill px-3">{{ $sectors->total() }} au total</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light-subtle">
                    <tr>
                        <th class="ps-4 py-3 text-muted small text-uppercase ls-1 fw-bold border-0">Identification</th>
                        <th class="py-3 text-muted small text-uppercase ls-1 fw-bold border-0">Hiérarchie Parente</th>
                        <th class="py-3 text-muted small text-uppercase ls-1 fw-bold border-0">Responsable (Chef)</th>
                        <th class="py-3 text-muted small text-uppercase ls-1 fw-bold border-0 text-center">Effectif</th>
                        <th class="pe-4 py-3 text-muted small text-uppercase ls-1 fw-bold border-0 text-end">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($sectors as $sector)
                        <tr class="hover-row transition-base">
                            <td class="ps-4 py-3">
                                <div class="fw-bold text-dark">{{ $sector->title }}</div>
                                <small class="text-muted">Code Secteur: #S0{{ $sector->id }}</small>
                            </td>
                            <td class="py-3">
                                <div class="d-flex flex-column gap-1">
                                    <span class="badge bg-primary-subtle text-primary rounded-pill w-fit small px-2">
                                        <i class="bi bi-diagram-3-fill me-1"></i>{{ $sector->entity->title ?? 'Indépendant' }}
                                    </span>
                                    <small class="text-muted extra-small ms-1">
                                        <i class="bi bi-chevron-double-right me-1"></i>{{ $sector->entity->service->title ?? 'Service Global' }}
                                    </small>
                                </div>
                            </td>
                            <td class="py-3">
                                @if($sector->chefs->where('state', true)->isNotEmpty())
                                    @foreach($sector->chefs->where('state', true) as $chef)
                                        <div class="d-flex align-items-center">
                                            <div class="bg-warning-subtle text-warning rounded-circle p-1 me-2">
                                                <i class="bi bi-star-fill" style="font-size: 0.7rem;"></i>
                                            </div>
                                            <a href="{{ Storage::url($chef->decision_file) }}" target="_blank" class="text-decoration-none text-dark fw-semibold small hover-link">
                                                {{ $chef->employee->lastname }} {{ $chef->employee->firstname }}
                                            </a>
                                        </div>
                                    @endforeach
                                @else
                                    <span class="text-muted italic small">Non assigné</span>
                                @endif
                            </td>
                            <td class="py-3 text-center">
                                <div class="badge bg-success-subtle text-success rounded-pill px-3 py-2 fw-bold">
                                    <i class="bi bi-people-fill me-1"></i>
                                    {{ $sector->affectations->count() }}
                                </div>
                            </td>
                            <td class="pe-4 py-3 text-end">
                                <div class="d-flex justify-content-end gap-1">
                                    <a href="{{ route('sectors.show', $sector) }}" class="btn btn-sm btn-outline-primary border-0 rounded-circle p-2" title="Consulter">
                                        <i class="bi bi-eye-fill fs-5"></i>
                                    </a>
                                    <a href="{{ route('sectors.edit', $sector) }}" class="btn btn-sm btn-outline-success border-0 rounded-circle p-2" title="Modifier">
                                        <i class="bi bi-pencil-fill fs-5"></i>
                                    </a>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light border-0 shadow-xs rounded-circle p-2" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical fs-5"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3">
                                            <li><a class="dropdown-item py-2" href="#"><i class="bi bi-envelope me-2 text-info"></i>Notifier</a></li>
                                            <li><hr class="dropdown-divider opacity-50"></li>
                                            <li>
                                                <button class="dropdown-item py-2 text-danger fw-medium" data-bs-toggle="modal" data-bs-target="#deleteSectorModal-{{ $sector->id }}">
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
                            <td colspan="5" class="text-center py-5">
                                <i class="bi bi-search fs-1 text-muted opacity-25"></i>
                                <p class="mt-3 text-muted">Aucun secteur ne correspond à vos critères.</p>
                                <a href="{{ route('sectors.create') }}" class="btn btn-primary rounded-pill px-4">Créer un secteur</a>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination Footer --}}
            @if(isset($sectors) && $sectors->hasPages())
                <div class="card-footer bg-white border-top-0 py-4 px-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                        <div class="text-muted small order-2 order-md-1">
                            Affichage <span class="fw-bold">{{ $sectors->firstItem() }}</span> - <span class="fw-bold">{{ $sectors->lastItem() }}</span> sur <span class="fw-bold">{{ $sectors->total() }}</span> secteurs
                        </div>
                        <div class="order-1 order-md-2">
                            {{ $sectors->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Individual Modals for Delete --}}
    @foreach($sectors as $sector)
        <x-delete-model
            href="{{ route('sectors.delete', $sector->id) }}"
            message="Attention : La suppression du secteur '{{ $sector->title }}' entraînera la dissociation de toutes les sections liées."
            title="Confirmer la suppression"
            target="deleteSectorModal-{{ $sector->id }}" />
    @endforeach

    {{-- Export Modal remains the same as previous logic --}}

    @push('styles')
        <style>
            .hover-row:hover { background-color: #f8faff !important; }
            .transition-base { transition: all 0.2s ease-in-out; }
            .hover-lift:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important; }
            .btn-white { background: #fff; color: #0d6efd; border: none; }
            .btn-white:hover { background: #f0f4ff; color: #0a58ca; }
            .btn-primary-light { background: rgba(255,255,255,0.15); border: none; color: #fff; }
            .btn-primary-light:hover { background: rgba(255,255,255,0.25); }
            .btn-rounded { border-radius: 50px; }
            .ls-1 { letter-spacing: 0.5px; }
            .w-fit { width: fit-content; }
            .extra-small { font-size: 0.7rem; }
            .hover-link:hover { color: #0d6efd !important; text-decoration: underline !important; }
            .shadow-xs { box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        </style>
    @endpush
</x-layout>
