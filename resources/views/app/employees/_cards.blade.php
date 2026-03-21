{{-- Employees Cards Grid --}}
<div class="card border-0 bg-transparent">
    <div class="row g-4" id="employees-cards">
        @forelse($employees ?? [] as $employee)
            @php
                // Extraction de l'affectation active
                $current = $employee->affectations->where('state', 1)->first();
                $service = $current?->service?->title;
                $entity = $current?->entity?->title;
                $entityType = $current?->entity?->type?->title;
                $sector = $current?->sector?->title;
                $section = $current?->section?->title;
            @endphp

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 card_items">

                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden employee-card hover-lift ms-1">

                    {{-- Banner Top --}}
                    <div class="position-relative" style="height: 60px; background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);">
                        <span class="position-absolute top-0 start-0 m-2">
                            @if ($employee->gender == 'M')
                                <i class="bi bi-gender-male text-white opacity-75 fs-5"></i>
                            @else
                                <i class="bi bi-gender-female text-white opacity-75 fs-5"></i>
                            @endif
                        </span>

                        {{-- Dropdown Actions --}}
                        <div class="position-absolute top-0 end-0 m-2 dropdown">
                            <button class="btn btn-sm btn-white btn-rounded shadow-xs p-0 d-flex align-items-center justify-content-center"
                                    type="button" data-bs-toggle="dropdown" style="width:28px; height:28px;">
                                <i class="bi bi-three-dots-vertical text-dark"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3">
                                <li><a class="dropdown-item py-2" href="{{ route('employees.show', $employee) }}"><i class="bi bi-eye text-info me-2"></i>Détails</a></li>
                                <li><a class="dropdown-item py-2" href="{{ route('employees.edit', $employee) }}"><i class="bi bi-pencil-square text-warning me-2"></i>Modifier</a></li>
                                <li><hr class="dropdown-divider opacity-50"></li>
                                <li><a class="dropdown-item py-2" href="{{ route('employees.unities', $employee) }}"><i class="bi bi-diagram-3 text-primary me-2"></i>Affectation</a></li>
                                <li>
                                    <button type="button" class="dropdown-item py-2 text-danger fw-bold" data-bs-toggle="modal" data-bs-target="#deleteEmployeeModal-{{ $employee->id }}">
                                        <i class="bi bi-trash3 me-2"></i>Supprimer
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Avatar Section --}}
                    <div class="d-flex justify-content-center" style="margin-top: -30px;">
                        <div class="position-relative">
                            @if($employee->photo && Storage::disk('public')->exists($employee->photo))
                                <img src="{{ Storage::url($employee->photo) }}" class="rounded-circle border border-3 border-white shadow-sm object-fit-cover avatar-hover" width="65" height="65">
                            @else
                                <div class="rounded-circle border border-3 border-white shadow-sm d-flex align-items-center justify-content-center text-white fw-bold"
                                     style="width:65px; height:65px; background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);">
                                    {{ strtoupper(substr($employee->firstname, 0, 1)) }}{{ strtoupper(substr($employee->lastname, 0, 1)) }}
                                </div>
                            @endif
                            <span class="position-absolute bottom-0 end-0 p-1 bg-{{ $employee->status == 1 ? 'success' : 'danger' }} border border-2 border-white rounded-circle" style="width:14px; height:14px;"></span>
                        </div>
                    </div>

                    {{-- Card Content --}}
                    <div class="card-body text-center pt-2 pb-3">
                        <h6 class="fw-bold text-dark mb-1" id="employee_fullname">{{ $employee->firstname }} {{ strtoupper($employee->lastname) }}</h6>
                        <div class="text-primary small mb-2" dir="rtl" id="employee_fullname_arabic">{{ $employee->firstname_arab }} {{ $employee->lastname_arab }}</div>

                        <div class="d-flex justify-content-center gap-1 mb-3">
                            <span class="badge bg-light text-dark border font-monospace extra-small" id="employee_ppr">#{{ $employee->ppr }}</span>
                            <span class="badge bg-light text-muted border font-monospace extra-small" id="employee_cin">{{ $employee->cin }}</span>
                        </div>

                        <ul class="list-unstyled text-start small mb-3 border rounded-3 p-2 bg-light-subtle">
                            <li class="d-flex align-items-center gap-2 mb-1">
                                <i class="bi bi-calendar-check text-info"></i>
                                <span class="text-muted" id="employee_hiring_date">{{ \Carbon\Carbon::parse($employee->hiring_date)->format('d/m/Y') }}</span>
                            </li>
                            <li class="d-flex align-items-center gap-2 mb-1">
                                <i class="bi bi-telephone text-success"></i>
                                <span class="text-dark" id="employee_tel">{{ $employee->tel ?? '—' }}</span>
                            </li>
                            <li class="d-flex align-items-center gap-2">
                                <i class="bi bi-envelope text-warning"></i>
                                <span class="text-truncate" title="{{ $employee->email }}" id="employee_email">{{ $employee->email }}</span>
                            </li>
                        </ul>

                        <button class="btn btn-primary btn-sm w-100 rounded-pill fw-bold open-details-modal transition-base"
                                data-employee-id="{{ $employee->id }}"
                                data-employee-name="{{ $employee->firstname }} {{ $employee->lastname }}">
                            <i class="bi bi-info-circle me-1"></i> Structure & Localisation
                        </button>

                        {{-- Hidden Data for JS Modal --}}
                        <div class="d-none" id="details-data-{{ $employee->id }}">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="p-3 rounded-4 bg-primary bg-opacity-10 border border-primary-subtle">
                                        <h6 class="small fw-bold text-primary text-uppercase mb-3">Affectation Structurelle</h6>
                                        <div class="mb-2 d-flex justify-content-between"><span class="text-muted">Service:</span> <span class="fw-bold">{{ $service ?: 'N/A' }}</span></div>
                                        <div class="mb-2 d-flex justify-content-between"><span class="text-muted">{{ $entityType ?: 'Entité' }}:</span> <span class="fw-bold text-end">{{ $entity ?: 'N/A' }}</span></div>
                                        @if($sector) <div class="mb-2 d-flex justify-content-between"><span class="text-muted">Secteur:</span> <span class="fw-bold">{{ $sector }}</span></div> @endif
                                        @if($section) <div class="d-flex justify-content-between"><span class="text-muted">Section:</span> <span class="fw-bold">{{ $section }}</span></div> @endif
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="p-3 rounded-4 bg-success bg-opacity-10 border border-success-subtle">
                                        <h6 class="small fw-bold text-success text-uppercase mb-3">Géolocalisation</h6>
                                        <div class="mb-2 d-flex align-items-center"><i class="bi bi-building me-2"></i> <span>Local : <strong>{{ $employee->local->title ?? 'N/A' }}</strong></span></div>
                                        <div class="d-flex align-items-center"><i class="bi bi-geo-alt me-2"></i> <span>Ville : <strong>{{ $employee->local->city->title ?? 'N/A' }}</strong></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-person-x fs-1 text-muted opacity-25"></i>
                <p class="text-muted mt-2">Aucun agent ne correspond à votre recherche.</p>
            </div>
        @endforelse
    </div>
</div>

{{-- Global Details Modal --}}
<div class="details-modal-overlay" id="detailsModal">
    <div class="details-modal-container">
        <div class="details-modal-header">
            <h5 class="modal-title fw-bold" id="modalEmployeeName"></h5>
            <button type="button" class="btn-close-modal" id="closeModalBtn"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="details-modal-body p-4">
            <div id="modalDetailsContent"></div>
        </div>
    </div>
</div>

<style>
    .hover-lift { transition: all 0.2s ease-in-out; }
    .hover-lift:hover { transform: translateY(-5px); box-shadow: 0 1rem 3rem rgba(0,0,0,0.1) !important; }
    .btn-white { background: #fff; border: 1px solid #e2e8f0; }
    .extra-small { font-size: 0.7rem; }
    .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
    .bg-light-subtle { background-color: #f8fafc !important; }

    /* Modal Design */
    .details-modal-overlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px);
        z-index: 9999; display: none; align-items: center; justify-content: center;
        opacity: 0; transition: opacity 0.3s ease;
    }
    .details-modal-overlay.show { display: flex; opacity: 1; }
    .details-modal-container {
        background: white; width: 90%; max-width: 500px; border-radius: 24px;
        transform: scale(0.9); transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
    .details-modal-overlay.show .details-modal-container { transform: scale(1); }
    .details-modal-header {
        padding: 1.25rem 1.5rem; background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        color: white; border-radius: 24px 24px 0 0; display: flex; justify-content: space-between; align-items: center;
    }
    .btn-close-modal { background: rgba(255,255,255,0.2); border: none; color: white; border-radius: 50%; width: 32px; height: 32px; transition: 0.2s; }
    .btn-close-modal:hover { background: rgba(255,255,255,0.3); transform: rotate(90deg); }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('detailsModal');
        const modalContent = document.getElementById('modalDetailsContent');
        const modalTitle = document.getElementById('modalEmployeeName');

        // Délégation pour l'ouverture
        document.getElementById('employees-cards').addEventListener('click', function(e) {
            const btn = e.target.closest('.open-details-modal');
            if (!btn) return;

            const id = btn.dataset.employeeId;
            const name = btn.dataset.employeeName;
            const sourceHtml = document.getElementById('details-data-' + id).innerHTML;

            modalTitle.textContent = name;
            modalContent.innerHTML = sourceHtml;
            modal.classList.add('show');
        });

        // Fermeture
        const closeModal = () => modal.classList.remove('show');
        document.getElementById('closeModalBtn').addEventListener('click', closeModal);
        modal.addEventListener('click', (e) => { if(e.target === modal) closeModal(); });
    });
</script>
