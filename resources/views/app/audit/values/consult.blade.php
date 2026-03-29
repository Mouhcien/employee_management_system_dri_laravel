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
                            <h4 class="fw-bold mb-0">Tableaux d'Évaluation</h4>
                            <p class="mb-0 text-white-50 small text-uppercase tracking-wider">Consulter des indicateurs de performance</p>
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

    <div>
        <div class="filter-section border-0 shadow-sm">
            <div class="row g-4 align-items-start">
                <div class="col-md-3 border-end">
                    <label class="form-label-sm">Configuration de base</label>
                    <div class="mb-2">
                        <select class="form-select form-select-sm border-0 bg-light" id="sl_consult_table_performance" name="table_id">
                            <option value="-1">Sélectionner le Tableau de suivi</option>
                            @foreach($tables as $table)
                                <option value="{{ $table->id }}" {{ $table->id == $selected_table ? 'selected': '' }}>{{ $table->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <select class="form-select form-select-sm border-0 bg-light" name="period_id" id="sl_consult_period">
                            <option value="-1">Sélectionner la période de suivi</option>
                            @foreach($periods as $period)
                                <option value="{{ $period->id }}" {{ $selected_period == $period->id ? 'selected' : '' }}>{{ $period->title }}</option>
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
                        <select id="employee_list" class="form-select border-0 x-small" size="8" name="employee_id">
                            <option value="-1" disabled selected>En attente de saisie...</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" data-name="{{ strtolower($employee->firstname . ' ' . $employee->lastname) }}">
                                    {{ strtoupper($employee->lastname) }} {{ $employee->firstname }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-3 d-grid">
                    <label class="form-label-sm">Untité Structurelle</label>
                    <select class="form-control mb-2" id="sl_consult_audit_service">
                        <option value="-1"> Séléctionnez le service</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ $selected_service == $service->id ? 'selected' : '' }}>{{ $service->title }}</option>
                        @endforeach
                    </select>

                    @if (count($entities) != 0)
                        <select class="form-control mb-2" id="sl_consult_audit_entity">
                            <option value="-1"> Séléctionnez l'entité</option>
                            @foreach($entities as $entity)
                                <option value="{{ $entity->id }}" {{ $selected_entity == $entity->id ? 'selected' : '' }}>{{ $entity->title }}</option>
                            @endforeach
                        </select>
                    @endif

                    @if (count($sectors) != 0)
                        <select class="form-control mb-2" id="sl_consult_audit_sector">
                            <option value="-1"> Séléctionnez le secteur</option>
                            @foreach($sectors as $sector)
                                <option value="{{ $sector->id }}" {{ $selected_sector == $sector->id ? 'selected' : '' }}>{{ $sector->title }}</option>
                            @endforeach
                        </select>
                    @endif

                    @if (count($sections) != 0)
                        <select class="form-control mb-2" id="sl_consult_audit_section">
                            <option value="-1"> Séléctionnez la section</option>
                            @foreach($sections as $section)
                                <option value="{{ $section->id }}" {{ $selected_section == $section->id ? 'selected' : '' }}>{{ $section->title }}</option>
                            @endforeach
                        </select>
                    @endif

                    <button type="button" class="btn btn-primary fw-bold py-2 shadow-sm mt-2">
                        <i class="bi bi-download me-2"></i>Téléchaarger le fichier
                    </button>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">

                @foreach($values->groupBy('period.title') as $periodTitle => $valuesInPeriod)
                    <div class="bg-primary bg-opacity-10 px-4 py-2 fw-bold text-primary border-bottom">
                        <i class="bi bi-calendar3 me-2"></i> Période : {{ $periodTitle }}
                    </div>

                    @foreach($valuesInPeriod->groupBy(fn($item) => $item->employee->lastname . ' ' . $item->employee->firstname) as $employeeName => $employeeEntries)
                        <div class="px-4 py-2 bg-light border-bottom d-flex align-items-center">
                            <i class="bi bi-person-fill me-2 text-muted"></i>
                            <span class="fw-bold small text-uppercase">{{ $employeeName }}</span>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-sm table-hover align-middle mb-4">
                                <thead></thead>
                                <tbody>
                                <tr>
                                    @foreach($employeeEntries as $entry)
                                        <td class="px-4 py-3 text-center border-0">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <input type="number"
                                                       class="form-control form-control-sm fw-bold text-center ajax-save-input"
                                                       style="max-width: 90px;"
                                                       data-id="{{ $entry->id }}"
                                                       value="{{ $entry->value }}" disabled>

                                                {{-- COMPARISON LOGIC --}}
                                                @php
                                                    // 1. Find the previous period key (relative to current period loop)
                                                    $periodKeys = $values->groupBy('period.title')->keys()->toArray();
                                                    $currentIndex = array_search($periodTitle, $periodKeys);
                                                    $prevPeriodTitle = $periodKeys[$currentIndex + 1] ?? null; // +1 because usually newest is first

                                                    $trend = null;
                                                    if ($prevPeriodTitle) {
                                                        // 2. Find the value for the same employee/column in that previous period
                                                        $prevValue = $values->where('period.title', $prevPeriodTitle)
                                                            ->where('employee_id', $entry->employee_id)
                                                            ->where('relation_id', $entry->relation_id) // Match the specific metric/column
                                                            ->first()?->value;

                                                        if ($prevValue !== null) {
                                                            if ($entry->value > $prevValue) $trend = 'up';
                                                            elseif ($entry->value < $prevValue) $trend = 'down';
                                                        }
                                                    }
                                                @endphp

                                                {{-- TREND ARROW --}}
                                                <span class="ms-2">
                                                    @if($trend === 'up')
                                                        <i class="bi bi-arrow-up-right-circle-fill text-success" title="Higher than previous period"></i>
                                                    @elseif($trend === 'down')
                                                        <i class="bi bi-arrow-down-right-circle-fill text-danger" title="Lower than previous period"></i>
                                                    @else
                                                        <i class="bi bi-dash-circle text-muted opacity-25"></i>
                                                    @endif
                                                </span>
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>

    </div>


</x-layout>
