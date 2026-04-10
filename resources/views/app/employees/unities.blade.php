<x-layout>
    @section('title', 'Affectation Structurelle - ' . $employee->firstname)

    <div class="container-fluid py-4">
        {{-- En-tête Profil Premium --}}
        <div class="card border-0 shadow-lg rounded-4 mb-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="bg-primary bg-gradient p-4 text-white position-relative">
                    {{-- Icône décorative --}}
                    <div class="position-absolute top-0 end-0 p-4 opacity-10">

                    </div>

                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 position-relative">
                        <div class="d-flex align-items-center gap-4">
                            {{-- Photo avec indicateur --}}
                            <div class="position-relative">
                                @if($employee->photo)
                                    <img src="{{ Storage::url($employee->photo) }}" alt="{{ $employee->firstname }}"
                                         class="rounded-circle border border-4 border-white shadow-lg object-fit-cover" width="100" height="100">
                                @else
                                    <div class="rounded-circle border border-4 border-white d-flex align-items-center justify-content-center text-white fw-bold shadow-lg fs-2"
                                         style="width:100px;height:100px;background:linear-gradient(135deg,#4f46e5 0%,#7c3aed 100%);">
                                        {{ strtoupper(substr($employee->firstname,0,1)) }}{{ strtoupper(substr($employee->lastname,0,1)) }}
                                    </div>
                                @endif
                                <span class="position-absolute bottom-0 end-0 p-2 bg-{{ $employee->status == 1 ? 'success' : 'danger' }} border border-3 border-white rounded-circle shadow"></span>
                            </div>

                            <div>
                                <h1 class="h3 fw-bold mb-1 text-white">{{ $employee->firstname }} {{ strtoupper($employee->lastname) }}</h1>
                                <p class="mb-2 text-white text-opacity-75 small">
                                    <i class="bi bi-hash me-1"></i>PPR: {{ $employee->ppr }} |
                                    <i class="bi bi-person-vcard me-1"></i>CIN: {{ $employee->cin ?? 'N/A' }}
                                </p>
                                <span class="badge rounded-pill bg-white bg-opacity-25 text-white border border-white border-opacity-25 px-3 py-2 fw-bold">
                                    <i class="bi bi-briefcase-fill me-1"></i>
                                    {{ $employee->status == 1 ? 'Agent Actif' : 'Agent Inactif' }}
                                </span>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('employees.index') }}" class="btn btn-white btn-rounded shadow-sm fw-bold px-4 transition-base">
                                <i class="bi bi-arrow-left me-2"></i>Retour
                            </a>
                            <a href="{{ route('employees.show', $employee) }}" class="btn btn-warning btn-sm px-4 fw-bold rounded-pill shadow-sm">
                                <i class="bi bi-list me-2"></i>Consulter
                            </a>
                            <a href="{{ route('employees.edit', $employee) }}" class="btn btn-primary-light btn-rounded shadow-sm fw-bold px-4 transition-base">
                                <i class="bi bi-pencil-square me-2"></i>Modifier profil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Colonne Gauche : Affectation Actuelle --}}
            <div class="col-12 col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                    <div class="card-header bg-white py-4 px-4 border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-geo-fill text-primary me-2"></i>Poste Actuel</h5>

                        @php
                            $affectation_id = $employee->affectations->where('state', 1)->first()?->id;
                        @endphp

                        @if ($employee->affectations->where('state', 1)->isNotEmpty())
                            @if (is_null($affectationObj))
                                <a href="{{ route('affectations.edit', ['employee_id' => $employee->id, 'affectation_id' => $affectation_id]) }}"
                                   class="btn btn-sm btn-outline-warning rounded-pill px-3 fw-bold">
                                    <i class="bi bi-pencil-square me-1"></i>Modifier
                                </a>
                            @else
                                <a href="{{ route('employees.unities', $employee->id) }}" class="btn btn-sm btn-outline-primary rounded-circle shadow-xs">
                                    <i class="bi bi-arrow-left"></i>
                                </a>
                            @endif
                        @endif
                    </div>

                    <div class="card-body p-4">
                        @php $activeAff = $employee->affectations->where('state', 1)->first(); @endphp

                        @if($activeAff)
                            <div class="d-flex flex-column gap-3">
                                <div class="p-3 bg-light rounded-4 border-start border-4 border-primary">
                                    <small class="text-muted text-uppercase fw-bold extra-small ls-1 d-block mb-1">Service</small>
                                    <span class="fw-bold text-dark fs-6">{{ $activeAff->service->title ?? 'N/A' }}</span>
                                </div>
                                <div class="p-3 bg-light rounded-4 border-start border-4 border-info">
                                    <small class="text-muted text-uppercase fw-bold extra-small ls-1 d-block mb-1">Entité / Direction</small>
                                    <span class="fw-bold text-dark fs-6">{{ $activeAff->entity->title ?? 'N/A' }}</span>
                                </div>
                                @if($activeAff->sector)
                                    <div class="p-3 bg-light rounded-4 border-start border-4 border-success">
                                        <small class="text-muted text-uppercase fw-bold extra-small ls-1 d-block mb-1">Secteur</small>
                                        <span class="fw-bold text-dark fs-6">{{ $activeAff->sector->title }}</span>
                                    </div>
                                @endif
                                @if($activeAff->section)
                                    <div class="p-3 bg-light rounded-4 border-start border-4 border-secondary">
                                        <small class="text-muted text-uppercase fw-bold extra-small ls-1 d-block mb-1">Section</small>
                                        <span class="fw-bold text-dark fs-6">{{ $activeAff->section->title }}</span>
                                    </div>
                                @endif

                                <div class="mt-3 p-3 bg-primary bg-opacity-10 rounded-4 text-center">
                                    <small class="text-primary fw-bold text-uppercase ls-1 d-block mb-1">En poste depuis le</small>
                                    <div class="h5 fw-bold text-primary mb-0">
                                        {{ \Carbon\Carbon::parse($activeAff->affectation_date)->translatedFormat('d F Y') }}
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="bg-light rounded-circle d-inline-flex p-4 mb-3">
                                    <i class="bi bi-diagram-3 fs-1 text-muted opacity-50"></i>
                                </div>
                                <p class="text-muted fw-medium mb-0">Aucune affectation active enregistrée.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Colonne Droite : Formulaire --}}
            <div class="col-12 col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white py-4 px-4 border-bottom">
                        <h5 class="mb-0 fw-bold text-dark">
                            <i class="bi bi-node-plus-fill text-{{ is_null($affectationObj) ? 'success' : 'warning' }} me-2"></i>
                            {{ is_null($affectationObj) ? 'Nouvelle Affectation' : 'Mise à jour du poste' }}
                        </h5>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ is_null($affectationObj) ? route('affectations.store') : route('affectations.update', $affectationObj->id)}}" method="POST">
                            @csrf
                            <input type="hidden" name="old_affectation" value="{{ is_null($activeAff) ? null : $activeAff->id }}">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted text-uppercase ls-1">Service d'accueil</label>
                                    <div class="input-group border rounded-3 overflow-hidden shadow-xs transition-base">
                                        <span class="input-group-text bg-light border-0"><i class="bi bi-briefcase text-primary"></i></span>
                                        <select class="form-select border-0 bg-light shadow-none" name="service_id" id="sl_aff_service_id" opt="{{ is_null($affectationObj) ? 'create' : 'edit' }}" employee_id="{{ $employee->id }}" @if(!is_null($affectationObj)) affectation_id="{{ $affectationObj->id }}" @endif>
                                            <option value="null">Choisir un service...</option>
                                            @foreach($services as $service)
                                                <option value="{{ $service->id }}" {{ (isset($service_id) && $service_id == $service->id) || (!is_null($affectationObj) && $affectationObj->service_id == $service->id) ? 'selected' : '' }}>
                                                    {{ $service->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted text-uppercase ls-1">Entité / Division</label>
                                    <div class="input-group border rounded-3 overflow-hidden shadow-xs transition-base">
                                        <span class="input-group-text bg-light border-0"><i class="bi bi-building text-primary"></i></span>
                                        <select class="form-select border-0 bg-light shadow-none" name="entity_id" id="sl_aff_entity_id" opt="{{ is_null($affectationObj) ? 'create' : 'edit' }}" employee_id="{{ $employee->id }}" @if(!is_null($affectationObj)) affectation_id="{{ $affectationObj->id }}" @endif>
                                            <option value="null">Choisir une entité...</option>
                                            @foreach($entities as $entity)
                                                <option value="{{ $entity->id }}" {{ (isset($entity_id) && $entity_id == $entity->id) || (!is_null($affectationObj) && $affectationObj->entity_id == $entity->id) ? 'selected' : '' }}>
                                                    {{ $entity->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted text-uppercase ls-1">Secteur spécifique</label>
                                    <div class="input-group border rounded-3 overflow-hidden shadow-xs transition-base">
                                        <span class="input-group-text bg-light border-0"><i class="bi bi-diagram-3 text-primary"></i></span>
                                        <select class="form-select border-0 bg-light shadow-none" name="sector_id">
                                            <option value="null">Aucun secteur particulier</option>
                                            @foreach($sectors as $sector)
                                                <option value="{{ $sector->id }}" {{ !is_null($affectationObj) && $affectationObj->sector_id == $sector->id ? 'selected' : '' }}>
                                                    {{ $sector->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted text-uppercase ls-1"> Section spécifique</label>
                                    <div class="input-group border rounded-3 overflow-hidden shadow-xs transition-base">
                                        <span class="input-group-text bg-light border-0"><i class="bi bi-diagram-2 text-primary"></i></span>
                                        <select class="form-select border-0 bg-light shadow-none" name="section_id">
                                            <option value="null">Aucune section particulière</option>
                                            @foreach($sections as $section)
                                                <option value="{{ $section->id }}" {{ !is_null($affectationObj) && $affectationObj->section_id == $section->id ? 'selected' : '' }}>
                                                    {{ $section->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted text-uppercase ls-1">Fonction</label>
                                    <div class="input-group border rounded-3 overflow-hidden shadow-xs transition-base">
                                        <span class="input-group-text bg-light border-0"><i class="bi bi-diagram-3 text-primary"></i></span>
                                        <select class="form-select border-0 bg-light shadow-none" name="occupation_id">
                                            <option value="null">Aucune fonction </option>
                                            @foreach($occupations as $occupation)
                                                <option value="{{ $occupation->id }}" {{ !is_null($affectationObj) && $affectationObj->occupation_id == $occupation->id ? 'selected' : '' }}>
                                                    {{ $occupation->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted text-uppercase ls-1">Date effective de l'affectation</label>
                                    <x-date-input id="affectation_date" name="affectation_date"
                                                  value="{{ is_null($affectationObj) ? '' : $affectationObj->affectation_date }}"
                                                  required="required"/>
                                </div>

                                <input type="hidden" name="employee_id" value="{{ $employee->id }}">

                                <div class="col-12 pt-3">
                                    <button type="submit" class="btn btn-{{ is_null($affectationObj) ? 'success' : 'warning' }} btn-lg w-100 rounded-pill shadow-sm fw-bold transition-base py-3">
                                        <i class="bi bi-check2-circle me-2"></i>
                                        {{ is_null($affectationObj) ? 'Confirmer l\'affectation' : 'Mettre à jour l\'affectation' }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .transition-base { transition: all 0.2s ease-in-out; }
        .ls-1 { letter-spacing: 0.5px; }
        .extra-small { font-size: 0.72rem; }
        .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
        .btn-white { background: #fff; color: #4f46e5; border: none; }
        .btn-white:hover { background: #f8f9fa; color: #4338ca; }
        .btn-primary-light { background: rgba(255,255,255,0.15); border: none; color: #fff; }
        .btn-primary-light:hover { background: rgba(255,255,255,0.25); }
        .btn-rounded { border-radius: 50px; }
        .form-select, .form-control { border-radius: 8px; }
        .bg-light-subtle { background-color: #f8f9fa !important; }
    </style>
</x-layout>
