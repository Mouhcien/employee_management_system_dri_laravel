<table class="table table-hover align-middle mb-0 border-0">
    <thead class="bg-light-subtle">
    <tr>
        <th scope="col" class="ps-4 py-3 border-0"></th>
        <th scope="col" class="text-muted small fw-bold text-uppercase ls-1 border-0">Profil</th>
        <th scope="col" class="text-muted small fw-bold text-uppercase ls-1 border-0">PPR / CIN</th>
        <th scope="col" class="text-muted small fw-bold text-uppercase ls-1 border-0">Identité</th>
        <th scope="col" class="text-muted small fw-bold text-uppercase ls-1 border-0">Recrutement</th>
        <th scope="col" class="text-muted small fw-bold text-uppercase ls-1 border-0">Contact</th>
        <th scope="col" class="text-muted small fw-bold text-uppercase ls-1 border-0 text-end pe-4">Actions</th>
    </tr>
    </thead>
    <tbody class="bg-white border-top-0">
    @forelse($employees ?? [] as $employee)
        @php
            // Logique d'affectation simplifiée
            $current = $employee->affectations->where('state', 1)->first();
            $service = $current?->service?->title;
            $entity = $current?->entity?->title;
            $entityType = $current?->entity?->type?->title;
            $sector = $current?->sector?->title;
            $section = $current?->section?->title;

            $rowId = 'employee-details-' . $employee->id;
        @endphp

        <tr class="employee-row transition-base border-bottom" style="cursor:pointer;">
            <td class="ps-4 py-3">
                @if ($employee->gender == 'M')
                    <span class="text-primary opacity-50"><i class="bi bi-gender-male fs-5"></i></span>
                @else
                    <span class="text-danger opacity-50"><i class="bi bi-gender-female fs-5"></i></span>
                @endif
            </td>
            <td class="py-3">
                <div class="position-relative d-inline-block">
                    @if($employee->photo && Storage::disk('public')->exists($employee->photo))
                        <img class="rounded-circle border border-2 border-white shadow-sm object-fit-cover employee-photo-thumb avatar-hover"
                             width="48" height="48"
                             src="{{ Storage::url($employee->photo) }}"
                             alt="{{ $employee->firstname }}">
                    @else
                        <div class="rounded-circle shadow-sm text-white fw-bold d-flex align-items-center justify-content-center"
                             style="width: 48px; height: 48px; background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);">
                            {{ strtoupper(substr($employee->firstname, 0, 1)) }}{{ strtoupper(substr($employee->lastname, 0, 1)) }}
                        </div>
                    @endif
                    <span class="position-absolute bottom-0 end-0 p-1 bg-{{ $employee->status == 1 ? 'success' : 'danger' }} border border-2 border-white rounded-circle"
                          style="width: 12px; height: 12px;" title="{{ $employee->status == 1 ? 'Actif' : 'Inactif' }}"></span>
                </div>
            </td>
            <td class="py-3">
                <div class="d-flex flex-column">
                    <span class="fw-bold text-dark font-monospace small">#{{ $employee->ppr }}</span>
                    <span class="text-muted extra-small fw-bold">{{ $employee->cin }}</span>
                </div>
            </td>
            <td class="py-3">
                <div class="d-flex flex-column">
                    <div class="fw-bold text-dark mb-0">{{ $employee->firstname }} {{ strtoupper($employee->lastname) }}</div>
                    <div class="text-primary small opacity-75" dir="rtl">{{ $employee->firstname_arab }} {{ $employee->lastname_arab }}</div>
                </div>
            </td>
            <td class="py-3">
                <div class="d-flex align-items-center text-muted small fw-medium">
                    <i class="bi bi-calendar-event me-2 text-info"></i>
                    {{ \Carbon\Carbon::parse($employee->hiring_date)->translatedFormat('d M Y') }}
                </div>
            </td>
            <td class="py-3">
                <div class="d-flex flex-column gap-1">
                    <div class="small d-flex align-items-center">
                        <i class="bi bi-telephone me-2 text-success opacity-75"></i>
                        <span class="text-dark">{{ $employee->tel ?? '—' }}</span>
                    </div>
                    <div class="small d-flex align-items-center">
                        <i class="bi bi-envelope me-2 text-warning opacity-75"></i>
                        <span class="text-muted text-truncate" style="max-width: 150px;">{{ $employee->email }}</span>
                    </div>
                </div>
            </td>
            <td class="pe-4 py-3 text-end">
                <div class="d-flex justify-content-end align-items-center gap-2">
                    <button class="btn btn-light btn-sm rounded-circle border-0 shadow-xs toggle-details"
                            type="button" data-bs-toggle="collapse" data-bs-target="#{{ $rowId }}">
                        <i class="bi bi-chevron-down"></i>
                    </button>

                    <div class="dropdown">
                        <button class="btn btn-white btn-sm rounded-pill px-3 shadow-xs border dropdown-toggle fw-bold"
                                type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots me-1"></i> Gérer
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-2">
                            <li><a class="dropdown-item rounded-3 py-2" href="{{ route('employees.show', $employee) }}"><i class="bi bi-eye text-info me-2"></i>Consulter</a></li>
                            <li><a class="dropdown-item rounded-3 py-2" href="{{ route('employees.edit', $employee) }}"><i class="bi bi-pencil-square text-warning me-2"></i>Modifier</a></li>
                            <li><hr class="dropdown-divider opacity-50"></li>
                            <li><a class="dropdown-item rounded-3 py-2" href="{{ route('employees.unities', $employee) }}"><i class="bi bi-diagram-3 text-primary me-2"></i>Gérer l'affectation</a></li>
                            <li><a class="dropdown-item rounded-3 py-2 text-danger fw-bold" href="#" data-bs-toggle="modal" data-bs-target="#deleteEmployeeModal"><i class="bi bi-trash3 me-2"></i>Supprimer</a></li>
                        </ul>
                    </div>
                </div>
            </td>
        </tr>

        {{-- Expanded Details Row --}}
        <tr class="details-row collapse bg-light-subtle" id="{{ $rowId }}">
            <td colspan="7" class="p-0">
                <div class="p-4 border-top">
                    <div class="row g-4">
                        <div class="col-lg-8">
                            <div class="card border-0 shadow-xs rounded-4">
                                <div class="card-body p-4">
                                    <h6 class="fw-bold text-muted text-uppercase ls-1 small mb-4">Structure d'affectation</h6>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="p-3 bg-white border border-light-subtle rounded-3 h-100">
                                                <small class="text-muted d-block mb-1">Service</small>
                                                <span class="fw-bold text-dark">{{ $service ?: 'Non affecté' }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="p-3 bg-white border border-light-subtle rounded-3 h-100">
                                                <small class="text-muted d-block mb-1">{{ $entityType ?: 'Entité' }}</small>
                                                <span class="fw-bold text-dark">{{ $entity ?: 'Non défini' }}</span>
                                            </div>
                                        </div>
                                        @if($sector)
                                            <div class="col-md-6">
                                                <div class="p-3 bg-white border border-light-subtle rounded-3">
                                                    <small class="text-muted d-block mb-1">Secteur</small>
                                                    <span class="fw-bold text-dark">{{ $sector }}</span>
                                                </div>
                                            </div>
                                        @endif
                                        @if($section)
                                            <div class="col-md-6">
                                                <div class="p-3 bg-white border border-light-subtle rounded-3">
                                                    <small class="text-muted d-block mb-1">Section</small>
                                                    <span class="fw-bold text-dark">{{ $section }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card border-0 shadow-xs rounded-4 bg-white h-100">
                                <div class="card-body p-4">
                                    <h6 class="fw-bold text-muted text-uppercase ls-1 small mb-4">Localisation</h6>
                                    <div class="d-flex align-items-center mb-3 p-3 bg-light rounded-3">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2 me-3">
                                            <i class="bi bi-building"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Site local</small>
                                            <span class="fw-bold">{{ $employee->local->title ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center p-3 bg-light rounded-3">
                                        <div class="bg-danger bg-opacity-10 text-danger rounded-circle p-2 me-3">
                                            <i class="bi bi-geo-alt"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Ville</small>
                                            <span class="fw-bold">{{ $employee->local->city->title ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    @empty
        {{-- Votre code pour le cas vide --}}
    @endforelse
    </tbody>
</table>

<style>
    .ls-1 { letter-spacing: 0.5px; }
    .extra-small { font-size: 0.7rem; }
    .shadow-xs { box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
    .transition-base { transition: all 0.2s ease-in-out; }
    .bg-light-subtle { background-color: #f8f9fa !important; }
    .avatar-hover:hover { transform: scale(1.1); transition: 0.2s ease; }
    .hover-row:hover { background-color: #f8fbff !important; }
</style>
