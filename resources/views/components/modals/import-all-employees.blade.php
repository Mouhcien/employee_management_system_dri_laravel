<div class="modal fade" id="importAllEmployeeModal" tabindex="-1" aria-labelledby="importAllEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('employees.import.all') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-header border-bottom-0 pt-4 px-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                            <i class="bi bi-file-earmark-arrow-up text-primary fs-3"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold text-dark" id="importAllEmployeeModalLabel">Importation en masse</h5>
                            <p class="text-muted small mb-0">Téléchargez vos fichiers d'employés (.xlsx, .csv)</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body px-4 py-4">
                    <div class="mb-3">
                        <label for="file" class="form-label fw-bold text-secondary small text-uppercase tracking-wider">
                            Sélectionner le document <span class="text-danger">*</span>
                        </label>

                        <div class="upload-container position-relative border border-2 border-dashed rounded-4 p-5 text-center bg-light transition-all">
                            <input type="file" name="file" id="file" class="position-absolute inset-0 w-100 h-100 opacity-0 cursor-pointer" style="z-index: 2;" required>

                            <div class="upload-content">
                                <i class="bi bi-cloud-upload text-primary display-4 mb-3 d-block"></i>
                                <p class="mb-1 fw-semibold">Cliquez pour parcourir ou glissez-déposez</p>
                                <p class="text-muted small">Taille maximale : 5MB</p>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info border-0 bg-info bg-opacity-10 d-flex align-items-center mb-0" role="alert">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        <div class="small">
                            Assurez-vous que votre fichier respecte le <a href="#" class="fw-bold text-decoration-none">modèle standard</a>.
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-top-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-link text-secondary text-decoration-none me-auto" data-bs-dismiss="modal">
                        Annuler
                    </button>
                    <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold shadow-sm">
                        <i class="bi bi-eye me-2"></i>Aperçu des données
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Custom styles to enhance the professional look */
    .border-dashed { border-style: dashed !important; }
    .cursor-pointer { cursor: pointer; }
    .transition-all { transition: all 0.2s ease-in-out; }
    .upload-container:hover {
        background-color: #f8f9fa !important;
        border-color: #0d6efd !important;
    }
    .inset-0 { top: 0; left: 0; }
</style>
