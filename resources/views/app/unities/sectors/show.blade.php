<x-layout>
    @section('title', 'Détails du Secteur - ' . $sector->title)

    <div class="container-fluid py-4">
        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="bg-primary bg-gradient p-4 text-white">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-white bg-opacity-20 rounded-3 p-3 me-3 text-dark">
                                <i class="bi bi-grid-3x3-gap-fill fs-3"></i>
                            </div>
                            <div>
                                <h2 class="fw-bold mb-1">Secteur : {{ $sector->title }}</h2>
                                <div class="d-flex flex-wrap gap-2 align-items-center opacity-90 small">
                                    <span class="badge bg-white text-primary rounded-pill">{{ $sector->entity->type->title ?? 'Unité' }}</span>
                                    <i class="bi bi-chevron-right"></i>
                                    <span class="fw-semibold">{{ $sector->entity->title ?? 'Sans Entité' }}</span>
                                    <i class="bi bi-chevron-double-right mx-1"></i>
                                    <span class="fst-italic">{{ $sector->entity->service->title ?? 'Sans Service' }}</span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('sectors.index') }}" class="btn btn-white btn-rounded px-4 fw-bold shadow-sm">
                            <i class="bi bi-arrow-left me-2"></i>Retour
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 order-2 order-lg-1">
                <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                        <h6 class="fw-bold text-uppercase text-muted small mb-0 ls-1">Responsable du Secteur</h6>
                    </div>
                    <div class="card-body px-4 pb-4">
                        @if($sector->chefs->where('state', true)->isNotEmpty())
                            @foreach($sector->chefs->where('state', true) as $chef)
                                <div class="p-3 bg-light rounded-4 border-start border-4 border-info shadow-xs">
                                    <x-chef-card :employee="$chef->employee" detach="true" :chef="$chef" />
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-4 border border-dashed rounded-4">
                                <i class="bi bi-person-exclamation text-muted fs-2"></i>
                                <p class="text-muted small mt-2 mb-0">Aucun chef actif assigné</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 border-top border-4 border-primary">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3 d-flex align-items-center">
                            <i class="bi bi-file-earmark-excel-fill text-success me-2 fs-5"></i>
                            Importation de Masse
                        </h6>
                        <p class="text-muted small mb-4">Chargez les employés directement via un fichier Excel.</p>

                        <form action="{{ route('affectations.sectors.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="sector_id" value="{{ $sector->id }}">
                            <div class="mb-3">
                                <div class="input-group input-group-sm rounded-3 overflow-hidden">
                                    <input type="file" class="form-control border-light shadow-none" name="file" id="fileInput">
                                </div>
                            </div>
                            <button class="btn btn-primary w-100 rounded-pill shadow-sm py-2">
                                <i class="bi bi-cloud-upload me-2"></i>Charger les PPR
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 order-1 order-lg-2">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0 fw-bold text-dark">Personnel Affecté</h5>
                            <small class="text-muted">Liste des agents actifs dans ce secteur</small>
                        </div>
                        <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2 fw-bold">
                            <i class="bi bi-people-fill me-1"></i> {{ $sector->affectations->where('state', true)->count() }} Agents
                        </span>
                    </div>
                    <div class="card-body p-4">
                        @if($sector->affectations->where('state', true)->isNotEmpty())
                            <div class="row g-3">
                                @foreach($sector->affectations as $affectation)
                                    @if ($affectation->state)
                                        <div class="col-xl-4 col-md-6">
                                            <div class="employee-wrapper transition-base hover-lift h-100">
                                                <x-employee-card :employee="$affectation->employee" detach="true" unity_type="sector" unity_id="{{ $sector->id }}" unity_name="{{ $sector->title }}" />
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
                                <h6 class="text-muted">Ce secteur est actuellement vide</h6>
                                <p class="small text-muted mb-0">Utilisez le module d'importation pour ajouter des agents.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Individual Delete Modal --}}
    @if($sector->affectations->where('state', true)->isNotEmpty())
        <x-delete-model
            href="{{ route('employees.delete', $affectation->employee->id) }}"
            message="Êtes-vous sûr de vouloir retirer cet agent de la base de données ?"
            title="Confirmation"
            target="deleteEmployeeModal" />
    @endif

    @if($sector->affectations->where('state', true)->isNotEmpty())
        @foreach($sector->affectations as $affectation)
            @if ($affectation->state)
                @php $employee = $affectation->employee; @endphp
                <x-affect-chef-modal
                    :employee="$employee"
                    unity_type="sector"
                    unity_id="{{ $sector->id }}"
                    unity_name="{{ $sector->title }}"
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
        .shadow-xs { box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
        .border-dashed { border-style: dashed !important; border-width: 2px !important; }
        .employee-wrapper .card { height: 100% !important; border: 1px solid #f0f0f0 !important; }
    </style>
</x-layout>
