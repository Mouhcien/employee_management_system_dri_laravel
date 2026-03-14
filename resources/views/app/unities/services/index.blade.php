<x-layout>
    @section('title', 'Gestion des services - HR Management')

    <div class="container-fluid py-4">
        {{-- Modern Page Header --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="bg-primary bg-gradient p-4 text-white">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="fw-bold mb-1">Architecture des Services</h2>
                            <p class="opacity-75 mb-0">Pilotez et organisez les départements de votre structure</p>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <button class="btn btn-white btn-rounded shadow-sm fw-bold px-4 me-2" data-bs-toggle="modal" data-bs-target="#createServiceModal">
                                <i class="bi bi-plus-lg me-2"></i>Nouveau Service
                            </button>
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
                    ['label' => 'Total Services', 'count' => $services->total() - 1, 'color' => 'primary', 'icon' => 'bi-layers-half'],
                    ['label' => 'Total Entités', 'count' => $total_entity, 'color' => 'success', 'icon' => 'bi-diagram-3-fill'],
                    ['label' => 'Total Secteurs', 'count' => $total_sector, 'color' => 'info', 'icon' => 'bi-grid-3x3-gap-fill'],
                    ['label' => 'Total Sections', 'count' => $total_section, 'color' => 'warning', 'icon' => 'bi-bounding-box-circles']
                ];
            @endphp
            @foreach($stats as $stat)
                <div class="col-xl-3 col-sm-6">
                    <div class="card border-0 shadow-sm rounded-4 hover-lift">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-{{ $stat['color'] }}-subtle text-{{ $stat['color'] }} rounded-4 p-3 me-3">
                                    <i class="bi {{ $stat['icon'] }} fs-4"></i>
                                </div>
                                <div>
                                    <h4 class="fw-bold mb-0 text-dark">{{ $stat['count'] ?? 0 }}</h4>
                                    <p class="text-muted small mb-0 fw-medium">{{ $stat['label'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Advanced Filter Bar --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-3">
                <form method="GET" action="{{ route('services.index') }}" class="row g-2 align-items-center">
                    <div class="col-lg-9 col-md-8">
                        <div class="input-group bg-light border-0 rounded-3">
                            <span class="input-group-text bg-transparent border-0"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control bg-transparent border-0 shadow-none py-2" placeholder="Rechercher un service par nom...">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 d-flex gap-2">
                        <button type="submit" class="btn btn-dark w-100 rounded-3 shadow-sm">
                            <i class="bi bi-funnel-fill me-2"></i>Filtrer
                        </button>
                        <a href="{{ route('services.index') }}" class="btn btn-outline-secondary rounded-3 border-light-subtle bg-white shadow-sm">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Services Table Card --}}
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-header bg-white py-3 px-4 border-bottom-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-stack text-primary me-2"></i>Répertoire des Services</h5>
                    <div class="badge bg-primary-subtle text-primary rounded-pill px-3">{{ $services->total() }} Services</div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light-subtle border-bottom border-light">
                    <tr>
                        <th class="ps-4 py-3 text-muted small text-uppercase ls-1 fw-bold">Identification</th>
                        <th class="py-3 text-muted small text-uppercase ls-1 fw-bold">Chef de Service Actuel</th>
                        <th class="py-3 text-muted small text-uppercase ls-1 fw-bold text-center">Effectif</th>
                        <th class="pe-4 py-3 text-muted small text-uppercase ls-1 fw-bold text-end">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($services as $service)
                        <tr class="hover-row transition-base">
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary-subtle text-primary rounded-3 p-2 me-3 d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                                        <i class="bi bi-building"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $service->title }}</div>
                                        <small class="text-muted">ID: #0{{ $service->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3">
                                @if($service->chefs->where('state', true)->isNotEmpty())
                                    @foreach($service->chefs->where('state', true) as $chef)
                                        <div class="d-flex align-items-center">
                                            <div class="bg-warning-subtle text-warning rounded-circle p-1 me-2">
                                                <i class="bi bi-star-fill extra-small"></i>
                                            </div>
                                            <a href="{{ Storage::url($chef->decision_file) }}" target="_blank" class="text-decoration-none text-dark fw-semibold small hover-link">
                                                {{ $chef->employee->lastname }} {{ $chef->employee->firstname }}
                                            </a>
                                        </div>
                                    @endforeach
                                @else
                                    <span class="badge bg-light text-muted fw-normal italic border">Non assigné</span>
                                @endif
                            </td>
                            <td class="py-3 text-center">
                                <div class="badge bg-info-subtle text-info rounded-pill px-3 py-2 fw-bold">
                                    <i class="bi bi-people-fill me-1"></i>
                                    {{ is_null($service->affectations) ? '0' : count($service->affectations) }}
                                </div>
                            </td>
                            <td class="pe-4 py-3 text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('services.show', $service) }}" class="btn btn-sm btn-outline-primary border-0 rounded-circle p-2" title="Consulter">
                                        <i class="bi bi-eye-fill fs-5"></i>
                                    </a>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light border shadow-xs rounded-circle p-2" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3">
                                            <li><a class="dropdown-item py-2" href="#"><i class="bi bi-envelope-at me-2 text-info"></i>Notifier</a></li>
                                            <li><a class="dropdown-item py-2" href="#"><i class="bi bi-file-earmark-pdf me-2 text-danger"></i>Fiche PDF</a></li>
                                            <li><hr class="dropdown-divider opacity-50"></li>
                                            <li>
                                                <button class="dropdown-item py-2 text-danger fw-medium" data-bs-toggle="modal" data-bs-target="#deleteServiceModal-{{ $service->id }}">
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
                            <td colspan="4" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-folder-x fs-1 text-muted opacity-25"></i>
                                    <h5 class="mt-3 text-muted">Aucun service disponible</h5>
                                    <button class="btn btn-primary btn-sm mt-2 rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#createServiceModal">Créer le premier</button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination Footer --}}
            @if(isset($services) && $services->hasPages())
                <div class="card-footer bg-white border-top-0 py-4 px-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                        <div class="text-muted small order-2 order-md-1">
                            Affichage <span class="fw-bold">{{ $services->firstItem() }}</span> - <span class="fw-bold">{{ $services->lastItem() }}</span> sur <span class="fw-bold">{{ $services->total() }}</span> services
                        </div>
                        <div class="order-1 order-md-2">
                            {{ $services->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Individual Modals for Delete --}}
    @foreach($services as $service)
        <x-delete-model
            href="{{ route('services.delete', $service->id) }}"
            message="Attention : La suppression du service '{{ $service->title }}' supprimera également les liaisons associées."
            title="Confirmer la suppression"
            target="deleteServiceModal-{{ $service->id }}" />
    @endforeach

    {{-- Create Service Modal --}}
    <div class="modal fade" id="createServiceModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <form action="{{ route('services.store') }}" method="POST">
                    @csrf
                    <div class="modal-header border-0 bg-primary bg-gradient p-4 text-white">
                        <div class="d-flex align-items-center">
                            <div class="bg-white bg-opacity-20 p-2 rounded-circle me-3 shadow-sm text-dark">
                                <i class="bi bi-plus-lg fs-3"></i>
                            </div>
                            <div>
                                <h5 class="modal-title fw-bold mb-0">Définir un service</h5>
                                <small class="text-white text-opacity-75">Classification administrative du personnel</small>
                            </div>
                        </div>
                        <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body p-4 bg-white">
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase ls-1">Intitulé du service <span class="text-danger">*</span></label>
                            <div class="input-group input-group-lg border rounded-3 overflow-hidden shadow-sm transition-base">
                                <span class="input-group-text bg-white border-0 text-primary"><i class="bi bi-tag"></i></span>
                                <input type="text" class="form-control border-0 bg-white shadow-none @error('title') is-invalid @enderror" id="categoryTitle" name="title" placeholder="Ex: Service RH, PM..." required>
                            </div>
                        </div>

                        <div class="bg-primary-subtle rounded-4 p-3 d-none" id="previewSection">
                            <div class="d-flex align-items-center text-primary fw-bold">
                                <i class="bi bi-check2-circle me-2"></i>
                                <span id="previewTitle" class="small"></span>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-0 bg-light px-4 py-3">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm transition-base">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
            .shadow-xs { box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        </style>
    @endpush
</x-layout>
