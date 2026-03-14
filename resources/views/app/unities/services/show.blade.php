<x-layout>
    @section('title', 'Détails du Service - ' . $service->title)

    <div class="container-fluid py-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('services.index') }}" class="text-decoration-none">Services</a></li>
                        <li class="breadcrumb-item active">Détails</li>
                    </ol>
                </nav>
                <h1 class="h3 fw-bold text-dark mb-0">
                    <i class="bi bi-building-gear text-primary me-2"></i>
                    Service : <span class="text-primary">{{ $service->title }}</span>
                </h1>
            </div>
            <a href="{{ route('services.index') }}" class="btn btn-outline-secondary btn-rounded px-4 shadow-sm bg-white">
                <i class="bi bi-arrow-left me-2"></i>Retour à la liste
            </a>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Configuration du Service</h5>
                        <form action="{{ route('services.update', $service->id) }}" method="POST">
                            @csrf
                            <div class="row g-3 align-items-end">
                                <div class="col-md-9">
                                    <label for="serviceTitle" class="form-label small fw-bold text-uppercase text-muted">Nom du service officiel</label>
                                    <div class="input-group border rounded-3 overflow-hidden">
                                        <span class="input-group-text bg-light border-0"><i class="bi bi-pencil"></i></span>
                                        <input type="text" id="serviceTitle" name="title" class="form-control border-0 bg-light shadow-none" value="{{ old('title', $service->title) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary w-100 rounded-3 py-2 fw-bold">
                                        <i class="bi bi-check2-circle me-1"></i>Mettre à jour
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 border-top border-4 border-success">
                    <div class="card-header bg-white py-3 px-4 border-bottom-0 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-people-fill text-success me-2"></i>Effectif du Service</h5>
                        <span class="badge bg-success-subtle text-success rounded-pill px-3">{{ $service->affectations->count() }} Agents</span>
                    </div>
                    <div class="card-body p-4">
                        @if($service->affectations->where('state', true)->isNotEmpty())
                            <div class="row g-3">
                                @foreach($service->affectations as $affectation)
                                    @if ($affectation->state)
                                        <div class="col-xl-4 col-md-6">
                                            @php $employee = $affectation->employee; @endphp
                                            <div class="hover-lift transition-base">
                                                <x-employee-card :employee="$employee" detach="true" unity_type="service" unity_id="{{ $service->id }}" unity_name="{{ $service->title }}" />
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-people text-muted opacity-25 fs-1"></i>
                                <p class="text-muted mt-2">Aucun employé n'est actuellement affecté à ce service.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                    <div class="card-header bg-primary py-3 px-4 border-0">
                        <h6 class="mb-0 text-white fw-bold"><i class="bi bi-person-workspace me-2"></i>Direction du Service</h6>
                    </div>
                    <div class="card-body p-4 text-center">
                        @if($service->chefs->where('state', true)->isNotEmpty())
                            @foreach($service->chefs->where('state', true) as $chef)
                                <div class="mb-3">
                                    <x-chef-card :employee="$chef->employee" detach="true" :chef="$chef" />
                                </div>
                            @endforeach
                        @else
                            <div class="py-3">
                                <div class="avatar avatar-xl bg-light rounded-circle mb-3 mx-auto d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                                    <i class="bi bi-person-x fs-2 text-muted"></i>
                                </div>
                                <p class="text-muted small">Poste de responsable vacant</p>
                                <button class="btn btn-sm btn-outline-primary rounded-pill px-3">Assigner un chef</button>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3"><i class="bi bi-file-earmark-excel text-success me-2"></i>Importation Rapide</h6>
                        <form action="{{ route('affectations.services.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="service_id" value="{{ $service->id }}">
                            <div class="mb-3">
                                <label class="form-label small text-muted">Fichier Excel (PPR)</label>
                                <input type="file" class="form-control form-control-sm border-0 bg-light shadow-none" name="file">
                            </div>
                            <button class="btn btn-dark btn-sm w-100 rounded-pill py-2">
                                <i class="bi bi-upload me-2"></i>Charger les agents
                            </button>
                        </form>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-4">Structure Hiérarchique</h6>

                        <div class="d-flex align-items-center justify-content-between mb-3 p-3 bg-primary-subtle rounded-3 transition-base hover-lift">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-archive-fill text-primary me-3 fs-5"></i>
                                <span class="fw-bold">Entités</span>
                            </div>
                            <span class="badge bg-primary">{{ $service->entities->count() }}</span>
                        </div>
                        <div class="ps-4 mb-4">
                            @foreach($service->entities as $entity)
                                <a href="{{ route('entities.show', $entity->id) }}" class="d-block text-decoration-none text-muted small mb-2 hover-link">
                                    <i class="bi bi-arrow-return-right me-2 text-primary-emphasis"></i>{{ $entity->title }}
                                </a>
                            @endforeach
                        </div>

                        <div class="d-flex align-items-center justify-content-between mb-3 p-3 bg-success-subtle rounded-3">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-diagram-3-fill text-success me-3 fs-5"></i>
                                <span class="fw-bold">Secteurs</span>
                            </div>
                            @php $sectors = $service->entities->flatMap(fn($e) => $e->sectors)->unique('id'); @endphp
                            <span class="badge bg-success">{{ $sectors->count() }}</span>
                        </div>

                        <div class="d-flex align-items-center justify-content-between p-3 bg-info-subtle rounded-3">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-journal-text text-info me-3 fs-5"></i>
                                <span class="fw-bold">Sections</span>
                            </div>
                            @php $sections = $service->entities->flatMap(fn($e) => $e->sections)->unique('id'); @endphp
                            <span class="badge bg-info">{{ $sections->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($service->affectations->where('state', true)->isNotEmpty())
        @foreach($service->affectations as $affectation)
            @if ($affectation->state)
                @php $employee = $affectation->employee; @endphp
                <x-affect-chef-modal
                    :employee="$employee"
                    unity_type="service"
                    unity_id="{{ $service->id }}"
                    unity_name="{{ $service->title }}"
                />
            @endif
        @endforeach
    @endif

    @if($service->affectations->isNotEmpty())
        <x-delete-model
            href="{{ route('employees.delete', $affectation->employee->id) }}"
            message="Voulez-vous vraiment supprimer cet agent ? Cette action est irréversible."
            title="Confirmation de suppression"
            target="deleteEmployeeModal" />
    @endif

    <style>
        .transition-base { transition: all 0.2s ease-in-out; }
        .hover-lift:hover { transform: translateY(-3px); box-shadow: 0 8px 15px rgba(0,0,0,0.05); }
        .btn-rounded { border-radius: 50px; }
        .hover-link:hover { color: #0d6efd !important; padding-left: 5px; transition: 0.2s; }
        .bg-primary-subtle { background-color: #eef2ff !important; }
        .bg-success-subtle { background-color: #f0fdf4 !important; }
        .bg-info-subtle { background-color: #ecfeff !important; }
    </style>

</x-layout>
