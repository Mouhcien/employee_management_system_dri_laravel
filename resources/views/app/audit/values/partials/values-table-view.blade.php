

@php
    // 1. Force PHP to allocate more memory since the controller lacks eager loading
    ini_set('memory_limit', '1024M');
@endphp

@if (count($values) != 0)
    @php
        // 2. Group the data by Table Title right inside the template
        $valuesByTable = $values->groupBy(fn($entry) => $entry->relation->table->title ?? 'Unknown Table');
    @endphp

    @foreach($valuesByTable as $tableName => $tableEntries)
        @php
            // 3. Group this specific table's records by period, sorted by year descending
            $valuesByPeriod = $tableEntries->groupBy('period_id')->sortByDesc(fn($group) => $group->first()->period->year ?? 0);
        @endphp

        <div class="card border-0 shadow-sm mb-5 rounded-4 overflow-hidden">
            <div class="card-header bg-dark py-3 px-4 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 text-white fw-bold">
                    <i class="bi bi-table me-2 text-primary"></i> Récapitulatif par Période : {{ $tableName }}
                </h6>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill">Indicateurs</span>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="bg-light-subtle border-bottom">
                        <tr>
                            <th class="ps-4 py-3 text-muted small fw-bolder text-uppercase" style="width: 30%;">Période</th>
                            <th class="py-3 text-center text-dark fw-bold border-start" style="width: 35%;">Nombre de {{ $tableName }}</th>
                            <th class="py-3 text-center text-dark fw-bold border-start" style="width: 35%;">Total Montant</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($valuesByPeriod as $periodId => $periodEntries)
                            @php
                                $period = $periodEntries->first()->period;
                                $safeId = md5($tableName . '_' . $periodId); // Unique component key

                                $pprCount = $periodEntries->filter(function($entry) {
                                    return ($entry->relation->column->title ?? '') === 'PPR_affectataire';
                                })->count();

                                // Define fallback priority hierarchy
                                $priorityColumns = ['Montant_recouvré', 'Montant_accord', 'Montant_recette'];

                                // Dynamically determine highest-priority column present
                                $activeColumnTitle = collect($priorityColumns)->first(function ($columnTitle) use ($periodEntries) {
                                    return $periodEntries->contains(fn($entry) => ($entry->relation->column->title ?? '') === $columnTitle);
                                });

                                // Filter entries matching chosen priority column
                                $montantEntries = $activeColumnTitle
                                    ? $periodEntries->filter(fn($entry) => ($entry->relation->column->title ?? '') === $activeColumnTitle)
                                    : collect();

                                $totalMontant = $montantEntries->sum('value');
                            @endphp

                            <tr class="align-middle">
                                <td class="ps-4 bg-light-subtle">
                                    <div class="fw-bold text-dark">{{ $period->title ?? 'N/A' }} {{ $period->year ?? '' }}</div>
                                </td>

                                <td class="text-center border-start">
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill px-3 py-2 fw-bold fs-6">
                                        {{ $pprCount }}
                                    </span>
                                </td>

                                <td class="text-center border-start">
                                    <div class="d-inline-flex align-items-center gap-2 p-2 bg-white border rounded shadow-xs justify-content-center">
                                        <span class="fw-black text-primary fs-6 me-1">
                                            {{ number_format($totalMontant, 2, ',', ' ') }} DH
                                        </span>
                                        <button class="btn btn-sm btn-outline-secondary py-1 px-2 border-0 rounded-2 toggle-details-btn"
                                                type="button"
                                                data-target="details-montant-{{ $safeId }}"
                                                title="Voir le détail">
                                            <i class="bi bi-eye"></i> Détails
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr class="border-0">
                                <td colspan="3" class="p-0 border-0">
                                    <div class="w-100 d-none details-container" id="details-montant-{{ $safeId }}">
                                        <div class="px-4 py-3 bg-light border-start border-primary border-4 shadow-inner">
                                            <h6 class="small fw-bold text-uppercase text-muted mb-2">
                                                <i class="bi bi-calendar-check me-1 text-primary"></i> Détail des montants :
                                            </h6>
                                            @if($montantEntries->count() > 0)
                                                <div class="d-flex flex-wrap gap-2">
                                                    @foreach($montantEntries as $detail)
                                                        <div class="bg-white px-3 py-2 rounded-3 border shadow-sm text-secondary small d-flex align-items-center gap-2">
                                                            <span class="badge bg-light text-muted border">
                                                                <i class="bi bi-clock me-1"></i>
                                                                {{ $detail->date_recouvrement ?? 'N/A' }}
                                                            </span>
                                                            <strong class="text-dark">
                                                                {{ number_format($detail->value, 2, ',', ' ') }} DH
                                                            </strong>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="text-muted small italic">
                                                    <i class="bi bi-info-circle me-1"></i> Aucun montant enregistré pour cette période.
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
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
            <p class="mt-2 fw-bold">Aucune valeur saisie pour cet employé</p>
        </div>
    </div>
@endif

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.toggle-details-btn').forEach(function (button) {
            button.addEventListener('click', function () {
                const targetId = this.getAttribute('data-target');
                const targetElement = document.getElementById(targetId);

                if (targetElement) {
                    // Toggles Bootstrap's visibility helper class natively
                    targetElement.classList.toggle('d-none');

                    // Optional: Toggle the eye icon visual state
                    const icon = this.querySelector('i');
                    if (icon) {
                        if (targetElement.classList.contains('d-none')) {
                            icon.className = 'bi bi-eye';
                        } else {
                            icon.className = 'bi bi-eye-slash';
                        }
                    }
                }
            });
        });
    });
</script>

