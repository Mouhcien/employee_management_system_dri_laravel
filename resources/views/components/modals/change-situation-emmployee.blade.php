@props(['employee'])

<div class="modal fade" id="changeStateModal" tabindex="-1" aria-labelledby="changeStateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <form action="{{ route('employees.change.state', $employee->id) }}" method="POST">
                @csrf

                <div class="modal-header border-0 pt-4 px-4 pb-2">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                            <i class="bi bi-person-badge-fill text-primary fs-4"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold text-dark" id="changeStateModalLabel">Mise à jour du statut</h5>
                            <p class="text-muted small mb-0">{{ $employee->firstname }} {{ $employee->lastname }}</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body px-4">
                    <input type="hidden" name="employee_id" value="{{ $employee->id }}">

                    <div class="mb-3">
                        <label for="diploma_id" class="form-label small fw-bold text-uppercase text-muted">
                            Situation actuelle <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted">
                                <i class="bi bi-briefcase"></i>
                            </span>
                            <select class="form-select border-start-0 ps-0" name="state" required>
                                <option value="" selected disabled>Choisir une situation...</option>
                                <option value="1">En fonction</option>
                                <option value="0">Mise à disposition</option>
                                <option value="-1">Mise à la retraite</option>
                                <option value="-2">Suspension immédiate</option>
                                <option value="2">Réintégration en position d'activité</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="date" class="form-label small fw-bold text-uppercase text-muted">
                            Date d'effet
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted">
                                <i class="bi bi-calendar-event"></i>
                            </span>
                            <div class="flex-grow-1">
                                <x-date-input id="date" name="date" class="border-start-0" value="{{ date('Y-m-d') }}" />
                            </div>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label for="motif" class="form-label small fw-bold text-uppercase text-muted">
                            Observations / Motif
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted align-items-start pt-2">
                                <i class="bi bi-pencil-square"></i>
                            </span>
                            <textarea class="form-control border-start-0 ps-0" name="motif" rows="3" placeholder="Précisez les raisons du changement..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 bg-light-subtle p-4">
                    <button type="button" class="btn btn-link text-secondary text-decoration-none me-auto" data-bs-dismiss="modal">
                        Annuler
                    </button>
                    <button type="submit" class="btn btn-primary px-4 py-2 shadow-sm fw-semibold">
                        <i class="bi bi-check2-circle me-2"></i>Confirmer le changement
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
