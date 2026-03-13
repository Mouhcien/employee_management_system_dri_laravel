
@props(['affectation', 'detach' => false, 'unity_type' => '', 'unity_id' => false, 'unity_name' => ''])

<div class="card mb-2 border shadow-sm rounded-4 overflow-hidden employee-card">
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
                    @if($detach)
                    <a class="dropdown-item py-2 text-success" href="{{ route('employees.show', $affectation->employee) }}" data-bs-toggle="modal" data-bs-target="#affectChefModal">
                        <i class="bi bi-star-fill me-2 text-success"></i>Mettre Chef
                    </a>

                    <a class="dropdown-item py-2 text-danger" href="{{ route('employees.show', $affectation->employee) }}">
                        <i class="bi bi-x me-2 text-danger"></i>Détacher
                    </a>
                    @endif
                </li>
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

    <x-affect-chef-modal :employee="$affectation->employee" unity_type="{{ $unity_type }}" unity_id="{{ $unity_id }}" unity_name="{{ $unity_name }}" />
</div>
