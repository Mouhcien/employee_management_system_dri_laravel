<x-layout>
    @section('title', 'Détails de l\'employé - ' . $employee->firstname)

    <style>
        /* 1. The Main Overlay Container */
        .profile-expanded-overlay {
            display: none; /* Hidden by default */
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(15, 23, 42, 0.98); /* Deep slate background */
            backdrop-filter: blur(15px); /* Modern frosted glass effect */
            z-index: 9999;
            padding: 30px;
            overflow: hidden;
        }

        /* 2. The Three-Column Layout Strategy */
        .profile-expanded-content {
            display: flex;
            align-items: flex-start; /* Align to top to allow scrolling */
            justify-content: center;
            gap: 40px;
            height: 90vh;
            max-width: 1800px;
            margin: 0 auto;
        }

        /* 3. The Side Panels (Personal & Professional) */
        .expanded-side-panel {
            flex: 1; /* Takes equal remaining space */
            background: #ffffff;
            border-radius: 24px;
            padding: 2.5rem;
            height: 85vh; /* Fixed height for the panel */
            overflow-y: auto; /* Enable scrolling for long lists (Diplomas/Grades) */
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Custom Scrollbar for the panels */
        .expanded-side-panel::-webkit-scrollbar {
            width: 6px;
        }
        .expanded-side-panel::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        /* 4. The Center Image (600x600) */
        .expanded-image-center {
            flex: 0 0 600px; /* Force exactly 600px width */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .expanded-image-center img,
        .expanded-image-center .rounded-circle {
            width: 600px !important;
            height: 600px !important;
            object-fit: cover;
            border-radius: 40px !important; /* Slightly more rectangular-round for the big view */
            border: 12px solid white !important;
            box-shadow: 0 0 40px rgba(0,0,0,0.6);
            transition: transform 0.3s ease;
        }

        /* 5. Typography and Cleanup in Expanded View */
        .expanded-side-panel h3 {
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 15px;
            margin-bottom: 25px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Ensure original cards look good inside the panels */
        .expanded-side-panel .card {
            box-shadow: none !important;
            border: 1px solid #f1f5f9 !important;
            margin-bottom: 1.5rem;
        }

        /* 6. Return Button Styling */
        .btn-close-expanded {
            position: absolute;
            top: 20px;
            right: 40px;
            z-index: 10001;
            padding: 12px 30px;
            font-size: 1.1rem;
            border-radius: 50px;
            background: #ef4444;
            color: white;
            border: none;
            font-weight: bold;
        }

        /* Styling for the structural info when inside the dark overlay */
        #imageDest .text-dark {
            color: #e2e8f0 !important; /* Lighten text for dark background */
        }
        #imageDest .bg-light {
            background-color: rgba(255, 255, 255, 0.05) !important; /* Subtle transparent background */
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
        }
        #imageDest .badge.bg-info {
            background-color: #0ea5e9 !important; /* Ensure visibility */
        }
    </style>

    <div id="profileOverlay" class="profile-expanded-overlay">
        <div class="text-center mb-3">
            <button class="btn btn-danger btn-rounded fw-bold px-5 shadow" onclick="closeProfile()">
                <i class="bi bi-x-circle me-2"></i>Quitter le mode plein écran
            </button>
        </div>

        <div class="profile-expanded-content">
            <div class="expanded-side-panel" id="personalDest">
            </div>

            <div class="expanded-image-center" id="imageDest">
            </div>

            <div class="expanded-side-panel" id="professionalDest">
            </div>
        </div>
    </div>

    <div class="container-fluid py-4">
        {{-- En-tête Profil Premium --}}
        <div class="card border-0 shadow-lg rounded-4 mb-4 overflow-hidden">
            {{-- Header Section --}}
            <div class="bg-primary bg-gradient p-4 text-white position-relative">

                {{-- FIX 1: Added pointer-events: none so this doesn't block clicks --}}
                <div class="position-absolute top-0 end-0 p-4 opacity-10" style="pointer-events: none; z-index: 0;">

                </div>

                <div class="position-relative" style="z-index: 1;">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-4">

                        {{-- Left Side: Avatar & Identity --}}
                        <div class="d-flex align-items-center gap-4">
                            <div class="position-relative">
                                {{-- FIX 2: Added 'employee-avatar' class and higher z-index --}}
                                @if($employee->photo && Storage::disk('public')->exists($employee->photo))
                                    <img src="{{ Storage::url($employee->photo) }}"
                                         alt="{{ $employee->firstname }}"
                                         class="employee-avatar rounded-circle border border-4 border-white shadow-lg object-fit-cover"
                                         width="110" height="110"
                                         style="cursor: pointer; position: relative; z-index: 10;">
                                @else
                                    <div class="employee-avatar rounded-circle border border-4 border-white d-flex align-items-center justify-content-center text-white fw-bold shadow-lg fs-1"
                                         style="width:110px;height:110px;background:linear-gradient(135deg,#6366f1 0%,#a855f7 100%); cursor: pointer; position: relative; z-index: 10;">
                                        {{ strtoupper(substr($employee->firstname,0,1)) }}{{ strtoupper(substr($employee->lastname,0,1)) }}
                                    </div>
                                @endif
                                {{-- Status Dot: pointer-events: none ensures it doesn't block the corner of the image --}}
                                <span class="position-absolute bottom-0 end-0 p-2 bg-{{ $employee->status == 1 ? 'success' : 'danger' }} border border-3 border-white rounded-circle shadow"
                                      style="z-index: 11; pointer-events: none;"></span>
                            </div>

                            <div>
                                <h1 class="h3 fw-bold mb-2 text-white">{{ $employee->firstname }} {{ strtoupper($employee->lastname) }}</h1>
                                <div class="d-flex flex-wrap gap-2 mb-3">
                            <span class="badge bg-white bg-opacity-25 text-white border border-white border-opacity-50 rounded-pill px-3 py-2">
                                <i class="bi bi-hash me-1"></i>PPR: {{ $employee->ppr }}
                            </span>
                                    @if($employee->cin)
                                        <span class="badge bg-white bg-opacity-25 text-white border border-white border-opacity-50 rounded-pill px-3 py-2">
                                    <i class="bi bi-person-vcard me-1"></i>{{ $employee->cin }}
                                </span>
                                    @endif
                                </div>
                                <span class="badge rounded-pill bg-{{ $employee->status == 1 ? 'success' : 'danger' }} px-3 py-2 fw-bold shadow-sm">
                            <i class="bi {{ $employee->status == 1 ? 'bi-check-circle-fill' : 'bi-x-circle-fill' }} me-2"></i>
                            {{ $employee->status == 1 ? 'Agent Actif' : 'Agent Inactif' }}
                        </span>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex gap-2">
                            <a href="{{ route('employees.index') }}" class="btn btn-light btn-sm px-4 fw-bold rounded-pill shadow-sm">
                                <i class="bi bi-arrow-left me-2"></i>Retour
                            </a>

                            <a href="{{ route('employees.edit', $employee) }}" class="btn btn-warning btn-sm px-4 fw-bold rounded-pill shadow-sm">
                                <i class="bi bi-pencil-square me-2"></i>Modifier
                            </a>

                            <button type="button"
                                    class="btn btn-info btn-sm px-4 fw-bold rounded-pill shadow-sm text-white"
                                    data-bs-toggle="modal"
                                    data-bs-target="#changeStateModal">
                                <i class="bi bi-pencil-square me-2"></i>Situation
                            </button>

                        </div>
                    </div>
                </div>
            </div>

            <x-change-situation-emmployee :employee="$employee" />

            {{-- Body Affectation --}}
            @include('app.employees.partials.hsitory_affectation', ['employees' => $employee])

        </div>

        <div class="row g-4">
            {{-- Colonne Gauche : Identité & Contact --}}
            <div class="col-lg-4 d-flex flex-column gap-4">

                @include('app.employees.partials.employee_information_peronnel', ['employee' => $employee])

                @if ($employee->category_id != 1)
                    @include('app.employees.partials.employee_other_information', ['employee' => $employee])
                @endif
            </div>

            {{-- Colonne Droite : Professionnel & Cursus --}}
            <div class="col-lg-8 d-flex flex-column gap-4">

                @include('app.employees.partials.employee_prof_info', ['employee' => $employee])

                @include('app.employees.partials.employee_grade_qualification', ['employee' => $employee])
            </div>
        </div>
    </div>

    {{-- Modals --}}
    <x-affect-occupation-modal :employee="$employee" :occupations="$occupations" />
    <x-affect-diploma-modal :employee="$employee" :diplomas="$diplomas" :options="$options" />
    <x-affect-grade-modal :employee="$employee" :levels="$levels" :grades="$grades" />

    <style>
        .hover-lift:hover { transform: translateY(-4px); transition: all 0.2s ease-in-out; }
        .ls-1 { letter-spacing: 0.5px; }
        .extra-small { font-size: 0.72rem; }
        .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
        .btn-white { background: #fff; color: #4f46e5; border: none; }
        .btn-white:hover { background: #f8f9fa; color: #4338ca; }
        .btn-primary-light { background: rgba(255,255,255,0.15); border: none; color: #fff; }
        .btn-primary-light:hover { background: rgba(255,255,255,0.25); }
        .btn-rounded { border-radius: 50px; }
        .bg-light-subtle { background-color: #f8f9fa !important; }
        .border-dashed { border-style: dashed !important; border-width: 2px !important; }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('dblclick', function(e) {
                const trigger = e.target.closest('.employee-avatar');

                if (trigger) {
                    // 1. Setup the Image/Avatar for the Overlay
                    const imageContainer = document.getElementById('imageDest');
                    if (imageContainer) {
                        // Clone the image
                        const imgClone = trigger.cloneNode(true);
                        imgClone.style.cursor = 'default';

                        imageContainer.innerHTML = '';
                        imageContainer.appendChild(imgClone);

                        // --- NEW STEP: Grab and Inject Structural Info ---
                        // Find the structural info inside the main card body
                        const structuralSource = document.querySelector('.card-body.p-4.bg-white');
                        if (structuralSource) {
                            const structuralClone = structuralSource.cloneNode(true);

                            // Create a wrapper for styling
                            const infoWrapper = document.createElement('div');
                            infoWrapper.className = 'mt-4 w-100 text-start px-4 overflow-auto';
                            infoWrapper.style.maxHeight = '200px'; // Prevent it from pushing too far down
                            infoWrapper.innerHTML = structuralClone.innerHTML;

                            imageContainer.appendChild(infoWrapper);
                        }
                    }

                    // 2. Grab Personal Info (Left Column)
                    const personalSource = document.querySelector('.col-lg-4');
                    const personalDest = document.getElementById('personalDest');
                    if (personalSource && personalDest) {
                        const personalClone = personalSource.cloneNode(true);
                        personalClone.querySelectorAll('.btn, a.btn').forEach(btn => btn.remove());
                        personalDest.innerHTML = '<h3 class="mb-4 fw-bold text-primary border-bottom pb-2">Dossier Personnel</h3>' + personalClone.innerHTML;
                    }

                    // 3. Grab Professional Info (Right Column)
                    const professionalSource = document.querySelector('.col-lg-8');
                    const professionalDest = document.getElementById('professionalDest');
                    if (professionalSource && professionalDest) {
                        const professionalClone = professionalSource.cloneNode(true);
                        professionalClone.querySelectorAll('.btn, a.btn').forEach(btn => btn.remove());
                        professionalDest.innerHTML = '<h3 class="mb-4 fw-bold text-info border-bottom pb-2">Parcours & Qualifications</h3>' + professionalClone.innerHTML;
                    }

                    // 4. Display Overlay
                    const overlay = document.getElementById('profileOverlay');
                    if (overlay) {
                        overlay.style.display = 'block';
                        document.body.style.overflow = 'hidden';
                    }
                }
            });

            document.addEventListener('mouseover', function(e) {
                if (e.target.closest('.employee-avatar')) {
                    e.target.closest('.employee-avatar').style.cursor = 'zoom-in';
                }
            });
        });

        function closeProfile() {
            const overlay = document.getElementById('profileOverlay');
            if (overlay) {
                overlay.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === "Escape") closeProfile();
        });

        /****************** show/hidden update occupation ***********************************/
        const displayDiv = document.getElementById('sl_occupation_insert_agent');
        const formDiv = document.getElementById('box_inserted_occupation');
        const cancelBtn = document.getElementById('btn_cancel_occupation');

        // Function to show the form
        if (displayDiv) {
            displayDiv.addEventListener('dblclick', function () {
                displayDiv.classList.add('d-none');
                formDiv.classList.remove('d-none');

                // Focus the select to make it immediately usable
                const select = formDiv.querySelector('select');
                if (select) select.focus();
            });
        }

        // Function to reset to default state
        if (cancelBtn) {
            cancelBtn.addEventListener('click', function () {
                formDiv.classList.add('d-none');
                displayDiv.classList.remove('d-none');
            });
        }

        /****************** show/hidden update grade ***********************************/
            // --- Occupation Form Logic ---
        const occDisplay = document.getElementById('sl_occupation_insert_agent');
        const occForm = document.getElementById('box_inserted_occupation');
        const occCancel = document.getElementById('btn_cancel_occupation');

        if (occDisplay && occForm) {
            occDisplay.addEventListener('dblclick', () => {
                occDisplay.classList.add('d-none');
                occForm.classList.remove('d-none');
            });

            if (occCancel) {
                occCancel.addEventListener('click', () => {
                    occForm.classList.add('d-none');
                    occDisplay.classList.remove('d-none');
                });
            }
        }

        // --- Grade Form Logic ---
        const gradeDisplay = document.getElementById('sl_grade_display');
        const gradeForm = document.getElementById('box_grade_form_wrapper');
        const gradeCancel = document.getElementById('btn_cancel_grade'); // Unique ID

        if (gradeDisplay && gradeForm) {
            gradeDisplay.addEventListener('dblclick', (e) => {
                if (e.target.closest('.btn-outline-danger')) return;
                gradeDisplay.classList.add('d-none');
                gradeForm.classList.remove('d-none');
            });

            if (gradeCancel) {
                gradeCancel.addEventListener('click', () => {
                    gradeForm.classList.add('d-none');
                    gradeDisplay.classList.remove('d-none');
                });
            }
        }

        // --- Qualification Form Logic ---
        // 1. Handle Double Click on Rows
        document.querySelectorAll('.qualification-row').forEach(row => {
            row.addEventListener('dblclick', function (e) {
                // Don't trigger if they double-click the delete button specifically
                if (e.target.closest('button')) return;

                const formRow = this.nextElementSibling;

                if (formRow && formRow.classList.contains('qualification-form-row')) {
                    // Hide current row
                    this.classList.add('d-none');
                    // Show form row
                    formRow.classList.remove('d-none');

                    // Focus first input
                    const firstInput = formRow.querySelector('select, input');
                    if (firstInput) firstInput.focus();
                }
            });
        });

        // 2. Handle Cancel Buttons
        document.querySelectorAll('.btn-cancel-qualif').forEach(btn => {
            btn.addEventListener('click', function () {
                const formRow = this.closest('.qualification-form-row');
                const displayRow = formRow.previousElementSibling;

                formRow.classList.add('d-none');
                displayRow.classList.remove('d-none');
            });
        });

        // 3. Optional: Close on Escape key for the most recently opened form
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('.qualification-form-row:not(.d-none)').forEach(row => {
                    const cancelBtn = row.querySelector('.btn-cancel-qualif');
                    if (cancelBtn) cancelBtn.click();
                });
            }
        });

        function toggleGradeHistory() {
            const containerWithout = document.getElementById('box_grade_without_history_container');
            const containerWith = document.getElementById('box_grade_with_history_container');

            containerWithout.classList.toggle('d-none');
            containerWith.classList.toggle('d-none');
        }

    </script>
</x-layout>
