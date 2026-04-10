<div class="modal fade" id="importTableModal" tabindex="-1" aria-labelledby="importTableModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <form action="{{ route('audit.tables.import') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape bg-primary bg-opacity-10 text-primary rounded-3 p-3 me-3">
                            <i class="bi bi-file-earmark-arrow-up fs-3"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold text-dark mb-0" id="importTableModalLabel">Importation de Schéma</h5>
                            <small class="text-muted">Format supportés: .xlsx, .csv (Max 5MB)</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body px-4 py-4">
                    <div class="row g-3 mb-4">
                        <div class="col-12">
                            <label for="schema_title" class="form-label fw-semibold small text-uppercase text-muted tracking-wider">Nom du schéma <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="schema_title" class="form-control form-control-lg fs-6 shadow-sm" placeholder="Ex: Audit Production 2026" required>
                        </div>
                        <div class="col-12">
                            <label for="schema_desc" class="form-label fw-semibold small text-uppercase text-muted tracking-wider">Description</label>
                            <textarea class="form-control shadow-sm" name="description" id="schema_desc" rows="2" placeholder="Détails optionnels sur l'origine des données..."></textarea>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold small text-uppercase text-muted tracking-wider">Sélectionner le document <span class="text-danger">*</span></label>
                        <div class="upload-zone position-relative border border-2 border-dashed rounded-4 p-4 text-center transition-all bg-light bg-opacity-50">
                            <input type="file" name="file" id="file_input" class="position-absolute top-0 start-0 w-100 h-100 opacity-0 cursor-pointer" style="z-index: 5;" required onchange="updateFileName(this)">

                            <div class="py-2" id="upload-content">
                                <div class="mb-3">
                                    <i class="bi bi-cloud-arrow-up text-primary display-5"></i>
                                </div>
                                <h6 class="fw-bold mb-1" id="file-name-display">Cliquez pour parcourir ou glissez-déposez</h6>
                                <p class="text-muted small mb-0">Vos données seront validées automatiquement</p>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-light border-0 shadow-sm d-flex align-items-center mb-0 px-3 py-2" role="alert">
                        <i class="bi bi-info-circle-fill text-info me-3 fs-5"></i>
                        <div class="small text-secondary">
                            Veuillez utiliser notre <a href="#" class="text-primary fw-bold text-decoration-none border-bottom border-primary border-opacity-25">modèle standard (.xlsx)</a> pour éviter les erreurs.
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-top-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-light text-secondary fw-semibold px-4" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary px-4 py-2 fw-bold shadow-sm d-flex align-items-center">
                        <span>Aperçu des données</span>
                        <i class="bi bi-arrow-right ms-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
