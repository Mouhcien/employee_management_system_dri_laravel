<div class="container-fluid py-4">
    <div class="row g-4">
        <div class="col-lg-4 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="card-title mb-0 fw-bold text-primary">
                        <i class="bi bi-people-fill me-2"></i>Liste des Agents
                    </h5>
                </div>
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-bottom py-3">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light border-end-0" id="search-addon">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text"
                                   class="form-control bg-light border-start-0 ps-0"
                                   id="input_employee"
                                   placeholder="Search by name or PPR..."
                                   aria-label="Search"
                                   aria-describedby="search-addon">
                        </div>
                    </div>

                    <div class="list-group list-group-flush overflow-auto custom-scrollbar" style="max-height: 700px;" id="employee-list">
                        @foreach($employees as $employee)
                            @php
                                $fullName = $employee->lastname . ' ' . $employee->firstname;
                                $isActive = request('emp') == $employee->id;
                            @endphp
                            <a href="{{ request()->fullUrlWithQuery(['emp' => $employee->id]) }}"
                               class="list-group-item list-group-item-action py-3 border-start border-4 employee-item {{ $isActive ? 'border-primary bg-primary bg-opacity-10' : 'border-transparent' }}"
                               data-search-term="{{ strtolower($fullName) }} {{ $employee->ppr }}">

                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-3 rounded-circle d-flex align-items-center justify-content-center fw-bold {{ $isActive ? 'bg-primary text-white' : 'bg-light text-primary border' }}"
                                         style="width: 40px; height: 40px; min-width: 40px; font-size: 0.85rem;">
                                        {{ strtoupper(substr($employee->firstname, 0, 1)) }}{{ strtoupper(substr($employee->lastname, 0, 1)) }}
                                    </div>

                                    <div class="overflow-hidden">
                                        <h6 class="mb-0 text-truncate {{ $isActive ? 'fw-bold' : 'fw-semibold' }}" style="font-size: 0.9rem;">
                                            {{ strtoupper($employee->lastname) }} {{ $employee->firstname }}
                                        </h6>
                                        <div class="d-flex align-items-center mt-1">
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary border-0 fw-normal" style="font-size: 0.7rem;">
                                                PPR: #{{ $employee->ppr }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <style>
                    /* Modern Scrollbar Styling */
                    .custom-scrollbar::-webkit-scrollbar {
                        width: 4px;
                    }
                    .custom-scrollbar::-webkit-scrollbar-track {
                        background: #f1f1f1;
                    }
                    .custom-scrollbar::-webkit-scrollbar-thumb {
                        background: #ccc;
                        border-radius: 10px;
                    }
                    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                        background: #bbb;
                    }

                    .border-transparent { border-left-color: transparent !important; }

                    .employee-item {
                        transition: all 0.2s ease;
                    }

                    .employee-item:hover {
                        background-color: #f8f9fa;
                        transform: translateX(2px);
                    }
                </style>

                <script>
                    // Fast Client-Side Filtering
                    document.getElementById('input_employee').addEventListener('keyup', function() {
                        let searchTerm = this.value.toLowerCase();
                        let items = document.querySelectorAll('.employee-item');

                        items.forEach(item => {
                            let text = item.getAttribute('data-search-term');
                            if (text.includes(searchTerm)) {
                                item.style.setProperty('display', 'block', 'important');
                            } else {
                                item.style.setProperty('display', 'none', 'important');
                            }
                        });
                    });
                </script>
            </div>
        </div>

        <div class="col-lg-8 col-xl-9">

            @if (isset($employeeObj) && !is_null($employeeObj))
            @php
                // Extraction de l'affectation active

                $current = $employeeObj->affectations->where('state', 1)->first();

                $service = $current?->service?->title;

                $entity = $current?->entity?->title;

                $entityType = $current?->entity?->type?->title;

                $sector = $current?->sector?->title;

                $section = $current?->section?->title;

            @endphp
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="position-relative shadow-sm rounded-4 overflow-hidden"
                     style="height: 300px; background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);">

                    <div class="d-flex flex-column align-items-center justify-content-center h-100 text-center">

                        <div class="position-relative mb-3">
                            @php
                                $photoExists = $employeeObj->photo && Storage::disk('public')->exists($employeeObj->photo);
                            @endphp

                            @if($photoExists)
                                <img src="{{ Storage::url($employeeObj->photo) }}"
                                     {{-- ADDED CLASSES AND STYLE BELOW --}}
                                     class="employee-avatar employee-photo-thumb rounded-circle border border-4 border-white shadow-lg object-fit-cover bg-white"
                                     width="200" height="200" style="cursor: zoom-in; position: relative; z-index: 10;">
                            @else
                                <div class="employee-avatar rounded-circle border border-4 border-white shadow-lg d-flex align-items-center justify-content-center text-white fw-bold h1 mb-0"
                                     style="width:160px; height:160px; background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); cursor: zoom-in;">
                                    {{ strtoupper(substr($employeeObj->firstname, 0, 1)) }}{{ strtoupper(substr($employeeObj->lastname, 0, 1)) }}
                                </div>
                            @endif

                            {{-- Pointer-events: none added here so the dot doesn't block the click --}}
                            <span class="position-absolute bottom-0 end-0 mb-1 me-1 p-2 bg-{{ $employeeObj->status == 1 ? 'success' : 'danger' }} border border-3 border-white rounded-circle shadow" style="pointer-events: none; z-index: 11;"></span>
                        </div>

                        <div class="px-3">
                            <h2 class="mb-1 fw-bold text-white text-uppercase tracking-tight">
                                {{ $employeeObj->firstname }} {{ $employeeObj->lastname }}
                            </h2>
                            <p class="text-white-50 mb-0 fw-medium opacity-90" dir="rtl" style="font-size: 1.25rem;">
                                {{ $employeeObj->firstname_arab }} {{ $employeeObj->lastname_arab }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card-body mt-5 pt-4 px-4 ">
                    <div class="row g-3 mb-4">
                        <div class="col-md-2">
                            <div class="p-3 border rounded-3 text-center  {{ \Carbon\Carbon::parse($employeeObj->birth_date)->age >= 63 ? 'bg-danger-subtle' : 'bg-light' }}">
                                <small class="text-muted d-block text-uppercase fw-bold ls-1">Age</small>
                                <span class="fw-bold text-dark">{{ \Carbon\Carbon::parse($employeeObj->birth_date)->age }} Ans</span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="p-3 border rounded-3 text-center bg-light">
                                <small class="text-muted d-block text-uppercase fw-bold ls-1">Matricule (PPR)</small>
                                <span class="fw-bold text-dark">#{{ $employeeObj->ppr }}</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 border rounded-3 text-center bg-light">
                                <small class="text-muted d-block text-uppercase fw-bold ls-1">Identité (CIN)</small>
                                <span class="fw-bold text-dark">{{ $employeeObj->cin }}</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 border rounded-3 text-center bg-light">
                                <small class="text-muted d-block text-uppercase fw-bold ls-1">Date Recrutement</small>
                                <span class="fw-bold text-dark">{{ \Carbon\Carbon::parse($employeeObj->hiring_date)->format('d M Y') }}</span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="p-3 border rounded-3 text-center bg-light">
                                <small class="text-muted d-block text-uppercase fw-bold ls-1">Contact</small>
                                <span class="fw-bold text-dark">{{ $employeeObj->tel ?? '—' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="row pb-4">
                        @if ($employeeObj->status == "-1")
                            <span class="badge bg-danger-subtle text-dark border font-monospace extra-small" >
                                    Mise à la retraite le
                                    {{ \Carbon\Carbon::parse($employeeObj->retiring_date)->translatedFormat('d M Y') }}
                                </span>
                        @elseif ($employeeObj->status == "0") {{-- mise a disposition --}}
                        <span class="badge bg-warning-subtle text-dark border font-monospace extra-small" >
                                    Mise à la disposition le
                                    {{ \Carbon\Carbon::parse($employeeObj->disposition_date)->translatedFormat('d M Y') }}
                                </span>
                        @elseif ($employeeObj->status == "2") {{-- Suspension immédiate --}}
                        <span class="badge bg-danger text-dark border font-monospace extra-small" >
                                Suspendu le
                                {{ \Carbon\Carbon::parse($employeeObj->retiring_date)->translatedFormat('d M Y') }}
                                </span>
                        @endif
                    </div>

                    <div class="row g-4">
                        <div class="col-md-7">
                            <div class="p-4 rounded-4 border-0 shadow-sm bg-primary bg-opacity-10 h-100">
                                <h6 class="fw-bold text-primary text-uppercase mb-4">
                                    <i class="bi bi-diagram-3-fill me-2"></i>Affectation Structurelle
                                </h6>
                                <table class="table table-borderless table-sm mb-0">
                                    <tr class="align-middle">
                                        <td class="text-muted py-2">Service</td>
                                        <td class="fw-bold text-end">{{ $service ?: 'N/A' }}</td>
                                    </tr>
                                    <tr class="align-middle border-top border-white">
                                        <td class="text-muted py-2">{{ $entityType ?: 'Entité' }}</td>
                                        <td class="fw-bold text-end">{{ $entity ?: 'N/A' }}</td>
                                    </tr>
                                    @if($sector)
                                        <tr class="align-middle border-top border-white">
                                            <td class="text-muted py-2">Secteur</td>
                                            <td class="fw-bold text-end">{{ $sector }}</td>
                                        </tr>
                                    @endif
                                    @if($section)
                                        <tr class="align-middle border-top border-white">
                                            <td class="text-muted py-2">Section</td>
                                            <td class="fw-bold text-end">{{ $section }}</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="p-4 rounded-4 border-0 shadow-sm bg-success bg-opacity-10 h-100">
                                <h6 class="fw-bold text-success text-uppercase mb-4">
                                    <i class="bi bi-geo-alt-fill me-2"></i>Géolocalisation
                                </h6>
                                <div class="mb-3 d-flex align-items-center">
                                    <div class="bg-white p-2 rounded-circle me-3 text-success shadow-sm">
                                        <i class="bi bi-building"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Local</small>
                                        <span class="fw-bold">{{ $employeeObj->local->title ?? 'N/A' }}</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="bg-white p-2 rounded-circle me-3 text-success shadow-sm">
                                        <i class="bi bi-geo"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Ville</small>
                                        <span class="fw-bold">{{ $employeeObj->local->city->title ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top text-center">
                        <span class="text-muted">Professional Email: </span>
                        <a href="mailto:{{ $employeeObj->email }}" class="text-decoration-none fw-bold">{{ $employeeObj->email }}</a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<div id="employee-photo-preview" style="display: none; position: fixed; z-index: 10000; width: 500px; height: 500px; border-radius: 20px; overflow: hidden; box-shadow: 0 15px 50px rgba(0,0,0,0.3); border: 5px solid white; pointer-events: none; background-color: #fff;">
    <img src="" alt="Aperçu" style="width: 100%; height: 100%; object-fit: cover;">
</div>

<style>
    .avatar-hover { transition: transform 0.3s ease; }
    .avatar-hover:hover { transform: scale(1.05); }
    .ls-1 { letter-spacing: 0.5px; }
    .extra-small { font-size: 0.7rem; }
    .border-transparent { border-left-color: transparent !important; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const previewContainer = document.getElementById('employee-photo-preview');
        const previewImg = previewContainer.querySelector('img');

        // --- 1. HOVER PREVIEW LOGIC ---
        document.addEventListener('mouseover', function(e) {
            const thumb = e.target.closest('.employee-photo-thumb');
            if (thumb) {
                previewImg.src = thumb.src;
                previewContainer.style.display = 'block';
            }
        });

        document.addEventListener('mousemove', function(e) {
            if (previewContainer.style.display === 'block') {
                let x = e.clientX + 20;
                let y = e.clientY + 20;

                if (x + 400 > window.innerWidth) x = e.clientX - 420;
                if (y + 400 > window.innerHeight) y = e.clientY - 420;

                previewContainer.style.left = x + 'px';
                previewContainer.style.top = y + 'px';
            }
        });

        document.addEventListener('mouseout', function(e) {
            if (e.target.closest('.employee-photo-thumb')) {
                previewContainer.style.display = 'none';
            }
        });

        // --- 2. DOUBLE CLICK EXPANDED MODE ---
        document.addEventListener('dblclick', function(e) {
            const avatar = e.target.closest('.employee-avatar');
            if (avatar) {
                previewContainer.style.display = 'none'; // Hide preview immediately

                const imageDest = document.getElementById('imageDest');
                const personalDest = document.getElementById('personalDest');
                const professionalDest = document.getElementById('professionalDest');
                const overlay = document.getElementById('profileOverlay');

                if (!overlay) return;

                // Clone Image to Center
                const imgClone = avatar.cloneNode(true);
                imgClone.style.width = '600px';
                imgClone.style.height = '600px';
                imageDest.innerHTML = '';
                imageDest.appendChild(imgClone);

                // Clone the 'Affectation' and 'Geolocalisation' boxes into the center under image
                const infoBoxes = document.querySelector('.card-body.mt-5').cloneNode(true);
                imageDest.appendChild(infoBoxes);

                // Optionally fill side panels if they exist in your x-layout
                personalDest.innerHTML = '<h3 class="text-primary">Info Agent</h3>' + document.querySelector('.px-3').innerHTML;

                overlay.style.display = 'block';
                document.body.style.overflow = 'hidden';
            }
        });
    });

    // Full Screen Close Logic
    function closeProfile() {
        document.getElementById('profileOverlay').style.display = 'none';
        document.body.style.overflow = 'auto';
    }
</script>
