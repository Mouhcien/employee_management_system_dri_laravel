


<div class="col-md-12">
    <!-- Soft shadow and refined border radius -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3">
                    <i class="bi bi-journal-bookmark-fill text-primary"></i>
                </div>
                <h6 class="text-dark fw-bold mb-0">Parcours de Formation</h6>
            </div>
            <span class="badge bg-light text-dark border fw-medium">{{ $attendences->count() }} Formations</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-faded-light">
                <tr>
                    <th class="ps-4 py-3 text-uppercase text-secondary xxs-font fw-bolder ls-1 border-0">Détails de la Formation</th>
                    <th class="py-3 text-uppercase text-secondary xxs-font fw-bolder ls-1 text-center border-0">Volume Horaire</th>
                    <th class="py-3 text-uppercase text-secondary xxs-font fw-bolder ls-1 border-0">Calendrier</th>
                    <th class="py-3 text-uppercase text-secondary xxs-font fw-bolder ls-1 border-0">Année</th>
                    <th class="pe-4 py-3 text-end border-0"></th>
                </tr>
                </thead>
                <tbody class="border-top-0">
                @forelse($attendences->sortByDesc('training.starting_date') as $attendence)
                    <tr>
                        <td class="ps-4 py-4">
                            <div class="d-flex flex-column">
                                <span class="fw-semibold text-dark mb-1 h6">{{ $attendence->training->title ?? 'N/A' }}</span>
                                <span class="text-muted small d-flex align-items-center">
                                        <i class="bi bi-tag me-1"></i> {{ Str::limit($attendence->training->theme ?? 'N/A', 60) }}
                                    </span>
                            </div>
                        </td>
                        <td class="py-4 text-center">
                            <div class="d-inline-flex align-items-center px-3 py-1 rounded-pill bg-info bg-opacity-10 text-info border border-info border-opacity-10">
                                <i class="bi bi-clock-history me-2 small"></i>
                                <span class="fw-bold">{{ $attendence->training->duration ?? 'N/A' }}</span>
                                <span class="ms-1 small fw-normal">Jours</span>
                            </div>
                        </td>
                        <td class="py-4">
                            <div class="d-flex align-items-center">
                                <div class="date-box text-center me-2">
                                    <div class="small fw-bold text-primary">{{ \Carbon\Carbon::parse($attendence->training->starting_date ?? '0000-00-00')->format('d') }}</div>
                                    <div class="text-uppercase text-muted" style="font-size: 0.65rem;">{{ \Carbon\Carbon::parse($attendence->training->starting_date ?? '0000-00-00')->format('M') }}</div>
                                </div>
                                <i class="bi bi-arrow-right-short text-muted mx-1"></i>
                                <div class="date-box text-center ms-1">
                                    <div class="small fw-bold text-dark">{{ \Carbon\Carbon::parse($attendence->training->end_date ?? '0000-00-00')->format('d') }}</div>
                                    <div class="text-uppercase text-muted" style="font-size: 0.65rem;">{{ \Carbon\Carbon::parse($attendence->training->end_date ?? '0000-00-00')->format('M') }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4">
                            <div class="d-flex align-items-center">
                                <div class="date-box text-center me-2">
                                    <div class="small fw-bold text-primary">{{ \Carbon\Carbon::parse($attendence->training->starting_date ?? '0000-00-00')->format('Y') }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="pe-4 text-end">
                            <button class="btn btn-sm btn-light border-0 rounded-circle shadow-sm">
                                <i class="bi bi-chevron-right small text-primary"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <div class="py-4">
                                <i class="bi bi-clipboard-x display-4 text-light mb-3 d-block"></i>
                                <h6 class="text-muted fw-bold">Aucune formation prévue</h6>
                                <p class="small text-secondary">Les nouveaux enregistrements apparaîtront ici.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* Professional UI Adjustments */
    .xxs-font { font-size: 0.7rem; }
    .ls-1 { letter-spacing: 0.05rem; }
    .bg-faded-light { background-color: #f8f9fa; }
    .date-box {
        min-width: 45px;
        padding: 4px;
        background: #ffffff;
        border: 1px solid #edf2f7;
        border-radius: 8px;
    }
    .table tbody tr { transition: all 0.2s; cursor: pointer; }
    .table tbody tr:hover { background-color: #fcfdfe; }
</style>
