
@props(['employee', 'unity_type', 'unity_id', 'unity_name'])

<div class="modal fade" id="affectChefModal-{{$employee->id}}" tabindex="-1" aria-labelledby="affectChefModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <form action="{{ route('chefs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-header border-0 pb-0">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3">
                            <i class="bi bi-star-fill text-primary fs-4"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold mb-0" id="affectChefModalLabel">Nouvelle Affectation</h5>
                            <small class="text-muted">Affecter Chef</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body pt-0 px-4">
                    {{-- Title Field --}}
                    <div class="mb-4">
                        <p class="text-dark fw-bolder"> Mettre <span class="badge bg-info"> {{ $employee->lastname }} {{ $employee->firstname }}</span> </p>
                        <p>Chef de </p>
                        <p><span class="badge bg-primary"> {!! html_entity_decode($unity_name) !!} </span></p>

                        <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                        <input type="hidden" name="unity_id" value="{{ $unity_id }}">
                        <input type="hidden" name="unity_type" value="{{ $unity_type }}">

                        <label for="workTitle" class="form-label fw-semibold text-dark mb-2">
                            Date de commencement <span class="text-danger"></span>
                        </label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-calendar text-primary"></i>
                            </span>
                            <x-date-input id="starting_date"
                                          name="starting_date"
                                          value="null" />
                        </div>

                        <label for="decision_file" class="form-label fw-semibold text-dark mb-2 mt-2">
                            Décision <span class="text-danger"></span>
                        </label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-file text-primary"></i>
                            </span>
                            <input type="file" name="decision_file" class="form-control" id="decision_file">
                        </div>

                    </div>
                </div>

                <div class="modal-footer border-0 bg-light px-4 py-3 rounded-bottom">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Annuler
                    </button>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-save me-2"></i>
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
