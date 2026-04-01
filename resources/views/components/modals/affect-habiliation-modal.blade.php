@props(['rules', 'profiles'])

<div class="modal fade" id="affectHabilitationModal" tabindex="-1" aria-labelledby="affectHabilitationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <form action="{{ route('habilitations.store') }}" method="POST">
                @csrf

                <div class="modal-header border-0 bg-primary bg-gradient p-4 text-white">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-20 p-3 rounded-3 me-3 shadow-sm border border-white border-opacity-10">
                            <i class="bi bi-shield-lock-fill fs-3 text-white"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold mb-0" id="importValuesModalLabel">Affecter des habilitations</h5>
                            <p class="text-white text-opacity-75 small mb-0 mt-1">
                                Gestion des accès
                            </p>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>

                <div class="modal-body p-4 bg-white">
                    <div class="alert alert-info border-0 bg-light-primary small mb-4 py-2 px-3 rounded-3 text-primary d-flex align-items-center">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        Maintenez la touche <strong>Ctrl</strong> (ou Cmd) pour sélectionner plusieurs éléments.
                    </div>

                    <div class="mb-3">
                        <label for="rule_id" class="form-label small fw-bold text-secondary text-uppercase tracking-wider ls-1">
                            Profile disponibles <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted">
                                <i class="bi bi-projector"></i>
                            </span>
                            <select class="form-select border-start-0 shadow-none py-2"
                                    name="profile_id"
                                    id="profile_id"
                                    required>
                                @foreach($profiles as $profile)
                                    <option value="{{ $profile->id }}" class="py-2 px-3 rounded-2 mb-1">
                                        {{ $profile->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="rule_id" class="form-label small fw-bold text-secondary text-uppercase tracking-wider ls-1">
                            Habilitations disponibles <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted">
                                <i class="bi bi-search"></i>
                            </span>
                            <select class="form-select border-start-0 shadow-none py-2"
                                    name="rule_id[]"
                                    id="rule_id"
                                    multiple
                                    size="6"
                                    required>
                                @foreach($rules as $rule)
                                    <option value="{{ $rule->id }}" class="py-2 px-3 rounded-2 mb-1">
                                        {{ $rule->title === '*' ? '❖ Accès total (Administrateur)' : $rule->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-text text-end x-small mt-2">
                            <i class="bi bi-layers me-1"></i> {{ count($rules) }} rôles disponibles
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 bg-light px-4 py-3">
                    <button type="button" class="btn btn-link text-secondary text-decoration-none fw-bold me-auto" data-bs-dismiss="modal">
                        Annuler
                    </button>
                    <button type="submit" class="btn btn-primary px-4 py-2 fw-bold shadow-sm rounded-3 hover-lift">
                        <i class="bi bi-check2-circle me-2"></i>Confirmer l'affectation
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .ls-1 { letter-spacing: 0.05rem; }
    .bg-light-primary { background-color: #f0f7ff; }

    .form-select option:hover {
        background-color: #0d6efd !important;
        color: white;
    }

    .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
    }

    .hover-lift {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .hover-lift:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.25) !important;
    }

    /* Style for the scrollbar within the select */
    .form-select::-webkit-scrollbar {
        width: 6px;
    }
    .form-select::-webkit-scrollbar-thumb {
        background-color: #dee2e6;
        border-radius: 10px;
    }
</style>
