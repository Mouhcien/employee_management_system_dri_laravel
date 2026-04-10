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
        #box_history_affectation {
            display: none !important;
        }
        .hover-lift:hover {
            transform: translateY(-1px);
            background-color: #f8fafc;
            color: #475569;
            border-color: #cbd5e1;
        }
        .transition-all {
            transition: all 0.2s ease-in-out;
        }

        /* Professional Micro-interactions */
        .btn-ghost-secondary {
            color: #64748b;
            border: 1px solid transparent;
        }
        .btn-ghost-secondary:hover {
            background-color: #f1f5f9;
            color: #1e293b;
        }

        .hover-danger-solid:hover {
            background-color: #dc3545 !important;
            color: white !important;
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.25);
        }

        .fw-black { font-weight: 800; }
        .tracking-tighter { letter-spacing: -0.02em; }
        .transition-all { transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1); }

    }
</style>

<div class="container-fluid py-3 mb-2 d-print-none">
    <div class="d-flex justify-content-between align-items-center bg-white p-3 rounded-4 shadow-sm border">
        <div>
            <h5 class="fw-bold text-dark mb-0">
                <i class="bi bi-file-earmark-person me-2 text-primary"></i>Fiche de Suivi Individuelle
            </h5>
        </div>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('audit.values.view.2', $employee) }}"
               class="btn btn-ghost-secondary d-inline-flex align-items-center rounded-pill px-3 py-2 transition-all">
                <div class="bg-secondary bg-opacity-10 rounded-circle p-1 me-2">
                    <i class="bi bi- eyeglasses text-secondary small"></i>
                </div>
                <span class="small fw-bold text-uppercase tracking-tighter">Mode Plein</span>
            </a>

            <div class="vr h-50 opacity-25"></div>

            <a href="javascript:window.history.back();"
               class="btn btn-outline-danger border-opacity-25 rounded-pill px-4 fw-black d-inline-flex align-items-center transition-all hover-danger-solid">
                <i class="bi bi-x-lg me-2"></i>
                <span>Fermer</span>
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
                    <div id="controls_overlay" class="d-none text-center mb-3">
                        <button onclick="toggleView(false)" class="btn btn-dark rounded-pill shadow-sm">
                            <i class="bi bi-arrow-left me-2"></i>Retour à la vue normale
                        </button>
                    </div>

                    <div class="text-center mb-4 transition-all" id="image_wrapper">
                        <div class="position-relative d-inline-block shadow-lg rounded-4 overflow-hidden border border-4 border-white">
                            @if($employee->photo && Storage::disk('public')->exists($employee->photo))
                                <img src="{{ Storage::url($employee->photo) }}"
                                     id="employee_img"
                                     class="object-fit-cover transition-all"
                                     width="300" height="300"
                                     ondblclick="toggleView(true)"
                                     style="cursor: pointer; transition: all 0.3s ease;">
                            @else
                                <div id="employee_placeholder"
                                     class="d-flex align-items-center justify-content-center text-white fw-bold transition-all"
                                     style="width:300px; height:300px; background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); font-size: 5rem;">
                                    {{ strtoupper(substr($employee->firstname, 0, 1)) }}{{ strtoupper(substr($employee->lastname, 0, 1)) }}
                                </div>
                            @endif

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

                    <section id="box_affectation" class="card border-0 bg-light rounded-4 shadow-xs mb-4">
                        <div class="card-body p-4">
                            <div class="row col-12 mb-3">
                                <div class="col-6 align-content-center">
                                    <h6 class="text-uppercase text-muted fw-bolder mb-3 ls-1 small">
                                        Affectation Structurelle Active
                                    </h6>
                                </div>
                                <div class="col-6 align-content-center">
                                    <a href="javascript:void(0);"
                                       onclick="toggleSections()"
                                       class="d-inline-flex align-items-center px-3 py-1 text-secondary text-decoration-none border rounded-pill shadow-sm bg-light hover-shadow float-end">
                                        <i class="bi bi-clock-history me-2 text-primary"></i>
                                        <span class="fw-medium">Historique</span>
                                    </a>
                                </div>
                            </div>

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
                                                @if($activeAff->sector) <span class="badge bg-info text-white px-3 py-2 rounded-pill small fw-bold">Secteur: {{ $activeAff->sector->title }}</span> @endif
                                                @if($activeAff->section) <span class="badge bg-secondary text-white px-3 py-2 rounded-pill small fw-bold">Section: {{ $activeAff->section->title }}</span> @endif
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-12 mt-2">
                                        <div class="d-flex flex-wrap gap-2 bg-white p-3 rounded-3 border shadow-xs">
                                            <span class="fw-bold text-dark"> Fonction :  </span>
                                            <span class="badge bg-success ms-2">{{ $activeAff->occupation->title ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="text-center p-4 bg-white rounded-3 border border-dashed">
                                    <i class="bi bi-diagram-3 text-muted fs-1 opacity-25"></i>
                                    <p class="text-muted small mb-0 mt-2">Aucune affectation active enregistrée.</p>
                                </div>
                            @endif
                        </div>
                    </section>

                    <section id="box_history_affectation" class="card border-0 bg-light rounded-4 shadow-xs mb-4 d-none">
                        <div class="card-body p-4">
                            <div class="row col-12 mb-4">
                                <div class="col-6 align-content-center">
                                    <h6 class="text-uppercase text-muted fw-bolder mb-0 ls-1 small">
                                        Historique des Affectations
                                    </h6>
                                </div>
                                <div class="col-6">
                                    <a href="javascript:void(0);" onclick="toggleSections()"
                                       class="d-inline-flex align-items-center px-3 py-1 text-danger text-decoration-none border border-danger rounded-pill shadow-sm bg-white hover-shadow float-end">
                                        <i class="bi bi-arrow-left me-2"></i>
                                        <span class="fw-medium">Retour</span>
                                    </a>
                                </div>
                            </div>

                            @foreach($employee->affectations->sortByDesc('affectation_date') as $affectation)
                                <div class="mb-4">
                                    <h6 class="text-uppercase text-primary fw-bolder mb-3 ls-1 small">
                                        <i class="bi bi-calendar-event me-2"></i>{{ \Carbon\Carbon::parse($affectation->affectation_date)->format('d/m/Y') }}
                                        @if ($affectation->section) <span class="badge bg-info ms-2"> {{ $affectation->section->title }} </span> @endif
                                        @if ($affectation->sector) <span class="badge bg-info ms-1"> {{ $affectation->sector->title }} </span> @endif
                                    </h6>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="p-3 rounded-4 bg-white border-start border-4 border-primary h-100 shadow-sm">
                                                <small class="text-muted d-block mb-1 fw-bold text-uppercase" style="font-size: 0.7rem;">Service</small>
                                                <span class="fw-bold text-dark">{{ $affectation->service->title ?? 'N/A' }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="p-3 rounded-4 bg-white border-start border-4 border-info h-100 shadow-sm">
                                                <small class="text-muted d-block mb-1 fw-bold text-uppercase" style="font-size: 0.7rem;">Direction / Entité</small>
                                                <span class="fw-bold text-dark">{{ $affectation->entity->title ?? 'N/A' }}</span>
                                            </div>
                                        </div>
                                        <div class="col-12 mt-2">
                                            <div class="d-flex flex-wrap gap-2 bg-white p-3 rounded-3 border shadow-xs">
                                                <span class="fw-bold text-dark"> Fonction :  </span>
                                                <span class="badge bg-success ms-2">{{ $affectation->occupation->title ?? 'N/A' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    @if(!$loop->last) <hr class="my-4 opacity-25"> @endif
                                </div>
                            @endforeach
                        </div>
                    </section>

                    <div class="row g-3" id="info_grid">
                        <div class="col-md-12">
                            <div class="h-100 p-3 border rounded-4 bg-white shadow-xs">
                                <small class="text-muted d-block mb-1 fw-bold">Grade & Échelle</small>
                                @foreach($employee->competences->sortByDesc('starting_date') as $competence)
                                    <span class="fw-bold text-dark d-block text-truncate">{{ $competence->grade->title ?? '—' }}</span>
                                    <span class="badge bg-info-subtle text-info mt-1">Échelle: {{ $competence->grade->scale ?? '—' }}</span>
                                    <span class="badge bg-success-subtle text-success mt-1"> {{ \Carbon\Carbon::parse($competence->starting_date)->format('d/m/Y') ?? '—' }}</span>
                                    <hr>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="h-100 p-3 border rounded-4 bg-white shadow-xs">
                                <small class="text-muted d-block mb-1 fw-bold">Qualification & Diplôme</small>
                                <div class="card border-0 shadow-sm rounded-4">
                                    <div class="card-body p-4 pt-2">
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle mb-0">
                                                <thead class="bg-light-subtle">
                                                <tr>
                                                    <th class="border-0 small fw-bold">Intitulé du diplôme</th>
                                                    <th class="border-0 small fw-bold">Filière</th>
                                                    <th class="border-0 small fw-bold text-center">Année</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @forelse($employee->qualifications->sortByDesc('year') as $qualification)
                                                    <tr class="qualification-row" style="cursor: pointer;" title="Double-cliquez pour modifier">
                                                        <td class="fw-bold text-dark border-0">{{ $qualification->diploma->title }}</td>
                                                        <td class="fw-bold text-dark border-0">{{ $qualification->option->title ?? '-' }}</td>
                                                        <td class="text-center border-0"><span class="badge bg-secondary rounded-pill px-3">{{ $qualification->year ?? '-' }}</span></td>
                                                    </tr>
                                                @empty
                                                    <tr><td colspan="3" class="text-center py-4 border-0 text-muted italic">Aucun diplôme renseigné</td></tr>
                                                @endforelse
                                                </tbody>
                                            </table>
                                            @foreach($employee->qualifications as $qualification)
                                                <x-delete-model
                                                    href="{{ route('qualifications.delete', $qualification->id) }}"
                                                    message="Attention : La suppression du {{ $qualification->diploma->title }}  est irréversible."
                                                    title="Confirmation de Suppression du diplôme"
                                                    target="deleteQualificationModal-{{ $qualification->id }}" />
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
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
            @include('app.audit.values.partials.values-table-view', ['values' => $values])
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




