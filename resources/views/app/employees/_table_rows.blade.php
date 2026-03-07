@forelse($employees ?? [] as $employee)
    <tr class="border-bottom ">
        <td class="px-4 py-3">
            @if ($employee->gender == 'M')
                <i class="bi bi-gender-male fs-3"></i>
            @elseif($employee->gender == 'F')
                <i class="bi bi-gender-female fs-3"></i>
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
                          style="width: 12px; height: 12px;" title="Actif">
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
            <div class="dropdown position-static">
                <button
                    class="btn btn-light btn-sm rounded-pill px-3 dropdown-toggle fw-medium shadow-sm"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
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
                                data-bs-target="#deleteEmployeeModal">
                            <i class="bi bi-trash-fill me-2"></i>Supprimer
                        </button>
                    </li>
                </ul>
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



