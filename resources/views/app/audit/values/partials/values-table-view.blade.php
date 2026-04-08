
@if (count($values) != 0)
    @php $groupedByTable = $values->groupBy('relation.table_id'); @endphp

    @foreach($groupedByTable as $tableId => $tableValues)
        @php
            $tableName = $tableValues->first()->relation->table->title ?? 'Table #'.$tableId;
            $tableColumns = $tableValues->map(fn($v) => $v->relation->column)->unique('id');
            $valuesByPeriod = $tableValues->groupBy('period_id')->sortByDesc(fn($group) => $group->first()->period->year);
            $periodKeys = $valuesByPeriod->keys()->toArray();
        @endphp

        <div class="card border-0 shadow-sm mb-4 rounded-4 overflow-hidden">
            <div class="card-header bg-dark py-3 px-4 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 text-white fw-bold"><i class="bi bi-bar-chart-line me-2 text-primary"></i> {{ $tableName }}</h6>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill">Analyse des KPIs</span>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light-subtle border-bottom">
                        <tr>
                            <th class="ps-4 py-3 text-muted small fw-bolder text-uppercase" style="width: 220px;">Période</th>
                            @foreach($tableColumns as $col)
                                <th class="py-3 text-center text-dark fw-bold border-start">{{ $col->title }}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($valuesByPeriod as $periodId => $periodEntries)
                            @php
                                $period = $periodEntries->first()->period;
                                $currentIndex = array_search($periodId, $periodKeys);
                                $olderPeriodId = $periodKeys[$currentIndex + 1] ?? null;
                                $olderEntries = $olderPeriodId ? $valuesByPeriod[$olderPeriodId] : null;
                            @endphp
                            <tr>
                                <td class="ps-4 border-end bg-light-subtle">
                                    <div class="fw-bold text-dark">{{ $period->title }} {{ $period->year }}</div>
                                    <small class="text-muted extra-small text-uppercase">{{ $period->start_date }} → {{ $period->end_date }}</small>
                                </td>
                                @foreach($tableColumns as $col)
                                    <td class="text-center">
                                        @php
                                            $entry = $periodEntries->firstWhere('relation.column_id', $col->id);
                                            $trend = null;
                                            if ($entry && $olderEntries) {
                                                $prevEntry = $olderEntries->firstWhere('relation.column_id', $col->id);
                                                if ($prevEntry && is_numeric($entry->value) && is_numeric($prevEntry->value)) {
                                                    if ($entry->value > $prevEntry->value) $trend = 'up';
                                                    elseif ($entry->value < $prevEntry->value) $trend = 'down';
                                                    else $trend = 'equal';
                                                }
                                            }
                                        @endphp
                                        @if($entry)
                                            <div class="d-inline-flex align-items-center gap-2 p-2 bg-white border rounded shadow-xs min-w-80 justify-content-center">
                                                <span class="fw-black text-primary">{{ $entry->value }}</span>
                                                @if($trend === 'up') <i class="bi bi-arrow-up-right text-success fw-bold"></i>
                                                @elseif($trend === 'down') <i class="bi bi-arrow-down-right text-danger fw-bold"></i>
                                                @elseif($trend === 'equal') <i class="bi bi-dash text-muted"></i> @endif
                                            </div>
                                        @else
                                            <span class="text-muted opacity-25 italic">N/A</span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                        @endforelse
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
