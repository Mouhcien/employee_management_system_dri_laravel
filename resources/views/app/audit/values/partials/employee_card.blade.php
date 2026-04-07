<div class="card employee-card border-0 shadow-lg overflow-hidden mb-4"
     style="border-radius: 20px; background: linear-gradient(145deg, #ffffff, #f0f2f5);"
     data-search="{{ strtolower($employee->firstname . ' ' . $employee->lastname . ' ' . $employee->ppr . ' ' . $employee->cin) }}">

    <div class="card-body p-0">
        <div class="row g-0 align-items-center">
            <div class="col-1" style="width: 12px; height: 120px; background: linear-gradient(180deg, #4f46e5 0%, #7c3aed 100%);"></div>

            <div class="col-8 d-flex align-items-center p-3">
                <div class="position-relative me-3">
                    @if($employee->photo && Storage::disk('public')->exists($employee->photo))
                        <img src="{{ Storage::url($employee->photo) }}"
                             class="rounded-circle border border-4 border-white shadow object-fit-cover"
                             width="75" height="75" style="transition: transform .3s ease;">
                    @else
                        <div class="rounded-circle border border-4 border-white shadow d-flex align-items-center justify-content-center text-white fw-bolder fs-4"
                             style="width:75px; height:75px; background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);">
                            {{ strtoupper(substr($employee->firstname, 0, 1)) }}{{ strtoupper(substr($employee->lastname, 0, 1)) }}
                        </div>
                    @endif
                </div>

                <div>
                    <h5 class="fw-bold mb-0 text-dark">
                        {{ $employee->firstname }} <span class="text-primary">{{ strtoupper($employee->lastname) }}</span>
                    </h5>
                    <small class="text-muted">PPR: {{ $employee->ppr }} | CIN: {{ $employee->cin }}</small>
                    <p class="mb-0 fw-medium text-secondary mt-1" style="direction: rtl;">
                        {{ $employee->firstname_arab }} {{ $employee->lastname_arab }}
                    </p>
                </div>
            </div>

            <div class="col-3 text-center pe-3">
                <a href="{{ route('audit.values.view', $employee) }}" class="btn btn-sm rounded-pill px-3 fw-bold text-white shadow-sm transition-all btn-charger"
                        style="background: linear-gradient(135deg, #0ea5e9 0%, #2563eb 100%); border: none;">
                    <i class="bi bi-cloud-arrow-down-fill me-1"></i> Charger
                </a>
            </div>
        </div>
    </div>
</div>
