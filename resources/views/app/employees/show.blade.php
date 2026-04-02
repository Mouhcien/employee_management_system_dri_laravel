<x-layout>
    @section('title', 'Détails de l\'employé - ' . $employee->firstname)

    <style>
        /* 1. The Main Overlay Container */
        .profile-expanded-overlay {
            display: none; /* Hidden by default */
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(15, 23, 42, 0.98); /* Deep slate background */
            backdrop-filter: blur(15px); /* Modern frosted glass effect */
            z-index: 9999;
            padding: 30px;
            overflow: hidden;
        }

        /* 2. The Three-Column Layout Strategy */
        .profile-expanded-content {
            display: flex;
            align-items: flex-start; /* Align to top to allow scrolling */
            justify-content: center;
            gap: 40px;
            height: 90vh;
            max-width: 1800px;
            margin: 0 auto;
        }

        /* 3. The Side Panels (Personal & Professional) */
        .expanded-side-panel {
            flex: 1; /* Takes equal remaining space */
            background: #ffffff;
            border-radius: 24px;
            padding: 2.5rem;
            height: 85vh; /* Fixed height for the panel */
            overflow-y: auto; /* Enable scrolling for long lists (Diplomas/Grades) */
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Custom Scrollbar for the panels */
        .expanded-side-panel::-webkit-scrollbar {
            width: 6px;
        }
        .expanded-side-panel::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        /* 4. The Center Image (600x600) */
        .expanded-image-center {
            flex: 0 0 600px; /* Force exactly 600px width */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .expanded-image-center img,
        .expanded-image-center .rounded-circle {
            width: 600px !important;
            height: 600px !important;
            object-fit: cover;
            border-radius: 40px !important; /* Slightly more rectangular-round for the big view */
            border: 12px solid white !important;
            box-shadow: 0 0 40px rgba(0,0,0,0.6);
            transition: transform 0.3s ease;
        }

        /* 5. Typography and Cleanup in Expanded View */
        .expanded-side-panel h3 {
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 15px;
            margin-bottom: 25px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Ensure original cards look good inside the panels */
        .expanded-side-panel .card {
            box-shadow: none !important;
            border: 1px solid #f1f5f9 !important;
            margin-bottom: 1.5rem;
        }

        /* 6. Return Button Styling */
        .btn-close-expanded {
            position: absolute;
            top: 20px;
            right: 40px;
            z-index: 10001;
            padding: 12px 30px;
            font-size: 1.1rem;
            border-radius: 50px;
            background: #ef4444;
            color: white;
            border: none;
            font-weight: bold;
        }

        /* Styling for the structural info when inside the dark overlay */
        #imageDest .text-dark {
            color: #e2e8f0 !important; /* Lighten text for dark background */
        }
        #imageDest .bg-light {
            background-color: rgba(255, 255, 255, 0.05) !important; /* Subtle transparent background */
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
        }
        #imageDest .badge.bg-info {
            background-color: #0ea5e9 !important; /* Ensure visibility */
        }
    </style>

    <div id="profileOverlay" class="profile-expanded-overlay">
        <div class="text-center mb-3">
            <button class="btn btn-danger btn-rounded fw-bold px-5 shadow" onclick="closeProfile()">
                <i class="bi bi-x-circle me-2"></i>Quitter le mode plein écran
            </button>
        </div>

        <div class="profile-expanded-content">
            <div class="expanded-side-panel" id="personalDest">
            </div>

            <div class="expanded-image-center" id="imageDest">
            </div>

            <div class="expanded-side-panel" id="professionalDest">
            </div>
        </div>
    </div>

    <div class="container-fluid py-4">
        {{-- En-tête Profil Premium --}}
        <div class="card border-0 shadow-lg rounded-4 mb-4 overflow-hidden">
            {{-- Header Section --}}
            <div class="bg-primary bg-gradient p-4 text-white position-relative">

                {{-- FIX 1: Added pointer-events: none so this doesn't block clicks --}}
                <div class="position-absolute top-0 end-0 p-4 opacity-10" style="pointer-events: none; z-index: 0;">
                    <i class="bi bi-person-bounding-box" style="font-size: 8rem;"></i>
                </div>

                <div class="position-relative" style="z-index: 1;">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-4">

                        {{-- Left Side: Avatar & Identity --}}
                        <div class="d-flex align-items-center gap-4">
                            <div class="position-relative">
                                {{-- FIX 2: Added 'employee-avatar' class and higher z-index --}}
                                @if($employee->photo && Storage::disk('public')->exists($employee->photo))
                                    <img src="{{ Storage::url($employee->photo) }}"
                                         alt="{{ $employee->firstname }}"
                                         class="employee-avatar rounded-circle border border-4 border-white shadow-lg object-fit-cover"
                                         width="110" height="110"
                                         style="cursor: pointer; position: relative; z-index: 10;">
                                @else
                                    <div class="employee-avatar rounded-circle border border-4 border-white d-flex align-items-center justify-content-center text-white fw-bold shadow-lg fs-1"
                                         style="width:110px;height:110px;background:linear-gradient(135deg,#6366f1 0%,#a855f7 100%); cursor: pointer; position: relative; z-index: 10;">
                                        {{ strtoupper(substr($employee->firstname,0,1)) }}{{ strtoupper(substr($employee->lastname,0,1)) }}
                                    </div>
                                @endif
                                {{-- Status Dot: pointer-events: none ensures it doesn't block the corner of the image --}}
                                <span class="position-absolute bottom-0 end-0 p-2 bg-{{ $employee->status == 1 ? 'success' : 'danger' }} border border-3 border-white rounded-circle shadow"
                                      style="z-index: 11; pointer-events: none;"></span>
                            </div>

                            <div>
                                <h1 class="h3 fw-bold mb-2 text-white">{{ $employee->firstname }} {{ strtoupper($employee->lastname) }}</h1>
                                <div class="d-flex flex-wrap gap-2 mb-3">
                            <span class="badge bg-white bg-opacity-25 text-white border border-white border-opacity-50 rounded-pill px-3 py-2">
                                <i class="bi bi-hash me-1"></i>PPR: {{ $employee->ppr }}
                            </span>
                                    @if($employee->cin)
                                        <span class="badge bg-white bg-opacity-25 text-white border border-white border-opacity-50 rounded-pill px-3 py-2">
                                    <i class="bi bi-person-vcard me-1"></i>{{ $employee->cin }}
                                </span>
                                    @endif
                                </div>
                                <span class="badge rounded-pill bg-{{ $employee->status == 1 ? 'success' : 'danger' }} px-3 py-2 fw-bold shadow-sm">
                            <i class="bi {{ $employee->status == 1 ? 'bi-check-circle-fill' : 'bi-x-circle-fill' }} me-2"></i>
                            {{ $employee->status == 1 ? 'Agent Actif' : 'Agent Inactif' }}
                        </span>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex gap-2">
                            <a href="{{ route('employees.index') }}" class="btn btn-light btn-sm px-4 fw-bold rounded-pill shadow-sm">
                                <i class="bi bi-arrow-left me-2"></i>Retour
                            </a>

                            <a href="{{ route('employees.edit', $employee) }}" class="btn btn-warning btn-sm px-4 fw-bold rounded-pill shadow-sm">
                                <i class="bi bi-pencil-square me-2"></i>Modifier
                            </a>

                            <button type="button"
                                    class="btn btn-info btn-sm px-4 fw-bold rounded-pill shadow-sm text-white"
                                    data-bs-toggle="modal"
                                    data-bs-target="#changeStateModal">
                                <i class="bi bi-pencil-square me-2"></i>Situation
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <x-change-situation-emmployee :employee="$employee" />

            {{-- Body Section --}}
            <div class="card-body p-4 bg-white">
                @php $activeAff = $employee->affectations->where('state', 1)->first(); @endphp
                @if($activeAff)
                    <h6 class="text-uppercase text-primary fw-bolder mb-3 ls-1 small">
                        <i class="bi bi-diagram-3-fill me-2"></i>Affectation Structurelle Active :
                        @if (!is_null($activeAff->section))
                            <span class="badge bg-info"> {{ $activeAff->section->title }} </span>
                        @endif
                        @if (!is_null($activeAff->sector))
                            <span class="badge bg-info"> {{ $activeAff->sector->title }} </span>
                        @endif
                    </h6>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="p-3 rounded-4 bg-light border-start border-4 border-primary h-100">
                                <small class="text-muted d-block mb-1 fw-bold text-uppercase" style="font-size: 0.7rem;">Service</small>
                                <span class="fw-bold text-dark fs-5">{{ $activeAff->service->title ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded-4 bg-light border-start border-4 border-info h-100">
                                <small class="text-muted d-block mb-1 fw-bold text-uppercase" style="font-size: 0.7rem;">Direction / Entité</small>
                                <span class="fw-bold text-dark fs-5">{{ $activeAff->entity->title ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center p-5 bg-light rounded-4 border border-dashed">
                        <i class="bi bi-exclamation-circle text-muted fs-2 opacity-50"></i>
                        <p class="text-muted small mb-0 mt-2">Aucune affectation active enregistrée.</p>
                        <a class="dropdown-item rounded-3 py-2" href="{{ route('employees.unities', $employee) }}"><i class="bi bi-diagram-3 text-primary me-2"></i>Gérer l'affectation</a>
                    </div>
                @endif
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
                                    <span class="text-dark fw-semibold">
                                        @if ($employee->sit == 'C')
                                            Célébataire
                                        @elseif($employee->sit == 'D')
                                            Divorcé
                                        @elseif($employee->sit == 'M')
                                            Marie
                                        @else
                                            {{ $employee->sit }}
                                        @endif

                                    </span>
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
                                    <div class="p-2 border-start border-4 {{ \Carbon\Carbon::parse($employee->birth_date)->age >= 62 ? 'border-info' : 'border-light' }}">
                                        <p class="text-muted small fw-bold text-uppercase mb-1">Départ à la retraite</p>

                                        @if (\Carbon\Carbon::parse($employee->birth_date)->age >= 62 && is_null($employee->retiring_date))
                                            <span class="text-primary fw-bold">
                                            <i class="bi bi-arrow-right-circle me-1"></i> À mettre en retrait
                                        </span>
                                        @else
                                            <div class="d-flex align-items-center">
                                                <span class="fs-5 fw-bold text-dark">
                                                    {{ $employee->retiring_date ? \Carbon\Carbon::parse($employee->retiring_date)->format('d F Y') : \Carbon\Carbon::parse($employee->birth_date)->age . ' ans' }}
                                                </span>
                                                <small class="ms-2 text-muted italic">/ 62 ans</small>
                                            </div>
                                        @endif
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
                                    <button class="btn btn-primary btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#affectOccupationModal"><i class="bi bi-plus-lg"></i></button>
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
                                <button class="btn btn-primary btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#affectGradeModal"><i class="bi bi-plus-lg"></i></button>
                            </div>
                            <div class="card-body p-4 pt-2">
                                @forelse($employee->competences as $competence)
                                    <div class="p-3 bg-light rounded-3 border mb-2 d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="fw-bold text-dark">{{ $competence->grade->title }}</span><br>
                                            <span class="fw-bold text-success">échelle : {{ $competence->grade->scale }}</span><br>
                                            <span class="fw-bold text-info">échellon : {{ $competence->echellon->title ?? 'N/A' }}</span>
                                        </div>
                                        <button class="btn btn-sm btn-outline-danger border-0" data-bs-toggle="modal" data-bs-target="#deleteCompetenceModal-{{ $competence->id }}"><i class="bi bi-trash3"></i></button>
                                    </div>
                                @empty
                                    <div class="text-center py-3 border border-dashed rounded-3"><p class="small text-muted mb-0">Grade non défini</p></div>
                                @endforelse
                            </div>
                            @foreach($employee->competences as $competence)
                                <x-delete-model
                                    href="{{ route('competences.delete', $competence->id) }}"
                                    message="Attention : La suppression du grade {{ $competence->grade->title }}  est irréversible."
                                    title="Confirmation de Suppression du grade"
                                    target="deleteCompetenceModal-{{ $competence->id }}" />
                            @endforeach
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
                                        @forelse($employee->qualifications->sortByDesc('year') as $qualification)
                                            <tr>
                                                <td class="fw-bold text-dark border-0">{{ $qualification->diploma->title }}</td>
                                                <td class="fw-bold text-dark border-0">{{ $qualification->option->title ?? '-' }}</td>
                                                <td class="text-center border-0"><span class="badge bg-secondary rounded-pill px-3">{{ $qualification->year ?? '-' }}</span></td>
                                                <td class="text-end border-0">
                                                    <button class="btn btn-sm btn-light border-0 rounded-circle text-danger shadow-xs"
                                                            data-bs-toggle="modal" data-bs-target="#deleteQualificationModal-{{ $qualification->id }}">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="3" class="text-center py-4 border-0 text-muted italic">Aucun diplôme renseigné</td></tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                    @foreach($employee->qualifications as $qualification)
                                    <x-delete-model
                                        href="{{ route('qualifications.delete', $qualification->id) }}"
                                        message="Attention : La suppression du {{ $qualification->diploma->title }}  est irréversible."
                                        title="Confirmation de Suppression du diplôme"
                                        target="deleteQualificationModal-{{ $qualification->id }}" />
                                    @endforeach
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
    <x-affect-diploma-modal :employee="$employee" :diplomas="$diplomas" :options="$options" />
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('dblclick', function(e) {
                const trigger = e.target.closest('.employee-avatar');

                if (trigger) {
                    // 1. Setup the Image/Avatar for the Overlay
                    const imageContainer = document.getElementById('imageDest');
                    if (imageContainer) {
                        // Clone the image
                        const imgClone = trigger.cloneNode(true);
                        imgClone.style.cursor = 'default';

                        imageContainer.innerHTML = '';
                        imageContainer.appendChild(imgClone);

                        // --- NEW STEP: Grab and Inject Structural Info ---
                        // Find the structural info inside the main card body
                        const structuralSource = document.querySelector('.card-body.p-4.bg-white');
                        if (structuralSource) {
                            const structuralClone = structuralSource.cloneNode(true);

                            // Create a wrapper for styling
                            const infoWrapper = document.createElement('div');
                            infoWrapper.className = 'mt-4 w-100 text-start px-4 overflow-auto';
                            infoWrapper.style.maxHeight = '200px'; // Prevent it from pushing too far down
                            infoWrapper.innerHTML = structuralClone.innerHTML;

                            imageContainer.appendChild(infoWrapper);
                        }
                    }

                    // 2. Grab Personal Info (Left Column)
                    const personalSource = document.querySelector('.col-lg-4');
                    const personalDest = document.getElementById('personalDest');
                    if (personalSource && personalDest) {
                        const personalClone = personalSource.cloneNode(true);
                        personalClone.querySelectorAll('.btn, a.btn').forEach(btn => btn.remove());
                        personalDest.innerHTML = '<h3 class="mb-4 fw-bold text-primary border-bottom pb-2">Dossier Personnel</h3>' + personalClone.innerHTML;
                    }

                    // 3. Grab Professional Info (Right Column)
                    const professionalSource = document.querySelector('.col-lg-8');
                    const professionalDest = document.getElementById('professionalDest');
                    if (professionalSource && professionalDest) {
                        const professionalClone = professionalSource.cloneNode(true);
                        professionalClone.querySelectorAll('.btn, a.btn').forEach(btn => btn.remove());
                        professionalDest.innerHTML = '<h3 class="mb-4 fw-bold text-info border-bottom pb-2">Parcours & Qualifications</h3>' + professionalClone.innerHTML;
                    }

                    // 4. Display Overlay
                    const overlay = document.getElementById('profileOverlay');
                    if (overlay) {
                        overlay.style.display = 'block';
                        document.body.style.overflow = 'hidden';
                    }
                }
            });

            document.addEventListener('mouseover', function(e) {
                if (e.target.closest('.employee-avatar')) {
                    e.target.closest('.employee-avatar').style.cursor = 'zoom-in';
                }
            });
        });

        function closeProfile() {
            const overlay = document.getElementById('profileOverlay');
            if (overlay) {
                overlay.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === "Escape") closeProfile();
        });
    </script>
</x-layout>
