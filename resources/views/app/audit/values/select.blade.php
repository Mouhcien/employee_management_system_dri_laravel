<x-layout>
    <div class="row col-12 p-4">
        <div class="col-6">
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px; background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px);">
                <div class="card-body p-2">
                    <div class="input-group align-items-center">
            <span class="input-group-text bg-transparent border-0 ps-3">
                <i class="bi bi-search text-primary fs-5"></i>
            </span>

                        <input type="text"
                               class="form-control border-0 shadow-none bg-transparent py-2 px-3 fw-medium"
                               id="select_employee_supervisor"
                               placeholder="Rechercher par Nom, Prénom, PPR ou CIN..."
                               autocomplete="off"
                               style="font-size: 1rem; color: #334155;">

                        <div class="vr my-2 opacity-25" style="width: 1px; background-color: #64748b;"></div>

                        <div class="ps-2 pe-1">
                            <a href="{{ route('audit.values.select') }}"
                               class="btn btn-light rounded-3 d-flex align-items-center justify-content-center shadow-sm hover-rotate"
                               style="width: 42px; height: 42px; background: #f1f5f9; transition: all 0.3s ease;"
                               data-bs-toggle="tooltip"
                               title="Réinitialiser">
                                <i class="bi bi-arrow-repeat text-secondary fs-5"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <style>
                /* Styling for the focus state of the entire card */
                .card:has(#select_employee_supervisor:focus) {
                    box-shadow: 0 10px 25px -5px rgba(79, 70, 229, 0.15) !important;
                    border: 1px solid rgba(79, 70, 229, 0.2) !important;
                    transform: translateY(-1px);
                    transition: all 0.3s ease;
                }

                /* Rotation effect for the refresh button on hover */
                .hover-rotate:hover {
                    background: #e2e8f0 !important;
                    color: #4f46e5 !important;
                }

                .hover-rotate:hover i {
                    transform: rotate(180deg);
                    transition: transform 0.5s ease;
                    color: #4f46e5 !important;
                }

                /* Modern Placeholder color */
                #select_employee_supervisor::placeholder {
                    color: #94a3b8;
                    font-weight: 400;
                }
            </style>

            <div id="paginated_container">
                @foreach($employees as $employee)
                    @include('app.audit.values.partials.employee_card', ['employee' => $employee])
                @endforeach

                <div class="d-flex justify-content-center mt-3">
                    {{ $employees->links() }}
                </div>
            </div>

            <div id="search_results_container" style="display: none;">
                @foreach($employees_all as $employee)
                    <div class="employee-search-card"
                         data-search="{{ strtolower($employee->firstname.' '.$employee->lastname.' '.$employee->ppr.' '.$employee->cin) }}"
                         style="display: none;">
                        @include('app.audit.values.partials.employee_card', ['employee' => $employee])
                    </div>
                @endforeach
            </div>
        </div>

        <div class="col-lg-6 col-md-8 mx-auto">
            <div class="card border-0 shadow-sm" style="border-radius: 15px; background: #f8fafc;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="p-2 rounded-3 bg-primary bg-opacity-10 me-3">
                            <i class="bi bi-diagram-3-fill text-primary fs-4"></i>
                        </div>
                        <h5 class="fw-bold mb-0 text-dark">Unité Structurelle</h5>
                    </div>

                    <div class="position-relative">
                        <div class="position-absolute start-0 top-0 bottom-0 ms-3 border-start border-2 border-primary border-opacity-25 d-none d-sm-block"></div>

                        <div class="mb-3 position-relative ps-sm-4">
                            <span class="position-absolute start-0 translate-middle-x badge rounded-circle bg-primary p-1 d-none d-sm-block" style="margin-left: -1px; margin-top: 15px;"> </span>
                            <label class="form-label small fw-bold text-uppercase text-muted opacity-75">Service</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-primary"><i class="bi bi-diagram-3-fill"></i></span>
                                <select class="form-select border-start-0 shadow-none" id="sl_audit_view_service">
                                    <option value="-1">Sélectionnez le service</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}" {{ $selected_service == $service->id ? 'selected' : '' }}>{{ $service->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @if (count($entities) != 0)
                            <div class="mb-3 position-relative ps-sm-4">
                                <span class="position-absolute start-0 translate-middle-x badge rounded-circle bg-info p-1 d-none d-sm-block" style="margin-left: -1px; margin-top: 15px;"> </span>
                                <label class="form-label small fw-bold text-uppercase text-muted opacity-75">Entité</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-info"><i class="bi bi-diagram-2-fill"></i></span>
                                    <select class="form-select border-start-0 shadow-none" id="sl_audit_view_entity">
                                        <option value="-1">Sélectionnez l'entité</option>
                                        @foreach($entities as $entity)
                                            <option value="{{ $entity->id }}" {{ $selected_entity == $entity->id ? 'selected' : '' }}>{{ $entity->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif

                        @if (count($sectors) != 0)
                            <div class="mb-3 position-relative ps-sm-4">
                                <span class="position-absolute start-0 translate-middle-x badge rounded-circle bg-warning p-1 d-none d-sm-block" style="margin-left: -1px; margin-top: 15px;"> </span>
                                <label class="form-label small fw-bold text-uppercase text-muted opacity-75">Secteur</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-warning"><i class="bi bi-grid-1x2"></i></span>
                                    <select class="form-select border-start-0 shadow-none" id="sl_audit_view_sector">
                                        <option value="-1">Sélectionnez le secteur</option>
                                        @foreach($sectors as $sector)
                                            <option value="{{ $sector->id }}" {{ $selected_sector == $sector->id ? 'selected' : '' }}>{{ $sector->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif

                        @if (count($sections) != 0)
                            <div class="mb-4 position-relative ps-sm-4">
                                <span class="position-absolute start-0 translate-middle-x badge rounded-circle bg-success p-1 d-none d-sm-block" style="margin-left: -1px; margin-top: 15px;"> </span>
                                <label class="form-label small fw-bold text-uppercase text-muted opacity-75">Section</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-success"><i class="bi bi-layers"></i></span>
                                    <select class="form-select border-start-0 shadow-none" id="sl_audit_view_section">
                                        <option value="-1">Sélectionnez la section</option>
                                        @foreach($sections as $section)
                                            <option value="{{ $section->id }}" {{ $selected_section == $section->id ? 'selected' : '' }}>{{ $section->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="text-center mt-2">
                        @php
                            $entityName = "l'unité";
                            $btnColor = "linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%)";
                            $selected_id = 0;

                            if ($selected_section) { $entityName = "Section"; $btnColor = "linear-gradient(135deg, #10b981 0%, #059669 100%)"; $selected_id = $selected_section;}
                            elseif ($selected_sector) { $entityName = "Secteur"; $btnColor = "linear-gradient(135deg, #f59e0b 0%, #d97706 100%)"; $selected_id = $selected_sector;}
                            elseif ($selected_entity) { $entityName = "Entité"; $btnColor = "linear-gradient(135deg, #0ea5e9 0%, #2563eb 100%)"; $selected_id = $selected_entity;}
                            elseif ($selected_service) { $entityName = "Service"; $selected_id = $selected_service;}
                        @endphp

                        <a href="{{ route('audit.values.view.entity', ['entity'=>$entityName, 'id'=>$selected_id]) }}" class="btn btn-lg w-100 text-white fw-bold shadow-sm border-0 py-3"
                                style="background: {{ $btnColor }}; border-radius: 12px; transition: all 0.3s ease;">
                            <i class="bi bi-arrow-right-circle-fill me-2"></i>
                            Charger pour {{ $entityName }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .form-select:focus {
                border-color: #cbd5e1;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            }
            .input-group-text {
                border-color: #dee2e6;
            }
            .btn:hover {
                transform: translateY(-2px);
                filter: brightness(1.1);
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
            }
        </style>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('select_employee_supervisor');
            const paginatedContainer = document.getElementById('paginated_container');
            const searchContainer = document.getElementById('search_results_container');
            const searchCards = document.querySelectorAll('.employee-search-card');

            searchInput.addEventListener('input', function(e) {
                const term = e.target.value.toLowerCase().trim();

                if (term.length > 0) {
                    // Switch to Search Mode
                    paginatedContainer.style.display = 'none';
                    searchContainer.style.display = 'block';

                    searchCards.forEach(card => {
                        const searchableText = card.getAttribute('data-search');
                        if (searchableText.includes(term)) {
                            card.style.display = "block";
                        } else {
                            card.style.display = "none";
                        }
                    });
                } else {
                    // Return to Paginated Mode
                    paginatedContainer.style.display = 'block';
                    searchContainer.style.display = 'none';
                }
            });
        });
    </script>
</x-layout>
