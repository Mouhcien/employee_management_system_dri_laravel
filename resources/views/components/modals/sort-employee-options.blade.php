<div class="modal fade" id="sortEmployeeOptionsModal" tabindex="-1" aria-labelledby="sortEmployeeOptionsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <form action="{{ route('employees.index') }}" method="GET" id="sortForm">
                @csrf
                <div class="px-4 py-3 bg-light border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 fw-bold text-dark">Options de Tri</h5>
                        <small class="text-muted">Organisez vos données avec précision</small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase text-secondary">PPR</label>
                            <select name="sort_ppr" class="form-select shadow-sm border-light-subtle">
                                <option value="">-- Par défaut --</option>
                                <option value="asc">↑ Croissant</option>
                                <option value="desc">↓ Décroissant</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase text-secondary">Nom / Prénom</label>
                            <select name="sort_nom" class="form-select shadow-sm border-light-subtle">
                                <option value="">-- Par défaut --</option>
                                <option value="asc">A → Z</option>
                                <option value="desc">Z → A</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase text-secondary">Âge</label>
                            <select name="sort_age" class="form-select shadow-sm border-light-subtle">
                                <option value="">-- Par défaut --</option>
                                <option value="asc">Plus jeune</option>
                                <option value="desc">Plus âgé</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase text-secondary">Service</label>
                            <select name="sort_service" class="form-select shadow-sm border-light-subtle">
                                <option value="">-- Par défaut --</option>
                                <option value="asc">Croissant</option>
                                <option value="desc">Décroissant</option>
                            </select>
                        </div>

                    </div>
                </div>

                <div class="px-4 py-3 bg-light border-top text-end">
                    <button type="reset" class="btn btn-link text-decoration-none text-muted fw-semibold me-3">Réinitialiser</button>
                    <button type="submit" class="btn btn-primary px-4 rounded-pill fw-bold shadow-sm">Appliquer le tri</button>
                </div>
            </form>
        </div>
    </div>
</div>
