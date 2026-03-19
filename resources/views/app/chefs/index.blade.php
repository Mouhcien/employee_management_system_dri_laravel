<x-layout>
    @section('title', 'Gestion des chefs - HR Management')

    <div class="container-fluid py-4">
        {{-- Glassmorphic Page Header --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="bg-primary bg-gradient p-4 text-white">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="fw-bold mb-1">Gestion des Responsables</h2>
                            <p class="opacity-75 mb-0">Supervision et suivi des chefs d'unités structurelles</p>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <a class="btn btn-primary-light btn-rounded shadow-sm" href="{{ route('chefs.download') }}" >
                                <i class="bi bi-download"></i>
                            </a>
                            <a href="{{ route('chefs.index') }}" class="btn btn-white btn-rounded"><i class="bi bi-arrow-clockwise"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Visual Stats Row --}}
        <div class="row g-3 mb-4">
            @php
                $stats = [
                    ['label' => 'Services', 'count' => $services->count() - 1, 'color' => 'primary', 'icon' => 'bi-building'],
                    ['label' => 'Entités', 'count' => $entities->count() - 1, 'color' => 'success', 'icon' => 'bi-diagram-3'],
                    ['label' => 'Secteurs', 'count' => $sectors->count(), 'color' => 'info', 'icon' => 'bi-grid-1x2'],
                    ['label' => 'Sections', 'count' => $sections->count(), 'color' => 'warning', 'icon' => 'bi-segmented-nav']
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
                <form method="GET" action="{{ route('chefs.index') }}" class="row g-3 align-items-end">
                    <div class="row col-12">
                        <div class="col-6">
                            <label class="form-label fw-bold small text-uppercase">Recherche Rapide</label>
                            <div class="input-group border rounded-3 overflow-hidden">
                                <span class="input-group-text bg-white border-0"><i class="bi bi-search"></i></span>
                                <input type="text" name="search" value="{{ $filter }}" class="form-control border-0 shadow-none" placeholder="Nom, prénom...">
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold small text-uppercase"></label>
                            <button type="submit" class="btn btn-dark w-100 rounded-3 mt-1"><i class="bi bi-filter me-2"></i>Filtrer</button>
                        </div>

                    </div>
                </form>
                    <hr>
                    <div class="row col-12">
                        <div class="col-lg-3">
                            <label class="form-label fw-bold small text-uppercase">Services</label>
                            <select name="chef_service_id" id="sl_chef_service_id" class="form-select border rounded-3">
                                <option value="-1">Tous les services</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}" {{ $service_id == $service->id ? 'selected' : '' }}>{{ $service->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label fw-bold small text-uppercase">Entité</label>
                            <select name="chef_service_id" id="sl_chef_entity_id" class="form-select border rounded-3">
                                <option value="-1">Tous les entités</option>
                                @foreach($entities as $entity)
                                    <option value="{{ $entity->id }}" {{ $entity_id == $entity->id ? 'selected' : '' }}>{{ $entity->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label fw-bold small text-uppercase">Secteurs</label>
                            <select name="chef_service_id" id="sl_chef_sector_id" class="form-select border rounded-3">
                                <option value="-1">Tous les secteurs</option>
                                @foreach($sectors as $sector)
                                    <option value="{{ $sector->id }}" {{ $sector_id == $sector->id ? 'selected' : '' }}>{{ $sector->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label fw-bold small text-uppercase">Sections</label>
                            <select name="chef_service_id" id="sl_chef_section_id" class="form-select border rounded-3">
                                <option value="-1">Tous les sections</option>
                                @foreach($sections as $section)
                                    <option value="{{ $section->id }}" {{ $section_id == $section->id ? 'selected' : '' }}>{{ $section->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-header bg-white py-3 px-4 border-bottom-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Liste des Chefs Actifs</h5>
                    <span class="badge bg-light text-dark border rounded-pill">{{ $chefs->total() }} au total</span>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase fw-bold">
                    <tr>
                        <th class="ps-4 border-0">Profil</th>
                        <th class="border-0">Hiérarchie / Entité</th>
                        <th class="border-0">Ancienneté</th>
                        <th class="border-0 text-center">Décision</th>
                        <th class="pe-4 border-0 text-end">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($chefs as $chef)
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="position-relative me-3">
                                        @if($chef->employee->photo && Storage::disk('public')->exists($chef->employee->photo))
                                            <img src="{{ Storage::url($chef->employee->photo) }}" class="rounded-circle border border-2 border-primary-subtle shadow-sm" width="50" height="50">
                                        @else
                                            <div class="rounded-circle bg-primary-subtle text-primary fw-bold d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                {{ substr($chef->employee->firstname, 0, 1) }}{{ substr($chef->employee->lastname, 0, 1) }}
                                            </div>
                                        @endif
                                        <span class="position-absolute bottom-0 end-0 p-1 bg-{{ $chef->employee->gender == 'M' ? 'info' : 'danger' }} border border-white rounded-circle" style="width: 14px; height: 14px;"></span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold text-dark">{{ $chef->employee->lastname }} {{ $chef->employee->firstname }}</h6>
                                        <small class="text-muted">{{ $chef->employee->gender == 'M' ? 'Masculin' : 'Féminin' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($chef->section)
                                    <div class="d-flex flex-column gap-1">
                                        <span class="badge bg-secondary-subtle text-secondary rounded-pill w-fit small px-2">Section: {{ $chef->section->title }}</span>
                                        <small class="text-muted extra-small"><i class="bi bi-chevron-double-right mx-1"></i>{{ $chef->section->entity->title }}</small>
                                    </div>
                                @elseif($chef->sector)
                                    <span class="badge bg-info-subtle text-info rounded-pill px-3">Secteur: {{ $chef->sector->title }}</span>
                                @elseif($chef->entity)
                                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3">{{ $chef->entity->title }}</span>
                                @elseif($chef->service)
                                    <span class="badge bg-primary-subtle text-success rounded-pill px-3">{{ $chef->service->title }}</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $interval = \Carbon\Carbon::parse($chef->starting_date)->diff(now());
                                @endphp
                                <div class="fw-bold text-dark small">{{ $interval->y }} <span class="text-muted fw-normal">ans</span>, {{ $interval->m }} <span class="text-muted fw-normal">mois</span></div>
                                <div class="progress mt-1" style="height: 4px; width: 60px;">
                                    <div class="progress-bar bg-warning" style="width: {{ min(($interval->y * 10) + 10, 100) }}%"></div>
                                </div>
                            </td>
                            <td class="text-center">
                                @if($chef->decision_file)
                                    <a href="{{ Storage::url($chef->decision_file) }}" target="_blank" class="btn btn-light btn-sm rounded-circle border shadow-xs" title="Voir la décision">
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
                                        <li><a class="dropdown-item py-2" href="{{ route('chefs.edit', $chef) }}"><i class="bi bi-pencil-square text-warning me-2"></i>Modifier</a></li>
                                        <li><a class="dropdown-item py-2" href="#"><i class="bi bi-clock-history text-info me-2"></i>Historique</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <button class="dropdown-item py-2 text-danger" data-bs-toggle="modal" data-bs-target="#deleteChefModal-{{ $chef->id }}">
                                                <i class="bi bi-trash3 me-2"></i>Supprimer
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="bi bi-search fs-1 text-muted opacity-25"></i>
                                <p class="mt-3 text-muted">Aucun chef ne correspond à votre recherche.</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Pagination Footer --}}
    @if(isset($chefs) && $chefs->hasPages())
        <div class="card-footer bg-white border-top-0 py-4 px-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                <div class="text-muted small order-2 order-md-1">
                    Affichage de <span class="fw-bold text-dark">{{ $chefs->firstItem() }}</span> à
                    <span class="fw-bold text-dark">{{ $chefs->lastItem() }}</span> sur
                    <span class="fw-bold text-dark">{{ $chefs->total() }}</span> responsables
                </div>
                <div class="order-1 order-md-2">
                    {{ $chefs->links('') }}
                </div>
            </div>
        </div>
    @endif

    {{-- Delete Modals --}}
    @foreach($chefs as $chef)
        <x-delete-model
            href="{{ route('entities.delete', $chef->id) }}"
            message="Attention: La suppression de ce responsable est irréversible."
            title="Supprimer le responsable"
            target="deleteChefModal-{{ $chef->id }}" />
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
