
@props(['employee', 'detach' => false, 'chef'])

<div class="card mb-2 border shadow-sm rounded-4 overflow-hidden employee-card">
    {{-- Card Top Banner --}}
    <div class="position-relative" style="height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        {{-- Gender Badge --}}
        <span class="position-absolute top-0 start-0 m-2">
            @if ($employee->gender == 'M')
                <i class="bi bi-gender-male text-white fs-5"></i>
            @elseif($employee->gender == 'F')
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
                        <a class="dropdown-item py-2 text-success" href="{{ route('employees.show', $employee) }}" data-bs-toggle="modal" data-bs-target="#affectChefModal">
                            <i class="bi bi-star-fill me-2 text-success"></i>Mettre Chef
                        </a>

                        <a class="dropdown-item py-2 text-danger" href="{{ route('employees.show', $employee) }}">
                            <i class="bi bi-x me-2 text-danger"></i>Détacher
                        </a>
                    @endif
                </li>
            </ul>
        </div>
    </div>

    {{-- Avatar --}}
    <div class="d-flex justify-content-center" style="margin-top: -28px;">
        <div class="position-relative">
            @if($employee->photo)
                <img
                    class="rounded-circle border border-3 border-white shadow object-fit-cover employee-photo-thumb"
                    width="56" height="56"
                    src="{{ Storage::url($employee->photo) }}"
                    data-full="{{ Storage::url($employee->photo) }}"
                    alt="{{ $employee->firstname }}"
                >
            @else
                <div class="rounded-circle border border-3 border-white shadow d-flex align-items-center justify-content-center text-white fw-bold"
                     style="width:56px; height:56px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); font-size: 1.1rem;">
                    {{ strtoupper(substr($employee->firstname, 0, 1)) }}{{ strtoupper(substr($employee->lastname, 0, 1)) }}
                </div>
            @endif
            {{-- Status dot --}}
            @if ($employee->status == 1)
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
            {{ $employee->firstname }} {{ $employee->lastname }} <br>
            {{ $employee->firstname_arab }} {{ $employee->lastname_arab }}
        </h6>

        {{-- PPR & CIN badges --}}
        <div class="d-flex justify-content-center gap-2 mt-2 flex-wrap">
                                                    <span class="badge bg-dark bg-opacity-10 text-dark font-monospace small">
                                                        <i class="bi bi-hash me-1"></i>{{ $employee->ppr }}
                                                    </span>
            <span class="badge bg-secondary bg-opacity-10 text-secondary font-monospace small">
                                                        {{ $employee->cin }}
                                                    </span>
        </div>

        <hr class="my-2">

        {{-- Details --}}
        <ul class="list-unstyled text-start small mb-0">
            <li class="d-flex align-items-center gap-2 mb-2 text-muted">
                <i class="bi bi-calendar3 text-info flex-shrink-0"></i>
                <span>{{ \Carbon\Carbon::parse($employee->hiring_date)->format('d/m/Y') }}</span>
            </li>
            <li class="d-flex align-items-center gap-2 mb-2 text-muted">
                <i class="bi bi-telephone text-success flex-shrink-0"></i>
                <span>{{ $employee->tel ?? '—' }}</span>
            </li>
            <li class="d-flex align-items-center gap-2 text-muted">
                <i class="bi bi-envelope text-warning flex-shrink-0"></i>
                <a href="mailto:{{ $employee->email }}"
                   class="text-decoration-none text-dark text-truncate"
                   style="max-width: 160px;"
                   title="{{ $employee->email }}">
                    {{ $employee->email }}
                </a>
            </li>
        </ul>
    </div>

    {{-- Card Footer --}}
    <div class="card-footer bg-white border-top py-2 px-3 d-flex justify-content-between gap-2">
        <a href="{{ Storage::url($chef->decision_file) }}" target="_blank"> La Decision </a>
    </div>

</div>
