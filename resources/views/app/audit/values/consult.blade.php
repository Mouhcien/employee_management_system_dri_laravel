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
                                <option value="{{ $period->id }}" {{ $selected_period == $period->id ? 'selected' : '' }}>{{ $period->title }} {{$period->year}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6 border-end">
                    <label class="form-label-sm">Recherche Employé(e)</label>
                    <div class="input-group input-group-sm mb-0">
                        <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                        <input type="text" id="employee_selected_consult" class="form-control border-0 bg-light" placeholder="Entrez un nom ou service...">
                    </div>
                    <div class="search-results-box bg-white">
                        <select id="employee_list_consult" class="form-select border-0 x-small" size="8" name="employee_id">
                            <option value="-1" disabled selected>En attente de saisie...</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" data-name="{{ strtolower($employee->firstname . ' ' . $employee->lastname) }}" {{ $selected_employee == $employee->id ? 'selected' : '' }}>
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
                {{-- 1. GROUP BY EMPLOYEE --}}
                @foreach($values->groupBy(fn($item) => $item->employee->lastname . ' ' . $item->employee->firstname) as $employeeName => $employeeValues)

                    <div class="px-4 py-3 bg-secondary bg-opacity-10 border-bottom d-flex align-items-center">
                        <div class="bg-white p-2 rounded-circle shadow-sm me-3">
                            <i class="bi bi-person-badge text-primary fs-5"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-dark text-uppercase">{{ $employeeName }}</h5>
                            <small class="text-muted small">Historique des performances</small>
                        </div>
                    </div>

                    {{-- 2. GROUP BY PERIOD AND SORT DESCENDING --}}
                    @foreach($employeeValues->groupBy('period.title')->sortByDesc(fn($group, $key) => $key) as $periodTitle => $valuesInPeriod)
                        <div class="px-4 py-2 bg-light border-bottom">
                    <span class="fw-bold small text-primary">
                        <i class="bi bi-calendar3 me-2"></i> Période : {{ $periodTitle }} {{ $valuesInPeriod->first()->period->year }}
                    </span>
                        </div>

                        <div class="p-4">
                            {{-- 3. GROUP BY TABLE TITLE --}}
                            @foreach($valuesInPeriod->groupBy(fn($item0) => $item0->relation->table->title) as $tableTitle => $tableEntries)
                                <div class="card border shadow-sm mb-4">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead class="bg-white">
                                            <tr>
                                                <th class="px-4 py-3 text-muted fw-bold border-0" style="width: 200px;">
                                                    <span class="badge bg-primary px-3 text-uppercase">{{ $tableTitle }}</span>
                                                </th>
                                                @foreach($tableEntries as $entry)
                                                    <th class="px-4 py-3 text-center border-0 text-uppercase x-small text-secondary">
                                                        {{ $entry->relation->column->title }}
                                                    </th>
                                                @endforeach
                                                <th class="px-4 py-3 text-end border-0"></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td class="px-4 py-3 border-0 small text-muted fst-italic">
                                                    Valeurs saisies
                                                </td>
                                                @foreach($tableEntries as $entry)
                                                    <td class="px-4 py-3 text-center border-0">
                                                        <div class="d-flex align-items-center justify-content-center">
                                                            <input type="number"
                                                                   class="form-control form-control-sm fw-bold text-center border-0 bg-light"
                                                                   style="max-width: 80px; border-radius: 6px;"
                                                                   value="{{ $entry->value }}" disabled>

                                                            {{-- COMPARISON LOGIC --}}
                                                            @php
                                                                // Get period keys for this employee, sorted DESC
                                                                $employeePeriodKeys = $employeeValues->groupBy('period.title')
                                                                    ->sortByDesc(fn($group, $key) => $key)
                                                                    ->keys()
                                                                    ->toArray();

                                                                $currentIndex = array_search($periodTitle, $employeePeriodKeys);

                                                                // Since it's DESC, the "Previous" period is the NEXT index (+1)
                                                                $prevPeriodTitle = $employeePeriodKeys[$currentIndex + 1] ?? null;

                                                                $trend = null;
                                                                if ($prevPeriodTitle) {
                                                                    $prevValue = $employeeValues->where('period.title', $prevPeriodTitle)
                                                                        ->where('relation_id', $entry->relation_id)
                                                                        ->first()?->value;

                                                                    if ($prevValue !== null) {
                                                                        if ($entry->value > $prevValue) $trend = 'up';
                                                                        elseif ($entry->value < $prevValue) $trend = 'down';
                                                                    }
                                                                }
                                                            @endphp

                                                            <span class="ms-2">
                                                        @if($trend === 'up')
                                                                    <i class="bi bi-caret-up-fill text-success" title="Supérieur à {{ $prevPeriodTitle }}"></i>
                                                                @elseif($trend === 'down')
                                                                    <i class="bi bi-caret-down-fill text-danger" title="Inférieur à {{ $prevPeriodTitle }}"></i>
                                                                @else
                                                                    <i class="bi bi-dash text-muted opacity-50"></i>
                                                                @endif
                                                    </span>
                                                        </div>
                                                    </td>
                                                @endforeach

                                                <td class="px-4 py-3 text-end border-0">
                                                    <div class="btn-group shadow-sm">
                                                        <a href="{{ route('audit.values.edit', $entry->relation_id) }}" class="btn btn-sm btn-white border text-warning"><i class="bi bi-pencil-square"></i></a>
                                                        <a href="{{ route('audit.values.delete', $entry->relation_id) }}" class="btn btn-sm btn-white border text-danger"><i class="bi bi-trash"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach

                    <div class="py-2 bg-white"></div> {{-- Spacer --}}
                @endforeach
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('employee_selected_consult');
            const list = document.getElementById('employee_list_consult');

            // 1. Create a master "Source of Truth" array from the initial HTML
            const masterOptions = Array.from(list.options)
                .filter(opt => opt.value !== "-1")
                .map(opt => ({
                    value: opt.value,
                    text: opt.text,
                    searchName: opt.getAttribute('data-name') || opt.text.toLowerCase()
                }));

            input.addEventListener('input', function() {
                const query = this.value.toLowerCase().trim();

                // 2. Clear the current list (except the first "Wait" option)
                list.innerHTML = '';

                // 3. Filter the master list
                const filtered = masterOptions.filter(item => item.searchName.includes(query));

                if (filtered.length > 0) {
                    // 4. Re-inject matching options
                    filtered.forEach(item => {
                        const newOpt = new Option(item.text, item.value);
                        list.add(newOpt);
                    });

                    // 5. Auto-select the first match if searching
                    if (query !== "") {
                        list.selectedIndex = 0;
                    }
                } else {
                    // 6. Handle "No results" case
                    const noRes = new Option("Aucun résultat trouvé...", "-1");
                    noRes.disabled = true;
                    list.add(noRes);
                }
            });

            // Sync input text when list is clicked
            list.addEventListener('change', function() {
                if (this.selectedIndex !== -1 && this.value !== "-1") {
                    input.value = this.options[this.selectedIndex].text.trim();
                }
            });

        });
    </script>

</x-layout>
