<x-layout>
    <div class="container-fluid py-4 px-5">
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form action="{{ route('holidays.store') }}" method="POST">
                            @csrf

                            <div class="row g-4">
                                <div class="col-md-12">
                                    <label for="employee_id" class="form-label fw-bold">Agent / Détaché</label>
                                    <select class="form-select @error('employee_id') is-invalid @enderror" id="employee_id" name="employee_id" required>
                                        <option value="" selected disabled>Choisir un agent...</option>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->lastname }} ({{ $employee->category_id == 3 ? 'Détaché' : 'Communal' }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('employee_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="year" class="form-label fw-bold">Année de référence</label>
                                    <input type="number" class="form-control" id="year" name="year" value="{{ old('year', now()->year) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="starting_date" class="form-label fw-bold">Date de début</label>
                                    <input type="date" class="form-control" id="starting_date" name="starting_date" value="{{ old('starting_date') }}" required>
                                </div>

                                <hr class="my-4 text-muted">

                                <div class="col-md-4">
                                    <label for="total_year" class="form-label fw-bold text-primary">Droit Annuel (Jours)</label>
                                    <input type="number" class="form-control bg-light-primary" id="total_year" name="total_year" value="{{ old('total_year', 22) }}" required>
                                </div>

                                <div class="col-md-4">
                                    <label for="demand" class="form-label fw-bold text-danger">Jours Demandés</label>
                                    <input type="number" class="form-control bg-light-danger" id="demand" name="demand" value="{{ old('demand', 0) }}" required>
                                </div>

                                <div class="col-md-4">
                                    <label for="total_rest" class="form-label fw-bold text-success">Solde Restant calculé</label>
                                    <input type="number" class="form-control bg-light-success fw-bold text-success" id="total_rest" name="total_rest" value="{{ old('total_rest', 22) }}" readonly>
                                    <small id="calc_info" class="text-muted text-truncate d-block">Basé sur le droit annuel</small>
                                </div>
                            </div>

                            <div class="mt-5 d-flex gap-2">
                                <button type="submit" class="btn btn-primary px-5 shadow-sm">Enregistrer</button>
                                <a href="{{ route('holidays.index') }}" class="btn btn-light px-4 border">Annuler</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm bg-primary text-white mb-4">
                    <div class="card-body p-4">
                        <h5><i class="bi bi-info-circle me-2"></i>Aide au calcul</h5>
                        <p class="small opacity-75">Le solde restant est calculé par la soustraction des jours demandés au droit annuel total.</p>
                        <hr class="border-white opacity-25">
                        <ul class="list-unstyled small mb-0">
                            <li class="mb-2"><i class="bi bi-check-circle me-2"></i>Droit standard : 22 jours</li>
                            <li><i class="bi bi-check-circle me-2"></i>Détachés : Vérifiez l'arrêté de détachement</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. On récupère les derniers soldes des employés envoyés par le contrôleur
            // Note: Dans votre contrôleur, faites : $employees = Employee::with(['holidays' => fn($q) => $q->latest()->limit(1)])->get();
            const lastHolidays = {
                @foreach($employees as $employee)
                "{{ $employee->id }}": {{ $employee->holidays->last()->total_rest ?? 'null' }},
                @endforeach
            };

            const employeeSelect = document.getElementById('employee_id');
            const totalYearInput = document.getElementById('total_year');
            const demandInput = document.getElementById('demand');
            const totalRestInput = document.getElementById('total_rest');
            const calcInfo = document.getElementById('calc_info');

            function calculateRest() {
                const selectedId = employeeSelect.value;
                const lastRest = lastHolidays[selectedId];

                const currentTotalYear = parseFloat(totalYearInput.value) || 0;
                const currentDemand = parseFloat(demandInput.value) || 0;

                if (selectedId && lastRest !== null) {
                    // S'il existe un historique, on part du dernier total_rest
                    const finalRest = lastRest - currentDemand;
                    totalRestInput.value = finalRest;
                    calcInfo.innerText = "Déduit du dernier solde (" + lastRest + "j)";
                    calcInfo.classList.replace('text-muted', 'text-primary');
                } else {
                    // Calcul standard si nouvel agent
                    totalRestInput.value = currentTotalYear - currentDemand;
                    calcInfo.innerText = "Nouveau dossier (Droit - Demande)";
                    calcInfo.classList.replace('text-primary', 'text-muted');
                }
            }

            // Écouteurs d'événements
            employeeSelect.addEventListener('change', calculateRest);
            totalYearInput.addEventListener('input', calculateRest);
            demandInput.addEventListener('input', calculateRest);
        });
    </script>
</x-layout>
