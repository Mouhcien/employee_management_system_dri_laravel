<div id="box_affectation_without_history" class="card-body p-4 bg-white">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="text-uppercase text-primary fw-bolder ls-1 small mb-0">
            <i class="bi bi-diagram-3-fill me-2"></i>Affectation Structurelle Active
        </h6>
        <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="toggleAffectationHistory()">
            <i class="bi bi-clock-history me-1"></i> Voir l'historique
        </button>
    </div>

    @php $activeAff = $employee->affectations->where('state', 1)->first(); @endphp
    @if($activeAff)
        <div class="mb-3">
            @if (!is_null($activeAff->section))
                <span class="badge bg-info"> {{ $activeAff->section->title }} </span>
            @endif
            @if (!is_null($activeAff->sector))
                <span class="badge bg-info"> {{ $activeAff->sector->title }} </span>
            @endif
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <div class="p-3 rounded-4 bg-light border-start border-4 border-primary h-100">
                    <small class="text-muted d-block mb-1 fw-bold text-uppercase" style="font-size: 0.7rem;">Service</small>
                    <span class="fw-bold text-dark fs-5">{{ $activeAff->service->title ?? 'N/A' }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-3 rounded-4 bg-light border-start border-4 border-info h-100">
                    <small class="text-muted d-block mb-1 fw-bold text-uppercase" style="font-size: 0.7rem;">Direction / Entité</small>
                    <span class="fw-bold text-dark fs-5">{{ $activeAff->entity->title ?? 'N/A' }}</span>
                </div>
            </div>
        </div>
    @else
        <div class="text-center p-5 bg-light rounded-4 border border-dashed">
            <i class="bi bi-exclamation-circle text-muted fs-2 opacity-50"></i>
            <p class="text-muted small mb-0 mt-2">Aucune affectation active enregistrée.</p>
            <a class="dropdown-item rounded-3 py-2" href="{{ route('employees.unities', $employee) }}"><i class="bi bi-diagram-3 text-primary me-2"></i>Gérer l'affectation</a>
        </div>
    @endif
</div>

<div id="box_affectation_with_history" class="card-body p-4 bg-white d-none">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h6 class="text-uppercase text-secondary fw-bolder ls-1 small mb-0">
            <i class="bi bi-clock-history me-2"></i>Historique des Affectations
        </h6>
        <button type="button" class="btn btn-sm btn-light border rounded-pill px-3" onclick="toggleAffectationHistory()">
            <i class="bi bi-arrow-left me-1"></i> Retour
        </button>
    </div>

    @if($employee->affectations->count() > 0)
        @foreach($employee->affectations->sortByDesc('affectation_date') as $affectation)
            <h6 class="text-uppercase text-primary fw-bolder mb-3 ls-1 small">
                <i class="bi bi-diagram-3-fill me-2"></i>Affectation <i class="bi bi-arrow-right"></i> {{ \Carbon\Carbon::parse($affectation->affectation_date)->format('d/m/Y') }} :
                @if (!is_null($affectation->section))
                    <span class="badge bg-info"> {{ $affectation->section->title }} </span>
                @endif
                @if (!is_null($affectation->sector))
                    <span class="badge bg-info"> {{ $affectation->sector->title }} </span>
                @endif
            </h6>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="p-3 rounded-4 bg-light border-start border-4 border-primary h-100">
                        <small class="text-muted d-block mb-1 fw-bold text-uppercase" style="font-size: 0.7rem;">Service</small>
                        <span class="fw-bold text-dark fs-5">{{ $affectation->service->title ?? 'N/A' }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 rounded-4 bg-light border-start border-4 border-info h-100">
                        <small class="text-muted d-block mb-1 fw-bold text-uppercase" style="font-size: 0.7rem;">Direction / Entité</small>
                        <span class="fw-bold text-dark fs-5">{{ $affectation->entity->title ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
            <hr>
        @endforeach
    @else
        <div class="text-center p-5 bg-light rounded-4 border border-dashed">
            <i class="bi bi-exclamation-circle text-muted fs-2 opacity-50"></i>
            <p class="text-muted small mb-0 mt-2">Aucun historique d'affectation trouvé.</p>
        </div>
    @endif
</div>


<script>
    function toggleAffectationHistory() {
        const boxWithout = document.getElementById('box_affectation_without_history');
        const boxWith = document.getElementById('box_affectation_with_history');

        if (boxWithout.classList.contains('d-none')) {
            boxWithout.classList.remove('d-none');
            boxWith.classList.add('d-none');
        } else {
            boxWithout.classList.add('d-none');
            boxWith.classList.remove('d-none');
        }
    }
</script>
