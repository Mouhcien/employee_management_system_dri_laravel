<x-layout>

    <div class="container-fluid py-4 px-md-5">
        {{-- Header Professionnel --}}
        <div class="row align-items-center mb-5">
            <div class="col-md-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item small"><a href="#" class="text-muted text-decoration-none uppercase fw-bold ls-1">RH Dashboard</a></li>
                        <li class="breadcrumb-item small active text-primary fw-bold uppercase ls-1" aria-current="page">Gérer les participants de la formation</li>
                    </ol>
                </nav>
                <h1 class="h2 fw-extrabold text-dark mb-0">Formation : <span class="text-primary">{{ $training->title }}</span></h1>
                <p class="text-muted small">{{ $training->theme }}</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a class="btn btn-primary shadow-sm rounded-3 px-4 py-2 fw-bold" href="{{ route('trainings.create') }}">
                    <i class="bi bi-plus-lg me-2"></i>Nouvelle Formation
                </a>
            </div>
        </div>

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
                                <a href="javascript:void(0)"
                                   class="list-group-item list-group-item-action py-3 border-start border-4 employee-item border-transparent"
                                   data-id="{{ $employee->id }}"
                                   data-name="{{ strtoupper($employee->lastname) }} {{ $employee->firstname }}"
                                   data-ppr="{{ $employee->ppr }}"
                                   onclick="addEmployeeToForm(this)"
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
                <form action="{{ route('attendences.store', $training) }}" method="POST" id="attendance-form">
                    @csrf
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 fw-bold"><i class="bi bi-calendar-check me-2 text-success"></i>Feuille de Présence</h5>
                        </div>

                        <div class="card-body">
                            <div id="empty-state" class="text-center py-5">
                                <i class="bi bi-person-plus fs-1 text-muted opacity-25"></i>
                                <p class="text-muted mt-2">Cliquez sur un agent à gauche pour l'ajouter à la liste de présence</p>
                            </div>

                            <div id="selected-employees-container" class="row g-3"></div>

                            <div id="hidden-inputs"></div>
                        </div>

                        <div class="card-footer bg-light text-end py-3 d-none" id="form-actions">
                            <button type="button" class="btn btn-link text-muted" onclick="clearAll()">Vider la liste</button>
                            <button type="submit" class="btn btn-success px-4 fw-bold">
                                Enregistrer la présence (<span id="count-badge">0</span>)
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>


    </div>

    <script>
        const selectedEmployees = new Set();

        function addEmployeeToForm(element) {
            const id = element.getAttribute('data-id');
            const name = element.getAttribute('data-name');
            const ppr = element.getAttribute('data-ppr');

            // Éviter les doublons
            if (selectedEmployees.has(id)) {
                alert("Cet agent est déjà dans la liste.");
                return;
            }

            selectedEmployees.add(id);
            updateUI();

            // Créer la carte visuelle
            const container = document.getElementById('selected-employees-container');
            const card = document.createElement('div');
            card.className = "col-md-6 col-xl-4 animate__animated animate__fadeInIn";
            card.id = `card-emp-${id}`;
            card.innerHTML = `
        <div class="card h-100 border shadow-none bg-light bg-opacity-50">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div class="overflow-hidden">
                    <div class="fw-bold text-dark text-truncate" style="font-size: 0.85rem;">${name}</div>
                    <div class="text-muted small">PPR: #${ppr}</div>
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger border-0" onclick="removeEmployee('${id}')">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <input type="hidden" name="employee_ids[]" value="${id}">
        </div>
    `;
            container.appendChild(card);
        }

        function removeEmployee(id) {
            selectedEmployees.delete(id);
            document.getElementById(`card-emp-${id}`).remove();
            updateUI();
        }

        function updateUI() {
            const emptyState = document.getElementById('empty-state');
            const formActions = document.getElementById('form-actions');
            const countBadge = document.getElementById('count-badge');

            if (selectedEmployees.size > 0) {
                emptyState.classList.add('d-none');
                formActions.classList.remove('d-none');
                countBadge.innerText = selectedEmployees.size;
            } else {
                emptyState.classList.remove('d-none');
                formActions.classList.add('d-none');
            }
        }

        function clearAll() {
            if(confirm("Vider toute la liste ?")) {
                selectedEmployees.clear();
                document.getElementById('selected-employees-container').innerHTML = "";
                updateUI();
            }
        }
    </script>

</x-layout>
