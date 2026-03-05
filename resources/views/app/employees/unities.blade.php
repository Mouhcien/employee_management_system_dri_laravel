<x-layout>
    @section('title', 'Unité structurelle')

    <div class="container-fluid py-4">

        <div class="bg-gradient-primary-to-secondary rounded-4 p-4 mb-4 text-white shadow-lg">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="position-relative">
                        @if($employee->photo)
                            <img src="{{ Storage::url($employee->photo) }}"
                                 alt="{{ $employee->firstname }}"
                                 class="rounded-circle border border-3 border-white shadow-lg object-fit-cover"
                                 width="80" height="80">
                        @else
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-lg"
                                 style="width:80px;height:80px;background:linear-gradient(135deg,#072194 0%,#113bf1 100%);">
                                {{ strtoupper(substr($employee->firstname,0,1)) }}{{ strtoupper(substr($employee->lastname,0,1)) }}
                            </div>
                        @endif

                        @if ($employee->status == 1)
                            <span class="position-absolute bottom-0 end-0 translate-middle p-2 bg-success border border-2 border-white rounded-circle"
                                  title="Actif"></span>
                        @else
                            <span class="position-absolute bottom-0 end-0 translate-middle p-2 bg-danger border border-2 border-white rounded-circle"
                                  title="Inactif"></span>
                        @endif
                    </div>

                    <div>
                        <h1 class="h4 mb-1 fw-bold">
                            {{ $employee->firstname }} {{ $employee->lastname }}
                        </h1>
                        <p class="mb-1 text-white-50">
                            <i class="bi bi-credit-card-2-front me-1"></i>PPR :
                            <span class="fw-semibold">{{ $employee->ppr }}</span>
                            @if($employee->cin)
                                · <i class="bi bi-person-vcard me-1 ms-2"></i>CIN :
                                <span class="fw-semibold">{{ $employee->cin }}</span>
                            @endif
                        </p>
                        <span class="badge rounded-pill bg-light text-primary fw-semibold px-3 py-2">
                        <i class="bi bi-briefcase-fill me-1"></i>
                        {{ $employee->status == 1 ? 'Employé actif' : 'Employé inactif' }}
                    </span>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('employees.index') }}" class="btn btn-outline-light">
                        <i class="bi bi-arrow-left me-1"></i>Retour à la liste
                    </a>
                    <a href="{{ route('employees.edit', $employee) }}" class="btn btn-light text-primary fw-semibold">
                        <i class="bi bi-pencil-square me-1"></i>Modifier
                    </a>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Affectation actuelle -->
            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header border-0 bg-primary bg-gradient text-white fw-semibold">
                        <i class="bi bi-diagram-3-fill me-2"></i>
                        L'affectation actuelle
                    </div>
                    <div class="card-body">
                        @if(count($employee->affectations))
                            @foreach($employee->affectations as $affectation)
                                @if ($affectation->state == 1)
                                    <div class="mb-2 small">
                                        @if (!is_null($affectation->sector))
                                            <div class="d-flex align-items-center mb-1">
                                        <span class="badge rounded-pill bg-info bg-opacity-10 text-info me-2">
                                            <i class="bi bi-diagram-3"></i>
                                        </span>
                                                <span class="fw-semibold text-dark">
                                            Secteur : {{ $affectation->sector->title }}
                                        </span>
                                            </div>
                                        @endif
                                        @if (!is_null($affectation->section))
                                            <div class="d-flex align-items-center mb-1">
                                        <span class="badge rounded-pill bg-success bg-opacity-10 text-success me-2">
                                            <i class="bi bi-diagram-2"></i>
                                        </span>
                                                <span class="fw-semibold text-dark">
                                            Section : {{ $affectation->section->title }}
                                        </span>
                                            </div>
                                        @endif
                                        @if (!is_null($affectation->entity))
                                            <div class="d-flex align-items-center mb-1">
                                        <span class="badge rounded-pill bg-warning bg-opacity-10 text-warning me-2">
                                            <i class="bi bi-building"></i>
                                        </span>
                                                <span class="fw-semibold text-dark">
                                            Entité : {{ $affectation->entity->title }}
                                        </span>
                                            </div>
                                        @endif
                                        @if (!is_null($affectation->service))
                                            <div class="d-flex align-items-center mb-1">
                                        <span class="badge rounded-pill bg-secondary bg-opacity-10 text-secondary me-2">
                                            <i class="bi bi-briefcase"></i>
                                        </span>
                                                <span class="fw-semibold text-dark">
                                            Service : {{ $affectation->service->title }}
                                        </span>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        @else
                            <div class="alert alert-light border-0 d-flex align-items-center small mb-0">
                                <i class="bi bi-info-circle text-muted me-2"></i>
                                <span class="text-muted">Pas d'affectation</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Nouvelle affectation -->
            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header border-0 bg-success bg-gradient text-white fw-semibold">
                        <i class="bi bi-diagram-3-fill me-2"></i>
                        Nouvelle Affectation pour {{ $employee->firstname }} {{ $employee->lastname }}
                    </div>
                    <div class="card-body">
                        <form action="{{ route('affectations.store') }}" method="POST">
                            @csrf

                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-semibold small text-muted">Service</label>
                                    <select class="form-select form-select-sm" name="service_id">
                                        <option value="null">Séléctionnez le service</option>
                                        @foreach($services as $service)
                                            <option value="{{ $service->id }}"> {{ $service->title }} </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold small text-muted">Entité</label>
                                    <select class="form-select form-select-sm" name="entity_id">
                                        <option value="null">Séléctionnez l'entité</option>
                                        @foreach($entities as $entity)
                                            <option value="{{ $entity->id }}"> {{ $entity->title }} </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold small text-muted">Secteur</label>
                                    <select class="form-select form-select-sm" name="sector_id">
                                        <option value="null">Séléctionnez le secteur</option>
                                        @foreach($sectors as $sector)
                                            <option value="{{ $sector->id }}"> {{ $sector->title }} </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold small text-muted">Section</label>
                                    <select class="form-select form-select-sm" name="section_id">
                                        <option value="null">Séléctionnez la section</option>
                                        @foreach($sections as $section)
                                            <option value="{{ $section->id }}"> {{ $section->title }} </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold small text-muted">Date d'affectation</label>
                                    <x-date-input id="affectation_date"
                                                  name="affectation_date"
                                                  value="" />
                                </div>

                                <input type="hidden" name="employee_id" value="{{ $employee->id }}">

                                <div class="col-12">
                                    <hr class="mt-3 mb-3">
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-sm btn-success d-inline-flex align-items-center">
                                            <i class="bi bi-save me-2"></i> Enregistrer
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>

</x-layout>
