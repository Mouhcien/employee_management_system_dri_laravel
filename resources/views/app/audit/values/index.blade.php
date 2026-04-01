<x-layout>
    <style>
        :root {
            --saas-primary: #0061f2;
            --saas-secondary: #0a2351;
            --saas-bg-soft: #f8f9fa;
            --saas-border: #e3e6f0;
        }

        .profile-header-custom {
            background: linear-gradient(135deg, var(--saas-primary) 0%, var(--saas-secondary) 100%);
            border-radius: 12px;
        }

        /* Modern Filter Bar */
        .filter-section {
            background: white;
            border-bottom: 1px solid var(--saas-border);
            padding: 1.5rem;
            margin-bottom: 2rem;
            border-radius: 12px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.05);
        }

        /* Professional Input Styling */
        .form-label-sm {
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            color: #4e73df;
            margin-bottom: 0.5rem;
            display: block;
        }

        .search-results-box {
            border: 1px solid var(--saas-border);
            border-top: none;
            border-radius: 0 0 8px 8px;
            max-height: 150px;
            overflow-y: auto;
        }

        /* Table Enhancements */
        .table-entry-container {
            background: white;
            border-radius: 12px;
            border: 1px solid var(--saas-border);
            overflow: hidden;
        }

        .table-input {
            border: 1px solid #d1d3e2;
            border-radius: 6px;
            padding: 0.5rem;
            text-align: center;
            transition: all 0.2s ease;
        }

        .table-input:focus {
            border-color: var(--saas-primary);
            box-shadow: 0 0 0 0.2rem rgba(0, 97, 242, 0.1);
            background-color: #fff;
        }

        .sticky-header th {
            position: sticky;
            top: 0;
            background: #f8f9fc;
            z-index: 10;
            border-bottom: 2px solid var(--saas-border);
        }

        .x-small { font-size: 0.75rem; }
    </style>

    <div class="card profile-header-custom border-0 mb-4 text-white shadow-sm">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-20 p-3 rounded-circle me-3">
                            <i class="bi bi-pencil-square fs-3"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-0">Console d'Évaluation</h4>
                            <p class="mb-0 text-white-50 small text-uppercase tracking-wider">Saisie des indicateurs de performance</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="d-inline-flex align-items-center bg-black bg-opacity-10 px-3 py-2 rounded-pill">
                        <span class="pulse-indicator me-2"></span>
                        <span class="small fw-bold">Session Active</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ is_null($values) ? route('audit.values.store') : route('audit.values.update') }}" method="POST">
        @csrf
        <div class="filter-section border-0 shadow-sm">
            <div class="row g-4 align-items-start">
                <div class="col-md-3 border-end">
                    <label class="form-label-sm">Configuration de base</label>
                    <div class="mb-2">
                        <select class="form-select form-select-sm border-0 bg-light" id="sl_table_performance" name="table_id" required>
                            <option value="">Sélectionner le Tableau de suivi</option>
                            @foreach($tables as $table)
                                <option value="{{ $table->id }}" {{ $table->id == $selected_table ? 'selected': '' }}>{{ $table->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <select class="form-select form-select-sm border-0 bg-light" name="period_id" required>
                            <option value="">Sélectionner la période de suivi</option>
                            @foreach($periods as $period)
                                <option value="{{ $period->id }}" {{ $selected_period == $period->period_id ? 'selected' : '' }}>{{ $period->title }} {{$period->year}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6 border-end">
                    <label class="form-label-sm">Recherche Employé(e)</label>
                    <div class="input-group input-group-sm mb-0">
                        <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                        <input type="text" id="employee_selected" class="form-control border-0 bg-light" placeholder="Entrez un nom ou service...">
                    </div>
                    <div class="search-results-box bg-white">
                        <select id="employee_list" class="form-select border-0 x-small" size="8" name="employee_id" required>
                            <option value="-1" disabled selected>En attente de saisie...</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" data-name="{{ strtolower($employee->firstname . ' ' . $employee->lastname) }}"
                                    {{ (!is_null($values) && $values[0]->employee_id == $employee->id) ? 'selected' : '' }}>
                                    {{ strtoupper($employee->lastname) }} {{ $employee->firstname }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-3 d-grid">
                    <label class="form-label-sm">Untité Structurelle</label>
                    <select class="form-control mb-2" id="sl_audit_service">
                        <option value="-1"> Séléctionnez le service</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ $selected_service == $service->id ? 'selected' : '' }}>{{ $service->title }}</option>
                        @endforeach
                    </select>

                    @if (count($entities) != 0)
                    <select class="form-control mb-2" id="sl_audit_entity">
                        <option value="-1"> Séléctionnez l'entité</option>
                        @foreach($entities as $entity)
                            <option value="{{ $entity->id }}" {{ $selected_entity == $entity->id ? 'selected' : '' }}>{{ $entity->title }}</option>
                        @endforeach
                    </select>
                    @endif

                    @if (count($sectors) != 0)
                    <select class="form-control mb-2" id="sl_audit_sector">
                        <option value="-1"> Séléctionnez le secteur</option>
                        @foreach($sectors as $sector)
                            <option value="{{ $sector->id }}" {{ $selected_sector == $sector->id ? 'selected' : '' }}>{{ $sector->title }}</option>
                        @endforeach
                    </select>
                    @endif

                    @if (count($sections) != 0)
                    <select class="form-control mb-2" id="sl_audit_section">
                        <option value="-1"> Séléctionnez la section</option>
                        @foreach($sections as $section)
                            <option value="{{ $section->id }}" {{ $selected_section == $section->id ? 'selected' : '' }}>{{ $section->title }}</option>
                        @endforeach
                    </select>
                    @endif
                    @php
                        $params = [];
                        if (!is_null($selected_table))
                            $params['tbl'] = $selected_table;

                        $params['srv'] = !is_null($selected_service) ? $selected_service : 0;
                        $params['ent'] = !is_null($selected_entity) ? $selected_entity : 0;
                        $params['sectr'] = !is_null($selected_sector) ? $selected_sector : 0;
                        $params['sect'] = !is_null($selected_section) ? $selected_section : 0;

                    @endphp
                    <a href="{{ route('audit.values.download.model', $params) }}" class="btn btn-primary fw-bold py-2 shadow-sm mt-2">
                        <i class="bi bi-download me-2"></i>Télécharger le modèle du fichier
                    </a>
                </div>
            </div>
        </div>

        <div class="table-entry-container shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <div>
                <span class="badge bg-primary-soft text-primary text-uppercase x-small px-3 py-2">Fiche de saisie</span>
                <h5 class="d-inline ms-2 fw-bold text-secondary mb-0">Indicateurs de performance</h5>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-light border btn-sm text-secondary px-3">
                    <i class="bi bi-file-earmark-excel me-1"></i>Modèle
                </button>
                @if (is_null($values))
                    <button type="submit" class="btn btn-success btn-sm px-4 fw-bold shadow-sm">
                        <i class="bi bi-save2 me-2"></i>Enregistrer
                    </button>
                @else
                    <button type="submit" class="btn btn-warning btn-sm px-4 fw-bold shadow-sm">
                        <i class="bi bi-save2 me-2"></i>Mettre à jour
                    </button>
                @endif
            </div>
        </div>

        <div class="card-body p-0">
            @if(!is_null($tableObj) && $tableObj->relations->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="sticky-header">
                        <tr>
                            @foreach($tableObj->relations->unique('column_id') as $relation)
                                <th class="px-4 py-3 text-center">
                                    <div class="x-small text-uppercase fw-bolder text-muted mb-1">{{ $relation->column->title }}</div>
                                    <i class="bi bi-info-circle text-primary opacity-50" data-bs-toggle="tooltip" title="{{ $relation->column->description }}"></i>
                                </th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="bg-light bg-opacity-50">
                            @php $j = 0; @endphp
                            @foreach($tableObj->relations->unique('column_id') as $relation)
                                <td class="px-4 py-4 text-center">
                                    <input type="number"
                                           name="values[]"
                                           class="form-control table-input fw-bold mx-auto"
                                           style="max-width: 120px;"
                                           value="{{ $values[$j]->value ?? '' }}"
                                           placeholder="000" required>
                                    <input type="hidden" name="relations[]" value="{{ $relation->id }}">
                                    @if (!is_null($values))
                                        <input type="hidden" name="ids[]" value="{{ $values[$j]->id ?? '' }}">
                                    @endif
                                </td>
                                @php $j++; @endphp
                            @endforeach
                        </tr>
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="bg-light rounded-circle d-inline-flex p-4 mb-3">
                        <i class="bi bi-clipboard-x fs-1 text-muted opacity-50"></i>
                    </div>
                    <h6 class="fw-bold">Prêt pour la saisie</h6>
                    <p class="text-muted small">Sélectionnez un tableau et un collaborateur pour commencer.</p>
                </div>
            @endif
        </div>
    </div>

    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('employee_selected');
            const list = document.getElementById('employee_list');
            const options = Array.from(list.options).filter(opt => opt.value !== "-1");

            input.addEventListener('input', function() {
                const query = this.value.toLowerCase().trim();
                let firstMatch = null;

                options.forEach(opt => {
                    const name = opt.getAttribute('data-name');
                    const isMatch = name.includes(query);
                    opt.style.display = isMatch ? "block" : "none";
                    if (isMatch && !firstMatch) firstMatch = opt;
                });

                if (firstMatch && query !== "") {
                    list.value = firstMatch.value;
                }
            });

            list.addEventListener('change', function() {
                input.value = this.options[this.selectedIndex].text.trim();
            });
        });
    </script>
</x-layout>
