
@php
    $initials = strtoupper(substr($employee->firstname, 0, 1) . substr($employee->lastname, 0, 1));
@endphp

<div class="col-12 mb-3">
    <div class="card border-0 shadow-sm rounded-3 hover-shadow-transition">
        <div class="card-body p-2 d-flex align-items-center">

            {{-- Affichage Photo ou Initiales --}}
            <div class="me-3">
                @if($employee->photo && Storage::disk('public')->exists($employee->photo))
                    <img class="rounded-circle border border-2 border-white shadow-sm object-fit-cover"
                         width="40" height="40"
                         src="{{ Storage::url($employee->photo) }}"
                         alt="{{ $employee->lastname }} {{ $employee->firstname }}">
                @else
                    <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm"
                         style="width: 40px; height: 40px; font-size: 0.75rem;">
                        {{ $initials }}
                    </div>
                @endif
            </div>

            {{-- Infos Employé --}}
            <div class="flex-grow-1 overflow-hidden">
                <div class="fw-bold text-dark text-truncate small mb-0">
                    <a href="{{ route('employees.show', $employee) }}" class="text-decoration-none" >
                        {{ strtoupper($employee->lastname) }} {{ $employee->firstname }}
                    </a>
                </div>
                <div class="text-muted" style="font-size: 0.7rem;">PPR: #{{ $employee->ppr }}</div>
            </div>

        </div>
    </div>
</div>
