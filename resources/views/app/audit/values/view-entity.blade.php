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
                <i class="bi bi-file-earmark-person me-2 text-primary"></i>
                @if (!is_null($service))
                    Fiche du Service : {{ $service->title }}
                @endif
                @if (!is_null($entity))
                    Fiche {{ $entity->type->title }} : {{ $entity->title }}
                @endif
                @if (!is_null($sector))
                    Fiche du Secteur : {{ $sector->title }}
                @endif
                @if (!is_null($section))
                    Fiche de la section : {{ $section->title }}
                @endif
            </h5>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
                <i class="bi bi-printer me-2"></i>Imprimer
            </button>

            <a href="{{ route('audit.values.select') }}" class="btn btn-light border rounded-pill px-4 fw-bold">
                <i class="bi bi-x-lg me-2"></i>Fermer
            </a>
        </div>
    </div>
</div>

<div class="container-fluid py-4" id="main_layout_container">
    <div class="row g-4" id="page_wrapper">

        @include('app.audit.values.partials.profile_column', ['employee' => $employee])

        <div class="col-lg-7" id="data_column">
            @if ($values->isNotEmpty())
                {{-- Group by table_id from the query result --}}
                @php $groupedByTable = $values->groupBy('table_id'); @endphp

                @foreach($groupedByTable as $tableId => $tableValues)
                    @php
                        $tableName = $tableValues->first()->table_title ?? 'Table #'.$tableId;

                        // Get unique columns for this specific table
                        $tableColumns = $tableValues->unique('column_id')->map(function($v) {
                            return (object) ['id' => $v->column_id, 'title' => $v->column_title];
                        });

                        $valuesByPeriod = $tableValues->groupBy('period_id')->sortByDesc(function ($group) {
                            // Access the period year from the first item in the group
                            return $group->first()->period->year;
                        });
                        $periodKeys = $valuesByPeriod->keys()->toArray();
                    @endphp

                    <div class="card border-0 shadow-sm mb-4 rounded-4 overflow-hidden">
                        <div class="card-header bg-dark py-3 px-4 d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 text-white fw-bold"><i class="bi bi-bar-chart-line me-2 text-primary"></i> {{ $tableName }}</h6>
                            <a href="{{ route('audit.values.view.entity.details', ['entityName' =>$entityName, 'id' => $id, 'table_id' => $tableId]) }}" class="badge bg-warning-subtle text-primary border border-warning-subtle rounded-pill">Détail</a>
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
                                                <div class="fw-bold text-dark">{{ $period->title }} {{ $period->year }}</div>
                                                <small class="text-muted extra-small text-uppercase">{{ $period->starting_date }} → {{ $period->end_date }}</small>
                                            </td>
                                            @foreach($tableColumns as $col)
                                                <td class="text-center">
                                                    @php
                                                        // Look for the summed total for this column
                                                        $entry = $periodEntries->firstWhere('column_id', $col->id);
                                                        $trend = null;

                                                        if ($entry && $olderEntries) {
                                                            $prevEntry = $olderEntries->firstWhere('column_id', $col->id);
                                                            if ($prevEntry && is_numeric($entry->total_sum) && is_numeric($prevEntry->total_sum)) {
                                                                if ($entry->total_sum > $prevEntry->total_sum) $trend = 'up';
                                                                elseif ($entry->total_sum < $prevEntry->total_sum) $trend = 'down';
                                                                else $trend = 'equal';
                                                            }
                                                        }
                                                    @endphp
                                                    @if($entry)
                                                        <div class="d-inline-flex align-items-center gap-2 p-2 bg-white border rounded shadow-xs min-w-80 justify-content-center">
                                                            <span class="fw-black text-primary">{{ number_format($entry->total_sum, 2) }}</span>
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
                        <p class="mt-2 fw-bold">Aucune valeur saisie pour ce service</p>
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

    function toggleView(isZoomed) {
        const img = document.getElementById('employee_img');
        const placeholder = document.getElementById('employee_placeholder');
        const identity = document.getElementById('identity_details');
        const affectation = document.querySelector('section.card'); // Targets the Affectation section
        const infoGrid = document.getElementById('info_grid');
        const controls = document.getElementById('controls_overlay');

        if (isZoomed) {
            // 1. Resize Image or Placeholder
            //
            if(img) {
                img.style.width = "600px";
                img.style.height = "600px";
            }
            if(placeholder) {
                placeholder.style.width = "600px";
                placeholder.style.height = "600px";
            }

            // 2. Hide Sections
            identity.classList.add('d-none');
            affectation.classList.add('d-none');
            infoGrid.classList.add('d-none');

            // 3. Show Return Button
            controls.classList.remove('d-none');
        } else {
            // 1. Reset Sizes
            if(img) {
                img.style.width = "300px";
                img.style.height = "300px";
            }
            if(placeholder) {
                placeholder.style.width = "300px";
                placeholder.style.height = "300px";
            }

            // 2. Show Sections
            identity.classList.remove('d-none');
            affectation.classList.remove('d-none');
            infoGrid.classList.remove('d-none');

            // 3. Hide Return Button
            controls.classList.add('d-none');
        }
    }

    function toggleSections() {
        const boxActive = document.getElementById('box_affectation');
        const boxHistory = document.getElementById('box_history_affectation');

        // Select the button components inside the link
        const btn = document.querySelector('[onclick="toggleSections()"]');
        const btnText = btn.querySelector('span');
        const btnIcon = btn.querySelector('i');

        // Toggle Visibility
        boxActive.classList.toggle('d-none');
        boxHistory.classList.toggle('d-none');

        // Update Button Appearance based on state
        if (boxHistory.classList.contains('d-none')) {
            // Normal State (Showing Active)
            btnText.innerText = "Historique";
            btnIcon.className = "bi bi-clock-history me-2 text-primary";
            btn.classList.replace('text-danger', 'text-secondary');
            btn.classList.replace('border-danger', 'border-secondary');
        } else {
            // Toggle State (Showing History)
            btnText.innerText = "Retour";
            btnIcon.className = "bi bi-arrow-left me-2 text-danger";
            btn.classList.replace('text-secondary', 'text-danger');
            btn.classList.replace('border-secondary', 'border-danger');
        }
    }
</script>




