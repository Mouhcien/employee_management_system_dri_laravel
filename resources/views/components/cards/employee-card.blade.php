@props(['employee', 'detach' => false, 'unity_type' => '', 'unity_id' => false, 'unity_name' => ''])

<div class="card border-0 shadow-sm rounded-4 overflow-hidden hover-lift transition-base h-100 mb-3">
    {{-- Card Top Banner (Gradient Soft & Moderne) --}}
    <div class="position-relative" style="height: 50px; background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);">
        {{-- Gender Badge --}}
        <div class="position-absolute top-0 start-0 m-2">
            @if ($employee->gender == 'M')
                <span class="badge bg-white bg-opacity-20 rounded-pill text-dark border border-white border-opacity-25 px-2 py-1 extra-small">
                    <i class="bi bi-gender-male me-1"></i>M
                </span>
            @elseif($employee->gender == 'F')
                <span class="badge bg-white bg-opacity-20 rounded-pill text-dark border border-white border-opacity-25 px-2 py-1 extra-small">
                    <i class="bi bi-gender-female me-1"></i>F
                </span>
            @endif
        </div>

        {{-- Action Dropdown --}}
        <div class="position-absolute top-0 end-0 m-2 dropdown">
            <button
                class="btn btn-sm btn-white rounded-circle p-0 d-flex align-items-center justify-content-center shadow-sm transition-base"
                type="button"
                data-bs-toggle="dropdown"
                style="width:26px; height:26px; border:none;"
            >
                <i class="bi bi-three-dots-vertical text-dark small"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 overflow-hidden">
                @if($detach)
                    <li>
                        <button class="dropdown-item py-2 small text-success fw-medium" data-bs-toggle="modal" data-bs-target="#affectChefModal-{{$employee->id}}">
                            <i class="bi bi-star-fill me-2"></i>Promouvoir Chef
                        </button>
                    </li>
                    <li>
                        <a class="dropdown-item py-2 small text-danger fw-medium" href="#">
                            <i class="bi bi-person-dash-fill me-2"></i>Détacher de l'unité
                        </a>
                    </li>
                    <li><hr class="dropdown-divider opacity-50"></li>
                @endif
                <li><a class="dropdown-item py-2 small" href="{{ route('employees.show', $employee) }}"><i class="bi bi-eye me-2 text-info"></i>Consulter</a></li>
                <li><a class="dropdown-item py-2 small" href="{{ route('employees.edit', $employee) }}"><i class="bi bi-pencil-square me-2 text-warning"></i>Modifier</a></li>
            </ul>
        </div>
    </div>

    {{-- Avatar avec effet Glow --}}
    <div class="d-flex justify-content-center" style="margin-top: -30px;">
        <div class="position-relative">
            @php
                $photoExists = $employee->photo && Storage::disk('public')->exists($employee->photo);
            @endphp
            @if($photoExists)
                <img
                    class="rounded-circle border border-3 border-white shadow-sm object-fit-cover bg-white"
                    width="60" height="60"
                    src="{{ Storage::url($employee->photo) }}"
                    alt="{{ $employee->firstname }}"
                >
            @else
                <div class="rounded-circle border border-3 border-white shadow-sm d-flex align-items-center justify-content-center text-white fw-bold"
                     style="width:60px; height:60px; background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); font-size: 1.2rem;">
                    {{ strtoupper(substr($employee->firstname, 0, 1)) }}{{ strtoupper(substr($employee->lastname, 0, 1)) }}
                </div>
            @endif

            {{-- Status dot --}}
            <span class="position-absolute bottom-0 end-0 p-1 bg-{{ $employee->status == 1 ? 'success' : 'danger' }} border border-2 border-white rounded-circle shadow-sm"
                  style="width:15px; height:15px;" title="{{ $employee->status == 1 ? 'Actif' : 'Inactif' }}"></span>
        </div>
    </div>

    {{-- Card Body --}}
    <div class="card-body text-center pt-2 pb-3 px-3">
        <div class="mb-2">
            <h6 class="fw-bold text-dark mb-0 ls-n1">{{ $employee->firstname }} {{ $employee->lastname }}</h6>
            <small class="text-muted fw-semibold" dir="rtl">{{ $employee->firstname_arab }} {{ $employee->lastname_arab }}</small>
        </div>

        {{-- PPR & CIN (Badges épurés) --}}
        <div class="d-flex justify-content-center gap-1 mb-3">
            <span class="badge bg-light text-secondary border rounded-pill px-2 py-1 extra-small">
                #{{ $employee->ppr }}
            </span>
            <span class="badge bg-light text-secondary border rounded-pill px-2 py-1 extra-small">
                CIN: {{ $employee->cin }}
            </span>
        </div>

        {{-- Infos Box --}}
        <div class="bg-light rounded-4 p-2 text-start">
            <div class="d-flex align-items-center gap-2 mb-1 px-1">
                <i class="bi bi-calendar3 text-primary extra-small"></i>
                <span class="extra-small text-dark fw-medium">{{ \Carbon\Carbon::parse($employee->hiring_date)->format('d/m/Y') }}</span>
            </div>
            <div class="d-flex align-items-center gap-2 mb-1 px-1">
                <i class="bi bi-telephone text-success extra-small"></i>
                <span class="extra-small text-dark fw-medium">{{ $employee->tel ?? '—' }}</span>
            </div>
            <div class="d-flex align-items-center gap-2 px-1">
                <i class="bi bi-envelope text-info extra-small"></i>
                <span class="extra-small text-dark text-truncate d-inline-block" style="max-width: 140px;">{{ $employee->email }}</span>
            </div>
        </div>
    </div>

    {{-- Card Footer (Boutons Pilotes) --}}
    <div class="card-footer bg-white border-top-0 d-flex gap-2 px-3 pb-3 pt-0">
        <a href="{{ route('employees.show', $employee) }}"
           class="btn btn-primary-subtle btn-sm flex-fill rounded-pill fw-bold extra-small transition-base py-1">
            Détails
        </a>
        <a href="{{ route('employees.edit', $employee) }}"
           class="btn btn-warning-subtle btn-sm flex-fill rounded-pill fw-bold extra-small transition-base py-1">
            Modifier
        </a>
    </div>
</div>

<style>
    .transition-base { transition: all 0.2s ease-in-out; }
    .hover-lift:hover { transform: translateY(-5px); box-shadow: 0 12px 24px rgba(0,0,0,0.08) !important; }
    .extra-small { font-size: 0.72rem; }
    .ls-n1 { letter-spacing: -0.2px; }
    .btn-white { background: white; color: #4f46e5; }
    .btn-white:hover { background: #f8f9fa; }
    .btn-primary-subtle { background-color: #eef2ff; color: #4f46e5; border: none; }
    .btn-primary-subtle:hover { background-color: #4f46e5; color: white; }
    .btn-warning-subtle { background-color: #fffbeb; color: #d97706; border: none; }
    .btn-warning-subtle:hover { background-color: #d97706; color: white; }
</style>
