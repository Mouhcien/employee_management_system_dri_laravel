<div class="card border-0 bg-white shadow-sm rounded-3">
    <form action="{{ route('qualifications.update', $qualification->id) }}" method="POST">
        @csrf

        <div class="card-body p-4">
            <h6 class="fw-bold text-uppercase text-primary mb-4 small tracking-wide">
                <i class="bi bi-pencil-square me-2"></i>Modifier le Diplôme
            </h6>

            <input type="hidden" name="employee_id" value="{{ $employee->id }}">

            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label small fw-semibold text-muted mb-1">Diplôme <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted py-1">
                            <i class="bi bi-mortarboard"></i>
                        </span>
                        <select class="form-select border-start-0 ps-1" name="diploma_id" required>
                            <option value="" disabled>Sélectionnez le diplôme</option>
                            @foreach($diplomas as $diploma)
                                <option value="{{ $diploma->id }}" {{ $qualification->diploma_id == $diploma->id ? 'selected' : '' }}>
                                    {{ $diploma->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-5">
                    <label class="form-label small fw-semibold text-muted mb-1">Filière <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted py-1">
                            <i class="bi bi-journal-bookmark"></i>
                        </span>
                        <select class="form-select border-start-0 ps-1" name="option_id" required>
                            <option value="" disabled>Sélectionnez la filière</option>
                            @foreach($options as $option)
                                <option value="{{ $option->id }}" {{ $qualification->option_id == $option->id ? 'selected' : '' }}>
                                    {{ $option->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <label class="form-label small fw-semibold text-muted mb-1">Année</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted py-1">
                            <i class="bi bi-calendar3"></i>
                        </span>
                        <input type="number" name="year" class="form-control border-start-0 ps-1"
                               value="{{ $qualification->year }}" min="1900" max="{{ date('Y') + 5 }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer bg-light border-0 d-flex justify-content-end gap-2 p-3">
            <button type="button" class="btn btn-outline-secondary btn-sm px-3 btn-cancel-qualif">
                Annuler
            </button>
            <button type="submit" class="btn btn-primary btn-sm px-4 fw-bold shadow-sm">
                <i class="bi bi-check-lg me-1"></i>Enregistrer
            </button>
        </div>
    </form>
</div>
