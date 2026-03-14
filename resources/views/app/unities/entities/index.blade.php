<x-layout>
    @section('title', 'Gestion des entités - HR Management')

    <div class="container-fluid py-4">
        {{-- Glassmorphic Page Header --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="bg-primary bg-gradient p-4 text-white">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="fw-bold mb-1">Architecture des Entités</h2>
                            <p class="opacity-75 mb-0">Structurez et segmentez votre organisation par entités administratives</p>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <a href="{{ route('entities.create') }}" class="btn btn-white btn-rounded shadow-sm fw-bold px-4 me-2">
                                <i class="bi bi-plus-lg me-2"></i>Nouvelle Entité
                            </a>
                            <button class="btn btn-primary-light btn-rounded shadow-sm" data-bs-toggle="modal" data-bs-target="#bulkActions">
                                <i class="bi bi-download"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Dynamic Stats Grid --}}
        <div class="row g-3 mb-4">
            @php
                $stats = [
                    ['label' => 'Entités Totales', 'count' => $entities->total(), 'color' => 'primary', 'icon' => 'bi-diagram-2-fill'],
                    ['label' => 'Services Parents', 'count' => $total_service - 1, 'color' => 'success', 'icon' => 'bi-building-fill'],
                    ['label' => 'Secteurs Liés', 'count' => $total_sector, 'color' => 'info', 'icon' => 'bi-grid-3x3-gap-fill'],
                    ['label' => 'Sections Actives', 'count' => $total_section, 'color' => 'warning', 'icon' => 'bi-bounding-box-circles']
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
                <form method="GET" action="{{ route('entities.index') }}" class="row g-3 align-items-end">
                    <div class="col-lg-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Recherche</label>
                        <div class="input-group bg-light border-0 rounded-3">
                            <span class="input-group-text bg-transparent border-0"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control bg-transparent border-0 shadow-none py-2" placeholder="Nom d'entité ou service...">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <label class="form-label fw-bold small text-muted text-uppercase">Service Parent</label>
                        <select name="department" class="form-select border-0 bg-light rounded-3 shadow-none">
                            <option value="">Tous les services</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ request('department') == $service->id ? 'selected' : '' }}>{{ $service->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label class="form-label fw-bold small text-muted text-uppercase">Catégorie</label>
                        <select name="status" class="form-select border-0 bg-light rounded-3 shadow-none">
                            <option value="">Toutes catégories</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}" {{ request('status') == $type->id ? 'selected' : '' }}>{{ $type->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2 d-flex gap-2">
                        <button type="submit" class="btn btn-dark w-100 rounded-3 shadow-sm"><i class="bi bi-filter me-1"></i>Filtrer</button>
                        <a href="{{ route('entities.index') }}" class="btn btn-outline-secondary rounded-3 border-light-subtle bg-white shadow-sm"><i class="bi bi-arrow-clockwise"></i></a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Main Table Card --}}
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-header bg-white py-3 px-4 border-bottom-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-diagram-2 text-primary me-2"></i>Répertoire des Entités</h5>
                <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 fw-bold">Total: {{ $entities->total() }}</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light-subtle">
                    <tr>
                        <th class="ps-4 py-3 text-muted small text-uppercase ls-1 fw-bold border-0">Catégorie</th>
                        <th class="py-3 text-muted small text-uppercase ls-1 fw-bold border-0">Désignation</th>
                        <th class="py-3 text-muted small text-uppercase ls-1 fw-bold border-0">Service de Rattachement</th>
                        <th class="py-3 text-muted small text-uppercase ls-1 fw-bold border-0">Responsable (Chef)</th>
                        <th class="pe-4 py-3 text-muted small text-uppercase ls-1 fw-bold border-0 text-end">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($entities as $entity)
                        <tr class="hover-row transition-base">
                            <td class="ps-4 py-3">
                                <span class="badge bg-white text-dark border rounded-pill px-3 py-2 fw-medium shadow-xs">
                                    {{ $entity->type->title ?? 'Générale' }}
                                </span>
                            </td>
                            <td class="py-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-warning-subtle text-warning rounded-3 p-2 me-3 d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                                        <i class="bi bi-diagram-3-fill"></i>
                                    </div>
                                    <div class="fw-bold text-dark">{{ $entity->title }}</div>
                                </div>
                            </td>
                            <td class="py-3">
                                <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 fw-semibold">
                                    <i class="bi bi-building me-1"></i>{{ $entity->service->title ?? 'Indépendant' }}
                                </span>
                            </td>
                            <td class="py-3">
                                @if($entity->chefs->where('state', true)->isNotEmpty())
                                    @foreach($entity->chefs->where('state', true) as $chef)
                                        <div class="d-flex align-items-center">
                                            <div class="bg-info-subtle text-info rounded-circle p-1 me-2 shadow-xs d-flex align-items-center justify-content-center" style="width: 22px; height: 22px;">
                                                <i class="bi bi-star-fill" style="font-size: 0.65rem;"></i>
                                            </div>
                                            <a href="{{ Storage::url($chef->decision_file) }}" target="_blank" class="text-decoration-none text-dark fw-semibold small hover-link">
                                                {{ $chef->employee->lastname }} {{ $chef->employee->firstname }}
                                            </a>
                                        </div>
                                    @endforeach
                                @else
                                    <span class="text-muted italic small opacity-75">Non pourvu</span>
                                @endif
                            </td>
                            <td class="pe-4 py-3 text-end">
                                <div class="d-flex justify-content-end gap-1">
                                    <a href="{{ route('entities.show', $entity) }}" class="btn btn-sm btn-outline-primary border-0 rounded-circle p-2" title="Voir">
                                        <i class="bi bi-eye-fill fs-5"></i>
                                    </a>
                                    <a href="{{ route('entities.edit', $entity) }}" class="btn btn-sm btn-outline-success border-0 rounded-circle p-2" title="Modifier">
                                        <i class="bi bi-pencil-fill fs-5"></i>
                                    </a>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light border-0 shadow-xs rounded-circle p-2" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical fs-5"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4">
                                            <li><a class="dropdown-item py-2" href="#"><i class="bi bi-envelope me-2 text-info"></i>Notifier</a></li>
                                            <li><a class="dropdown-item py-2" href="#"><i class="bi bi-file-earmark-pdf me-2 text-danger"></i>Export PDF</a></li>
                                            <li><hr class="dropdown-divider opacity-50"></li>
                                            <li>
                                                <button class="dropdown-item py-2 text-danger fw-medium" data-bs-toggle="modal" data-bs-target="#deleteEntityModal-{{ $entity->id }}">
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
                                <div class="py-4">
                                    <i class="bi bi-diagram-2 fs-1 text-muted opacity-25"></i>
                                    <h5 class="mt-3 text-muted">Aucune entité n'a été créée</h5>
                                    <a href="{{ route('entities.create') }}" class="btn btn-primary rounded-pill px-4 mt-2 shadow-sm">Commencer maintenant</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination Footer --}}
            @if(isset($entities) && $entities->hasPages())
                <div class="card-footer bg-white border-top-0 py-4 px-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                        <div class="text-muted small order-2 order-md-1">
                            Affichage <span class="fw-bold">{{ $entities->firstItem() }}</span> - <span class="fw-bold">{{ $entities->lastItem() }}</span> sur <span class="fw-bold">{{ $entities->total() }}</span> entités
                        </div>
                        <div class="order-1 order-md-2">
                            {{ $entities->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Individual Modals for Delete --}}
    @foreach($entities as $entity)
        <x-delete-model
            href="{{ route('entities.delete', $entity->id) }}"
            message="Attention : Vous allez supprimer l'entité '{{ $entity->title }}'. Cette action peut impacter les secteurs et sections rattachés."
            title="Confirmation de Suppression"
            target="deleteEntityModal-{{ $entity->id }}" />
    @endforeach

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
            .hover-link:hover { color: #0d6efd !important; text-decoration: underline !important; }
            .shadow-xs { box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        </style>
    @endpush
</x-layout>
