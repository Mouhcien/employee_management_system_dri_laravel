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

            <a href="{{ route('audit.values.view.entity', ['entityName' => $entityName, 'id' => $id]) }}" class="btn btn-light border rounded-pill px-4 fw-bold">
                <i class="bi bi-x-lg me-2"></i>Fermer
            </a>
        </div>
    </div>
</div>

<div class="container-fluid py-4" id="main_layout_container">
    <div class="row g-4" id="page_wrapper">

        @include('app.audit.values.partials.profile_column', ['employee' => $employee])

        <div class="col-lg-7" id="data_column">
            <select class="form-select" id="sl_view_detail_period">
                <option value="">Séléction la période </option>
                @foreach($periods->sortByDesc('year')->sortByDesc('title') as $period)
                    <option {{ $period_id == $period->id ? 'selected' : '' }} value="{{ $period->id }}"> {{ $period->title }} {{ $period->year }} </option>
                @endforeach
            </select>
            <input type="hidden" id="input_hidden_entity_name" value="{{ $entityName }}">
            <input type="hidden" id="input_hidden_entity_id" value="{{ $id }}">
            <input type="hidden" id="input_hidden_table_id" value="{{ $table_id }}">
            <hr>

            @if ($values->isNotEmpty())
                @php $groupedByTable = $values->groupBy('table_id'); @endphp

                @foreach($groupedByTable as $tableId => $tableValues)
                    @php

                        $firstRecordInTable = $tableValues->first();
                        $tableName = $firstRecordInTable->table_title ?? 'Table #'.$tableId;

                        $tableColumns = $tableValues->unique('column_id')->map(function($v) {
                            return (object) ['id' => $v->column_id, 'title' => $v->column_title];
                        });

                        $employeesInTable = $tableValues->groupBy('employee_id');
                    @endphp

                    <div class="card border-0 shadow-sm mb-4 rounded-4 overflow-hidden">
                        <div class="card-header bg-dark py-3 px-4">
                            <h6 class="mb-0 text-white fw-bold">
                                <i class="bi bi-table me-2 text-primary"></i> {{ $tableName }}
                            </h6>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light-subtle border-bottom">
                                    <th class="ps-4 py-3 text-muted small fw-bolder text-uppercase" style="width: 250px;">Agent</th>
                                    @foreach($tableColumns as $index => $col)
                                        <th class="py-3 text-center text-dark fw-bold border-start">
                                            <div class="d-flex align-items-center justify-content-center gap-2">
                                                {{ $col->title }}
                                                <button class="btn btn-link p-0 text-muted sort-btn"
                                                        onclick="sortTable(this, {{ $index + 1 }})">
                                                    <i class="bi bi-arrow-down-up" style="font-size: 0.8rem;"></i>
                                                </button>
                                            </div>
                                        </th>
                                    @endforeach
                                    </thead>
                                    <tbody>
                                    @foreach($employeesInTable as $employeeId => $employeeEntries)
                                        <tr>
                                            <td class="ps-4 border-end bg-light-subtle text">
                                                @php $employee = $employeeEntries[0]->employee; @endphp

                                                @include('app.audit.values.partials.small_employee_card', ['employee' => $employee])

                                            </td>

                                            @foreach($tableColumns as $col)
                                                <td class="text-center">
                                                    @php
                                                        // Find the specific cell value for this employee and column
                                                        $cell = $employeeEntries->firstWhere('column_id', $col->id);
                                                    @endphp

                                                    @if($cell)
                                                        <div class="d-inline-flex align-items-center gap-2 p-2 bg-white border rounded shadow-xs min-w-80 justify-content-center">
                                                            <span class="fw-black text-primary">{{ number_format($cell->total_sum, 0) }}</span>
                                                        </div>
                                                    @else
                                                        <span class="text-muted opacity-25">-</span>
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
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
                        <p class="mt-2 fw-bold">Aucune donnée trouvée</p>
                    </div>
                </div>
            @endif
        </div>

    </div>
</div>



@vite(['resources/js/jquery-3.7.1.js', 'resources/js/app.js', 'resources/js/toastr.min.js', 'resources/js/script.js', 'resources/js/chart.js'])

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const loader = document.getElementById('global-loader');

        const showLoader = () => {
            loader.style.display = 'flex';
        };

        // 1. All Form Submissions
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', showLoader);
        });

        // 2. All Links (except external or hash links)
        document.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function(e) {
                // Only show loader if it's a normal internal navigation
                if (
                    link.href &&
                    link.getAttribute('target') !== '_blank' &&
                    !link.href.includes('#') &&
                    link.origin === window.location.origin
                ) {
                    showLoader();
                }
            });
        });

        // 3. Custom Buttons (like "Refresh" or specific actions)
        document.querySelectorAll('.trigger-loader').forEach(btn => {
            btn.addEventListener('click', showLoader);
        });

        // 4. Hide loader if the user hits the "Back" button
        window.onpageshow = function(event) {
            if (event.persisted) {
                document.getElementById('global-loader').style.display = 'none';
            }
        };

        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('sidebarToggle');
        const toggleIcon = document.getElementById('toggleIcon');

        // Optionnel : Gérer le contenu principal pour qu'il s'adapte
        const mainContent = document.querySelector('main');

        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('sidebar-collapsed');

            // Changement d'icône
            if (sidebar.classList.contains('sidebar-collapsed')) {
                toggleIcon.classList.replace('bi-chevron-left', 'bi-chevron-right');
            } else {
                toggleIcon.classList.replace('bi-chevron-right', 'bi-chevron-left');
            }
        });

        // Toastr Configuration
        window.addEventListener('load', function() {
            // Configure Toastr
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-bottom-right",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut",
                "preventDuplicates": true,
                "newestOnTop": true
            };

            // Display Session Messages
            @if(Session::has('success'))
            toastr.success("{{ session('success') }}", "Succès");
            @endif

            @if(Session::has('error'))
            toastr.error("{{ session('error') }}", "Erreur");
            @endif

            @if(Session::has('info'))
            toastr.info("{{ session('info') }}", "Information");
            @endif

            @if(Session::has('warning'))
            toastr.warning("{{ session('warning') }}", "Attention");
            @endif
        });

        //Global Search

        const searchInput = document.getElementById('mainSearch');
        const resultBox = document.getElementById('box_result_search');
        const resultContent = document.getElementById('searchContent');

        function debounce(func, timeout = 300) {
            let timer;
            return (...args) => {
                clearTimeout(timer);
                timer = setTimeout(() => { func.apply(this, args); }, timeout);
            };
        }

        async function performSearch(query) {
            // Trim whitespace to prevent empty searches
            const cleanQuery = query.trim();

            if (cleanQuery.length < 2) {
                resultBox.classList.add('d-none');
                return;
            }

            try {
                const response = await fetch(`/search/?q=${encodeURIComponent(cleanQuery)}`);
                if (!response.ok) throw new Error('Network response error');

                const data = await response.json();

                // Reveal the box before rendering
                resultBox.classList.remove('d-none');
                renderCategorizedResults(data);
            } catch (error) {
                console.error("Erreur:", error);
                resultContent.innerHTML = '<div class="p-3 text-danger small">Erreur de connexion.</div>';
                resultBox.classList.remove('d-none');
            }
        }

        const processChange = debounce((e) => performSearch(e.target.value));
        searchInput.addEventListener('input', processChange);

        function renderCategorizedResults(matches) {
            if (matches.length === 0) {
                resultContent.innerHTML = '<div class="p-3 text-muted text-center">Aucun résultat trouvé.</div>';
                return;
            }

            const grouped = matches.reduce((acc, obj) => {
                const key = obj.display_category || 'Autres';
                if (!acc[key]) acc[key] = [];
                acc[key].push(obj);
                return acc;
            }, {});

            let html = '';

            for (const category in grouped) {
                const categoryItems = grouped[category];
                html += `
            <div class="row w-100 py-2 m-0 align-items-start">
                <div class="col-4 fw-bold text-secondary text-uppercase" style="font-size: 0.75rem;">
                    ${category} <span class="badge bg-info ms-1">${categoryItems.length}</span>
                </div>
                <div class="col-8">
                    ${categoryItems.map(item => {
                    // Secure the JSON string for the onclick attribute
                    const safeData = JSON.stringify(item).replace(/"/g, '&quot;');
                    return `
                            <div class="search-result-item mb-2 p-2 rounded"
                                 style="cursor:pointer;"
                                 onclick="handleSelect(${safeData})">
                                <div class="fw-bold text-dark" style="font-size: 0.9rem;">
                                <a href="${item.url}" >${item.display_name}</a>
                                </div>
                                <div class="text-muted" style="font-size: 0.8rem;">${item.display_info}</div>
                            </div>`;
                }).join('')}
                </div>
            </div>
            <hr class="my-1 text-secondary opacity-25">
        `;
            }

            resultContent.innerHTML = html;
        }

        // NEW: Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!resultBox.contains(e.target) && e.target !== searchInput) {
                resultBox.classList.add('d-none');
            }
        });

        function handleSelect(fullData) {
            console.log("Full Object:", fullData);
            // Logic: e.g., window.location.href = `/profile/${fullData.id}`;
        }

    });

    function sortTable(button, colIndex) {
        // 1. Get the table elements
        const table = button.closest('table');
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));

        // 2. Determine sort direction (toggle)
        const isAscending = button.dataset.order === 'asc';
        button.dataset.order = isAscending ? 'desc' : 'asc';

        // 3. Update UI icons (optional)
        table.querySelectorAll('.sort-btn i').forEach(icon => icon.className = 'bi bi-arrow-down-up');
        button.querySelector('i').className = isAscending ? 'bi bi-arrow-down text-primary' : 'bi bi-arrow-up text-primary';

        // 4. Sort rows
        const sortedRows = rows.sort((a, b) => {
        // Get text from the specific cell index
        const aCol = a.cells[colIndex].innerText.trim().replace(/,/g, '');
        const bCol = b.cells[colIndex].innerText.trim().replace(/,/g, '');

        // Check if the values are numeric
        const aVal = isNaN(parseFloat(aCol)) ? aCol.toLowerCase() : parseFloat(aCol);
        const bVal = isNaN(parseFloat(bCol)) ? bCol.toLowerCase() : parseFloat(bCol);

        if (aVal < bVal) return isAscending ? -1 : 1;
        if (aVal > bVal) return isAscending ? 1 : -1;
            return 0;
        });

        // 5. Re-append sorted rows to the tbody
        tbody.append(...sortedRows);
    }

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


