<x-layout>
    @section('title', isset($temp) ? "Modifier le chef par intérim" : "Nouveau Chef par intérim")

    <div class="container py-5">
        <div class="row justify-content-center">
            {{-- Focused width for administrative forms --}}
            <div class="col-xl-10 col-lg-9 col-md-10">

                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    {{-- Vibrant Gradient Header --}}
                    <div class="card-header border-0 py-4 px-4 d-flex justify-content-between align-items-center"
                         style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);">
                        <div>
                            <h4 class="mb-1 text-white fw-bold">
                                <i class="bi {{ isset($temp) ? 'bi-pencil-square' : 'bi-plus-circle-dotted' }} me-2"></i>
                                {{ isset($temp) ? "Modifier le chef par intérim" : "Nouveau Chef par intérim" }}
                            </h4>
                            <p class="text-white text-opacity-75 mb-0 small">
                                {{ isset($temp) ? "Mise à jour du chef par intérim" : "Création d'un nouveau chef par intérim" }}
                            </p>
                        </div>

                        <a href="{{ route('temps.index') }}" class="btn btn-white btn-sm rounded-pill px-3 fw-bold shadow-sm transition-base">
                            <i class="bi bi-arrow-left me-1"></i>
                            Retour
                        </a>
                    </div>

                    <div class="card-body bg-white p-4 p-md-5">
                        <form
                            action="{{ isset($temp) ? route('temps.update', $temp->id) : route('temps.store') }}"
                            method="POST"
                            class="needs-validation"
                            novalidate
                            enctype="multipart/form-data"
                        >
                            @csrf

                            <div class="row col-12">
                                <div class="col-6">
                                    <div class="mb-4">
                                        <label for="employee_id" class="form-label small fw-bold text-muted text-uppercase">
                                            Employé <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0 text-primary">
                                                <i class="bi bi-calendar-event"></i>
                                            </span>
                                            <select class="form-control" name="employee_id" id="employee_id" >
                                                <option class="-1">Séléctionnez l'employé</option>
                                                @foreach($employees->sortBy('lastname') as $employee)
                                                    <option value="{{ $employee->id }}" {{ $employee->id == $temp->employee_id ? 'selected' : '' }}>
                                                        {{ $employee->lastname }} {{ $employee->firstname }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="chef_id" class="form-label small fw-bold text-muted text-uppercase">
                                            Résponsable <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0 text-primary">
                                                <i class="bi bi-calendar-event"></i>
                                            </span>
                                            <select class="form-control" name="chef_id" id="chef_id" >
                                                <option class="-1">Séléctionnez chef</option>
                                                @foreach($chefs->sortBy('employee.lastname') as $chef)
                                                    <option value="{{ $chef->id }}" {{ $chef->id == $temp->chef_id ? 'selected' : '' }}> {{ $chef->employee->lastname }} {{ $chef->employee->firstname }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-6">
                                    {{-- Date de commencement --}}
                                    <div class="mb-4">
                                        <label for="starting_date" class="form-label small fw-bold text-muted text-uppercase">
                                            Date de prise d'intérim <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0 text-primary">
                                                <i class="bi bi-calendar-event"></i>
                                            </span>
                                            <x-date-input id="starting_date"
                                                          name="starting_date"
                                                          class="form-control border-start-0 ps-0 shadow-none bg-white"
                                                          value="{{ !is_null($temp->starting_date) ? $temp->starting_date : 'null' }}"
                                                          required />
                                        </div>
                                    </div>

                                    {{-- Date de fin --}}
                                    <div class="mb-4">
                                        <label for="finished_date" class="form-label small fw-bold text-muted text-uppercase">
                                            Date de fin de fonction <span class="text-danger"></span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0 text-primary">
                                                <i class="bi bi-calendar-event"></i>
                                            </span>
                                            <x-date-input id="finished_date"
                                                          name="finished_date"
                                                          class="form-control border-start-0 ps-0 shadow-none bg-white"
                                                          value="{{ !is_null($temp->finished_date) ? $temp->finished_date : 'null' }}"
                                                          required />
                                        </div>
                                    </div>

                                    {{-- Fichier de décision --}}
                                    <div class="mb-2">
                                        <label for="decision_file" class="form-label small fw-bold text-muted text-uppercase">
                                            Acte de nomination (PDF) <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-danger">
                                <i class="bi bi-file-earmark-pdf"></i>
                            </span>
                                            <input type="file"
                                                   name="decision_file"
                                                   class="form-control border-start-0 ps-0 shadow-none"
                                                   id="decision_file"
                                                   accept=".pdf"
                                                   required>
                                        </div>
                                        <div class="form-text small mt-2">
                                            <i class="bi bi-info-circle me-1"></i> Veuillez joindre la copie numérisée de la décision officielle.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Form Actions --}}
                            <div class="d-flex flex-column flex-md-row justify-content-end gap-3 pt-4 border-top">
                                <button type="reset" class="btn btn-light btn-rounded px-4 fw-semibold text-muted order-2 order-md-1">
                                    <i class="bi bi-x-circle me-1"></i> Annuler
                                </button>
                                <button type="submit" class="btn btn-primary btn-rounded px-5 fw-bold shadow-sm order-1 order-md-2">
                                    <i class="bi bi-check-lg me-1"></i>
                                    {{ isset($temp) ? 'Mettre à jour' : 'Enregistrer' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Security/Info Badge --}}
                <div class="text-center mt-4 opacity-50 small">
                    <p><i class="bi bi-shield-check me-1"></i> Validation des données RH active</p>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .transition-base { transition: all 0.2s ease-in-out; }
            .bg-light-subtle { background-color: #f9fafb !important; }
            .btn-white { background: #fff; color: #4f46e5; border: none; }
            .btn-white:hover { background: #f0f4ff; color: #3730a3; }
            .btn-rounded { border-radius: 50px; }
            .ls-1 { letter-spacing: 0.5px; }

            /* Premium Input Focus States */
            .form-select:focus, .input-group:focus-within {
                border: 1px solid #4f46e5 !important;
                box-shadow: 0 0 0 0.25rem rgba(79, 70, 229, 0.1) !important;
            }
            .form-control:focus {
                box-shadow: none !important;
            }
        </style>
    @endpush
</x-layout>
