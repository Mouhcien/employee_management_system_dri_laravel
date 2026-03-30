<x-layout>

    <style>
        :root {
            --saas-primary: #0061f2;
            --saas-secondary: #0a2351;
            --saas-bg-soft: #f8f9fa;
            --saas-border: #e3e6f0;
        }

        .fw-800 { font-weight: 800; }
        .tracking-tight { letter-spacing: -0.02em; }
        .tracking-widest { letter-spacing: 0.1em; }
        .bg-warning-emphasis { background-color: #fff3cd !important; color: #664d03 !important; }

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


        /* Fixed Button Styling */
         .fixed-bottom-left {
             position: fixed;
             left: 25px;
             bottom: 25px;
             z-index: 1050; /* Above all tables */
             transition: transform 0.3s ease;
         }

        .fixed-bottom-left:hover {
            transform: scale(1.1);
        }

        /* Animation for the filter section */
        #filterCollapse.collapsing {
            transition: height 0.35s ease, opacity 0.3s ease;
            opacity: 0;
        }

        #filterCollapse.show {
            opacity: 1;
        }

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
                    <a href="{{ route('audit.values.consult') }}"
                       class="btn btn-light text-primary border shadow-sm rounded-pill px-3 fw-bold d-inline-flex align-items-center"
                       title="Actualiser les données">
                        <i class="bi bi-arrow-clockwise me-2"></i> Actualiser
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="filter-section border-0 shadow-sm position-relative collapse show" id="filterCollapse">

            <button type="button" class="btn-close position-absolute top-0 end-0 m-3"
                    data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-label="Close"></button>

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

        <button class="btn btn-primary rounded-circle shadow-lg d-flex align-items-center justify-content-center fixed-bottom-left"
                id="btnShowFilters"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#filterCollapse"
                style="width: 55px; height: 55px; display: none !important;">
            <i class="bi bi-sliders2 fs-4"></i>
        </button>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                {{-- 1. GROUP BY EMPLOYEE --}}
                @php $i=0; @endphp
                @if (count($values) != 0)
                @foreach($values->groupBy(fn($item) => $item->employee->lastname . ' ' . $item->employee->firstname) as $employeeName => $employeeValues)

                    <div class="px-4 py-4 bg-white border-bottom d-flex align-items-start position-relative" style="border-left: 4px solid var(--saas-primary);">
                        <div class="flex-shrink-0">
                            @if($employeeValues->first()->employee->photo && Storage::disk('public')->exists($employeeValues->first()->employee->photo))
                                <img src="{{ Storage::url($employeeValues->first()->employee->photo) }}" class="rounded-circle border border-3 border-white shadow-sm object-fit-cover avatar-hover" width="65" height="65">
                            @else
                                <div class="rounded-circle shadow-sm d-flex align-items-center justify-content-center text-white"
                                     style="width: 56px; height: 56px; background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);">
                                    <i class="bi bi-person-badge fs-4"></i>
                                </div>
                            @endif
                        </div>

                        <div class="ms-4 flex-grow-1">
                            <div class="d-flex align-items-center mb-2">
                                <h5 class="mb-0 fw-800 text-dark text-uppercase tracking-tight me-3">{{ $employeeName }}</h5>
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1">
                                    <i class="bi bi-check-circle-fill me-1"></i> Actif
                                </span>
                            </div>

                            <div class="d-flex flex-wrap gap-2 align-items-center">
                                @php
                                    $activeAffectation = $employeeValues->first()->employee->affectations->where('state', 1)->first();
                                @endphp

                                @if($activeAffectation)
                                    @if($activeAffectation->section)
                                        <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary fw-bold px-3 py-2">
                                            <i class="bi bi-diagram-3 me-1"></i> {{ $activeAffectation->section->title }}
                                        </span>
                                        <i class="bi bi-chevron-right text-muted opacity-50 small"></i>
                                    @endif

                                    @if($activeAffectation->sector)
                                        <span class="badge rounded-pill bg-info bg-opacity-10 text-info fw-bold px-3 py-2">
                                            <i class="bi bi-layers me-1"></i> {{ $activeAffectation->sector->title }}
                                        </span>
                                        <i class="bi bi-chevron-right text-muted opacity-50 small"></i>
                                    @endif

                                    <span class="badge rounded-pill bg-warning bg-opacity-10 text-warning-emphasis fw-bold px-3 py-2">
                                        <i class="bi bi-building me-1"></i> {{ $activeAffectation->entity->title }}
                                    </span>

                                    <i class="bi bi-chevron-right text-muted opacity-50 small"></i>

                                    <span class="badge rounded-pill bg-secondary bg-opacity-10 text-secondary fw-bold px-3 py-2">
                                        <i class="bi bi-diagram-3-fill me-1"></i> {{ $activeAffectation->service->title }}
                                    </span>
                                @endif
                            </div>

                            <div class="mt-2">
                                <small class="text-muted fw-bold text-uppercase x-small tracking-widest">
                                    <i class="bi bi-clock-history me-1"></i> Historique des performances par période
                                </small>
                            </div>
                        </div>

                        <div class="ms-auto d-none d-lg-block">
                            <div class="text-end">
                                <div class="text-muted x-small fw-bold text-uppercase">Dernière mise à jour</div>
                                <div class="fw-bold text-dark">{{ now()->format('d/m/Y') }}</div>
                            </div>
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

                    @php $i++; @endphp
                @endforeach

                @else
                    <div class="card border-0 shadow-sm my-5 bg-white">
                        <div class="card-body p-5 text-center">
                            <div class="mb-4">
                                <div class="bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 80px; height: 80px;">
                                    <i class="bi bi-people-fill text-warning fs-1"></i>
                                </div>
                            </div>

                            <div class="mx-auto" style="max-width: 450px;">
                                <h5 class="fw-bold text-dark">Prêt à consulter les performances ?</h5>
                                <p class="text-muted mb-4">
                                    Veuillez sélectionner un employé dans le panneau de configuration ci-dessus pour générer l'historique complet de ses indicateurs et comparer ses résultats par période.
                                </p>

                                <div class="d-inline-flex align-items-center text-primary fw-bold small text-uppercase tracking-wider">
                                    <i class="bi bi-arrow-up me-2 pulse-animation"></i>
                                    Utilisez les filtres pour commencer
                                </div>
                            </div>
                        </div>
                    </div>

                    <style>
                        /* Subtle pulse to draw attention to the top filters */
                        @keyframes pulse-y {
                            0%, 100% { transform: translateY(0); }
                            50% { transform: translateY(-5px); }
                        }
                        .pulse-animation {
                            animation: pulse-y 2s infinite ease-in-out;
                        }
                    </style>
                @endif
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


            //Button hide/show filter div
            const filterDiv = document.getElementById('filterCollapse');
            const showBtn = document.getElementById('btnShowFilters');

            // When the filters start to hide, show the floating button
            filterDiv.addEventListener('hide.bs.collapse', function () {
                showBtn.style.setProperty('display', 'flex', 'important');
            });

            // When the filters start to show, hide the floating button
            filterDiv.addEventListener('show.bs.collapse', function () {
                showBtn.style.setProperty('display', 'none', 'important');
            });

        });
    </script>

</x-layout>
