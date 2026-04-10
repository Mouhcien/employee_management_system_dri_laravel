
    @section('title', 'Détails de l\'employé - ' . $employee->firstname)

    @vite(['resources/css/app.css', 'resources/css/toastr.min.css'])

    <style>
        /* 1. Overlay & Layout Base */
        .profile-expanded-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.98);
            backdrop-filter: blur(20px);
            z-index: 9999;
            padding: 40px;
            overflow-y: auto;
        }

        .profile-expanded-content {
            display: flex;
            align-items: flex-start;
            justify-content: center;
            gap: 30px;
            max-width: 1800px;
            margin: 0 auto;
        }

        /* 2. Professional Panels */
        .expanded-side-panel {
            flex: 1;
            background: #f8fafc; /* Ultra light slate */
            border-radius: 28px;
            height: 88vh;
            overflow-y: auto;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* 3. Center Image Strategy */
        .expanded-image-center {
            flex: 0 0 550px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .expanded-image-center img,
        .expanded-image-center .avatar-placeholder {
            width: 480px !important;
            height: 480px !important;
            object-fit: cover;
            border-radius: 40px !important;
            border: 10px solid white;
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }

        /* 4. Typography & Accents */
        .panel-section-title {
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #6366f1; /* Indigo */
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .data-label { font-size: 0.7rem; color: #64748b; text-transform: uppercase; font-weight: 700; }
        .data-value { font-size: 0.95rem; color: #1e293b; font-weight: 600; }

        /* Custom Scrollbar */
        .expanded-side-panel::-webkit-scrollbar { width: 6px; }
        .expanded-side-panel::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

        /* Close Button */
        .btn-close-expanded {
            position: fixed;
            top: 30px;
            right: 30px;
            z-index: 10001;
            background: #ef4444;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 700;
            box-shadow: 0 10px 15px -3px rgba(239, 68, 68, 0.4);
        }
    </style>

    <div class="container-fluid py-3 mb-2 d-print-none">
        <div class="d-flex justify-content-between align-items-center bg-white p-3 rounded-4 shadow-sm border">
            <div>
                <h5 class="fw-bold text-dark mb-0">
                    <i class="bi bi-file-earmark-person me-2 text-primary"></i>Fiche de Suivi Individuelle
                </h5>
            </div>
            <div class="d-flex gap-2">

                <a href="javascript:window.history.back();" class="btn btn-light border rounded-pill px-4 fw-bold">
                    <i class="bi bi-x-lg me-2"></i>Fermer
                </a>
            </div>
        </div>
    </div>

    <div class="container-fluid py-4">
        <div class="profile-expanded-content">

            {{-- LEFT COLUMN: Identity & Contact --}}
            <div class="expanded-side-panel shadow-lg" id="personalDest" style="background-color: #f8fafc; border-radius: 24px;">
                <div class="p-4 d-flex flex-column gap-4">

                    {{-- Identity Card --}}
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold text-uppercase text-secondary small mb-0 tracking-wider">
                                    <i class="bi bi-person-badge-fill text-primary me-2"></i>État Civil
                                </h6>
                                <span class="badge rounded-pill bg-{{ $employee->status == 1 ? 'success' : 'danger' }}-subtle text-{{ $employee->status == 1 ? 'success' : 'danger' }} px-3 py-2 fw-bolder border border-{{ $employee->status == 1 ? 'success' : 'danger' }} border-opacity-25">
                                {{ $employee->status == 1 ? 'ACTIF' : 'INACTIF' }}
                            </span>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <div class="text-center mb-4 p-3 bg-light rounded-4 border border-dashed">
                                <h2 class="h4 fw-bold mb-1 text-dark">{{ $employee->firstname }} {{ strtoupper($employee->lastname) }}</h2>
                                <div class="d-flex justify-content-center gap-2 mt-2">
                                    <span class="badge bg-white text-primary border rounded-pill px-3 shadow-xs">PPR: {{ $employee->ppr }}</span>
                                    @if($employee->cin)
                                        <span class="badge bg-white text-muted border rounded-pill px-3 shadow-xs">CIN: {{ $employee->cin }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="d-flex flex-column gap-3">
                                <div class="p-3 bg-primary bg-opacity-10 border-start border-4 border-primary rounded-3">
                                    <small class="text-primary text-uppercase fw-bold extra-small d-block mb-1 opacity-75">Nom (Arabe)</small>
                                    <span class="fw-bold text-dark fs-5 font-arabic" dir="rtl">{{ $employee->firstname_arab }} {{ $employee->lastname_arab }}</span>
                                </div>

                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="p-2 border rounded-3 bg-white shadow-xs text-center">
                                            <small class="text-muted d-block extra-small fw-bold">GENRE</small>
                                            <span class="fw-bold text-{{ $employee->gender === 'F' ? 'danger' : 'info' }}">
                                            <i class="bi bi-gender-{{ $employee->gender === 'F' ? 'female' : 'male' }} me-1"></i>{{ $employee->gender === 'F' ? 'Féminin' : 'Masculin' }}
                                        </span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-2 border rounded-3 bg-white shadow-xs text-center">
                                            <small class="text-muted d-block extra-small fw-bold">SITUATION</small>
                                            <span class="text-dark fw-bold">
                                            @if ($employee->sit == 'C') Célébataire @elseif($employee->sit == 'D') Divorcé @elseif($employee->sit == 'M') Marié @else {{ $employee->sit }} @endif
                                        </span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block extra-small fw-bold">NÉ(E) LE</small>
                                        <span class="text-dark fw-semibold small">{{ $employee->birth_date ? \Carbon\Carbon::parse($employee->birth_date)->format('d/m/Y') : '—' }}</span>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block extra-small fw-bold">À</small>
                                        <span class="text-dark fw-semibold small text-truncate d-block">{{ $employee->birth_city ?? '—' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Contact Card --}}
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                            <h6 class="fw-bold text-uppercase text-secondary small mb-0 tracking-wider"><i class="bi bi-geo-alt-fill text-success me-2"></i>Coordonnées</h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center p-3 mb-3 bg-success bg-opacity-10 rounded-4 border border-success border-opacity-10">
                                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 40px; height: 40px;"><i class="bi bi-telephone"></i></div>
                                <div>
                                    <small class="text-muted d-block extra-small fw-bold">TÉLÉPHONE</small>
                                    <span class="fw-bold text-dark">{{ $employee->tel ?? '—' }}</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center p-3 mb-3 bg-warning bg-opacity-10 rounded-4 border border-warning border-opacity-10">
                                <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 40px; height: 40px;"><i class="bi bi-envelope"></i></div>
                                <div class="text-truncate">
                                    <small class="text-muted d-block extra-small fw-bold">EMAIL</small>
                                    <a href="mailto:{{ $employee->email }}" class="fw-bold text-dark text-decoration-none">{{ $employee->email ?? '—' }}</a>
                                </div>
                            </div>
                            <div class="p-3 bg-light rounded-4">
                                <small class="text-muted d-block extra-small fw-bold mb-1">ADRESSE</small>
                                <span class="text-dark fw-semibold small d-block mb-1 lh-sm">{{ $employee->address ?? '—' }}</span>
                                @if($employee->city)<span class="badge bg-white text-muted border px-2 py-1 shadow-xs">{{ $employee->city }}</span>@endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CENTER: Image --}}
            <div class="expanded-image-center" id="imageDest">
                <div class="position-relative">
                    @if($employee->photo && Storage::disk('public')->exists($employee->photo))
                        <img src="{{ Storage::url($employee->photo) }}"
                             alt="{{ $employee->firstname }}"
                             class="employee-avatar rounded-circle border border-5 border-white shadow-lg object-fit-cover"
                             width="180" height="180"
                             style="cursor: pointer; position: relative; z-index: 10;">
                    @else
                        <div class="employee-avatar rounded-circle border border-5 border-white d-flex align-items-center justify-content-center text-white fw-bold shadow-lg fs-1"
                             style="width:180px;height:180px;background:linear-gradient(135deg,#6366f1 0%,#a855f7 100%); cursor: pointer; position: relative; z-index: 10;">
                            {{ strtoupper(substr($employee->firstname,0,1)) }}{{ strtoupper(substr($employee->lastname,0,1)) }}
                        </div>
                    @endif
                    <div class="mt-3 text-center">
                        <span class="badge bg-white text-dark shadow-sm border rounded-pill px-4 py-2 fw-bold">{{ $employee->local->title ?? 'Bureau Central' }}</span>
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN: Professional --}}
            <div class="expanded-side-panel" id="professionalDest" style="background-color: #f8fafc; border-radius: 24px;">
                <div class="p-4 d-flex flex-column gap-4">

                    {{-- Professional Info --}}
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-header bg-white border-bottom py-3 px-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold text-uppercase text-secondary small mb-0 tracking-wider"><i class="bi bi-briefcase-fill text-info me-2"></i>Parcours</h6>
                                <span class="badge bg-info-subtle text-info border border-info border-opacity-10 rounded-pill px-3">{{ $employee->local->title ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <div class="col-md-6 border-end">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light rounded-3 p-2 me-3 text-info shadow-xs"><i class="bi bi-calendar2-check fs-5"></i></div>
                                        <div>
                                            <small class="text-muted text-uppercase extra-small fw-bold d-block">Recrutement</small>
                                            <span class="fw-bold text-dark small">{{ $employee->hiring_date ? \Carbon\Carbon::parse($employee->hiring_date)->format('d/m/Y') : '—' }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light rounded-3 p-2 me-3 text-secondary shadow-xs"><i class="bi bi-hourglass-split fs-5"></i></div>
                                        <div>
                                            <small class="text-muted text-uppercase extra-small fw-bold d-block">Retraite</small>
                                            @if (\Carbon\Carbon::parse($employee->birth_date)->age >= 63)
                                                <span class="text-danger fw-bold small">À METTRE EN RETRAIT</span>
                                            @else
                                                <span class="fw-bold text-dark small">{{ \Carbon\Carbon::parse($employee->birth_date)->addYears(63)->format('d/m/Y') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 mt-3">
                                <div class="col-md-4">
                                    <div class="p-2 border rounded-3 bg-light-subtle text-center">
                                        <small class="text-muted d-block extra-small fw-bold">CARTE</small>
                                        <span class="fw-bold text-dark small">{{ $employee->commission_card ?? '—' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="p-2 border rounded-3 bg-light-subtle text-center">
                                        <small class="text-muted d-block extra-small fw-bold">DÉBUT FONCTION PUBLIQUE</small>
                                        <span class="fw-bold text-dark small">{{ $employee->hiring_public_date ? \Carbon\Carbon::parse($employee->hiring_public_date)->format('d/m/Y') : '—' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Career Cards Grid --}}
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="card border-0 shadow-sm rounded-4 h-100">
                                <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between">
                                    <h6 class="fw-bold text-secondary small mb-0 text-uppercase tracking-wider">Grade</h6>
                                </div>
                                <div class="card-body p-4 pt-2">
                                    @forelse($employee->competences->sortByDesc('starting_date') as $competence)
                                        <div class="p-2 bg-light rounded-3 border mb-2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-bold text-dark small">{{ $competence->grade->title }}</span>
                                            </div>
                                            <div class="mt-1">
                                                <span class="badge bg-success bg-opacity-10 text-success extra-small">Éch: {{ $competence->grade->scale }}</span>
                                                <span class="badge bg-success-subtle text-success mt-1"> {{ \Carbon\Carbon::parse($competence->starting_date)->format('d/m/Y') ?? '—' }}</span>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-2 border border-dashed rounded-3"><p class="extra-small text-muted mb-0">Non défini</p></div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Affectations Card --}}
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                            <h6 class="fw-bold text-uppercase text-secondary small mb-0 tracking-wider"><i class="bi bi-diagram-3-fill text-primary me-2"></i>Historique d'Affectation</h6>
                        </div>
                        <div class="card-body p-4">
                            @forelse($employee->affectations->sortByDesc('affectation_date') as $affectation)
                                <div class="mb-3 border-bottom pb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="badge bg-primary rounded-pill me-2 px-3">{{ \Carbon\Carbon::parse($affectation->affectation_date)->format('d/m/Y') }}</span>
                                        <div class="flex-grow-1 border-top opacity-25"></div>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <div class="p-2 rounded-3 bg-light shadow-xs border-start border-3 border-primary">
                                                <small class="text-muted d-block extra-small fw-bold">SERVICE</small>
                                                <span class="fw-bold text-dark small">{{ $affectation->service->title ?? 'N/A' }}</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="p-2 rounded-3 bg-light shadow-xs border-start border-3 border-info">
                                                <small class="text-muted d-block extra-small fw-bold">UNITÉ/DIRECTION</small>
                                                <span class="fw-bold text-dark small text-truncate d-block">{{ $affectation->entity->title ?? 'N/A' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="d-flex flex-wrap gap-2 bg-white p-3 rounded-3 border shadow-xs">
                                            <span class="fw-bold text-dark"> Fonction :  </span>
                                            <span class="badge bg-success ms-2">{{ $affectation->occupation->title ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center p-4 bg-light rounded-4 border border-dashed">
                                    <p class="text-muted small mb-0">Aucune affectation enregistrée.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="container-fluid mt-5 p-4">
            @include('app.audit.values.partials.values-table-view', ['values' => $values])
        </div>
    </div>

    <style>
        /* Professional Micro-Styles */
        .extra-small { font-size: 0.72rem; }
        .tracking-wider { letter-spacing: 0.08em; }
        .shadow-xs { box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
        .font-arabic { font-family: 'Segoe UI', Tahoma, sans-serif; line-height: 1.6; }
        .badge-subtle { border: 1px solid currentColor; }
        .expanded-side-panel { transition: all 0.3s ease; }

        /* Center Layout Fix */
        .profile-expanded-content {
            display: flex;
            align-items: flex-start;
            justify-content: center;
            gap: 2rem;
        }

        .expanded-image-center {
            position: sticky;
            top: 2rem;
            flex-shrink: 0;
        }
    </style>

