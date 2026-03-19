<x-layout>
    @section('title', 'Gestion des chefs - HR Management')

    <div class="container-fluid py-4">
        {{-- Glassmorphic Page Header --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="bg-primary bg-gradient p-4 text-white">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="fw-bold mb-1">Gestion des Responsables par intérim</h2>
                            <p class="opacity-75 mb-0">Supervision et suivi des chefs d'unités structurelles</p>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <a class="btn btn-white btn-rounded shadow-sm fw-bold px-4" href="{{ route('temps.create') }}">
                                <i class="bi bi-plus-circle-fill me-2"></i>Nouveau Chef par intérim
                            </a>

                            <button class="btn btn-primary-light btn-rounded shadow-sm" data-bs-toggle="modal" data-bs-target="#bulkActions">
                                <i class="bi bi-download"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Visual Stats Row --}}
        <div class="row g-3 mb-4">
            @php
                $stats = [
                    ['label' => 'Chefs par intérim', 'count' => $temps->count(), 'color' => 'primary', 'icon' => 'bi-building'],
                    ['label' => 'Chefs & Responsables', 'count' => $chefs->count() , 'color' => 'success', 'icon' => 'bi-diagram-3'],
                    ['label' => 'Secteurs', 'count' => 0, 'color' => 'info', 'icon' => 'bi-grid-1x2'],
                    ['label' => 'Sections', 'count' => 0, 'color' => 'warning', 'icon' => 'bi-segmented-nav']
                ];
            @endphp
            @foreach($stats as $stat)
                <div class="col-xl-3 col-sm-6">
                    <div class="card border-0 shadow-sm rounded-4 hover-lift">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 bg-{{ $stat['color'] }}-subtle text-{{ $stat['color'] }} rounded-3 p-3">
                                    <i class="bi {{ $stat['icon'] }} fs-4"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h4 class="fw-bold mb-0">{{ $stat['count'] ?? 0 }}</h4>
                                    <p class="text-muted small mb-0">{{ $stat['label'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Filter Section --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                <form method="GET" action="{{ route('entities.index') }}" class="row g-3 align-items-end">
                    <div class="col-lg-4">
                        <label class="form-label fw-bold small text-uppercase">Recherche Rapide</label>
                        <div class="input-group border rounded-3 overflow-hidden">
                            <span class="input-group-text bg-white border-0"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control border-0 shadow-none" placeholder="Nom, prénom ou unité...">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <label class="form-label fw-bold small text-uppercase">Département</label>
                        <select name="department" class="form-select border rounded-3">
                            <option value="">Tous les services</option>
                            @foreach($chefs as $chef)
                                <option value="{{ $chef->id }}" {{ request('chef') == $chef->id ? 'selected' : '' }}>{{ $chef->employee->lastname }} {{ $chef->employee->firstname }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-5 d-flex gap-2 mt-4 mt-lg-0">
                        <button type="submit" class="btn btn-dark w-100 rounded-3"><i class="bi bi-filter me-2"></i>Filtrer</button>
                        <a href="{{ route('temps.index') }}" class="btn btn-outline-secondary rounded-3"><i class="bi bi-arrow-clockwise"></i></a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-header bg-white py-3 px-4 border-bottom-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Liste des Chefs par intérim Actifs</h5>
                    <span class="badge bg-light text-dark border rounded-pill">{{ $temps->total() }} au total</span>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase fw-bold">
                    <tr>
                        <th class="ps-4 border-0">Profil</th>
                        <th class="border-0">Hiérarchie / Entité</th>
                        <th class="border-0">Ancienneté</th>
                        <th class="border-0">Date de début</th>
                        <th class="border-0">Date de fin</th>
                        <th class="border-0 text-center">Décision</th>
                        <th class="pe-4 border-0 text-end">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($temps as $temp)
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="position-relative me-3">
                                        @if($temp->employee->photo && Storage::disk('public')->exists($temp->employee->photo))
                                            <img src="{{ Storage::url($temp->employee->photo) }}" class="rounded-circle border border-2 border-primary-subtle shadow-sm" width="50" height="50">
                                        @else
                                            <div class="rounded-circle bg-primary-subtle text-primary fw-bold d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                {{ substr($temp->employee->firstname, 0, 1) }}{{ substr($temp->employee->lastname, 0, 1) }}
                                            </div>
                                        @endif
                                        <span class="position-absolute bottom-0 end-0 p-1 bg-{{ $temp->employee->gender == 'M' ? 'info' : 'danger' }} border border-white rounded-circle" style="width: 14px; height: 14px;"></span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold text-dark">{{ $temp->employee->lastname }} {{ $temp->chef->employee->firstname }}</h6>
                                        <small class="text-muted">{{ $temp->employee->gender == 'M' ? 'Masculin' : 'Féminin' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($temp->chef->section)
                                    <div class="d-flex flex-column gap-1">
                                        <span class="badge bg-secondary-subtle text-secondary rounded-pill w-fit small px-2">Section: {{ $temp->chef->section->title }}</span>
                                        <small class="text-muted extra-small"><i class="bi bi-chevron-double-right mx-1"></i>{{ $temp->chef->section->entity->title }}</small>
                                    </div>
                                @elseif($temp->chef->sector)
                                    <span class="badge bg-info-subtle text-info rounded-pill px-3">Secteur: {{ $temp->chef->sector->title }}</span>
                                @elseif($temp->chef->entity)
                                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3">{{ $temp->chef->entity->title }}</span>
                                @elseif($temp->chef->service)
                                    <span class="badge bg-primary-subtle text-success rounded-pill px-3">{{ $temp->chef->service->title }}</span>
                                @endif
                            </td>
                            <td>
                                @php
                                if (is_null($temp->finished_date))
                                    $interval = \Carbon\Carbon::parse($temp->starting_date)->diff(now());
                                else
                                    $interval = \Carbon\Carbon::parse($temp->starting_date)->diff($temp->finished_date);
                                @endphp
                                <div class="fw-bold text-dark small">
                                    @if ($interval->y > 0)
                                        {{ $interval->y }} <span class="text-muted fw-normal">ans</span>,
                                    @endif
                                    @if ($interval->m > 0)
                                        {{ $interval->m }} <span class="text-muted fw-normal">mois</span>
                                    @endif
                                    @if ($interval->d > 0)
                                        {{ $interval->d }} <span class="text-muted fw-normal">jours</span>
                                    @endif
                                </div>
                                <div class="progress mt-1" style="height: 4px; width: 60px;">
                                    <div class="progress-bar bg-warning" style="width: {{ min(($interval->y * 10) + 10, 100) }}%"></div>
                                </div>
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($temp->starting_date)->format('d/m/Y') }}
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($temp->finished_date)->format('d/m/Y') }}
                            </td>
                            <td class="text-center">
                                @if($temp->file)
                                    <a href="{{ Storage::url($temp->file) }}" target="_blank" class="btn btn-light btn-sm rounded-circle border shadow-xs" title="Voir la décision d'intérim">
                                        <i class="bi bi-file-earmark-pdf text-danger fs-5"></i>
                                    </a>
                                @else
                                    <span class="badge bg-danger-subtle text-danger small">Manquante</span>
                                @endif
                            </td>
                            <td class="pe-4 text-end">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-white border shadow-sm dropdown-toggle" data-bs-toggle="dropdown">
                                        Option
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3">
                                        <li><a class="dropdown-item py-2" href="{{ route('temps.edit', $temp) }}"><i class="bi bi-pencil-square text-warning me-2"></i>Modifier</a></li>
                                        <li><a class="dropdown-item py-2" href="{{ route('temps.decision', $temp) }}" target="_blank"><i class="bi bi-clock-history text-info me-2"></i>Décision</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <button class="dropdown-item py-2 text-danger" data-bs-toggle="modal" data-bs-target="#deleteChefTempModal-{{ $temp->id }}">
                                                <i class="bi bi-trash3 me-2"></i>Supprimer
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="bi bi-search fs-1 text-muted opacity-25"></i>
                                <p class="mt-3 text-muted">Aucun chef par intérim ne correspond à votre recherche.</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Pagination Footer --}}
    @if(isset($temps) && $temps->hasPages())
        <div class="card-footer bg-white border-top-0 py-4 px-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                <div class="text-muted small order-2 order-md-1">
                    Affichage de <span class="fw-bold text-dark">{{ $temps->firstItem() }}</span> à
                    <span class="fw-bold text-dark">{{ $temps->lastItem() }}</span> sur
                    <span class="fw-bold text-dark">{{ $temps->total() }}</span> responsables par intérim
                </div>
                <div class="order-1 order-md-2">
                    {{ $temps->links() }}
                </div>
            </div>
        </div>
    @endif

    {{-- Delete Modals --}}
    @foreach($temps as $temp)
        <x-delete-model
            href="{{ route('temps.delete', $temp->id) }}"
            message="Attention: La suppression de ce responsable est irréversible."
            title="Supprimer le responsable"
            target="deleteChefTempModal-{{ $temp->id }}" />
    @endforeach

    <style>
        .hover-lift { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .hover-lift:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; }
        .btn-white { background: white; border: 1px solid #dee2e6; color: #333; }
        .btn-white:hover { background: #f8f9fa; }
        .btn-rounded { border-radius: 50px; }
        .btn-primary-light { background: rgba(255,255,255,0.2); border: none; color: white; }
        .btn-primary-light:hover { background: rgba(255,255,255,0.3); }
        .w-fit { width: fit-content; }
        .extra-small { font-size: 0.65rem; }
        .shadow-xs { box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
    </style>
</x-layout>
