
@props(['employee', 'occupations'])

<div class="modal fade" id="affectOccupationModal" tabindex="-1" aria-labelledby="affectOccupationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <form action="{{ route('works.store') }}" method="POST">
                @csrf

                <div class="modal-header border-0 pb-0">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3">
                            <i class="bi bi-geo-alt-fill text-primary fs-4"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold mb-0" id="createCityModalLabel">Nouvelle Affectation</h5>
                            <small class="text-muted">Affecter fonction</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body pt-0 px-4">
                    {{-- Title Field --}}
                    <div class="mb-4">
                        <input type="hidden" name="employee_id" value="{{ $employee->id }}">

                        <label for="workTitle" class="form-label fw-semibold text-dark mb-2">
                            Fonction <span class="text-danger">*</span>
                        </label>
                        <div class="input-group input-group-lg mb-2">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="bi bi-geo-alt text-primary"></i>
                                    </span>
                            <select class="form-control" name="occupation_id">
                                <option> Sélectionnez la fonction</option>
                                @foreach($occupations as $occupation)
                                    <option value="{{ $occupation->id }}"> {{ $occupation->title }} </option>
                                @endforeach
                            </select>
                        </div>

                        <label for="workTitle" class="form-label fw-semibold text-dark mb-2">
                            Date de commencement <span class="text-danger"></span>
                        </label>
                        <div class="input-group input-group-lg">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="bi bi-calendar text-primary"></i>
                                </span>
                            <x-date-input id="starting_date"
                                          name="starting_date"
                                          value="" />
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
