<div class="p-3 border rounded bg-white shadow-sm" id="box_inserted_occupation">
    <form method="POST" action="{{ route('works.update', $work_id) }}">
        @csrf
        <div class="mb-3">
            <label for="occupation-select" class="form-label small fw-bold text-uppercase text-muted mb-2">
                <i class="bi bi-person-workspace me-1"></i> Mettre à jour la fonction
            </label>

            <div class="input-group">
                <span class="input-group-text bg-light border-end-0">
                    <i class="bi bi-suit-club"></i>
                </span>

                <select
                    id="occupation-select"
                    name="occupation_id"
                    class="form-select border-start-0 ps-1 focus-shadow-none"
                    required
                >
                    <option value="" selected disabled>Choisir votre poste...</option>
                    @foreach($occupations as $occupation)
                        <option value="{{ $occupation->id }}" {{ $occupation_id == $occupation->id ? 'selected' : '' }}>
                            {{ $occupation->title }}
                        </option>
                    @endforeach
                </select>

                <input type="hidden" name="employee_id" value="{{ $employee_id }}">
                <input type="hidden" name="work_id" value="{{ $work_id }}">
            </div>

            <label for="workTitle" class="form-label fw-semibold text-dark mb-2">
                Date de commencement <span class="text-danger"></span>
            </label>
            <div class="input-group">
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-calendar text-primary"></i>
                    </span>
                    <x-date-input id="starting_date"
                                  name="starting_date"
                                  value="{{ $starting_date }}" />
                </div>
            </div>
        </div>

        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-primary btn-sm flex-grow-1 fw-bold">
                Enregistrer
            </button>
            <button type="button" id="btn_cancel_occupation" class="btn btn-light btn-sm border">
                Annuler
            </button>
        </div>
    </form>
</div>
