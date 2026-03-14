<x-layout>
    @section('title', 'Détails de la Section - ' . $section->title)

    <div class="container-fluid py-4">
        {{-- Modern Breadcrumb & Header --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="bg-primary bg-gradient p-4 text-white">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-white bg-opacity-20 rounded-3 p-3 me-3 text-dark">
                                <i class="bi bi-grid-3x3-gap-fill fs-3"></i>
                            </div>
                            <div>
                                <h2 class="fw-bold mb-1">Section : {{ $section->title }}</h2>
                                <div class="d-flex flex-wrap gap-2 align-items-center opacity-90 small">
                                    <span class="badge bg-white text-primary rounded-pill fw-bold">{{ $section->entity->type->title ?? 'Unité' }}</span>
                                    <i class="bi bi-chevron-right"></i>
                                    <span class="fw-semibold">{{ $section->entity->title ?? 'Sans Entité' }}</span>
                                    <i class="bi bi-chevron-double-right mx-1"></i>
                                    <span class="fst-italic">{{ $section->entity->service->title ?? 'Sans Service' }}</span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('sections.index') }}" class="btn btn-white btn-rounded px-4 fw-bold shadow-sm transition-base">
                            <i class="bi bi-arrow-left me-2"></i>Retour à la liste
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- LEFT COLUMN: Workforce Management --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0 fw-bold text-dark">Effectif de la Section</h5>
                            <p class="text-muted small mb-0">Liste des agents actuellement affectés</p>
                        </div>
                        <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2 fw-bold">
                            <i class="bi bi-people-fill me-1"></i> {{ $section->affectations->where('state', true)->count() }} Agents
                        </span>
                    </div>
                    <div class="card-body p-4">
                        @if($section->affectations->where('state', true)->isNotEmpty())
                            <div class="row g-3">
                                @foreach($section->affectations as $affectation)
                                    @if ($affectation->state)
                                        <div class="col-xl-4 col-md-6">
                                            <div class="employee-wrapper transition-base hover-lift h-100">
                                                <x-employee-card :employee="$affectation->employee" detach="true" unity_type="section" unity_id="{{ $section->id }}" unity_name="{{ $section->title }}" />
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
                                <h6 class="text-muted fw-bold">Aucun employé assigné</h6>
                                <p class="small text-muted mb-0">Utilisez le module d'importation pour ajouter du personnel.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN: Administration & Tools --}}
            <div class="col-lg-4">
                {{-- Chef / Management Card --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                    <div class="card-header bg-dark py-3 px-4 border-0">
                        <h6 class="mb-0 text-white fw-bold"><i class="bi bi-person-badge me-2 text-info"></i>Direction de Section</h6>
                    </div>
                    <div class="card-body p-4">
                        @if($section->chefs->where('state', true)->isNotEmpty())
                            @foreach($section->chefs->where('state', true) as $chef)
                                <div class="p-3 bg-info-subtle bg-opacity-10 rounded-4 border border-info border-opacity-25 shadow-xs">
                                    <x-chef-card :employee="$chef->employee" detach="true" :chef="$chef" />
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-4 border border-dashed rounded-4 bg-light">
                                <i class="bi bi-person-x text-muted fs-2"></i>
                                <p class="text-muted small mt-2 mb-0 fst-italic">Poste de responsable vacant</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Import Tools Card --}}
                <div class="card border-0 shadow-sm rounded-4 border-top border-4 border-primary mb-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3 d-flex align-items-center">
                            <i class="bi bi-file-earmark-excel-fill text-success me-2 fs-5"></i>
                            Importation Excel (PPR)
                        </h6>
                        <p class="text-muted small mb-4">Mettez à jour l'effectif via votre fichier source.</p>

                        <form action="{{ route('affectations.sections.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="section_id" value="{{ $section->id }}">
                            <div class="mb-3">
                                <input type="file" class="form-control form-control-sm border-light bg-light shadow-none" name="file">
                            </div>
                            <button class="btn btn-primary w-100 rounded-pill shadow-sm py-2 fw-bold">
                                <i class="bi bi-cloud-arrow-up-fill me-2"></i>Charger les données
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Quick Settings / Info --}}
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3 small text-uppercase text-muted ls-1">Informations Système</h6>
                        <ul class="list-unstyled mb-0">
                            <li class="d-flex justify-content-between mb-2 pb-2 border-bottom border-light">
                                <span class="text-muted small">Création :</span>
                                <span class="fw-bold small">{{ $section->created_at->format('d/m/Y') }}</span>
                            </li>
                            <li class="d-flex justify-content-between">
                                <span class="text-muted small">Type d'unité :</span>
                                <span class="badge bg-secondary-subtle text-secondary px-2">Unité Terminale</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Individual Delete Modal --}}
    @if($section->affectations->where('state', true)->isNotEmpty())
        <x-delete-model
            href="{{ route('employees.delete', $affectation->employee->id) }}"
            message="Attention : Vous allez retirer cet agent de la liste active de cette section."
            title="Confirmer le retrait"
            target="deleteEmployeeModal" />
    @endif

    @if($section->affectations->where('state', true)->isNotEmpty())
        @foreach($section->affectations as $affectation)
            @if ($affectation->state)
                @php $employee = $affectation->employee; @endphp
                <x-affect-chef-modal
                    :employee="$employee"
                    unity_type="section"
                    unity_id="{{ $section->id }}"
                    unity_name="{{ $section->title }}"
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
        .employee-wrapper .card { height: 100% !important; border: 1px solid #f2f2f2 !important; }
        .bg-info-subtle { background-color: #e0f2fe !important; }
    </style>
</x-layout>
