<x-layout>
    <style>
        :root {
            --saas-primary: #6366f1;
            --saas-indigo: #4f46e5;
            --saas-slate: #0f172a;
            --glass-bg: rgba(255, 255, 255, 0.7);
        }

        body { background-color: #f1f5f9; font-family: 'Inter', sans-serif; }

        /* Futurist Hero Header */
        .header-vibrant {
            background: radial-gradient(circle at top right, #4f46e5, #0f172a);
            border-radius: 24px;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Glassmorphism Filter Hub */
        .filter-hub {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        }

        .ls-caps { letter-spacing: 0.08em; font-size: 0.65rem; text-transform: uppercase; font-weight: 800; color: #6366f1; }

        /* Employee Card - Premium Profile */
        .employee-header-surface {
            background: white;
            border-radius: 20px 20px 0 0;
            border: 1px solid #e2e8f0;
            border-left: 6px solid var(--saas-primary);
            transition: all 0.3s;
        }

        /* Trend Indicators with Glowing Accents */
        .trend-badge {
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
        }
        .trend-up { background: #ecfdf5; color: #059669; border: 1px solid #d1fae5; box-shadow: 0 0 10px rgba(16, 185, 129, 0.2); }
        .trend-down { background: #fff1f2; color: #e11d48; border: 1px solid #ffe4e6; box-shadow: 0 0 10px rgba(225, 29, 72, 0.2); }

        /* Technical Table Layout */
        .table-technical thead th {
            background: #f8fafc;
            color: #64748b;
            font-size: 0.65rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            padding: 1.25rem;
            border-bottom: 2px solid #eef2ff;
        }

        .input-readonly-data {
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            font-weight: 800;
            color: #1e293b;
            border-radius: 8px;
        }

        /* Floating Filter Trigger */
        .fixed-bottom-left {
            position: fixed;
            left: 30px;
            bottom: 30px;
            z-index: 1050;
            background: var(--saas-indigo);
            color: white;
            border: none;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .fixed-bottom-left:hover { transform: scale(1.15) rotate(5deg); box-shadow: 0 10px 20px rgba(79, 70, 229, 0.4); }
    </style>

    {{-- Vibrant Header --}}
    <div class="card header-vibrant border-0 shadow-lg mb-4 text-white">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-8 d-flex align-items-center">
                    <div class="bg-white bg-opacity-10 p-3 rounded-4 me-4 border border-white border-opacity-10">
                        <i class="bi bi-graph-up-arrow fs-2 text-info"></i>
                    </div>
                    <div>
                        <span class="ls-caps text-info opacity-75">Analytics Engine v3.0</span>
                        <h3 class="fw-bold mb-0">Consultation & <span class="text-info">Tendances</span></h3>
                    </div>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="{{ route('audit.values.consult') }}" class="btn btn-outline-info rounded-pill px-4 fw-bold border-2">
                        <i class="bi bi-arrow-clockwise me-2"></i> Actualiser les Flux
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Section --}}
    <div class="filter-hub p-4 mb-5 shadow-sm collapse show position-relative" id="filterCollapse">
        <button type="button" class="btn-close position-absolute top-0 end-0 m-3 shadow-none" data-bs-toggle="collapse" data-bs-target="#filterCollapse"></button>

        <div class="row g-4 align-items-start">
            <div class="col-md-3 border-end">
                <label class="ls-caps mb-3">Configuration Source</label>
                <select class="form-select border-0 bg-light mb-2 fw-bold" id="sl_consult_table_performance">
                    <option value="-1">Sélectionner le Tableau...</option>
                    @foreach($tables as $table)
                        <option value="{{ $table->id }}" {{ $table->id == $selected_table ? 'selected': '' }}>{{ $table->title }}</option>
                    @endforeach
                </select>
                <select class="form-select border-0 bg-light fw-bold" id="sl_consult_period">
                    <option value="-1">Sélectionner la Période...</option>
                    @foreach($periods as $period)
                        <option value="{{ $period->id }}" {{ $selected_period == $period->id ? 'selected' : '' }}>{{ $period->title }} {{$period->year}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 border-end">
                <label class="ls-caps mb-3">Index des Collaborateurs</label>
                <div class="input-group mb-2 shadow-sm rounded-3 overflow-hidden">
                    <span class="input-group-text bg-white border-0"><i class="bi bi-search text-primary"></i></span>
                    <input type="text" id="employee_selected_consult" class="form-control border-0" placeholder="Scanner un nom ou service...">
                </div>
                <div class="search-results-box bg-white">
                    <select id="employee_list_consult" class="form-select border-0 x-small" size="6">
                        <option value="-1" disabled selected>Initialisation du système...</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" data-name="{{ strtolower($employee->firstname . ' ' . $employee->lastname) }}" {{ $selected_employee == $employee->id ? 'selected' : '' }}>
                                {{ strtoupper($employee->lastname) }} {{ $employee->firstname }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-3 d-flex flex-column gap-2">
                <label class="ls-caps mb-2">Unité Structurelle</label>
                <select class="form-select bg-light border-0 py-1" id="sl_consult_audit_service">
                    <option value="-1">Service...</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" {{ $selected_service == $service->id ? 'selected' : '' }}>{{ $service->title }}</option>
                    @endforeach
                </select>

                @if (count($entities) != 0)
                    <select class="form-select bg-light border-0 py-1" id="sl_consult_audit_entity">
                        <option value="-1">Entité...</option>
                        @foreach($entities as $entity)
                            <option value="{{ $entity->id }}" {{ $selected_entity == $entity->id ? 'selected' : '' }}>{{ $entity->title }}</option>
                        @endforeach
                    </select>
                @endif

                {{-- RESTORED: Other Select Logic remains same --}}
                @if (count($sectors) != 0)
                    <select class="form-select bg-light border-0 py-1" id="sl_consult_audit_sector">
                        <option value="-1">Secteur...</option>
                        @foreach($sectors as $sector)
                            <option value="{{ $sector->id }}" {{ $selected_sector == $sector->id ? 'selected' : '' }}>{{ $sector->title }}</option>
                        @endforeach
                    </select>
                @endif

                <button type="button" class="btn btn-primary bg-indigo-soft text-primary border-0 fw-bold py-2 mt-2 rounded-3">
                    <i class="bi bi-cloud-download-fill me-2"></i>Exporter Rapport
                </button>
            </div>
        </div>
    </div>

    {{-- Floating Trigger --}}
    <button class="btn fixed-bottom-left rounded-circle shadow-lg d-flex align-items-center justify-content-center"
            id="btnShowFilters" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse"
            style="width: 60px; height: 60px; display: none !important;">
        <i class="bi bi-sliders2 fs-4"></i>
    </button>

    {{-- Main Results View --}}
    <div class="results-surface">
        @if (count($values) != 0)
            @foreach($values->groupBy(fn($item) => $item->employee?->lastname . ' ' . $item->employee?->firstname) as $employeeName => $employeeValues)
                <div class="employee-header-surface px-4 py-4 mb-0 d-flex align-items-center shadow-sm">
                    <div class="flex-shrink-0 position-relative">
                        @if($employeeValues->first()->employee?->photo && Storage::disk('public')->exists($employeeValues->first()->employee?->photo))
                            <img src="{{ Storage::url($employeeValues->first()->employee?->photo) }}" class="rounded-circle border border-4 border-white shadow-sm object-fit-cover" width="75" height="75">
                        @else
                            <div class="rounded-circle shadow-sm d-flex align-items-center justify-content-center text-white"
                                 style="width: 75px; height: 75px; background: linear-gradient(135deg, #4f46e5 0%, #0f172a 100%);">
                                <i class="bi bi-person-badge fs-2"></i>
                            </div>
                        @endif
                        <span class="position-absolute bottom-0 end-0 bg-success border border-2 border-white rounded-circle p-2"></span>
                    </div>

                    <div class="ms-4 flex-grow-1">
                        <div class="d-flex align-items-center mb-1">
                            <h4 class="mb-0 fw-bold text-dark text-uppercase me-3">{{ $employeeName }}</h4>
                            <span class="ls-caps text-muted opacity-75">ID-{{ $employeeValues->first()->employee?->id }}</span>
                        </div>
                        <div class="d-flex gap-3">
                            <small class="ls-caps text-primary fw-bold"><i class="bi bi-diagram-2 me-1"></i> Performance Insight</small>
                            <small class="ls-caps text-muted"><i class="bi bi-clock-history me-1"></i> Analyse Multi-Périodes</small>
                        </div>
                    </div>
                </div>

                @foreach($employeeValues->groupBy(fn($item) => $item->relation->table->title) as $tableTitle => $tableEntries)
                    <div class="px-4 py-3 bg-indigo-soft text-primary ls-caps border-start border-end border-white">
                        <i class="bi bi-table me-2"></i> Dimension : {{ $tableTitle }}
                    </div>

                    <div class="bg-white border p-4 mb-4 rounded-bottom-4 shadow-sm">
                        @php
                            $periodsInTable = $tableEntries->groupBy('period_id')->sortByDesc(fn($group) => $group->first()->period->year);
                            $periodKeys = $periodsInTable->keys()->toArray();
                        @endphp

                        @foreach($periodsInTable as $periodId => $valuesInPeriod)
                            @php $currentPeriod = $valuesInPeriod->first()->period; @endphp
                            <div class="card border-light shadow-xs mb-4 overflow-hidden rounded-3">
                                <div class="table-responsive">
                                    <table class="table table-technical align-middle mb-0">
                                        <thead>
                                        <tr>
                                            <th class="ps-4" style="width: 220px;">
                                                    <span class="badge bg-dark px-3 py-2 text-uppercase rounded-2">
                                                        {{ $currentPeriod->title }} {{ $currentPeriod->year }}
                                                    </span>
                                            </th>
                                            @foreach($valuesInPeriod as $entry)
                                                <th class="text-center">{{ $entry->relation->column->title }}</th>
                                            @endforeach
                                            <th class="text-end pe-4">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="bg-light bg-opacity-25">
                                            <td class="ps-4 py-3 small text-muted fw-medium italic"><i class="bi bi-activity me-2"></i>Métriques</td>
                                            @php $attr = ""; @endphp
                                            @foreach($valuesInPeriod as $entry)
                                                <td class="text-center">
                                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                                        <div class="input-readonly-data px-3 py-2">{{ $entry->value }}</div>

                                                        @php
                                                            $currentIndex = array_search($periodId, $periodKeys);
                                                            $prevPeriodId = $periodKeys[$currentIndex + 1] ?? null;
                                                            $trend = null;
                                                            if ($prevPeriodId) {
                                                                $prevEntry = $tableEntries->where('period_id', $prevPeriodId)->where('relation_id', $entry->relation_id)->first();
                                                                if ($prevEntry) {
                                                                    if ($entry->value > $prevEntry->value) $trend = 'up';
                                                                    elseif ($entry->value < $prevEntry->value) $trend = 'down';
                                                                }
                                                            }
                                                        @endphp

                                                        @if($trend === 'up')
                                                            <span class="trend-badge trend-up"><i class="bi bi-graph-up"></i></span>
                                                        @elseif($trend === 'down')
                                                            <span class="trend-badge trend-down"><i class="bi bi-graph-down"></i></span>
                                                        @endif
                                                    </div>
                                                </td>
                                                @php $attr .= $entry->id."-" @endphp
                                            @endforeach
                                            <td class="text-end pe-4">
                                                <div class="btn-group rounded-3 overflow-hidden shadow-xs">
                                                    <a href="{{ route('audit.values.edit', ['id' => $valuesInPeriod->first()->relation_id, 'attr' => $attr]) }}" class="btn btn-white border px-2 text-warning"><i class="bi bi-pencil-square"></i></a>
                                                    <button class="btn btn-white border px-2 text-danger" data-bs-toggle="modal" data-bs-target="#deleteValueElementModal-{{ $valuesInPeriod->first()->id }}"><i class="bi bi-trash3"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <x-delete-model href="{{ route('audit.values.delete', ['attr' => $attr]) }}" message="Attention : Suppression irréversible." title="Confirmer" target="deleteValueElementModal-{{ $valuesInPeriod->first()->id }}" />
                        @endforeach
                    </div>
                @endforeach
            @endforeach
        @endif
    </div>

    {{-- Restored JS logic exactly as requested --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('employee_selected_consult');
            const list = document.getElementById('employee_list_consult');
            const masterOptions = Array.from(list.options).filter(opt => opt.value !== "-1").map(opt => ({
                value: opt.value, text: opt.text, searchName: opt.getAttribute('data-name') || opt.text.toLowerCase()
            }));

            input.addEventListener('input', function() {
                const query = this.value.toLowerCase().trim();
                list.innerHTML = '';
                const filtered = masterOptions.filter(item => item.searchName.includes(query));
                if (filtered.length > 0) {
                    filtered.forEach(item => { list.add(new Option(item.text, item.value)); });
                    if (query !== "") list.selectedIndex = 0;
                } else {
                    const noRes = new Option("Aucun résultat trouvé...", "-1");
                    noRes.disabled = true;
                    list.add(noRes);
                }
            });

            list.addEventListener('change', function() {
                if (this.selectedIndex !== -1 && this.value !== "-1") {
                    input.value = this.options[this.selectedIndex].text.trim();
                }
            });

            const filterDiv = document.getElementById('filterCollapse');
            const showBtn = document.getElementById('btnShowFilters');
            filterDiv.addEventListener('hide.bs.collapse', () => showBtn.style.setProperty('display', 'flex', 'important'));
            filterDiv.addEventListener('show.bs.collapse', () => showBtn.style.setProperty('display', 'none', 'important'));
        });
    </script>
</x-layout>
