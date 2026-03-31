@vite(['resources/css/app.css', 'resources/css/toastr.min.css'])


<div class="row col-12 p-5">
    <div class="col-5 bg-white rounded-4 shadow-sm border overflow-hidden">
        <div class="p-4 border-bottom bg-light-subtle">
            <div class="row align-items-center g-4">
                <div class="col-md-auto text-center">
                    <div class="position-relative d-inline-block">
                        @if($employee->photo && Storage::disk('public')->exists($employee->photo))
                            <img src="{{ Storage::url($employee->photo) }}"
                                 class="rounded-4 border border-4 border-white shadow-sm object-fit-cover"
                                 width="300" height="300">
                        @else
                            <div class="rounded-4 border border-4 border-white shadow-sm d-flex align-items-center justify-content-center text-white fw-bold"
                                 style="width:200px; height:200px; background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); font-size: 3.5rem;">
                                {{ strtoupper(substr($employee->firstname, 0, 1)) }}{{ strtoupper(substr($employee->lastname, 0, 1)) }}
                            </div>
                        @endif
                        <span class="position-absolute bottom-0 end-0 p-2 m-2 border border-3 border-white rounded-circle shadow-sm {{ $employee->gender === 'F' ? 'bg-danger' : 'bg-primary' }}"
                              title="{{ $employee->gender === 'F' ? 'Féminin' : 'Masculin' }}"
                              style="transform: translate(10%, 10%);">
                        <i class="bi bi-gender-{{ $employee->gender === 'F' ? 'female' : 'male' }} text-white fs-5"></i>
                    </span>
                    </div>
                </div>

                <div class="col-md ps-md-4">
                    <div class="d-flex flex-column h-100 justify-content-center">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h1 class="fw-bold text-dark mb-1 display-6">{{ $employee->firstname }} {{ strtoupper($employee->lastname) }}</h1>
                                <h3 class="text-secondary fw-medium mb-3" dir="rtl">{{ $employee->firstname_arab }} {{ $employee->lastname_arab }}</h3>
                            </div>
                            <div class="text-end">
                                <span class="d-block text-muted small fw-bold text-uppercase mb-1">Localisation</span>
                                <div class="badge bg-dark px-3 py-2 fs-6 rounded-3 shadow-sm">{{ $employee->local->title ?? 'Siège' }}</div>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                        <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fw-bold border border-primary-subtle">
                            <i class="bi bi-hash me-1"></i>PPR: {{ $employee->ppr ?? 'N/A' }}
                        </span>
                            <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill fw-bold border border-secondary-subtle">
                            <i class="bi bi-card-text me-1"></i>CIN: {{ $employee->cin ?? 'N/A' }}
                        </span>
                            <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-bold border border-success-subtle">
                            <i class="bi bi-calendar-event me-1"></i>Recruté le: {{ $employee->hiring_date ? \Carbon\Carbon::parse($employee->hiring_date)->format('d/m/Y') : '—' }}
                        </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-4 bg-white">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="d-flex flex-column gap-4">
                        <section>
                            <h6 class="text-uppercase text-muted fw-bolder mb-3 ls-1 small border-start border-4 border-primary ps-2">État Civil</h6>
                            <div class="list-group list-group-flush border rounded-3 overflow-hidden shadow-xs">
                                <div class="list-group-item d-flex justify-content-between align-items-center py-3 bg-transparent">
                                    <span class="text-muted small">Situation Familiale</span>
                                    <span class="fw-bold text-dark">{{ $employee->sit ?? '—' }}</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center py-3 bg-transparent">
                                    <span class="text-muted small">Date de naissance</span>
                                    <span class="fw-bold text-dark">{{ $employee->birth_date ? \Carbon\Carbon::parse($employee->birth_date)->format('d/m/Y') : '—' }}</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center py-3 bg-transparent">
                                    <span class="text-muted small">Lieu de naissance</span>
                                    <span class="fw-bold text-dark text-end">{{ $employee->birth_city ?? '—' }}</span>
                                </div>
                            </div>
                        </section>

                        <section>
                            <h6 class="text-uppercase text-muted fw-bolder mb-3 ls-1 small border-start border-4 border-success ps-2">Coordonnées</h6>
                            <div class="p-3 bg-light-subtle rounded-4 border border-success-subtle">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-shape bg-white shadow-sm rounded-circle p-2 text-success me-3 border"><i class="bi bi-telephone"></i></div>
                                    <div><small class="d-block text-muted extra-small fw-bold text-uppercase">Téléphone</small><span class="fw-bold text-dark">{{ $employee->tel ?? '—' }}</span></div>
                                </div>
                                <div class="d-flex align-items-center mb-3 text-truncate">
                                    <div class="icon-shape bg-white shadow-sm rounded-circle p-2 text-warning me-3 border"><i class="bi bi-envelope"></i></div>
                                    <div class="text-truncate"><small class="d-block text-muted extra-small fw-bold text-uppercase">E-mail</small><span class="fw-bold text-dark">{{ $employee->email ?? '—' }}</span></div>
                                </div>
                                <hr class="my-3 opacity-10">
                                <div class="d-flex align-items-start">
                                    <div class="icon-shape bg-white shadow-sm rounded-circle p-2 text-info me-3 border"><i class="bi bi-geo-alt"></i></div>
                                    <div><small class="d-block text-muted extra-small fw-bold text-uppercase">Adresse</small><span class="fw-bold text-dark small">{{ $employee->address ?? '—' }}</span></div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="d-flex flex-column gap-4">
                        <section class="card border-0 bg-light rounded-4 shadow-xs">
                            <div class="card-body p-4">
                                <h6 class="text-uppercase text-muted fw-bolder mb-3 ls-1 small">Affectation Structurelle Active</h6>
                                @php $activeAff = $employee->affectations->where('state', 1)->first(); @endphp
                                @if($activeAff)
                                    <div class="row g-3">
                                        <div class="col-sm-6">
                                            <div class="bg-white p-3 rounded-3 shadow-xs border-top border-4 border-primary h-100">
                                                <small class="text-muted d-block mb-1 fw-bold text-uppercase extra-small">Service</small>
                                                <span class="fw-bold text-dark">{{ $activeAff->service->title ?? 'N/A' }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="bg-white p-3 rounded-3 shadow-xs border-top border-4 border-info h-100">
                                                <small class="text-muted d-block mb-1 fw-bold text-uppercase extra-small">Direction / Entité</small>
                                                <span class="fw-bold text-dark">{{ $activeAff->entity->title ?? 'N/A' }}</span>
                                            </div>
                                        </div>
                                        @if($activeAff->sector || $activeAff->section)
                                            <div class="col-12 mt-2">
                                                <div class="d-flex flex-wrap gap-2 bg-white p-3 rounded-3 border shadow-xs">
                                                    @if($activeAff->sector) <span class="badge bg-success text-white px-3 py-2 rounded-pill small fw-bold">Secteur: {{ $activeAff->sector->title }}</span> @endif
                                                    @if($activeAff->section) <span class="badge bg-secondary text-white px-3 py-2 rounded-pill small fw-bold">Section: {{ $activeAff->section->title }}</span> @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="text-center p-5 bg-white rounded-3 border border-dashed">
                                        <i class="bi bi-diagram-3 text-muted fs-1 opacity-25"></i>
                                        <p class="text-muted small mb-0 mt-2">Aucune affectation active enregistrée.</p>
                                    </div>
                                @endif
                            </div>
                        </section>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="card h-100 shadow-xs border-0 bg-white rounded-4 border-start border-4 border-primary">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="text-uppercase text-muted fw-bolder mb-0 ls-1 small">Fonction Active</h6>
                                            <i class="bi bi-briefcase text-primary opacity-50 fs-4"></i>
                                        </div>
                                        @forelse($employee->works->whereNull('terminated_date') as $work)
                                            <h5 class="fw-bold text-dark mb-0">{{ $work->occupation->title }}</h5>
                                        @empty
                                            <span class="text-muted italic small">Non définie</span>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card h-100 shadow-xs border-0 bg-white rounded-4 border-start border-4 border-warning">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="text-uppercase text-muted fw-bolder mb-0 ls-1 small">Grade & Échelle</h6>
                                            <i class="bi bi-award text-warning opacity-50 fs-4"></i>
                                        </div>
                                        @forelse($employee->competences as $competence)
                                            <div class="fw-bold text-dark mb-2">{{ $competence->grade->title }}</div>
                                            <div class="d-flex gap-2">
                                                <span class="badge bg-success px-2 py-1">Échelle {{ $competence->grade->scale }}</span>
                                                <span class="badge bg-info px-2 py-1">Échelon {{ $competence->echellon->title ?? 'N/A' }}</span>
                                            </div>
                                        @empty
                                            <span class="text-muted small">Non défini</span>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>

                        <section class="card shadow-xs border-0 rounded-4 overflow-hidden mt-2">
                            <div class="card-header bg-dark text-white py-3">
                                <h6 class="text-uppercase fw-bolder mb-0 ls-1 small"><i class="bi bi-mortarboard me-2"></i>Diplômes & Formations</h6>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                    <tr>
                                        <th class="small py-3 ps-4">Diplôme</th>
                                        <th class="small py-3">Filière / Option</th>
                                        <th class="small py-3 text-center pe-4">Année</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($employee->qualifications as $qualification)
                                        <tr>
                                            <td class="fw-bold text-dark ps-4">{{ $qualification->diploma->title }}</td>
                                            <td>{{ $qualification->option->title ?? '-' }}</td>
                                            <td class="text-center pe-4"><span class="badge bg-light text-dark border rounded-pill px-3">{{ $qualification->year ?? '-' }}</span></td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3" class="text-center py-5 text-muted italic">Aucun diplôme renseigné</td></tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .ls-1 { letter-spacing: 0.5px; }
        .extra-small { font-size: 0.65rem; }
        .shadow-xs { box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .icon-shape { width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; }
        .display-6 { font-size: 2.25rem; line-height: 1.2; }
    </style>

    <div class="col-6 bg-white rounded-4 shadow-sm border overflow-hidden ms-1">
        @if (count($values) != 0)
            @php
                $groupedByTable = $values->groupBy('relation.table_id');
            @endphp

            @foreach($groupedByTable as $tableId => $tableValues)
                @php
                    $tableName = $tableValues->first()->relation->table->title ?? 'Table #'.$tableId;
                    $tableColumns = $tableValues->map(fn($v) => $v->relation->column)->unique('id');

                    // Group by Period and SORT BY TITLE DESCENDING (Newest first)
                    $valuesByPeriod = $tableValues->groupBy('period_id')->sortByDesc(function($group) {
                        return $group->first()->period->title;
                    });

                    // Convert to array keys to easily find the "next" period (which is chronologically older)
                    $periodKeys = $valuesByPeriod->keys()->toArray();
                @endphp

                <div class="card border-0 shadow-sm mb-5 rounded-4 overflow-hidden">
                    <div class="card-header bg-dark py-3 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-white fw-bold">
                            <i class="bi bi-grid-3x3-gap me-2 text-primary"></i> {{ $tableName }}
                        </h5>
                        <div class="d-flex align-items-center">
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 me-2">
                    Analyse Tendancielle
                </span>
                            <i class="bi bi-sort-down text-white-50 fs-5"></i>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light border-bottom">
                                <tr>
                                    <th class="ps-4 py-3 text-muted small fw-bolder text-uppercase" style="width: 280px; letter-spacing: 0.5px;">
                                        Période / Intervalle
                                    </th>
                                    @foreach($tableColumns as $col)
                                        <th class="py-3 text-center text-dark fw-bold border-start">
                                            {{ $col->title ?? 'Colonne '.$col->id }}
                                        </th>
                                    @endforeach
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($valuesByPeriod as $periodId => $periodEntries)
                                    @php
                                        $period = $periodEntries->first()->period;
                                        // Find the position of current period to get the older one (next in desc list)
                                        $currentIndex = array_search($periodId, $periodKeys);
                                        $olderPeriodId = $periodKeys[$currentIndex + 1] ?? null;
                                        $olderEntries = $olderPeriodId ? $valuesByPeriod[$olderPeriodId] : null;
                                    @endphp
                                    <tr>
                                        <td class="ps-4 border-end bg-light-subtle">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-white border shadow-xs rounded-circle p-2 me-3 text-primary">
                                                    <i class="bi bi-calendar3"></i>
                                                </div>
                                                <div>
                                                    <span class="d-block fw-bolder text-dark fs-6">{{ $period->title ?? 'Période '.$periodId }}</span>
                                                    <small class="text-muted extra-small font-monospace text-uppercase">
                                                        {{ $period->start_date ?? '...' }} <i class="bi bi-arrow-right mx-1"></i> {{ $period->end_date ?? '...' }}
                                                    </small>
                                                </div>
                                            </div>
                                        </td>

                                        @foreach($tableColumns as $col)
                                            <td class="text-center">
                                                @php
                                                    $entry = $periodEntries->firstWhere('relation.column_id', $col->id);
                                                    $trend = null;

                                                    if ($entry && $olderEntries) {
                                                        $prevEntry = $olderEntries->firstWhere('relation.column_id', $col->id);
                                                        if ($prevEntry && is_numeric($entry->value) && is_numeric($prevEntry->value)) {
                                                            if ($entry->value > $prevEntry->value) $trend = 'up';
                                                            elseif ($entry->value < $prevEntry->value) $trend = 'down';
                                                            else $trend = 'equal';
                                                        }
                                                    }
                                                @endphp

                                                @if($entry)
                                                    <div class="value-container py-2 px-3 rounded-3 bg-white border shadow-xs d-inline-flex align-items-center gap-2">
                                                        <span class="fw-bolder text-primary fs-5">{{ $entry->value }}</span>

                                                        @if($trend === 'up')
                                                            <i class="bi bi-arrow-up-right-circle-fill text-success fs-6" title="En hausse"></i>
                                                        @elseif($trend === 'down')
                                                            <i class="bi bi-arrow-down-right-circle-fill text-danger fs-6" title="En baisse"></i>
                                                        @elseif($trend === 'equal')
                                                            <i class="bi bi-dash-circle-fill text-muted opacity-50" style="font-size: 0.8rem;" title="Stable"></i>
                                                        @endif
                                                    </div>
                                                @else
                                                    <div class="text-muted opacity-25 small italic">nulle</div>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @empty
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach

            <style>
                /* Same styles as before + trend animations */
                .extra-small { font-size: 0.68rem; }
                .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
                .bg-light-subtle { background-color: #fbfcfd; }
                .value-container { min-width: 85px; transition: all 0.2s ease-in-out; cursor: default; }
                .value-container:hover { border-color: #4f46e5; transform: translateY(-2px); box-shadow: 0 4px 6px rgba(79, 70, 229, 0.1); }

                .bi-arrow-up-right-circle-fill { animation: fadeIn 0.5s ease; }
                .bi-arrow-down-right-circle-fill { animation: fadeIn 0.5s ease; }

                @keyframes fadeIn {
                    from { opacity: 0; transform: scale(0.5); }
                    to { opacity: 1; transform: scale(1); }
                }
            </style>
        @else
            <p> pas valeurs saisie pour ce employé</p>
        @endif
    </div>
</div>
