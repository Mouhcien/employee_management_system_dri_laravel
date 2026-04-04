<div class="d-flex align-items-center gap-3">
    <div class="position-relative flex-shrink-0">
        @if($employee->photo && Storage::disk('public')->exists($employee->photo))
            <img src="{{ Storage::url($employee->photo) }}"
                 class="rounded-circle border border-2 border-white shadow-sm object-fit-cover"
                 width="45" height="45">
        @else
            <div class="rounded-circle border border-2 border-white shadow-sm d-flex align-items-center justify-content-center text-white fw-bold"
                 style="width:45px; height:45px; background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); font-size: 0.85rem;">
                {{ strtoupper(substr($employee->firstname, 0, 1)) }}{{ strtoupper(substr($employee->lastname, 0, 1)) }}
            </div>
        @endif

        <span class="position-absolute bottom-0 end-0 rounded-circle border border-2 border-white {{ $employee->gender == 'M' ? 'bg-primary' : 'bg-danger' }}"
              style="width: 12px; height: 12px;"
              title="{{ $employee->gender == 'M' ? 'Homme' : 'Femme' }}">
            </span>
    </div>

    <div class="lh-sm">
        <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.9rem;">
            {{ $employee->firstname }} <span class="text-primary text-uppercase">{{ $employee->lastname }}</span>
        </h6>
        <div class="d-flex align-items-center gap-2 mt-1">
            <small class="text-secondary fw-medium" style="font-size: 0.75rem; direction: rtl;">
                {{ $employee->firstname_arab }} {{ $employee->lastname_arab }}
            </small>
            <span class="text-muted opacity-50" style="font-size: 0.7rem;">• ID: {{ $employee->id }}</span>
        </div>
    </div>
</div>
