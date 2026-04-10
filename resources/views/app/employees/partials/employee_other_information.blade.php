
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white border-bottom-0 pt-4 px-4">
        <h6 class="fw-bold text-uppercase text-muted small mb-0 ls-1"><i class="bi bi-file-word-fill text-primary me-2"></i>Attestations</h6>
    </div>

    <div class="card-body p-4 pt-3">
        <h6 class="text-uppercase text-muted fw-bold mb-3" style="font-size: 0.75rem; letter-spacing: 1px;">
            Documents & Certificats
        </h6>
        <div class="d-grid gap-2">
            <a href="{{ route('employees.work.certificate', $employee) }}" target="_blank"
               class="btn btn-outline-light text-start d-flex align-items-center justify-content-between p-3 border shadow-sm hover-shadow transition-all">
                <div class="d-flex align-items-center">
                    <div class="bg-primary-subtle rounded p-2 me-3">
                        <i class="bi bi-file-earmark-person text-primary fs-5"></i>
                    </div>
                    <div>
                        <span class="d-block fw-bold text-dark mb-0">Attestation de Travail</span>
                        <small class="text-muted">{{ $employee->category->title }}</small>
                    </div>
                </div>
                <i class="bi bi-download text-primary"></i>
            </a>

            <a href="{{ route('employees.bonus.certificate', $employee) }}" target="_blank"
               class="btn btn-outline-light text-start d-flex align-items-center justify-content-between p-3 border shadow-sm hover-shadow transition-all">
                <div class="d-flex align-items-center">
                    <div class="bg-success-subtle rounded p-2 me-3">
                        <i class="bi bi-cash-stack text-success fs-5"></i>
                    </div>
                    <div>
                        <span class="d-block fw-bold text-dark mb-0">Attestation de Prime</span>
                        <small class="text-muted">{{ $employee->category->title }}</small>
                    </div>
                </div>
                <i class="bi bi-download text-success"></i>
            </a>

            <a href="{{ route('employees.holiday.certificate', $employee) }}" target="_blank"
               class="btn btn-outline-light text-start d-flex align-items-center justify-content-between p-3 border shadow-sm hover-shadow transition-all">
                <div class="d-flex align-items-center">
                    <div class="bg-warning-subtle rounded p-2 me-3">
                        <i class="bi bi-calendar2-range text-success fs-5"></i>
                    </div>
                    <div>
                        <span class="d-block fw-bold text-dark mb-0">Décision de congé</span>
                        <small class="text-muted">{{ $employee->category->title }}</small>
                    </div>
                </div>
                <i class="bi bi-download text-warning"></i>
            </a>

            <a href="{{ route('employees.renewal.certificate', $employee) }}" target="_blank"
               class="btn btn-outline-light text-start d-flex align-items-center justify-content-between p-3 border shadow-sm hover-shadow transition-all">
                <div class="d-flex align-items-center">
                    <div class="bg-danger-subtle rounded p-2 me-3">
                        <i class="bi bi-calendar2-range text-success fs-5"></i>
                    </div>
                    <div>
                        <span class="d-block fw-bold text-dark mb-0">Initier un renouvellement </span>
                        <small class="text-muted">{{ $employee->category->title }}</small>
                    </div>
                </div>
                <i class="bi bi-download text-danger"></i>
            </a>
        </div>
    </div>
</div>
