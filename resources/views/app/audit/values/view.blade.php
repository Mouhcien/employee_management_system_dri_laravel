@vite(['resources/css/app.css', 'resources/css/toastr.min.css'])

<style>
    /* ... your previous styles ... */

    /* PRINT OPTIMIZATION */
    @media print {
        /* Hide UI elements that shouldn't be on paper */
        .d-print-none, #resize_btn, .btn, .card-header button {
            display: none !important;
        }

        /* Ensure background colors and gradients appear in print */
        body {
            background-color: white !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .card {
            box-shadow: none !important;
            border: 1px solid #dee2e6 !important;
        }

        /* Force columns to sit side-by-side on paper if there is room */
        #page_wrapper {
            display: flex !important;
            flex-direction: row !important;
        }

        #profile_column { width: 40% !important; }
        #data_column { width: 60% !important; }

        /* Ensure the image fits the page if it was expanded to 600px */
        #employee_img, #employee_placeholder {
            max-width: 100% !important;
            height: auto !important;
        }

        /* Expand table to full width on print */
        .table-responsive {
            overflow: visible !important;
        }
    }
</style>

<div class="container-fluid py-3 mb-2 d-print-none">
    <div class="d-flex justify-content-between align-items-center bg-white p-3 rounded-4 shadow-sm border">
        <div>
            <h5 class="fw-bold text-dark mb-0">
                <i class="bi bi-file-earmark-person me-2 text-primary"></i>Fiche de Suivi Individuelle
            </h5>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
                <i class="bi bi-printer me-2"></i>Imprimer
            </button>

            <a href="javascript:window.history.back();" class="btn btn-light border rounded-pill px-4 fw-bold">
                <i class="bi bi-x-lg me-2"></i>Fermer
            </a>
        </div>
    </div>
</div>

<div class="container-fluid py-4" id="main_layout_container">
    <div class="row g-4" id="page_wrapper">

        <div class="col-lg-5" id="profile_column">
            <div class="card border-0 shadow-lg rounded-4 sticky-top" style="top: 20px; z-index: 1000;">
                <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark mb-0"><i class="bi bi-person-badge me-2 text-primary"></i>Profil de l'agent</h5>
                    <button class="btn btn-sm btn-outline-secondary rounded-pill px-3" onclick="toggleImageSize()" id="resize_btn">
                        <i class="bi bi-arrows-fullscreen me-1"></i> <span id="btn_text">Agrandir</span>
                    </button>
                </div>

                <div class="card-body p-4">
                    <div class="text-center mb-4 transition-all" id="image_wrapper">
                        <div class="position-relative d-inline-block shadow-lg rounded-4 overflow-hidden border border-4 border-white">
                            @if($employee->photo && Storage::disk('public')->exists($employee->photo))
                                <img src="{{ Storage::url($employee->photo) }}"
                                     id="employee_img"
                                     class="object-fit-cover transition-all"
                                     width="300" height="300">
                            @else
                                <div id="employee_placeholder"
                                     class="d-flex align-items-center justify-content-center text-white fw-bold transition-all"
                                     style="width:300px; height:300px; background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); font-size: 5rem;">
                                    {{ strtoupper(substr($employee->firstname, 0, 1)) }}{{ strtoupper(substr($employee->lastname, 0, 1)) }}
                                </div>
                            @endif
                            <span class="position-absolute bottom-0 end-0 p-3 m-3 border border-3 border-white rounded-circle shadow {{ $employee->gender === 'F' ? 'bg-danger' : 'bg-primary' }}">
                                <i class="bi bi-gender-{{ $employee->gender === 'F' ? 'female' : 'male' }} text-white fs-4"></i>
                            </span>
                        </div>
                    </div>

                    <div class="text-center mb-4 border-bottom pb-4" id="identity_details">
                        <h1 class="fw-black text-dark mb-0" style="font-size: 2rem;">{{ $employee->firstname }} {{ strtoupper($employee->lastname) }}</h1>
                        <h3 class="text-secondary fw-medium mb-3" dir="rtl">{{ $employee->firstname_arab }} {{ $employee->lastname_arab }}</h3>

                        <div class="d-flex flex-wrap justify-content-center gap-2 mt-2">
                            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-bold"><i class="bi bi-hash text-primary me-1"></i>{{ $employee->ppr ?? 'N/A' }}</span>
                            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-bold"><i class="bi bi-card-text text-primary me-1"></i>{{ $employee->cin ?? 'N/A' }}</span>
                            <span class="badge bg-dark text-white px-3 py-2 rounded-pill fw-bold"><i class="bi bi-calendar-check me-1"></i>Entrée: {{ $employee->hiring_date ? \Carbon\Carbon::parse($employee->hiring_date)->format('d/m/Y') : '—' }}</span>
                        </div>
                    </div>

                    <section class="card border-0 bg-light rounded-4 shadow-xs mb-4">
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
                                <div class="text-center p-4 bg-white rounded-3 border border-dashed">
                                    <i class="bi bi-diagram-3 text-muted fs-1 opacity-25"></i>
                                    <p class="text-muted small mb-0 mt-2">Aucune affectation active enregistrée.</p>
                                </div>
                            @endif
                        </div>
                    </section>

                    <div class="row g-3" id="info_grid">
                        <div class="col-md-6">
                            <div class="h-100 p-3 border rounded-4 bg-white shadow-xs">
                                <small class="text-muted d-block mb-1 fw-bold">Fonction</small>
                                <span class="fw-bold text-dark">{{ $employee->works->whereNull('terminated_date')->first()->occupation->title ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="h-100 p-3 border rounded-4 bg-white shadow-xs">
                                <small class="text-muted d-block mb-1 fw-bold">Grade & Échelle</small>
                                @php $comp = $employee->competences->first(); @endphp
                                <span class="fw-bold text-dark d-block text-truncate">{{ $comp->grade->title ?? '—' }}</span>
                                <span class="badge bg-info-subtle text-info mt-1">Échelle: {{ $comp->grade->scale ?? '—' }}</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="p-3 bg-white border rounded-4 shadow-xs d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted d-block fw-bold">Contact Direct</small>
                                    <span class="fw-bold text-dark"><i class="bi bi-telephone text-success me-1"></i>{{ $employee->tel ?? '—' }}</span>
                                </div>
                                <div class="text-end">
                                    <small class="text-muted d-block fw-bold">Ville</small>
                                    <span class="fw-bold text-dark">{{ $employee->local->title ?? '—' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7" id="data_column">
            @if (count($values) != 0)
                @php $groupedByTable = $values->groupBy('relation.table_id'); @endphp

                @foreach($groupedByTable as $tableId => $tableValues)
                    @php
                        $tableName = $tableValues->first()->relation->table->title ?? 'Table #'.$tableId;
                        $tableColumns = $tableValues->map(fn($v) => $v->relation->column)->unique('id');
                        $valuesByPeriod = $tableValues->groupBy('period_id')->sortByDesc(fn($group) => $group->first()->period->title);
                        $periodKeys = $valuesByPeriod->keys()->toArray();
                    @endphp

                    <div class="card border-0 shadow-sm mb-4 rounded-4 overflow-hidden">
                        <div class="card-header bg-dark py-3 px-4 d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 text-white fw-bold"><i class="bi bi-bar-chart-line me-2 text-primary"></i> {{ $tableName }}</h6>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill">Analyse des KPIs</span>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light-subtle border-bottom">
                                    <tr>
                                        <th class="ps-4 py-3 text-muted small fw-bolder text-uppercase" style="width: 220px;">Période</th>
                                        @foreach($tableColumns as $col)
                                            <th class="py-3 text-center text-dark fw-bold border-start">{{ $col->title }}</th>
                                        @endforeach
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($valuesByPeriod as $periodId => $periodEntries)
                                        @php
                                            $period = $periodEntries->first()->period;
                                            $currentIndex = array_search($periodId, $periodKeys);
                                            $olderPeriodId = $periodKeys[$currentIndex + 1] ?? null;
                                            $olderEntries = $olderPeriodId ? $valuesByPeriod[$olderPeriodId] : null;
                                        @endphp
                                        <tr>
                                            <td class="ps-4 border-end bg-light-subtle">
                                                <div class="fw-bold text-dark">{{ $period->title }}</div>
                                                <small class="text-muted extra-small text-uppercase">{{ $period->start_date }} → {{ $period->end_date }}</small>
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
                                                        <div class="d-inline-flex align-items-center gap-2 p-2 bg-white border rounded shadow-xs min-w-80 justify-content-center">
                                                            <span class="fw-black text-primary">{{ $entry->value }}</span>
                                                            @if($trend === 'up') <i class="bi bi-arrow-up-right text-success fw-bold"></i>
                                                            @elseif($trend === 'down') <i class="bi bi-arrow-down-right text-danger fw-bold"></i>
                                                            @elseif($trend === 'equal') <i class="bi bi-dash text-muted"></i> @endif
                                                        </div>
                                                    @else
                                                        <span class="text-muted opacity-25 italic">N/A</span>
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
            @else
                <div class="h-100 d-flex align-items-center justify-content-center border-dashed rounded-4 p-5">
                    <div class="text-center opacity-50">
                        <i class="bi bi-database-exclamation display-4"></i>
                        <p class="mt-2 fw-bold">Aucune valeur saisie pour cet employé</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    function toggleImageSize() {
        const profileCol = document.getElementById('profile_column');
        const dataCol = document.getElementById('data_column');
        const img = document.getElementById('employee_img');
        const placeholder = document.getElementById('employee_placeholder');
        const btnText = document.getElementById('btn_text');

        if (profileCol.classList.contains('col-lg-5')) {
            profileCol.classList.replace('col-lg-5', 'col-lg-12');
            dataCol.classList.replace('col-lg-7', 'col-lg-12');
            if(img) { img.width = 600; img.height = 600; }
            if(placeholder) { placeholder.style.width = '600px'; placeholder.style.height = '600px'; placeholder.style.fontSize = '10rem'; }
            btnText.innerText = "Réduire";
        } else {
            profileCol.classList.replace('col-lg-12', 'col-lg-5');
            dataCol.classList.replace('col-lg-12', 'col-lg-7');
            if(img) { img.width = 300; img.height = 300; }
            if(placeholder) { placeholder.style.width = '300px'; placeholder.style.height = '300px'; placeholder.style.fontSize = '5rem'; }
            btnText.innerText = "Agrandir";
        }
    }
</script>




