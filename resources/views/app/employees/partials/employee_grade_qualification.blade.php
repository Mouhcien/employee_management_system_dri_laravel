
{{-- Bloc Tri-Cartes : Fonction, Grade, Diplômes --}}
<div class="row g-4">


    {{-- Fonction --}}
    {{--
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold text-muted small mb-0 text-uppercase ls-1">Fonction</h6>
                <button class="btn btn-primary btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#affectOccupationModal"><i class="bi bi-plus-lg"></i></button>
            </div>
            <div class="card-body p-4 pt-2">
                @forelse($employee->works->whereNull('terminated_date')->sortByDesc('starting_date') as $work)
                    <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded-3 border"
                         id="sl_occupation_insert_agent"
                         style="cursor: pointer;">
                        <span class="fw-bold text-dark">{{ $work->occupation->title }}</span>
                        <button class="btn btn-sm btn-outline-danger border-0 rounded-circle" data-bs-toggle="modal" data-bs-target="#deleteOccupationModal-{{ $work->id }}"><i class="bi bi-trash3"></i></button>
                    </div>
                    @break
                @empty
                    <div class="text-center py-3 border border-dashed rounded-3">
                        <p class="small text-muted mb-0">Aucune fonction affectée</p>
                    </div>
                @endforelse

                @foreach($employee->works as $work)
                    <x-delete-model
                        href="{{ route('works.delete', $work->id) }}"
                        message="Attention : La suppression de la fonction est irréversible."
                        title="Confirmation de Suppression de la fonction"
                        target="deleteOccupationModal-{{ $work->id }}" />
                @endforeach
            </div>
            <div class="d-none px-4 pb-4" id="box_inserted_occupation">
                @if (count($employee->works->whereNull('terminated_date')) != 0)
                    @php
                        $work_id = $employee->works->whereNull('terminated_date')[0]->id;
                        $occupation_id = $employee->works->whereNull('terminated_date')[0]->occupation_id;
                        $starting_date = $employee->works->whereNull('terminated_date')[0]->starting_date;
                    @endphp
                    @include('app.employees.partials.update_occupation', [
                        'work_id' => $work_id,
                        'employee_id' => $employee->id,
                        'occupation_id' => $occupation_id,
                        'starting_date' => $starting_date])
                @endif
            </div>
        </div>
    </div>
    --}}

    {{-- Grade --}}
    <div class="col-md-12">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                <h6 class="text-uppercase text-muted fw-bold small mb-0">Grade Actuel</h6>
                <button class="btn btn-primary btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#affectGradeModal"><i class="bi bi-plus-lg"></i></button>
            </div>
            <div id="box_grade_without_history_container">
                <div class="px-4 d-flex justify-content-between align-items-center mb-0">
                    <button type="button" class="btn btn-sm btn-link text-primary text-decoration-none fw-bold small" onclick="toggleGradeHistory()">
                        <i class="bi bi-clock-history me-1"></i> Historique
                    </button>
                </div>

                <div id="box_grade_without_history" class="card-body p-4 pt-2">
                    @php $competenceSelected = null @endphp
                    @forelse($employee->competences->sortByDesc('starting_date') as $competence)
                        @php $competenceSelected = $competence;  @endphp
                        <div class="p-3 bg-light rounded-3 border mb-2 d-flex justify-content-between align-items-center"
                             id="sl_grade_display"
                             style="cursor: pointer;">
                            <div>
                                <span class="fw-bold text-dark">{{ $competence->grade->title }}</span><br>
                                <span class="fw-bold text-success">échelle : {{ $competence->grade->scale }}</span>
                                <span class="badge bg-success-subtle text-success mt-1"> {{ \Carbon\Carbon::parse($competence->starting_date)->format('d/m/Y') ?? '—' }}</span>
                                <br>
                                <span class="fw-bold text-info">échellon : {{ $competence->echellon->title ?? 'N/A' }}</span>

                            </div>
                            <button class="btn btn-sm btn-outline-danger border-0" data-bs-toggle="modal" data-bs-target="#deleteCompetenceModal-{{ $competence->id }}"><i class="bi bi-trash3"></i></button>
                        </div>
                        @break
                    @empty
                        <div class="text-center py-3 border border-dashed rounded-3"><p class="small text-muted mb-0">Grade non défini</p></div>
                    @endforelse
                </div>
            </div>

            <div id="box_grade_with_history_container" class="d-none">
                <div class="px-4 d-flex justify-content-between align-items-center mb-0">
                    <h6 class="text-uppercase text-primary fw-bold small mb-0">Historique des Grades</h6>
                    <button type="button" class="btn btn-sm btn-link text-secondary text-decoration-none fw-bold small" onclick="toggleGradeHistory()">
                        <i class="bi bi-arrow-left me-1"></i> Retour
                    </button>
                </div>

                <div id="box_grade_with_history" class="card-body p-4 pt-2">
                    @php $competenceSelected = null @endphp
                    @forelse($employee->competences->sortByDesc('starting_date') as $competence)
                        @php $competenceSelected = $competence;  @endphp
                        <div class="p-3 bg-light rounded-3 border mb-2 d-flex justify-content-between align-items-center"
                             id="sl_grade_display"
                             style="cursor: pointer;">
                            <div>
                                <span class="fw-bold text-dark">{{ $competence->grade->title }}</span><br>
                                <span class="fw-bold text-success">échelle : {{ $competence->grade->scale }}</span><br>
                                <span class="fw-bold text-info">échellon : {{ $competence->echellon->title ?? 'N/A' }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-3 border border-dashed rounded-3"><p class="small text-muted mb-0">Grade non défini</p></div>
                    @endforelse
                </div>
            </div>

            @foreach($employee->competences as $competence)
                <x-delete-model
                    href="{{ route('competences.delete', $competence->id) }}"
                    message="Attention : La suppression du grade {{ $competence->grade->title }}  est irréversible."
                    title="Confirmation de Suppression du grade"
                    target="deleteCompetenceModal-{{ $competence->id }}" />
            @endforeach
        </div>

    </div>

    {{-- Diplômes --}}
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4">
            @if (count($employee->competences) != 0)
                <div class="d-none" id="box_grade_form_wrapper">
                    @include('app.employees.partials.update_grade', [
                        'competence' => $competenceSelected,
                        'employee' => $employee,
                        'levels' => $levels,
                        'grades' => $grades])
                </div>
            @endif
            <div class="card-header bg-white border-bottom-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold text-muted small mb-0 text-uppercase ls-1">Qualifications & Diplômes</h6>
                <button class="btn btn-primary btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#affectDiplomaModal">
                    <i class="bi bi-plus-lg me-1"></i>Ajouter
                </button>
            </div>
            <div class="card-body p-4 pt-2">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light-subtle">
                        <tr>
                            <th class="border-0 small fw-bold">Intitulé du Diplôme</th>
                            <th class="border-0 small fw-bold">Filière</th>
                            <th class="border-0 small fw-bold text-center">Année</th>
                            <th class="border-0 small fw-bold text-end">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($employee->qualifications->sortByDesc('year') as $qualification)
                            <tr class="qualification-row" style="cursor: pointer;" title="Double-cliquez pour modifier">
                                <td class="fw-bold text-dark border-0">{{ $qualification->diploma->title }}</td>
                                <td class="fw-bold text-dark border-0">{{ $qualification->option->title ?? '-' }}</td>
                                <td class="text-center border-0"><span class="badge bg-secondary rounded-pill px-3">{{ $qualification->year ?? '-' }}</span></td>
                                <td class="text-end border-0">
                                    <button class="btn btn-sm btn-light border-0 rounded-circle text-danger shadow-xs"
                                            data-bs-toggle="modal" data-bs-target="#deleteQualificationModal-{{ $qualification->id }}">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr class="qualification-form-row d-none bg-light">
                                <td colspan="4" class="p-3 border-0">
                                    <div class="qualification-form-container">
                                        @include('app.employees.partials.update_qualification', [
                                            'qualification' => $qualification,
                                            'employee' => $employee,
                                            'diplomas' => $diplomas, // Fixed variable name pluralization
                                            'options' => $options])

                                        <div class="text-end mt-2">
                                            <button type="button" class="btn btn-sm btn-link text-muted btn-cancel-qualif">Annuler</button>
                                        </div>
                                    </div>
                                </td>
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
