<x-layout>
    @section('title', 'Détails de l\'Entité - ' . $entity->title)

    <div class="container-fluid py-4">
        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="bg-primary bg-gradient p-4 text-white">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-white bg-opacity-20 rounded-3 p-3 me-3 text-dark">
                                <i class="bi bi-diagram-2-fill fs-3"></i>
                            </div>
                            <div>
                                <h2 class="fw-bold mb-1">
                                    {{ $entity->type->title }} : <span class="text-white-50">{{ $entity->title }}</span>
                                </h2>
                                <div class="d-flex align-items-center opacity-90 small">
                                    <i class="bi bi-building me-2"></i>
                                    <span class="fw-semibold">Service :</span>
                                    <span class="ms-1 fst-italic">{{ $entity->service->title ?? 'Non défini' }}</span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('entities.index') }}" class="btn btn-white btn-rounded px-4 fw-bold shadow-sm transition-base">
                            <i class="bi bi-arrow-left me-2"></i>Retour à la liste
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-5 col-xl-4">
                <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                        <h6 class="fw-bold text-uppercase text-muted small mb-0 ls-1">Direction de l'Entité</h6>
                    </div>
                    <div class="card-body px-4 pb-4">
                        @if($entity->chefs->where('state', true)->isNotEmpty())
                            @foreach($entity->chefs->where('state', true) as $chef)
                                <div class="p-3 bg-primary-subtle bg-opacity-10 rounded-4 border border-primary border-opacity-10 mb-3">
                                    <x-chef-card :employee="$chef->employee" detach="true" :chef="$chef" />
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-4 border border-dashed rounded-4 bg-light">
                                <i class="bi bi-person-x text-muted fs-2"></i>
                                <p class="text-muted small mt-2 mb-0">Aucun chef actif assigné</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-4 text-dark text-uppercase small ls-1">Sous-unités Structurelles</h6>

                        @if ($entity->sectors->isNotEmpty())
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-success-subtle text-success rounded-circle p-2 me-2">
                                        <i class="bi bi-grid-3x3-gap-fill"></i>
                                    </div>
                                    <span class="fw-bold text-success">Secteurs</span>
                                </div>
                                <div class="list-group list-group-flush border-start ms-3 ps-3">
                                    @foreach($entity->sectors as $sector)
                                        <a href="{{ route('sectors.show', $sector->id) }}" class="list-group-item list-group-item-action border-0 py-2 rounded-3 small hover-link">
                                            <i class="bi bi-chevron-right me-1 opacity-50"></i>{{ $sector->title }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if ($entity->sections->isNotEmpty())
                            <div>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-info-subtle text-info rounded-circle p-2 me-2">
                                        <i class="bi bi-journal-text"></i>
                                    </div>
                                    <span class="fw-bold text-info">Sections</span>
                                </div>
                                <div class="list-group list-group-flush border-start ms-3 ps-3">
                                    @foreach($entity->sections as $section)
                                        <a href="{{ route('sections.show', $section->id) }}" class="list-group-item list-group-item-action border-0 py-2 rounded-3 small hover-link">
                                            <i class="bi bi-chevron-right me-1 opacity-50"></i>{{ $section->title }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($entity->sectors->isEmpty() && $entity->sections->isEmpty())
                            <div class="text-center py-3">
                                <p class="text-muted small italic mb-0">Aucune sous-unité rattachée.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 bg-dark text-white">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3 d-flex align-items-center">
                            <i class="bi bi-file-earmark-excel-fill text-success me-2 fs-5"></i>
                            Importation Excel
                        </h6>
                        <form action="{{ route('affectations.entities.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="entity_id" value="{{ $entity->id }}">
                            <div class="mb-3">
                                <input type="file" class="form-control form-control-sm bg-transparent border-secondary text-white shadow-none" name="file">
                            </div>
                            <button class="btn btn-primary w-100 rounded-pill py-2 fw-bold shadow-sm">
                                <i class="bi bi-cloud-upload me-2"></i>Charger les PPR
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 col-xl-8">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0 fw-bold text-dark">Effectif de l'Entité</h5>
                            <p class="text-muted small mb-0">Agents actuellement affectés à {{ $entity->title }}</p>
                        </div>
                        <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2 fw-bold shadow-xs">
                            <i class="bi bi-people-fill me-1"></i> {{ $entity->affectations->where('state', true)->count() }} Agents
                        </span>
                    </div>
                    <div class="card-body p-4">
                        @if($entity->affectations->where('state', true)->isNotEmpty())
                            <div class="row g-3">
                                @foreach($entity->affectations as $affectation)
                                    @if ($affectation->state)
                                        <div class="col-xl-4 col-md-6">
                                            <div class="employee-wrapper transition-base hover-lift">
                                                <x-employee-card :employee="$affectation->employee" detach="true" unity_type="entity" unity_id="{{ $entity->id }}" unity_name="{{ $entity->title }}" />
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="bg-light rounded-circle d-inline-flex p-4 mb-3">
                                    <i class="bi bi-people text-muted fs-1"></i>
                                </div>
                                <h6 class="text-muted fw-bold">Effectif vide</h6>
                                <p class="small text-muted mb-0">Utilisez l'importateur Excel pour ajouter des employés.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Individual Delete Modal --}}
    @if($entity->affectations->where('state', true)->isNotEmpty())
        <x-delete-model
            href="{{ route('employees.delete', $affectation->employee->id) }}"
            message="Attention : Vous allez retirer cet agent de la base de données opérationnelle de cette entité."
            title="Confirmation de retrait"
            target="deleteEmployeeModal" />
    @endif

    @if($entity->affectations->where('state', true)->isNotEmpty())
        @foreach($entity->affectations as $affectation)
            @if ($affectation->state)
                @php $employee = $affectation->employee; @endphp
                <x-affect-chef-modal
                    :employee="$employee"
                    unity_type="entity"
                    unity_id="{{ $entity->id }}"
                    unity_name="{{ $entity->title }}"
                />
            @endif
        @endforeach
    @endif

    <style>
        .transition-base { transition: all 0.2s ease-in-out; }
        .hover-lift:hover { transform: translateY(-5px); }
        .btn-white { background: #fff; color: #0d6efd; border: none; }
        .btn-white:hover { background: #f8f9fa; color: #0056b3; }
        .btn-rounded { border-radius: 50px; }
        .ls-1 { letter-spacing: 0.5px; }
        .hover-link:hover { color: #0d6efd !important; padding-left: 8px; transition: 0.2s; }
        .shadow-xs { box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
        .border-dashed { border-style: dashed !important; border-width: 2px !important; }
        .employee-wrapper .card { border: 1px solid #f0f0f0 !important; }
    </style>
</x-layout>
