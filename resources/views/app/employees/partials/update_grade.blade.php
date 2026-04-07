<div class="card border-0 shadow-sm bg-white rounded-3" id="box_inserted_grade">
    <form action="{{ route('competences.update', $competence->id) }}" method="POST">
        @csrf
        <input type="hidden" name="employee_id" value="{{ $employee->id }}">

        <div class="card-body p-4">
            <h6 class="fw-bold text-uppercase text-primary mb-4 small tracking-wide">
                <i class="bi bi-shield-check me-2"></i>Mise ç jour du Grade
            </h6>

            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label small fw-semibold text-muted mb-1">Niveau <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted">
                            <i class="bi bi-layer-backward"></i>
                        </span>
                        <select class="form-select border-start-0 ps-1" name="level_id" required>
                            <option value="" selected disabled>Sélectionnez le niveau</option>
                            @foreach($levels as $level)
                                <option value="{{ $level->id }}" {{ $competence->level->id == $level->id ? 'selected' : '' }}>{{ $level->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label small fw-semibold text-muted mb-1">Grade <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted">
                            <i class="bi bi-award"></i>
                        </span>
                        <select class="form-select border-start-0 ps-1" name="grade_id" required>
                            <option value="" selected disabled>Sélectionnez le grade</option>
                            @foreach($grades as $grade)
                                <option value="{{ $grade->id }}" {{ $competence->grade->id == $grade->id ? 'selected' : '' }}>{{ $grade->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label small fw-semibold text-muted mb-1">Date de commencement</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted">
                            <i class="bi bi-calendar-event"></i>
                        </span>
                        <x-date-input id="starting_date" name="starting_date" value="{{ $competence->starting_date }}" class="form-control border-start-0 ps-1" />
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer bg-light border-0 d-flex gap-2 p-3">
            <button type="submit" class="btn btn-primary btn-sm flex-grow-1 fw-bold">
                <i class="bi bi-check2-circle me-1"></i>Enregistrer
            </button>
            <button type="button" id="btn_cancel_grade" class="btn btn-outline-secondary btn-sm px-3">
                Annuler
            </button>
        </div>
    </form>
</div>
