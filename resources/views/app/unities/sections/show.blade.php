<x-layout>
    <div class="d-flex flex-column gap-4">

        <!-- Header section with "Retour" -->
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3">
            <div>
                <h1 class="h3 fw-semibold text-dark mb-1">
                    Section :
                    <span class="text-primary">{{ $section->title }}</span>
                </h1>
                <span class="fw-semibold text-dark">{{ $section->entity->type->title ?? 'Non assignée' }}</span> :
                <span class="fw-semibold text-primary">{{ $section->entity->title ?? 'Non assignée' }}</span> <br>
                <span class="fw-semibold text-dark">Service</span> :
                <small class="text-muted">{{ $section->entity->service->title ?? 'Service non défini' }}</small>
                <p class="text-muted mb-0">
                    Gérez efficacement le service <strong class="text-primary">{{ $section->title }}</strong> et ses employées associées.
                </p>
            </div>
            <!-- Retour link -->
            <a
                href="{{ route('sections.index') }}"
                class="btn btn-outline-secondary btn-sm px-3"
            >
                <i class="bi bi-arrow-left me-1"></i>
                Retour
            </a>
        </div>

        <div class="row g-4">
            <div class="col-12 col-lg-3">
                <div class="card border-info shadow-sm h-100">
                    <div class="card-header bg-info text-white">
                        <h5 class="h6 mb-0">
                            <i class="bi bi-journal-text me-2"></i>
                            Chef
                        </h5>
                    </div>
                    <div class="card-body pt-3 px-4 pb-4">

                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="card border-success shadow-sm h-100">
                    <div class="card-header bg-success text-white">
                        <h5 class="h6 mb-0">
                            <i class="bi bi-diagram-3 me-2"></i>
                            employés
                        </h5>
                    </div>
                    <div class="card-body pt-3 px-4 pb-4">
                        @if($section->affectations->isNotEmpty())
                            <div class="row col-12">
                                @foreach($section->affectations as $affectation)
                                @if ($affectation->state)
                                    <div class="col-4">
                                        <div class="card h-100 border shadow-sm rounded-4 overflow-hidden employee-card">
                                            {{-- Card Top Banner --}}
                                            <div class="position-relative" style="height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                                {{-- Gender Badge --}}
                                                <span class="position-absolute top-0 start-0 m-2">
                                                    @if ($affectation->employee->gender == 'M')
                                                        <i class="bi bi-gender-male text-white fs-5"></i>
                                                    @elseif($affectation->employee->gender == 'F')
                                                        <i class="bi bi-gender-female text-white fs-5"></i>
                                                    @endif
                                                </span>

                                                {{-- Action Dropdown --}}
                                                <div class="position-absolute top-0 end-0 m-2 dropdown">
                                                    <button
                                                        class="btn btn-sm btn-light rounded-circle p-1 lh-1 shadow-sm dropdown-toggle-no-caret"
                                                        type="button"
                                                        data-bs-toggle="dropdown"
                                                        aria-expanded="false"
                                                        style="width:28px; height:28px;"
                                                    >
                                                        <i class="bi bi-three-dots-vertical text-dark" style="font-size: 0.75rem;"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                                        <li>
                                                            <a class="dropdown-item py-2" href="{{ route('employees.show', $affectation->employee) }}">
                                                                <i class="bi bi-eye-fill me-2 text-info"></i>Voir détails
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item py-2" href="{{ route('employees.edit', $affectation->employee) }}">
                                                                <i class="bi bi-pencil-square me-2 text-warning"></i>Modifier
                                                            </a>
                                                        </li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <a class="dropdown-item py-2" href="{{ route('employees.unities', $affectation->employee) }}">
                                                                <i class="bi bi-diagram-3-fill me-2 text-primary"></i>Affectation
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item py-2" href="#">
                                                                <i class="bi bi-file-earmark-pdf me-2 text-danger"></i>Télécharger CV
                                                            </a>
                                                        </li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <button type="button" class="dropdown-item py-2 text-danger"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#deleteEmployeeModal">
                                                                <i class="bi bi-trash-fill me-2"></i>Supprimer
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                            {{-- Avatar --}}
                                            <div class="d-flex justify-content-center" style="margin-top: -28px;">
                                                <div class="position-relative">
                                                    @if($affectation->employee->photo)
                                                        <img
                                                            class="rounded-circle border border-3 border-white shadow object-fit-cover employee-photo-thumb"
                                                            width="56" height="56"
                                                            src="{{ Storage::url($affectation->employee->photo) }}"
                                                            data-full="{{ Storage::url($affectation->employee->photo) }}"
                                                            alt="{{ $affectation->employee->firstname }}"
                                                        >
                                                    @else
                                                        <div class="rounded-circle border border-3 border-white shadow d-flex align-items-center justify-content-center text-white fw-bold"
                                                             style="width:56px; height:56px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); font-size: 1.1rem;">
                                                            {{ strtoupper(substr($affectation->employee->firstname, 0, 1)) }}{{ strtoupper(substr($affectation->employee->lastname, 0, 1)) }}
                                                        </div>
                                                    @endif
                                                    {{-- Status dot --}}
                                                    @if ($affectation->employee->status == 1)
                                                        <span class="position-absolute bottom-0 end-0 p-1 bg-success border border-2 border-white rounded-circle"
                                                              style="width:14px; height:14px;" title="Actif"></span>
                                                    @else
                                                        <span class="position-absolute bottom-0 end-0 p-1 bg-danger border border-2 border-white rounded-circle"
                                                              style="width:14px; height:14px;" title="Inactif"></span>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Card Body --}}
                                            <div class="card-body text-center pt-2 pb-3 px-3">
                                                {{-- Name --}}
                                                <h6 class="fw-bold text-dark mb-0">
                                                    {{ $affectation->employee->firstname }} {{ $affectation->employee->lastname }} <br>
                                                    {{ $affectation->employee->firstname_arab }} {{ $affectation->employee->lastname_arab }}
                                                </h6>

                                                {{-- PPR & CIN badges --}}
                                                <div class="d-flex justify-content-center gap-2 mt-2 flex-wrap">
                                                    <span class="badge bg-dark bg-opacity-10 text-dark font-monospace small">
                                                        <i class="bi bi-hash me-1"></i>{{ $affectation->employee->ppr }}
                                                    </span>
                                                    <span class="badge bg-secondary bg-opacity-10 text-secondary font-monospace small">
                                                        {{ $affectation->employee->cin }}
                                                    </span>
                                                </div>

                                                <hr class="my-2">

                                                {{-- Details --}}
                                                <ul class="list-unstyled text-start small mb-0">
                                                    <li class="d-flex align-items-center gap-2 mb-2 text-muted">
                                                        <i class="bi bi-calendar3 text-info flex-shrink-0"></i>
                                                        <span>{{ \Carbon\Carbon::parse($affectation->employee->hiring_date)->format('d/m/Y') }}</span>
                                                    </li>
                                                    <li class="d-flex align-items-center gap-2 mb-2 text-muted">
                                                        <i class="bi bi-telephone text-success flex-shrink-0"></i>
                                                        <span>{{ $affectation->employee->tel ?? '—' }}</span>
                                                    </li>
                                                    <li class="d-flex align-items-center gap-2 text-muted">
                                                        <i class="bi bi-envelope text-warning flex-shrink-0"></i>
                                                        <a href="mailto:{{ $affectation->employee->email }}"
                                                           class="text-decoration-none text-dark text-truncate"
                                                           style="max-width: 160px;"
                                                           title="{{ $affectation->employee->email }}">
                                                            {{ $affectation->employee->email }}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>

                                            {{-- Card Footer --}}
                                            <div class="card-footer bg-white border-top py-2 px-3 d-flex justify-content-between gap-2">
                                                <a href="{{ route('employees.show', $affectation->employee) }}"
                                                   class="btn btn-outline-info btn-sm flex-fill rounded-pill">
                                                    <i class="bi bi-eye-fill me-1"></i>Voir
                                                </a>
                                                <a href="{{ route('employees.edit', $affectation->employee) }}"
                                                   class="btn btn-outline-warning btn-sm flex-fill rounded-pill">
                                                    <i class="bi bi-pencil-square me-1"></i>Modifier
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            </div>
                            <x-delete-model
                                href="{{ route('employees.delete', $affectation->employee->id) }}"
                                message="Voulez-vous vraiment supprimer ce agent ?"
                                title="Confiramtion"
                                target="deleteEmployeeModal" />
                        @else
                            <small class="text-muted">Aucun employés associé à ce service.</small>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-3">
                <div class="card border-info shadow-sm h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="h6 mb-0">
                            <i class="bi bi-journal-text me-2"></i>
                            Importer les employées
                        </h5>
                    </div>
                    <div class="card-body pt-3 px-4 pb-4">
                        <form action="{{ route('affectations.sections.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="section_id" value="{{ $section->id }}">
                            <label class="form-label mb-2">Fichier Excel des PPR</label>
                            <input type="file" class="form-control mb-2" name="file">
                            <button class="btn btn-primary"><i class="bi bi-save me-2"></i> Charger</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
