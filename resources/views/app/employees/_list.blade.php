
<div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-list-ul me-2 text-primary"></i>Liste des employés</h5>
    <div class="btn-group">
        <button type="button" class="btn btn-outline-primary btn-sm" onclick="window.print()">
            <i class="bi bi-printer me-1"></i>Imprimer
        </button>
        <button type="button" class="btn btn-outline-success btn-sm">
            <i class="bi bi-file-excel me-1"></i>Exporter
        </button>
        <a href="{{ route('employees.index') }}?opt=cards" class="btn btn-outline-info btn-sm">
            <i class="bi bi-card-list me-1"></i>
        </a>
    </div>
</div>
<table class="table table-hover align-middle mb-0">
    <thead class="bg-light">
    <tr>
        <th scope="col" class="text-muted small fw-semibold px-4 py-3 border-0"></th>
        <th scope="col" class="text-muted small fw-semibold px-4 py-3 border-0">PHOTO</th>
        <th scope="col" class="text-muted small fw-semibold px-4 py-3 border-0">PPR</th>
        <th scope="col" class="text-muted small fw-semibold px-4 py-3 border-0">NOM</th>
        <th scope="col" class="text-muted small fw-semibold px-4 py-3 border-0">PRÉNOM</th>
        <th scope="col" class="text-muted small fw-semibold px-4 py-3 border-0">CIN</th>
        <th scope="col" class="text-muted small fw-semibold px-4 py-3 border-0">RECRUTEMENT</th>
        <th scope="col" class="text-muted small fw-semibold px-4 py-3 border-0">CONTACT</th>
        <th scope="col" class="text-muted small fw-semibold px-4 py-3 border-0">EMAIL</th>
        <th scope="col" class="text-muted small fw-semibold px-4 py-3 border-0 text-center">ACTIONS</th>
    </tr>
    </thead>
    <tbody class="bg-white">
    @forelse($employees ?? [] as $employee)
        @php
            $service_title = "";
            $entity_title = "";
            $type_entity_title = "";
            $sector_title = "";
            $section_title = "";

            if(count($employee->affectations) != 0) {
                foreach($employee->affectations as $affectation) {
                    if ($affectation->state == 1) {
                        if (!is_null($affectation->service))
                            $service_title = $affectation->service->title;
                        if (!is_null($affectation->entity))
                            $entity_title = $affectation->entity->title;
                        if (!is_null($affectation->entity) && !is_null($affectation->entity->type))
                            $type_entity_title = $affectation->entity->type->title;
                        if (!is_null($affectation->sector))
                            $sector_title = $affectation->sector->title;
                        if (!is_null($affectation->section))
                            $section_title = $affectation->section->title;
                    }
                }
            }
        @endphp

        @php
            $rowId = 'employee-details-' . $employee->id;
        @endphp

        <tr class="border-bottom employee-row" data-bs-toggle="collapse" data-bs-target="#{{ $rowId }}" aria-expanded="false" style="cursor:pointer;">
            <td class="px-4 py-3 align-middle">
                @if ($employee->gender == 'M')
                    <i class="bi bi-gender-male fs-3 text-primary"></i>
                @elseif($employee->gender == 'F')
                    <i class="bi bi-gender-female fs-3 text-danger"></i>
                @endif
            </td>
            <td class="px-4 py-3">
                <div class="position-relative">
                    @if($employee->photo)
                        <img
                            class="rounded-circle border border-2 border-white shadow-sm object-fit-cover employee-photo-thumb"
                            width="45" height="45"
                            src="{{ Storage::url($employee->photo) }}"
                            data-full="{{ Storage::url($employee->photo) }}"
                            alt="{{ $employee->first_name }}"
                        >
                    @else
                        <div class="rounded-circle bg-gradient-primary d-flex align-items-center justify-content-center shadow-sm text-white fw-bold"
                             style="width: 45px; height: 45px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            {{ strtoupper(substr($employee->first_name, 0, 1)) }}{{ strtoupper(substr($employee->last_name, 0, 1)) }}
                        </div>
                    @endif
                    @if ($employee->status == 1)
                        <span class="position-absolute bottom-0 end-0 translate-middle-x p-1 bg-success border border-light rounded-circle"
                              style="width: 12px; height: 12px;" title="Actif">
                                            </span>
                    @else
                        <span class="position-absolute bottom-0 end-0 translate-middle-x p-1 bg-danger border border-light rounded-circle"
                              style="width: 12px; height: 12px;" title="Inactif">
                                            </span>
                    @endif
                </div>
            </td>
            <td class="px-4 py-3">
                                    <span class="badge bg-dark bg-opacity-10 text-dark fw-mono font-monospace">
                                        {{ $employee->ppr }}
                                    </span>
            </td>
            <td class="px-4 py-3">
                <div class="fw-semibold text-dark">{{ $employee->lastname }}</div>
            </td>
            <td class="px-4 py-3">
                <div class="fw-semibold text-dark">{{ $employee->firstname }}</div>
            </td>
            <td class="px-4 py-3">
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary font-monospace">
                                        {{ $employee->cin }}
                                    </span>
            </td>
            <td class="px-4 py-3">
                <div class="d-flex align-items-center text-muted">
                    <i class="bi bi-calendar3 me-2 text-info"></i>
                    <span>{{ \Carbon\Carbon::parse($employee->hiring_date)->format('d/m/Y') }}</span>
                </div>
            </td>
            <td class="px-4 py-3">
                <div class="d-flex align-items-center">
                    <i class="bi bi-telephone me-2 text-success"></i>
                    <span class="text-dark">{{ $employee->tel ?? '—' }}</span>
                </div>
            </td>
            <td class="px-4 py-3">
                <div class="d-flex align-items-center">
                    <i class="bi bi-envelope me-2 text-warning"></i>
                    <a href="mailto:{{ $employee->email }}" class="text-decoration-none text-dark hover-primary">
                        {{ $employee->email }}
                    </a>
                </div>
            </td>
            <td class="px-4 py-3 text-center">
                <div class="d-flex justify-content-center align-items-center gap-2">
                    <button class="btn btn-light btn-sm rounded-circle shadow-sm toggle-details" type="button">
                        <i class="bi bi-chevron-down"></i>
                    </button>

                    <div class="dropdown">
                        <button
                            class="btn btn-light btn-sm rounded-pill px-3 dropdown-toggle fw-medium shadow-sm"
                            type="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                            onclick="event.stopPropagation();"
                        >
                            <i class="bi bi-gear-fill me-1 text-primary"></i>Gérer
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('employees.show', $employee) }}">
                                    <i class="bi bi-eye-fill me-2 text-info"></i>Voir détails
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('employees.edit', $employee) }}">
                                    <i class="bi bi-pencil-square me-2 text-warning"></i>Modifier
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('employees.unities', $employee) }}">
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
                                        data-bs-target="#deleteEmployeeModal"
                                        onclick="event.stopPropagation();">
                                    <i class="bi bi-trash-fill me-2"></i>Supprimer
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </td>
        </tr>

        <tr class="details-row collapse bg-light" id="{{ $rowId }}">
            <td colspan="11" class="p-0">
                <div class="p-3 border-top">
                    <div class="row g-3 align-items-stretch">
                        <div class="col-md-8">
                            <div class="card h-100 shadow-sm border-0">
                                <div class="card-header bg-transparent border-0 pb-0">
                                    <h6 class="mb-1 text-uppercase text-muted small">Affectation</h6>
                                </div>
                                <div class="card-body pt-2">
                                    <div class="mb-2">
                                        <span class="badge bg-success me-2">Service</span>
                                        <span class="text-dark">{{ $service_title ?: 'Non affecté' }}</span>
                                    </div>
                                    <div class="mb-2">
                                        <span class="badge bg-info me-2">{{ $type_entity_title ?: 'Entité' }}</span>
                                        <span class="text-dark">{{ $entity_title ?: 'Non défini' }}</span>
                                    </div>
                                    @if ($sector_title != "")
                                        <div class="mb-2">
                                            <span class="badge bg-secondary me-2">Secteur</span>
                                            <span class="text-dark">{{ $sector_title ?: 'Non défini' }}</span>
                                        </div>
                                    @endif

                                    @if ($section_title != "")
                                        <div>
                                            <span class="badge bg-dark me-2">Section</span>
                                            <span class="text-dark">{{ $section_title ?: 'Non défini' }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card h-100 shadow-sm border-0">
                                <div class="card-header bg-transparent border-0 pb-0">
                                    <h6 class="mb-1 text-uppercase text-muted small">Localisation</h6>
                                </div>
                                <div class="card-body pt-2">
                                    <div class="mb-2">
                                        <i class="bi bi-building me-2 text-primary"></i>
                                        <span class="fw-semibold">{{ $employee->local->title ?? 'Non défini' }}</span>
                                    </div>
                                    <div class="mb-2">
                                        <i class="bi bi-geo-alt me-2 text-danger"></i>
                                        <span class="text-muted">{{ $employee->local->city->title ?? 'Non défini' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>

    @empty
        <tr>
            <td colspan="10" class="text-center py-5">
                <div class="d-flex flex-column align-items-center">
                    <div class="mb-3 p-4 bg-primary bg-opacity-10 rounded-circle">
                        <i class="bi bi-search text-primary" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="fw-bold mb-2 text-dark">Aucun employé trouvé</h5>
                    <p class="text-muted mb-4">Aucun résultat ne correspond à vos critères de recherche.</p>
                </div>
            </td>
        </tr>
    @endforelse
    </tbody>
</table>
