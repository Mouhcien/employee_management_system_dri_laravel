

{{-- Identité Card --}}
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white border-bottom-0 pt-4 px-4">
        <h6 class="fw-bold text-uppercase text-muted small mb-0 ls-1"><i class="bi bi-person-lines-fill text-primary me-2"></i>État Civil</h6>
    </div>
    <div class="card-body p-4 pt-3">
        <div class="d-flex flex-column gap-3">
            <div class="p-3 bg-light rounded-3">
                <small class="text-muted d-block text-uppercase fw-bold extra-small mb-1">Nom (Arabe)</small>
                <span class="fw-bold text-dark fs-5" dir="rtl">{{ $employee->firstname_arab }} {{ $employee->lastname_arab }}</span>
            </div>
            <div class="row g-2">
                <div class="col-6">
                    <small class="text-muted d-block extra-small">GENRE</small>
                    <span class="badge rounded-pill bg-{{ $employee->gender === 'F' ? 'danger' : 'info' }} bg-opacity-10 text-{{ $employee->gender === 'F' ? 'danger' : 'info' }} fw-bold">
                                        <i class="bi bi-gender-{{ $employee->gender === 'F' ? 'female' : 'male' }} me-1"></i>{{ $employee->gender === 'F' ? 'Féminin' : 'Masculin' }}
                                    </span>
                </div>
                <div class="col-6">
                    <small class="text-muted d-block extra-small">SITUATION</small>
                    <span class="text-dark fw-semibold">
                                        @if ($employee->sit == 'C')
                            Célébataire
                        @elseif($employee->sit == 'D')
                            Divorcé
                        @elseif($employee->sit == 'M')
                            Marie
                        @else
                            {{ $employee->sit }}
                        @endif

                                    </span>
                </div>
                <div class="col-6 mt-3">
                    <small class="text-muted d-block extra-small">NÉ(E) LE</small>
                    <span class="text-dark fw-semibold">{{ $employee->birth_date ? \Carbon\Carbon::parse($employee->birth_date)->format('d/m/Y') : '—' }}</span>
                </div>
                <div class="col-6 mt-3">
                    <small class="text-muted d-block extra-small">À</small>
                    <span class="text-dark fw-semibold text-truncate d-block">{{ $employee->birth_city ?? '—' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Contact Card --}}
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white border-bottom-0 pt-4 px-4">
        <h6 class="fw-bold text-uppercase text-muted small mb-0 ls-1"><i class="bi bi-geo-alt-fill text-success me-2"></i>Contact & Adresse</h6>
    </div>
    <div class="card-body p-4 pt-3">
        <div class="d-flex align-items-center p-3 mb-3 bg-success bg-opacity-10 rounded-4">
            <div class="bg-success text-white rounded-circle p-2 me-3 shadow-sm"><i class="bi bi-telephone-fill"></i></div>
            <div>
                <small class="text-muted d-block extra-small">TÉLÉPHONE</small>
                <span class="fw-bold text-dark">{{ $employee->tel ?? '—' }}</span>
            </div>
        </div>
        <div class="d-flex align-items-center p-3 mb-3 bg-warning bg-opacity-10 rounded-4">
            <div class="bg-warning text-white rounded-circle p-2 me-3 shadow-sm"><i class="bi bi-envelope-at-fill"></i></div>
            <div class="text-truncate">
                <small class="text-muted d-block extra-small">EMAIL</small>
                <a href="mailto:{{ $employee->email }}" class="fw-bold text-dark text-decoration-none">{{ $employee->email ?? '—' }}</a>
            </div>
        </div>
        <div class="p-3 bg-light rounded-4">
            <small class="text-muted d-block extra-small mb-1">ADRESSE DE RÉSIDENCE</small>
            <span class="text-dark fw-semibold small">{{ $employee->address ?? '—' }}</span>
            @if($employee->city)<div class="badge bg-white text-muted border mt-2">{{ $employee->city }}</div>@endif
        </div>
    </div>
</div>
