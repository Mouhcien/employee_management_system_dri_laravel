

{{-- Informations Professionnelles & Affectation --}}
<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-header bg-white border-bottom py-3 px-4">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="fw-bold text-uppercase text-muted small mb-0 ls-1"><i class="bi bi-briefcase-fill text-info me-2"></i>Parcours Professionnel</h6>
            <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill">{{ $employee->local->title ?? 'Sans affectation' }}</span>
        </div>
    </div>
    <div class="card-body p-4">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="d-flex align-items-center">
                    <div class="bg-light rounded-3 p-3 me-3 text-info"><i class="bi bi-calendar-check fs-4"></i></div>
                    <div>
                        <small class="text-muted text-uppercase extra-small fw-bold">Date de recrutement</small>
                        <div class="fw-bold text-dark">{{ $employee->hiring_date ? \Carbon\Carbon::parse($employee->hiring_date)->format('d F Y') : '—' }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex align-items-center">
                    <div class="bg-light rounded-3 p-3 me-3 text-secondary"><i class="bi bi-hourglass-bottom fs-4"></i></div>
                    <div class="p-2 border-start border-4 {{ \Carbon\Carbon::parse($employee->birth_date)->age >= 63 ? 'border-info' : 'border-light' }}">
                        <p class="text-muted small fw-bold text-uppercase mb-1">Départ à la retraite</p>

                        @if (\Carbon\Carbon::parse($employee->birth_date)->age >= 63 && is_null($employee->retiring_date))
                            <span class="text-primary fw-bold">
                                            <i class="bi bi-arrow-right-circle me-1"></i> À mettre en retrait
                                        </span>
                        @else
                            <div class="d-flex align-items-center">
                                                <span class="fs-5 fw-bold text-dark">
                                                    {{ $employee->retiring_date ? \Carbon\Carbon::parse($employee->retiring_date)->format('d F Y') : \Carbon\Carbon::parse($employee->birth_date)->age . ' ans' }}
                                                </span>
                                <small class="ms-2 text-muted italic">/ 63 ans</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex align-items-center">
                    <div class="bg-light rounded-3 p-3 me-3 text-info"><i class="bi bi-calendar-check fs-4"></i></div>
                    <div>
                        <small class="text-muted text-uppercase extra-small fw-bold">Date de commencement au fonction publique</small>
                        <div class="fw-bold text-dark">{{ $employee->hiring_public_date ? \Carbon\Carbon::parse($employee->hiring_public_date)->format('d F Y') : '—' }}</div>
                    </div>
                </div>
            </div>
        </div>
        <hr class="my-4 opacity-50">
        <div class="row g-3">
            <div class="col-md-4">
                <small class="text-muted d-block mb-1">Affectation Actuelle</small>
                <div class="p-2 border border-light-subtle rounded-3 bg-light-subtle fw-bold text-dark text-center shadow-xs">
                    {{ $employee->local->title ?? 'N/A' }}
                </div>
            </div>
            <div class="col-md-4">
                <small class="text-muted d-block mb-1">Commission / Carte</small>
                <div class="p-2 border border-light-subtle rounded-3 bg-light-subtle fw-bold text-dark text-center shadow-xs">
                    {{ $employee->commission_card ?? '—' }}
                </div>
            </div>
            <div class="col-md-4">
                @if (!is_null($employee->reintegration_date))
                    <small class="text-muted d-block mb-1">Réintégration</small>
                    <div class="p-2 border border-light-subtle rounded-3 bg-light-subtle fw-bold text-dark text-center shadow-xs">
                        {{ $employee->reintegration_date ? \Carbon\Carbon::parse($employee->reintegration_date)->format('d/m/Y') : '—' }}
                    </div>
                @endif
                @if (!is_null($employee->disposition_date))
                    <small class="text-muted d-block mb-1">La date de disposition</small>
                    <div class="p-2 border border-light-subtle rounded-3 bg-light-subtle fw-bold text-dark text-center shadow-xs">
                        {{ $employee->disposition_date ? \Carbon\Carbon::parse($employee->disposition_date)->format('d/m/Y') : '—' }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
