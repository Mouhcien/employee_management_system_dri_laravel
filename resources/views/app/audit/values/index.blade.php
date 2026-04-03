<x-layout>
    @push('styles')
        <style>
            :root {
                --saas-primary: #6366f1;
                --saas-indigo: #4f46e5;
                --saas-slate: #0f172a;
                --saas-cyan: #06b6d4;
                --glass-bg: rgba(255, 255, 255, 0.7);
            }

            body { background-color: #f1f5f9; font-family: 'Inter', system-ui, sans-serif; }

            /* Futurist Mission Header */
            .header-console {
                background: radial-gradient(circle at top right, #4f46e5, #0f172a);
                border-radius: 24px;
                position: relative;
                overflow: hidden;
                border: 1px solid rgba(255, 255, 255, 0.1);
            }

            .pulse-indicator {
                width: 8px; height: 8px; background: #22c55e; border-radius: 50%;
                display: inline-block; box-shadow: 0 0 0 rgba(34, 197, 94, 0.4);
                animation: pulse-green 2s infinite;
            }
            @keyframes pulse-green {
                0% { box-shadow: 0 0 0 0px rgba(34, 197, 94, 0.7); }
                70% { box-shadow: 0 0 0 10px rgba(34, 197, 94, 0); }
                100% { box-shadow: 0 0 0 0px rgba(34, 197, 94, 0); }
            }

            /* Filter Hub - Glass Surface */
            .filter-hub {
                background: var(--glass-bg);
                backdrop-filter: blur(12px);
                border-radius: 20px;
                border: 1px solid rgba(255, 255, 255, 0.5);
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            }

            .ls-caps { letter-spacing: 0.08em; font-size: 0.65rem; text-transform: uppercase; font-weight: 800; color: #6366f1; }

            /* Modern Input Boxes */
            .input-futurist {
                border: 1px solid #e2e8f0; border-radius: 12px; transition: all 0.2s; background: #ffffff;
            }
            .input-futurist:focus { border-color: var(--saas-primary); box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1); }

            /* Search List Styling */
            .search-results-box {
                border-radius: 12px; border: 1px solid #e2e8f0; max-height: 160px; overflow-y: auto;
            }
            .search-results-box select option { padding: 8px 12px; border-bottom: 1px solid #f8fafc; }

            /* Table Entry - Technical View */
            .entry-surface {
                background: white; border-radius: 24px; border: 1px solid #e2e8f0; overflow: hidden;
            }

            .table-technical thead th {
                background: #f8fafc; color: #64748b; font-size: 0.7rem; letter-spacing: 0.05em;
                text-transform: uppercase; padding: 1.25rem; border-bottom: 2px solid #eef2ff;
            }

            .value-input-glow {
                border-radius: 10px; border: 2px solid #f1f5f9; text-align: center;
                transition: all 0.3s; font-weight: 800; color: #1e293b;
            }
            .value-input-glow:focus {
                border-color: var(--saas-cyan); background: #f0fdff; outline: none;
                transform: scale(1.05); box-shadow: 0 10px 15px -5px rgba(6, 182, 212, 0.2);
            }

            .btn-spectrum-primary {
                background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
                color: white; border: none; box-shadow: 0 4px 14px rgba(99, 102, 241, 0.4);
            }
            .btn-spectrum-success {
                background: linear-gradient(135deg, #22c55e 0%, #10b981 100%);
                color: white; border: none; box-shadow: 0 4px 14px rgba(34, 197, 94, 0.4);
            }
        </style>
    @endpush

    {{-- Console Header --}}
    <div class="card header-console border-0 shadow-lg mb-4 text-white">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-8 d-flex align-items-center">
                    <div class="bg-white bg-opacity-10 p-3 rounded-4 me-4 border border-white border-opacity-10">
                        <i class="bi bi-cpu-fill fs-2 text-info"></i>
                    </div>
                    <div>
                        <span class="ls-caps text-info opacity-75">Système d'Audit v3.0</span>
                        <h3 class="fw-bold mb-0">Console d'Évaluation <span class="text-info">Performance</span></h3>
                    </div>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="d-inline-flex align-items-center bg-black bg-opacity-20 px-4 py-2 rounded-pill border border-white border-opacity-10">
                        <span class="pulse-indicator me-3"></span>
                        <span class="small fw-bold ls-caps mb-0 text-white">Transmission Active</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ is_null($values) ? route('audit.values.store') : route('audit.values.update') }}" method="POST">
        @csrf

        {{-- Filtering Hub --}}
        <div class="filter-hub p-4 mb-4 shadow-sm">
            <div class="row g-4 align-items-start">
                {{-- Config --}}
                <div class="col-xl-3 border-end">
                    <label class="ls-caps mb-3"><i class="bi bi-gear-fill me-2"></i>Configuration</label>
                    <select class="form-select input-futurist mb-3 fw-bold" id="sl_table_performance" name="table_id" required>
                        <option value="" selected disabled>Choisir le Tableau...</option>
                        @foreach($tables as $table)
                            <option value="{{ $table->id }}" {{ !is_null($selected_table) && $table->id == $selected_table ? 'selected': '' }}>{{ $table->title }}</option>
                        @endforeach
                    </select>
                    <select class="form-select input-futurist fw-bold" name="period_id" required>
                        <option value="" selected disabled>Choisir la Période...</option>
                        @foreach($periods as $period)
                            <option value="{{ $period->id }}" {{ !is_null($selected_period) && $selected_period == $period->period_id ? 'selected' : '' }}>{{ $period->title }} {{$period->year}}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Employee Search --}}
                <div class="col-xl-6 border-end">
                    <label class="ls-caps mb-3"><i class="bi bi-person-bounding-box me-2"></i>Identification Collaborateur</label>
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-white border-end-0 rounded-start-3"><i class="bi bi-search text-primary"></i></span>
                        <input type="text" id="employee_selected" class="form-control input-futurist rounded-start-0" placeholder="Scanner un nom ou un matricule...">
                    </div>
                    <div class="search-results-box bg-white shadow-inner">
                        <select id="employee_list" class="form-select border-0 x-small" size="6" name="employee_id" required>
                            <option value="-1" disabled selected class="text-muted italic">En attente d'entrée clavier...</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" data-name="{{ strtolower($employee->firstname . ' ' . $employee->lastname) }}"
                                    {{ (!is_null($values) && $values[0]->employee_id == $employee->id) ? 'selected' : '' }}>
                                    {{ strtoupper($employee->lastname) }} {{ $employee->firstname }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Structure: Restored & Professionalized --}}
                <div class="col-xl-3 d-flex flex-column gap-2">
                    <label class="ls-caps mb-2"><i class="bi bi-diagram-3-fill me-2"></i>Unités Structurelles</label>

                    {{-- Service Select (Always Visible) --}}
                    <select class="form-select input-futurist py-2 fw-medium shadow-xs" id="sl_audit_service">
                        <option value="-1" {{ is_null($selected_service) ? 'selected' : '' }}>Sélectionnez le service</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ $selected_service == $service->id ? 'selected' : '' }}>
                                {{ $service->title }}
                            </option>
                        @endforeach
                    </select>

                    {{-- Entity Select (Conditional) --}}
                    @if (count($entities) != 0)
                        <select class="form-select input-futurist py-2 fw-medium shadow-xs" id="sl_audit_entity">
                            <option value="-1">Sélectionnez l'entité</option>
                            @foreach($entities as $entity)
                                <option value="{{ $entity->id }}" {{ $selected_entity == $entity->id ? 'selected' : '' }}>
                                    {{ $entity->title }}
                                </option>
                            @endforeach
                        </select>
                    @endif

                    {{-- Sector Select (Conditional) --}}
                    @if (count($sectors) != 0)
                        <select class="form-select input-futurist py-2 fw-medium shadow-xs" id="sl_audit_sector">
                            <option value="-1">Sélectionnez le secteur</option>
                            @foreach($sectors as $sector)
                                <option value="{{ $sector->id }}" {{ $selected_sector == $service->id ? 'selected' : '' }}>
                                    {{ $sector->title }}
                                </option>
                            @endforeach
                        </select>
                    @endif

                    {{-- Section Select (Conditional) --}}
                    @if (count($sections) != 0)
                        <select class="form-select input-futurist py-2 fw-medium shadow-xs" id="sl_audit_section">
                            <option value="-1">Sélectionnez la section</option>
                            @foreach($sections as $section)
                                <option value="{{ $section->id }}" {{ $selected_section == $section->id ? 'selected' : '' }}>
                                    {{ $section->title }}
                                </option>
                            @endforeach
                        </select>
                    @endif

                    {{-- Logic for Export Params --}}
                    @php
                        $params = [
                            'srv' => $selected_service ?? 0,
                            'ent' => $selected_entity ?? 0,
                            'sectr' => $selected_sector ?? 0,
                            'sect' => $selected_section ?? 0
                        ];
                        if (!is_null($selected_table)) $params['tbl'] = $selected_table;
                    @endphp

                    <a href="{{ route('audit.values.download.model', $params) }}" class="btn btn-outline-primary btn-sm fw-bold py-2 mt-3 rounded-3 border-2">
                        <i class="bi bi-file-earmark-arrow-down-fill me-2"></i>Modèle Excel (.xlsx)
                    </a>
                </div>
            </div>
        </div>

        {{-- Entry Surface --}}
        <div class="entry-surface shadow-lg">
            <div class="card-header bg-white py-4 px-4 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="bg-indigo-soft p-2 rounded-3 me-3"><i class="bi bi-pencil-square text-primary fs-5"></i></div>
                    <h5 class="mb-0 fw-bold text-dark">Matrice des Indicateurs</h5>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-light border btn-sm px-4 fw-bold text-muted rounded-pill" id="btn_import_values">
                        <i class="bi bi-cloud-upload me-2"></i>Import
                    </button>
                    @if (is_null($values))
                        <button type="submit" class="btn btn-spectrum-success px-5 fw-bold rounded-pill">
                            <i class="bi bi-save2 me-2"></i>Soumettre
                        </button>
                    @else
                        <button type="submit" class="btn btn-spectrum-primary px-5 fw-bold rounded-pill text-white">
                            <i class="bi bi-arrow-repeat me-2"></i>Synchroniser
                        </button>
                    @endif
                </div>
            </div>

            <div class="card-body p-0">
                @if(!is_null($tableObj) && $tableObj->relations->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-technical align-middle mb-0">
                            <thead>
                            <tr>
                                @foreach($tableObj->relations->unique('column_id') as $relation)
                                    <th class="text-center">
                                        <div class="mb-1">{{ $relation->column->title }}</div>
                                        <i class="bi bi-info-circle-fill text-info opacity-50" data-bs-toggle="tooltip" title="{{ $relation->column->description }}"></i>
                                    </th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="bg-light bg-opacity-25">
                                @php $j = 0; @endphp
                                @foreach($tableObj->relations->unique('column_id') as $relation)
                                    <td class="px-4 py-5 text-center">
                                        <div class="d-flex flex-column align-items-center">
                                            <input type="number" name="values[]"
                                                   class="form-control value-input-glow p-3 fs-5"
                                                   style="max-width: 140px;"
                                                   value="{{ $values[$j]->value ?? '' }}"
                                                   placeholder="0.00" required>
                                            <input type="hidden" name="relations[]" value="{{ $relation->id }}">
                                            @if (!is_null($values))
                                                <input type="hidden" name="ids[]" value="{{ $values[$j]->id ?? '' }}">
                                            @endif
                                            <small class="ls-caps mt-3 text-muted">Valeur KPI</small>
                                        </div>
                                    </td>
                                    @php $j++; @endphp
                                @endforeach
                            </tr>
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="bg-light rounded-circle d-inline-flex p-4 mb-4 border shadow-sm">
                            <i class="bi bi-hdd-network-fill fs-1 text-primary opacity-25"></i>
                        </div>
                        <h5 class="fw-bold text-dark">Canal d'Évaluation Prêt</h5>
                        <p class="text-muted small px-5">Veuillez configurer les paramètres de session ci-dessus pour charger la structure de données.</p>
                    </div>
                @endif
            </div>
        </div>
    </form>

    <x-import-values-modal :periods="$periods" :table="$tableObj ?? null" />

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
                if(this.selectedIndex >= 0) {
                    input.value = this.options[this.selectedIndex].text.trim();
                }
            });

            // Tooltip Init
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            tooltipTriggerList.map(t => new bootstrap.Tooltip(t))
        });
    </script>
</x-layout>
