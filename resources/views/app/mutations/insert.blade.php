<x-layout>
    <style>
        body { font-family: 'Inter', 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        .fw-extrabold { font-weight: 800; }
        .form-label { font-weight: 600; color: #475569; font-size: 0.875rem; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .input-group-text { background-color: #f1f5f9; border-right: none; }
        .form-control:focus, .form-select:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
    </style>

    <div class="container py-5">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 fw-extrabold text-dark mb-1"><i class="bi bi-shuffle me-1 text-primary"></i>Mutation <span class="text-muted">du Personnel</span></h1>
                <p class="text-muted small mb-0">Remplissez les informations ci-dessous pour acter le mouvement.</p>
            </div>
            <a href="{{ route('mutations.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                <i class="bi bi-arrow-left me-1"></i> Retour à la liste
            </a>
        </div>

        <div class="card bg-white">
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('mutations.store') }}" method="POST">
                    @csrf
                    <div class="row g-4">

                        <div class="col-12 border-bottom pb-3 mb-2">
                            <h5 class="text-primary fw-bold mb-0"><i class="bi bi-person-badge me-2"></i>Identification de l'Agent</h5>
                        </div>

                        <div class="col-md-6">
                            <label for="txt_employee_mutation" class="form-label">Rechercher un agent</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <input type="text" id="txt_employee_mutation" class="form-control" placeholder="Saisir un nom ou prénom...">
                            </div>
                            <div class="form-text">Filtre dynamiquement la liste déroulante à droite.</div>
                        </div>

                        <div class="col-md-6">
                            <label for="employee_id" class="form-label">Agent à muter <span class="text-danger">*</span></label>
                            <select name="employee_id" id="employee_id" class="form-select shadow-sm" required>
                                <option value="" selected disabled>Sélectionner l'agent...</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}" data-full-name="{{ strtolower($employee->lastname . ' ' . $employee->firstname) }}">
                                        {{ strtoupper($employee->lastname) }} {{ $employee->firstname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 border-bottom pb-3 mt-5 mb-2">
                            <h5 class="text-primary fw-bold mb-0"><i class="bi bi-geo-alt me-2"></i>Destination & Affectation</h5>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Entité d'accueil</label>
                            <input type="text" name="entity_name" class="form-control" placeholder="ex: Section/Secteur">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Direction</label>
                            <input type="text" name="direction_name" class="form-control" placeholder="ex: Ressources Humaines">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Ville de destination</label>
                            <input type="text" name="city_name" class="form-control" placeholder="ex: Casablanca">
                        </div>

                        <div class="col-12 border-bottom pb-3 mt-5 mb-2">
                            <h5 class="text-primary fw-bold mb-0"><i class="bi bi-calendar-date me-2"></i> Date de mutation</h5>
                        </div>

                        <div class="col-md-4">
                            <x-date-input name="starting_date" id="starting_date" />
                        </div>


                        <div class="col-12 d-flex justify-content-end gap-2 mt-4">
                            <button type="reset" class="btn btn-light px-4 border">Réinitialiser</button>
                            <button type="submit" class="btn btn-primary px-5 fw-bold shadow">
                                <i class="bi bi-check2-circle me-1"></i> Enregistrer la mutation
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('txt_employee_mutation');
            const employeeSelect = document.getElementById('employee_id');
            const originalOptions = Array.from(employeeSelect.options);

            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase().trim();

                // Clear the select
                employeeSelect.innerHTML = '';

                // Filter options
                const filteredOptions = originalOptions.filter(option => {
                    // Always keep the disabled placeholder
                    if (option.disabled) return true;

                    const fullName = option.getAttribute('data-full-name');
                    return fullName.includes(searchTerm);
                });

                // Re-append filtered options
                filteredOptions.forEach(option => {
                    employeeSelect.add(option);
                });

                // Automatically select the first match if it's not the placeholder
                if (filteredOptions.length > 1 && searchTerm !== '') {
                    // Optional: employeeSelect.selectedIndex = 1;
                }
            });
        });
    </script>
</x-layout>
