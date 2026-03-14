@props(['employee', 'unity_type', 'unity_id', 'unity_name'])

<div class="modal fade" id="affectChefModal-{{$employee->id}}" tabindex="-1" aria-labelledby="affectChefModalLabel-{{$employee->id}}" aria-hidden="true" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <form action="{{ route('chefs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Header avec dégradé moderne --}}
                <div class="modal-header border-0 bg-primary bg-gradient p-4 text-white">
                    <div class="d-flex align-items-center">
                        <div class="bg-white bg-opacity-20 p-2 rounded-circle me-3 shadow-sm">
                            <i class="bi bi-person-badge-fill fs-3 text-white"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold mb-0" id="affectChefModalLabel-{{$employee->id}}">Nomination de Chef</h5>
                            <small class="text-white text-opacity-75">Nouvelle affectation structurelle</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal"  aria-label="Annuler"></button>
                </div>

                <div class="modal-body p-4 bg-white">
                    {{-- Récapitulatif de l'action --}}
                    <div class="bg-light rounded-4 p-3 mb-4 text-center border">
                        <div class="small text-muted text-uppercase fw-bold ls-1 mb-2">Action de promotion</div>
                        <div class="d-flex align-items-center justify-content-center gap-2 flex-wrap">
                            <span class="badge bg-dark rounded-pill px-3 py-2 fs-6">
                                {{ $employee->lastname }} {{ $employee->firstname }}
                            </span>
                            <i class="bi bi-arrow-right text-primary fs-5"></i>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-2 fs-6">
                                {!! html_entity_decode($unity_name) !!}
                            </span>
                        </div>
                    </div>

                    {{-- Hidden Inputs --}}
                    <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                    <input type="hidden" name="unity_id" value="{{ $unity_id }}">
                    <input type="hidden" name="unity_type" value="{{ $unity_type }}">

                    {{-- Date de commencement --}}
                    <div class="mb-4">
                        <label for="starting_date-{{$employee->id}}" class="form-label small fw-bold text-muted text-uppercase">
                            Date de prise de fonction <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-primary">
                                <i class="bi bi-calendar-event"></i>
                            </span>
                            <x-date-input id="starting_date-{{$employee->id}}"
                                          name="starting_date"
                                          class="form-control border-start-0 ps-0 shadow-none bg-white"
                                          value="null"
                                          required />
                        </div>
                    </div>

                    {{-- Fichier de décision --}}
                    <div class="mb-2">
                        <label for="decision_file-{{$employee->id}}" class="form-label small fw-bold text-muted text-uppercase">
                            Acte de nomination (PDF) <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-danger">
                                <i class="bi bi-file-earmark-pdf"></i>
                            </span>
                            <input type="file"
                                   name="decision_file"
                                   class="form-control border-start-0 ps-0 shadow-none"
                                   id="decision_file-{{$employee->id}}"
                                   accept=".pdf"
                                   required>
                        </div>
                        <div class="form-text small mt-2">
                            <i class="bi bi-info-circle me-1"></i> Veuillez joindre la copie numérisée de la décision officielle.
                        </div>
                    </div>
                </div>

                {{-- Footer épuré --}}
                <div class="modal-footer border-0 bg-light px-4 py-3">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4 fw-semibold" data-bs-dismiss="modal" aria-label="Annuler">
                        Annuler
                    </button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm transition-base">
                        <i class="bi bi-check-lg me-2"></i>Confirmer la nomination
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .ls-1 { letter-spacing: 0.5px; }
    .transition-base { transition: all 0.2s ease-in-out; }
    .input-group:focus-within {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1) !important;
    }
    .input-group:focus-within .input-group-text,
    .input-group:focus-within .form-control {
        border-color: #0d6efd !important;
    }
</style>
