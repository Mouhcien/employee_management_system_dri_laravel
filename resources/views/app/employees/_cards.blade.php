
    {{-- Employees Cards --}}
    <div class="card shadow border-0">

        <div class="p-4">
            <div class="row g-4" id="employees-cards">
                @forelse($employees ?? [] as $employee)
                    @php
                        $service_title = "";
                        $entity_title = "";
                        $type_entity_title = "";
                        $sector_title = "";
                        $section_title = "";

                        if(count($employee->affectations) != 0) {
                            foreach($employee->affectations as $affectation) {
                                if ($affectation->state == 1) {
                                    if (!is_null($affectation->service))
                                        $service_title = $affectation->service->title;
                                    if (!is_null($affectation->entity))
                                        $entity_title = $affectation->entity->title;
                                    if (!is_null($affectation->entity) && !is_null($affectation->entity->type))
                                        $type_entity_title = $affectation->entity->type->title;
                                    if (!is_null($affectation->sector))
                                        $sector_title = $affectation->sector->title;
                                    if (!is_null($affectation->section))
                                        $section_title = $affectation->section->title;
                                }
                            }
                        }
                    @endphp
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                        <div class="card h-100 border shadow-sm rounded-4 overflow-hidden employee-card">

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
                                            <a class="dropdown-item py-2" href="{{ route('employees.show', $employee) }}">
                                                <i class="bi bi-eye-fill me-2 text-info"></i>Voir détails
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item py-2" href="{{ route('employees.edit', $employee) }}">
                                                <i class="bi bi-pencil-square me-2 text-warning"></i>Modifier
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item py-2" href="{{ route('employees.unities', $employee) }}">
                                                <i class="bi bi-diagram-3-fill me-2 text-primary"></i>Affectation
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item py-2" href="#">
                                                <i class="bi bi-file-earmark-pdf me-2 text-danger"></i>Télécharger CV
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <button type="button" class="dropdown-item py-2 text-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteEmployeeModal">
                                                <i class="bi bi-trash-fill me-2"></i>Supprimer
                                            </button>
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

                                <div class="details-trigger text-center mt-2 mb-1">
                                    <button class="btn btn-primary btn-sm rounded-pill px-3 fw-semibold open-details-modal"
                                            data-employee-id="{{ $employee->id }}"
                                            data-employee-name="{{ $employee->firstname }} {{ $employee->lastname }}">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Voir Détails
                                    </button>
                                </div>


                                {{-- Details Section - HIDDEN BY DEFAULT + INDIVIDUAL TOGGLE --}}
                                <div class="details-grid-vertical collapse" id="details-{{ $employee->id }}" data-employee-id="{{ $employee->id }}">
                                    {{-- Affectation Card - TOP --}}
                                    <div class="detail-card h-100">
                                        <div class="detail-header mb-2">
                                            <i class="bi bi-briefcase-fill text-primary me-2"></i>
                                            <small class="text-uppercase fw-semibold text-muted">Affectation</small>
                                        </div>
                                        <div class="detail-content">
                                            @if($service_title)
                                                <div class="detail-row mb-2">
                                                    <span class="detail-label bg-success">Service</span>
                                                    <span class="detail-value fw-medium">{{ $service_title }}</span>
                                                </div>
                                            @endif
                                            @if($entity_title)
                                                <div class="detail-row mb-2">
                                                    <span class="detail-label bg-info">{{ $type_entity_title ?: 'Entité' }}</span>
                                                    <span class="detail-value fw-medium">{{ $entity_title }}</span>
                                                </div>
                                            @endif
                                            @if($sector_title)
                                                <div class="detail-row mb-2">
                                                    <span class="detail-label bg-secondary">Secteur</span>
                                                    <span class="detail-value fw-medium">{{ $sector_title }}</span>
                                                </div>
                                            @endif
                                            @if($section_title)
                                                <div class="detail-row">
                                                    <span class="detail-label bg-dark text-white">Section</span>
                                                    <span class="detail-value fw-medium">{{ $section_title }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Localisation Card - BOTTOM --}}
                                    <div class="detail-card h-100">
                                        <div class="detail-header mb-2">
                                            <i class="bi bi-geo-alt-fill text-danger me-2"></i>
                                            <small class="text-uppercase fw-semibold text-muted">Localisation</small>
                                        </div>
                                        <div class="detail-content">
                                            <div class="detail-row mb-2">
                                                <span class="detail-label bg-primary">Local</span>
                                                <span class="detail-value fw-semibold">{{ $employee->local->title ?? 'Non défini' }}</span>
                                            </div>
                                            <div class="detail-row">
                                                <span class="detail-label bg-warning text-dark">Ville</span>
                                                <span class="detail-value">{{ $employee->local->city->title ?? 'Non défini' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            {{-- Card Footer --}}
                            <div class="card-footer bg-white border-top py-2 px-3 d-flex justify-content-between gap-2">
                                <a href="{{ route('employees.show', $employee) }}"
                                   class="btn btn-outline-info btn-sm flex-fill rounded-pill">
                                    <i class="bi bi-eye-fill me-1"></i>Voir
                                </a>
                                <a href="{{ route('employees.edit', $employee) }}"
                                   class="btn btn-outline-warning btn-sm flex-fill rounded-pill">
                                    <i class="bi bi-pencil-square me-1"></i>Modifier
                                </a>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <div class="mb-3 p-4 bg-primary bg-opacity-10 rounded-circle d-inline-block">
                                <i class="bi bi-search text-primary" style="font-size: 3rem;"></i>
                            </div>
                            <h5 class="fw-bold mb-2 text-dark">Aucun employé trouvé</h5>
                            <p class="text-muted mb-4">Aucun résultat ne correspond à vos critères de recherche.</p>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-1"></i>Retour
                                </a>
                                <a href="{{ route('employees.create') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-lg me-1"></i>Nouvel employé
                                </a>
                            </div>
                        </div>
                    </div>
                @endforelse

                    {{-- GLOBAL MODAL OVERLAY - ONE FOR ALL CARDS --}}
                    <div class="details-modal-overlay" id="detailsModal">
                        <div class="details-modal-container">
                            <div class="details-modal-header">
                                <h5 class="modal-title fw-bold" id="modalEmployeeName"></h5>
                                <button type="button" class="btn-close-modal" id="closeModalBtn">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>
                            <div class="details-modal-body">
                                <div class="details-grid-vertical" id="modalDetailsContent">
                                    {{-- Content populated by JS --}}
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>

    </div>

    {{-- Hover effect --}}
    <style>
        .employee-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .employee-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.12) !important;
        }
        .dropdown-toggle-no-caret::after {
            display: none !important;
        }

        /* Main Details Container */
        .details-grid-vertical {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin-bottom: 1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Individual Detail Cards */
        .detail-card {
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.95), rgba(248, 250, 252, 0.85));
            border-radius: 16px;
            border: 1px solid rgba(226, 232, 240, 0.6);
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(12px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .detail-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }

        /* Detail Header */
        .detail-header {
            padding: 1rem 1.25rem 0.5rem;
            color: #64748b;
            font-size: 0.85rem;
        }

        .detail-header i {
            font-size: 1rem;
            width: 20px;
        }

        /* Detail Content */
        .detail-content {
            padding: 0 1.25rem 1.25rem;
        }

        /* Detail Rows */
        .detail-row {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
            padding: 0.5rem 0;
        }

        .detail-row:last-child {
            margin-bottom: 0;
        }

        /* Detail Labels */
        .detail-label {
            padding: 0.375rem 0.875rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.025em;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        /* Detail Values */
        .detail-value {
            flex: 1;
            color: #1e293b;
            font-size: 0.9rem;
            line-height: 1.4;
            font-weight: 500;
            word-break: break-word;
        }

        /* Label Color Variants */
        .detail-label.bg-primary { background-color: #3b82f6 !important; color: white; }
        .detail-label.bg-success { background-color: #10b981 !important; color: white; }
        .detail-label.bg-info { background-color: #0ea5e9 !important; color: white; }
        .detail-label.bg-secondary { background-color: #6b7280 !important; color: white; }
        .detail-label.bg-warning {
            background-color: #f59e0b !important;
            color: #1f2937 !important;
        }
        .detail-label.bg-dark {
            background-color: #1f2937 !important;
            color: white !important;
        }

        /* Hover Effects for Rows */
        .detail-row:hover .detail-label {
            transform: scale(1.05);
        }

        .detail-row:hover .detail-value {
            color: #1e40af;
        }

        /* Collapse Animation Enhancement */
        .details-grid-vertical.collapsing {
            opacity: 0.7;
        }

        .details-grid-vertical.show {
            opacity: 1;
        }

        /* Responsive Adjustments */
        @media (max-width: 576px) {
            .detail-card {
                border-radius: 12px;
            }

            .detail-header {
                padding: 0.875rem 1rem 0.375rem;
            }

            .detail-content {
                padding: 0 1rem 1rem;
            }

            .detail-label {
                font-size: 0.7rem;
                padding: 0.25rem 0.625rem;
            }

            .detail-value {
                font-size: 0.85rem;
            }
        }

        /* Empty state for no details */
        .detail-content:empty::after {
            content: "Aucune information disponible";
            color: #9ca3af;
            font-style: italic;
            padding: 1rem;
            display: block;
            text-align: center;
        }

        /* Modal Overlay */
        .details-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(8px);
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .details-modal-overlay.show {
            display: flex !important;
            opacity: 1;
            visibility: visible;
        }

        /* Modal Container */
        .details-modal-container {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 50px 100px rgba(0, 0, 0, 0.3);
            max-width: 600px;
            max-height: 90vh;
            width: 100%;
            transform: scale(0.7) translateY(-20px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        .details-modal-overlay.show .details-modal-container {
            transform: scale(1) translateY(0);
        }

        /* Modal Header */
        .details-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 2rem;
            border-bottom: 1px solid rgba(226, 232, 240, 0.5);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        #modalEmployeeName {
            margin: 0;
            font-size: 1.25rem;
        }

        .btn-close-modal {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            padding: 0.5rem;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .btn-close-modal:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: rotate(90deg);
        }

        /* Modal Body */
        .details-modal-body {
            padding: 0;
            max-height: 70vh;
            overflow-y: auto;
        }

        /* All your existing detail-card, detail-row, etc. styles go here... */
        .details-grid-vertical {
            padding: 2rem;
        }

        /* Scrollbar Styling */
        .details-modal-body::-webkit-scrollbar {
            width: 6px;
        }

        .details-modal-body::-webkit-scrollbar-track {
            background: rgba(226, 232, 240, 0.5);
            border-radius: 10px;
        }

        .details-modal-body::-webkit-scrollbar-thumb {
            background: rgba(102, 126, 234, 0.4);
            border-radius: 10px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .details-modal-container {
                margin: 1rem;
                border-radius: 20px;
                max-height: 95vh;
            }

            .details-modal-header {
                padding: 1.25rem 1.5rem;
            }

            .details-grid-vertical {
                padding: 1.5rem;
            }
        }

    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const previewBox = document.getElementById('employee-photo-preview');
            const previewImg = previewBox.querySelector('img');
            const offsetX = 20;  // distance from cursor
            const offsetY = 20;

            document.querySelectorAll('.employee-photo-thumb').forEach(function (img) {
                img.addEventListener('mouseenter', function (e) {
                    const src = img.dataset.full || img.src;
                    previewImg.src = src;
                    previewBox.style.display = 'block';
                    movePreview(e);
                });

                img.addEventListener('mousemove', function (e) {
                    movePreview(e);
                });

                img.addEventListener('mouseleave', function () {
                    previewBox.style.display = 'none';
                });
            });

            function movePreview(e) {
                const x = e.clientX + offsetX;
                const y = e.clientY + offsetY;

                previewBox.style.left = x + 'px';
                previewBox.style.top  = y + 'px';
            }
        });

        /*** Details appear ***/
        document.querySelectorAll('.open-details-modal').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const employeeId   = this.dataset.employeeId;
                const employeeName = this.dataset.employeeName;

                // Set modal title
                document.getElementById('modalEmployeeName').textContent = employeeName;

                // ✅ Clone content from the hidden div inside the card
                const source = document.getElementById('details-' + employeeId);
                const modalContent = document.getElementById('modalDetailsContent');

                if (source) {
                    modalContent.innerHTML = source.innerHTML;
                } else {
                    modalContent.innerHTML = '<p class="text-center text-muted p-4">Aucun détail disponible.</p>';
                }

                // Open modal
                document.getElementById('detailsModal').classList.add('show');
            });
        });

        // Close modal
        document.getElementById('closeModalBtn').addEventListener('click', function() {
            document.getElementById('detailsModal').classList.remove('show');
        });

        // Close on overlay click
        document.getElementById('detailsModal').addEventListener('click', function(e) {
            if (e.target === this) this.classList.remove('show');
        });


    </script>
