

<div class="col-lg-5" id="profile_column">
    <div class="card border-0 shadow-lg rounded-4 sticky-top" style="top: 20px; z-index: 1000;">
        <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold text-dark mb-0"><i class="bi bi-person-badge me-2 text-primary"></i>Profil de l'agent</h5>
            <button class="btn btn-sm btn-outline-secondary rounded-pill px-3" onclick="toggleImageSize()" id="resize_btn">
                <i class="bi bi-arrows-fullscreen me-1"></i> <span id="btn_text">Agrandir</span>
            </button>
        </div>

        <div class="card-body p-4">
            @if(!is_null($employee))
                <div id="controls_overlay" class="d-none text-center mb-3">
                    <button onclick="toggleView(false)" class="btn btn-dark rounded-pill shadow-sm">
                        <i class="bi bi-arrow-left me-2"></i>Retour à la vue normale
                    </button>
                </div>

                <div class="text-center mb-4 transition-all" id="image_wrapper">
                    <div class="position-relative d-inline-block shadow-lg rounded-4 overflow-hidden border border-4 border-white">
                        @if($employee->photo && Storage::disk('public')->exists($employee->photo))
                            <img src="{{ Storage::url($employee->photo) }}"
                                 id="employee_img"
                                 class="object-fit-cover transition-all"
                                 width="300" height="300"
                                 ondblclick="toggleView(true)"
                                 style="cursor: pointer; transition: all 0.3s ease;">
                        @else
                            <div id="employee_placeholder"
                                 class="d-flex align-items-center justify-content-center text-white fw-bold transition-all"
                                 style="width:300px; height:300px; background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); font-size: 5rem;">
                                {{ strtoupper(substr($employee->firstname, 0, 1)) }}{{ strtoupper(substr($employee->lastname, 0, 1)) }}
                            </div>
                        @endif
                        {{--
                        <span class="position-absolute bottom-0 end-0 p-3 m-3 border border-3 border-white rounded-circle shadow {{ $employee->gender === 'F' ? 'bg-danger' : 'bg-primary' }}">
                            <i class="bi bi-gender-{{ $employee->gender === 'F' ? 'female' : 'male' }} text-white fs-4"></i>
                        </span>
                        --}}
                    </div>
                </div>

                <div class="text-center mb-4 border-bottom pb-4" id="identity_details">
                    <h1 class="fw-black text-dark mb-0" style="font-size: 2rem;">{{ $employee->firstname }} {{ strtoupper($employee->lastname) }}</h1>
                    <h3 class="text-secondary fw-medium mb-3" dir="rtl">{{ $employee->firstname_arab }} {{ $employee->lastname_arab }}</h3>

                    <div class="d-flex flex-wrap justify-content-center gap-2 mt-2">
                        <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-bold"><i class="bi bi-hash text-primary me-1"></i>{{ $employee->ppr ?? 'N/A' }}</span>
                        <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-bold"><i class="bi bi-card-text text-primary me-1"></i>{{ $employee->cin ?? 'N/A' }}</span>
                        <span class="badge bg-dark text-white px-3 py-2 rounded-pill fw-bold"><i class="bi bi-calendar-check me-1"></i>Entrée: {{ $employee->hiring_date ? \Carbon\Carbon::parse($employee->hiring_date)->format('d/m/Y') : '—' }}</span>
                    </div>
                </div>

                <section id="box_affectation" class="card border-0 bg-light rounded-4 shadow-xs mb-4">
                    <div class="card-body p-4">
                        <div class="row col-12 mb-3">
                            <div class="col-6 align-content-center">
                                <h6 class="text-uppercase text-muted fw-bolder mb-3 ls-1 small">
                                    Affectation Structurelle Active
                                </h6>
                            </div>
                            <div class="col-6 align-content-center">
                                <a href="javascript:void(0);"
                                   onclick="toggleSections()"
                                   class="d-inline-flex align-items-center px-3 py-1 text-secondary text-decoration-none border rounded-pill shadow-sm bg-light hover-shadow float-end">
                                    <i class="bi bi-clock-history me-2 text-primary"></i>
                                    <span class="fw-medium">Historique</span>
                                </a>
                            </div>
                        </div>
                        @php $activeAff = $employee->affectations->where('state', 1)->first(); @endphp
                        @if($activeAff)
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <div class="bg-white p-3 rounded-3 shadow-xs border-top border-4 border-primary h-100">
                                        <small class="text-muted d-block mb-1 fw-bold text-uppercase extra-small">Service</small>
                                        <span class="fw-bold text-dark">{{ $activeAff->service->title ?? 'N/A' }}</span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="bg-white p-3 rounded-3 shadow-xs border-top border-4 border-info h-100">
                                        <small class="text-muted d-block mb-1 fw-bold text-uppercase extra-small">Direction / Entité</small>
                                        <span class="fw-bold text-dark">{{ $activeAff->entity->title ?? 'N/A' }}</span>
                                    </div>
                                </div>
                                @if($activeAff->sector || $activeAff->section)
                                    <div class="col-12 mt-2">
                                        <div class="d-flex flex-wrap gap-2 bg-white p-3 rounded-3 border shadow-xs">
                                            @if($activeAff->sector) <span class="badge bg-success text-white px-3 py-2 rounded-pill small fw-bold">Secteur: {{ $activeAff->sector->title }}</span> @endif
                                            @if($activeAff->section) <span class="badge bg-secondary text-white px-3 py-2 rounded-pill small fw-bold">Section: {{ $activeAff->section->title }}</span> @endif
                                        </div>
                                    </div>
                                @endif
                                <div class="col-12 mt-2">
                                    <div class="d-flex flex-wrap gap-2 bg-white p-3 rounded-3 border shadow-xs">
                                        <span class="fw-bold text-dark"> Fonction :  </span>
                                        <span class="badge bg-success ms-2">{{ $activeAff->occupation->title ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center p-4 bg-white rounded-3 border border-dashed">
                                <i class="bi bi-diagram-3 text-muted fs-1 opacity-25"></i>
                                <p class="text-muted small mb-0 mt-2">Aucune affectation active enregistrée.</p>
                            </div>
                        @endif
                    </div>
                </section>

                <section id="box_history_affectation" class="card border-0 bg-light rounded-4 shadow-xs mb-4 d-none">
                    <div class="card-body p-4">
                        <div class="row col-12 mb-4">
                            <div class="col-6 align-content-center">
                                <h6 class="text-uppercase text-muted fw-bolder mb-0 ls-1 small">
                                    Historique des Affectations
                                </h6>
                            </div>
                            <div class="col-6">
                                <a href="javascript:void(0);" onclick="toggleSections()"
                                   class="d-inline-flex align-items-center px-3 py-1 text-danger text-decoration-none border border-danger rounded-pill shadow-sm bg-white hover-shadow float-end">
                                    <i class="bi bi-arrow-left me-2"></i>
                                    <span class="fw-medium">Retour</span>
                                </a>
                            </div>
                        </div>
                        {{-- Historique d'affectation --}}
                        @foreach($employee->affectations->sortByDesc('affectation_date') as $affectation)
                            <div class="mb-4">
                                <h6 class="text-uppercase text-primary fw-bolder mb-3 ls-1 small">
                                    <i class="bi bi-calendar-event me-2"></i>{{ \Carbon\Carbon::parse($affectation->affectation_date)->format('d/m/Y') }}
                                    @if ($affectation->section) <span class="badge bg-info ms-2"> {{ $affectation->section->title }} </span> @endif
                                    @if ($affectation->sector) <span class="badge bg-info ms-1"> {{ $affectation->sector->title }} </span> @endif
                                </h6>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="p-3 rounded-4 bg-white border-start border-4 border-primary h-100 shadow-sm">
                                            <small class="text-muted d-block mb-1 fw-bold text-uppercase" style="font-size: 0.7rem;">Service</small>
                                            <span class="fw-bold text-dark">{{ $affectation->service->title ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-3 rounded-4 bg-white border-start border-4 border-info h-100 shadow-sm">
                                            <small class="text-muted d-block mb-1 fw-bold text-uppercase" style="font-size: 0.7rem;">Direction / Entité</small>
                                            <span class="fw-bold text-dark">{{ $affectation->entity->title ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="d-flex flex-wrap gap-2 bg-white p-3 rounded-3 border shadow-xs">
                                            <span class="fw-bold text-dark"> Fonction :  </span>
                                            <span class="badge bg-success ms-2">{{ $affectation->occupation->title ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </div>
                                @if(!$loop->last) <hr class="my-4 opacity-25"> @endif
                            </div>
                        @endforeach
                    </div>
                </section>

                <div class="row g-3" id="info_grid">

                    <div class="col-md-12">
                        <div class="h-100 p-3 border rounded-4 bg-white shadow-xs">
                            <small class="text-muted d-block mb-1 fw-bold">Grade & Échelle</small>
                            @php $comp = $employee->competences->first(); @endphp
                            <span class="fw-bold text-dark d-block text-truncate">{{ $comp->grade->title ?? '—' }}</span>
                            <span class="badge bg-info-subtle text-info mt-1">Échelle: {{ $comp->grade->scale ?? '—' }}</span>
                            <span class="badge bg-success-subtle text-success mt-1"> {{ \Carbon\Carbon::parse($comp->starting_date)->format('d/m/Y') ?? '—' }}</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 bg-white border rounded-4 shadow-xs d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted d-block fw-bold">Contact Direct</small>
                                <span class="fw-bold text-dark"><i class="bi bi-telephone text-success me-1"></i>{{ $employee->tel ?? '—' }}</span>
                            </div>
                            <div class="text-end">
                                <small class="text-muted d-block fw-bold">Ville</small>
                                <span class="fw-bold text-dark">{{ $employee->local->title ?? '—' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <P> pas de chef actuellment </P>
            @endif
        </div>
    </div>
</div>
