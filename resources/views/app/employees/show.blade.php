<x-layout>
    @section('title', 'Détails de l\'employé - ' . $employee->firstname)

    <div class="container-fluid py-4">
        {{-- En-tête Profil Premium --}}
        <div class="card border-0 shadow-lg rounded-4 mb-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="bg-primary bg-gradient p-4 text-white position-relative">
                    {{-- Icône de fond décorative --}}
                    <div class="position-absolute top-0 end-0 p-4 opacity-10">
                        <i class="bi bi-person-bounding-box" style="font-size: 8rem;"></i>
                    </div>

                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 position-relative">
                        <div class="d-flex align-items-center gap-4">
                            {{-- Photo avec indicateur de statut --}}
                            <div class="position-relative">
                                @if($employee->photo && Storage::disk('public')->exists($employee->photo))
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
                                <div class="d-flex flex-wrap gap-2 mb-2">
                                    <span class="badge bg-white bg-opacity-20 text-dark border border-white border-opacity-25 rounded-pill px-3">
                                        <i class="bi bi-hash me-1"></i>PPR: {{ $employee->ppr }}
                                    </span>
                                    @if($employee->cin)
                                        <span class="badge bg-white bg-opacity-20 text-dark border border-white border-opacity-25 rounded-pill px-3">
                                            <i class="bi bi-person-vcard me-1"></i>CIN: {{ $employee->cin }}
                                        </span>
                                    @endif
                                </div>
                                <span class="badge rounded-pill bg-{{ $employee->status == 1 ? 'success' : 'secondary' }} px-3 py-2 fw-bold">
                                    <i class="bi bi-check-circle-fill me-2"></i>{{ $employee->status == 1 ? 'Agent Actif' : 'Agent Inactif' }}
                                </span>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('employees.index') }}" class="btn btn-white btn-rounded shadow-sm fw-bold px-4">
                                <i class="bi bi-arrow-left me-2"></i>Retour
                            </a>
                            <a href="{{ route('employees.edit', $employee) }}" class="btn btn-primary-light btn-rounded shadow-sm fw-bold px-4">
                                <i class="bi bi-pencil-square me-2"></i>Modifier
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Colonne Gauche : Identité & Contact --}}
            <div class="col-lg-4 d-flex flex-column gap-4">

                {{-- Identité Card --}}
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                        <h6 class="fw-bold text-uppercase text-muted small mb-0 ls-1"><i class="bi bi-person-lines-fill text-primary me-2"></i>État Civil</h6>
                    </div>
                    <div class="card-body p-4 pt-3">
                        <div class="d-flex flex-column gap-3">
                            <div class="p-3 bg-light rounded-3">
                                <small class="text-muted d-block text-uppercase fw-bold extra-small mb-1">Nom (Arabe)</small>
                                <span class="fw-bold text-dark fs-5" dir="rtl">{{ $employee->firstname_arab }} {{ $employee->lastname_arab }}</span>
                            </div>
                            <div class="row g-2">
                                <div class="col-6">
                                    <small class="text-muted d-block extra-small">GENRE</small>
                                    <span class="badge rounded-pill bg-{{ $employee->gender === 'F' ? 'danger' : 'info' }} bg-opacity-10 text-{{ $employee->gender === 'F' ? 'danger' : 'info' }} fw-bold">
                                        <i class="bi bi-gender-{{ $employee->gender === 'F' ? 'female' : 'male' }} me-1"></i>{{ $employee->gender === 'F' ? 'Féminin' : 'Masculin' }}
                                    </span>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block extra-small">SITUATION</small>
                                    <span class="text-dark fw-semibold">{{ $employee->sit ?? '—' }}</span>
                                </div>
                                <div class="col-6 mt-3">
                                    <small class="text-muted d-block extra-small">NÉ(E) LE</small>
                                    <span class="text-dark fw-semibold">{{ $employee->birth_date ? \Carbon\Carbon::parse($employee->birth_date)->format('d/m/Y') : '—' }}</span>
                                </div>
                                <div class="col-6 mt-3">
                                    <small class="text-muted d-block extra-small">À</small>
                                    <span class="text-dark fw-semibold text-truncate d-block">{{ $employee->birth_city ?? '—' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Contact Card --}}
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                        <h6 class="fw-bold text-uppercase text-muted small mb-0 ls-1"><i class="bi bi-geo-alt-fill text-success me-2"></i>Contact & Adresse</h6>
                    </div>
                    <div class="card-body p-4 pt-3">
                        <div class="d-flex align-items-center p-3 mb-3 bg-success bg-opacity-10 rounded-4">
                            <div class="bg-success text-white rounded-circle p-2 me-3 shadow-sm"><i class="bi bi-telephone-fill"></i></div>
                            <div>
                                <small class="text-muted d-block extra-small">TÉLÉPHONE</small>
                                <span class="fw-bold text-dark">{{ $employee->tel ?? '—' }}</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center p-3 mb-3 bg-warning bg-opacity-10 rounded-4">
                            <div class="bg-warning text-white rounded-circle p-2 me-3 shadow-sm"><i class="bi bi-envelope-at-fill"></i></div>
                            <div class="text-truncate">
                                <small class="text-muted d-block extra-small">EMAIL</small>
                                <a href="mailto:{{ $employee->email }}" class="fw-bold text-dark text-decoration-none">{{ $employee->email ?? '—' }}</a>
                            </div>
                        </div>
                        <div class="p-3 bg-light rounded-4">
                            <small class="text-muted d-block extra-small mb-1">ADRESSE DE RÉSIDENCE</small>
                            <span class="text-dark fw-semibold small">{{ $employee->address ?? '—' }}</span>
                            @if($employee->city)<div class="badge bg-white text-muted border mt-2">{{ $employee->city }}</div>@endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Colonne Droite : Professionnel & Cursus --}}
            <div class="col-lg-8 d-flex flex-column gap-4">

                {{-- Informations Professionnelles & Affectation --}}
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold text-uppercase text-muted small mb-0 ls-1"><i class="bi bi-briefcase-fill text-info me-2"></i>Parcours Professionnel</h6>
                            <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill">{{ $employee->local->title ?? 'Sans affectation' }}</span>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-3 p-3 me-3 text-info"><i class="bi bi-calendar-check fs-4"></i></div>
                                    <div>
                                        <small class="text-muted text-uppercase extra-small fw-bold">Date de recrutement</small>
                                        <div class="fw-bold text-dark">{{ $employee->hiring_date ? \Carbon\Carbon::parse($employee->hiring_date)->format('d F Y') : '—' }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-3 p-3 me-3 text-secondary"><i class="bi bi-hourglass-bottom fs-4"></i></div>
                                    <div>
                                        <small class="text-muted text-uppercase extra-small fw-bold">Départ à la retraite</small>
                                        <div class="fw-bold text-dark">{{ $employee->retiring_date ? \Carbon\Carbon::parse($employee->retiring_date)->format('d F Y') : '—' }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-3 p-3 me-3 text-info"><i class="bi bi-calendar-check fs-4"></i></div>
                                    <div>
                                        <small class="text-muted text-uppercase extra-small fw-bold">Date de commencement au fonction publique</small>
                                        <div class="fw-bold text-dark">{{ $employee->hiring_public_date ? \Carbon\Carbon::parse($employee->hiring_public_date)->format('d F Y') : '—' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4 opacity-50">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <small class="text-muted d-block mb-1">Affectation Actuelle</small>
                                <div class="p-2 border border-light-subtle rounded-3 bg-light-subtle fw-bold text-dark text-center shadow-xs">
                                    {{ $employee->local->title ?? 'N/A' }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted d-block mb-1">Commission / Carte</small>
                                <div class="p-2 border border-light-subtle rounded-3 bg-light-subtle fw-bold text-dark text-center shadow-xs">
                                    {{ $employee->commission_card ?? '—' }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted d-block mb-1">Réintégration</small>
                                <div class="p-2 border border-light-subtle rounded-3 bg-light-subtle fw-bold text-dark text-center shadow-xs">
                                    {{ $employee->reintegration_date ? \Carbon\Carbon::parse($employee->reintegration_date)->format('d/m/Y') : '—' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Bloc Tri-Cartes : Fonction, Grade, Diplômes --}}
                <div class="row g-4">
                    {{-- Fonction --}}
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-header bg-white border-bottom-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold text-muted small mb-0 text-uppercase ls-1">Fonction</h6>
                                @if(count($employee->works) == 0)
                                    <button class="btn btn-sm btn-primary-light rounded-circle" data-bs-toggle="modal" data-bs-target="#affectOccupationModal"><i class="bi bi-plus-lg"></i></button>
                                @endif
                            </div>
                            <div class="card-body p-4 pt-2">
                                @forelse($employee->works->whereNull('terminated_date') as $work)
                                    <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded-3 border">
                                        <span class="fw-bold text-dark">{{ $work->occupation->title }}</span>
                                        <button class="btn btn-sm btn-outline-danger border-0 rounded-circle"><i class="bi bi-trash3"></i></button>
                                    </div>
                                @empty
                                    <div class="text-center py-3 border border-dashed rounded-3">
                                        <p class="small text-muted mb-0">Aucune fonction affectée</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    {{-- Grade --}}
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-header bg-white border-bottom-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold text-muted small mb-0 text-uppercase ls-1">Grade Actuel</h6>
                                <button class="btn btn-sm btn-primary-light rounded-circle" data-bs-toggle="modal" data-bs-target="#affectGradeModal"><i class="bi bi-plus-lg"></i></button>
                            </div>
                            <div class="card-body p-4 pt-2">
                                @forelse($employee->competences as $competence)
                                    <div class="p-3 bg-light rounded-3 border mb-2 d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="badge bg-dark rounded-pill me-2">Échelle {{ $competence->level->title }}</span>
                                            <span class="fw-bold text-dark">{{ $competence->grade->title }}</span>
                                        </div>
                                        <button class="btn btn-sm btn-outline-danger border-0"><i class="bi bi-trash3"></i></button>
                                    </div>
                                @empty
                                    <div class="text-center py-3 border border-dashed rounded-3"><p class="small text-muted mb-0">Grade non défini</p></div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    {{-- Diplômes --}}
                    <div class="col-12">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-header bg-white border-bottom-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold text-muted small mb-0 text-uppercase ls-1">Qualifications & Diplômes</h6>
                                <button class="btn btn-primary btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#affectDiplomaModal">
                                    <i class="bi bi-plus-lg me-1"></i>Ajouter
                                </button>
                            </div>
                            <div class="card-body p-4 pt-2">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="bg-light-subtle">
                                        <tr>
                                            <th class="border-0 small fw-bold">Intitulé du Diplôme</th>
                                            <th class="border-0 small fw-bold">Filière</th>
                                            <th class="border-0 small fw-bold text-center">Année</th>
                                            <th class="border-0 small fw-bold text-end">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($employee->qualifications as $qualification)
                                            <tr>
                                                <td class="fw-bold text-dark border-0">{{ $qualification->diploma->title }}</td>
                                                <td class="fw-bold text-dark border-0">{{ $qualification->option->title }}</td>
                                                <td class="text-center border-0"><span class="badge bg-secondary rounded-pill px-3">{{ $qualification->year }}</span></td>
                                                <td class="text-end border-0">
                                                    <button class="btn btn-sm btn-light border-0 rounded-circle text-danger shadow-xs"><i class="bi bi-trash-fill"></i></button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="3" class="text-center py-4 border-0 text-muted italic">Aucun diplôme renseigné</td></tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modals --}}
    <x-affect-occupation-modal :employee="$employee" :occupations="$occupations" />
    <x-affect-diploma-modal :employee="$employee" :diplomas="$diplomas" />
    <x-affect-grade-modal :employee="$employee" :levels="$levels" :grades="$grades" />

    <style>
        .hover-lift:hover { transform: translateY(-4px); transition: all 0.2s ease-in-out; }
        .ls-1 { letter-spacing: 0.5px; }
        .extra-small { font-size: 0.72rem; }
        .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
        .btn-white { background: #fff; color: #4f46e5; border: none; }
        .btn-white:hover { background: #f8f9fa; color: #4338ca; }
        .btn-primary-light { background: rgba(255,255,255,0.15); border: none; color: #fff; }
        .btn-primary-light:hover { background: rgba(255,255,255,0.25); }
        .btn-rounded { border-radius: 50px; }
        .bg-light-subtle { background-color: #f8f9fa !important; }
        .border-dashed { border-style: dashed !important; border-width: 2px !important; }
    </style>
</x-layout>
