@props(['periods', 'table' =>null])

<div class="modal fade" id="importValuesModal" tabindex="-1" aria-labelledby="importValuesModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <form action="{{ route('audit.values.import') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Header avec dégradé moderne --}}
                <div class="modal-header border-0 bg-primary bg-gradient p-4 text-white">
                    <div class="d-flex align-items-center">
                        <div class="bg-white bg-opacity-20 p-2 rounded-circle me-3 shadow-sm">
                            <i class="bi bi-person-badge-fill fs-3 text-white"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold mb-0" id="importValuesModalLabel"> Imorter les valeurs pour la table {{ $table->title ?? '' }} </h5>
                            <small class="text-white text-opacity-75">Nouvelle affectation structurelle</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal"  aria-label="Annuler"></button>
                </div>

                <div class="modal-body p-4 bg-white">
                    {{-- Période --}}
                    <div class="mb-2">
                        <label for="file" class="form-label small fw-bold text-muted text-uppercase">
                            Période de suivi <span class="text-danger">*</span>
                        </label>
                        <select class="form-control" name="period_id">
                            @foreach($periods as $period)
                                <option value="{{ $period->id }}">{{ $period->title }} - {{ $period->year }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Fichier de décision --}}
                    <div class="mb-2">
                        <label for="file" class="form-label small fw-bold text-muted text-uppercase">
                            Acte de nomination (EXCEL) <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-danger">
                                <i class="bi bi-file-earmark-pdf"></i>
                            </span>
                            <input type="file"
                                   name="file"
                                   class="form-control border-start-0 ps-0 shadow-none"
                                   id="file"
                                   accept=".xlsx"
                                   required>
                        </div>
                        <div class="form-text small mt-2">
                            <i class="bi bi-info-circle me-1"></i> Veuillez joindre le fichier
                        </div>
                    </div>
                </div>

                <input type="hidden" value="{{ $table->id ?? null }}" name="table_id">

                {{-- Footer épuré --}}
                <div class="modal-footer border-0 bg-light px-4 py-3">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4 fw-semibold" data-bs-dismiss="modal" aria-label="Annuler">
                        Annuler
                    </button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm transition-base">
                        <i class="bi bi-check-lg me-2"></i>Confirmer
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
