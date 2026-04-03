<x-layout>
    @section('title', 'Gestion Profil Responsable - ' . $chef->employee->lastname)

    <div class="container-fluid py-4 px-md-5">
        {{-- En-tête Futuriste --}}
        <div class="card border-0 shadow-lg rounded-5 mb-5 overflow-hidden position-relative">
            <div class="card-body p-0">
                <div class="header-gradient p-4 p-md-5 text-white">
                    {{-- Icône décorative --}}
                    <div class="position-absolute top-0 end-0 p-5 opacity-10 d-none d-lg-block">

                    </div>

                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-4 position-relative">
                        <div class="d-flex align-items-center">
                            <div class="glass-icon-wrapper me-4">
                                <i class="bi bi-shield-lock-fill fs-2"></i>
                            </div>
                            <div>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb mb-1 extra-small text-uppercase fw-bold ls-1">
                                        <li class="breadcrumb-item"><a href="{{ route('chefs.index') }}" class="text-white text-opacity-75 text-decoration-none">Gouvernance</a></li>
                                        <li class="breadcrumb-item active text-white" aria-current="page">Profil Direction</li>
                                    </ol>
                                </nav>
                                <h1 class="fw-bold mb-0 display-6">Gestion du <span class="text-white-50">Profil Responsable</span></h1>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('chefs.index') }}" class="btn btn-glass-light btn-rounded px-4 py-2 fw-bold transition-base">
                                <i class="bi bi-arrow-left-short fs-5 me-1"></i>Retour
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Colonne Gauche : Identité & Status --}}
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                    <div class="card-body p-4 p-xl-5">
                        <div class="text-center mb-5">
                            <div class="profile-biometric-wrapper mb-4">
                                <x-employee-card :employee="$chef->employee" detach="false" />
                            </div>
                        </div>

                        <div class="stats-grid">
                            <div class="stats-item p-3 mb-3 rounded-4 bg-light d-flex justify-content-between align-items-center transition-base hover-lift">
                                <div class="d-flex align-items-center">
                                    <div class="icon-node-small me-3 bg-primary-subtle text-primary">
                                        <i class="bi bi-calendar-check"></i>
                                    </div>
                                    <span class="text-muted fw-bold small text-uppercase">Nomination</span>
                                </div>
                                <span class="badge-cyber active">
                                    {{ \Carbon\Carbon::parse($chef->starting_date)->format('d F Y') }}
                                </span>
                            </div>

                            <div class="stats-item p-3 mb-3 rounded-4 bg-light d-flex justify-content-between align-items-center transition-base hover-lift">
                                <div class="d-flex align-items-center">
                                    <div class="icon-node-small me-3 bg-warning-subtle text-warning">
                                        <i class="bi bi-hourglass-split"></i>
                                    </div>
                                    <span class="text-muted fw-bold small text-uppercase">Expérience Directionnelle</span>
                                </div>
                                @php
                                    $interval = \Carbon\Carbon::parse($chef->starting_date)->diff(now());
                                @endphp
                                <div class="text-end">
                                    <div class="fw-bold text-dark h5 mb-0">{{ $interval->y }} <small class="text-muted">Ans</small></div>
                                    <div class="extra-small text-muted fw-bold">{{ $interval->m }} Mois</div>
                                </div>
                            </div>

                            <div class="stats-item p-3 rounded-4 bg-light d-flex justify-content-between align-items-center transition-base hover-lift">
                                <div class="d-flex align-items-center">
                                    <div class="icon-node-small me-3 bg-danger-subtle text-danger">
                                        <i class="bi bi-file-earmark-lock"></i>
                                    </div>
                                    <span class="text-muted fw-bold small text-uppercase">Acte de Décision</span>
                                </div>
                                <a href="{{ Storage::url($chef->decision_file) }}" target="_blank" class="btn btn-action-circle text-danger bg-white border shadow-sm">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Colonne Droite : Update Node --}}
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 h-100 bg-white overflow-hidden">
                    <div class="card-header bg-transparent py-4 px-4 border-bottom-0">
                        <div class="d-flex align-items-center">
                            <span class="p-2 bg-warning-subtle text-warning rounded-3 me-3">
                                <i class="bi bi-pencil-square"></i>
                            </span>
                            <h5 class="fw-bold text-dark mb-0">Édition des Données Logiques</h5>
                        </div>
                    </div>
                    <div class="card-body p-4 p-xl-5">
                        <form action="{{ route('chefs.update', $chef) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-4">
                                <label class="input-label">Date de Prise de Fonction</label>
                                <div class="input-group-futurist">
                                    <x-date-input id="starting_date" name="starting_date" value="null" class="form-control futurist-input" />
                                    <i class="bi bi-calendar3 input-icon"></i>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="input-label">Téléverser Nouvelle Décision (PDF)</label>
                                <div class="input-group-futurist">
                                    <input type="file" name="decision_file" class="form-control futurist-input" id="decision_file">
                                    <i class="bi bi-cloud-arrow-up input-icon"></i>
                                </div>
                                <div class="form-text extra-small mt-3 text-muted">
                                    <i class="bi bi-info-circle-fill me-1"></i> Laissez vide pour conserver l'archive système actuelle.
                                </div>
                            </div>

                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 pt-5 border-top">
                                <button type="button" class="btn btn-link text-decoration-none text-muted fw-bold extra-small text-uppercase ls-1">
                                    Réinitialiser le formulaire
                                </button>
                                <button type="submit" class="btn btn-futurist-warning px-5 py-3 rounded-pill fw-bold shadow-sm transition-base">
                                    <i class="bi bi-shield-check me-2"></i>Mettre à jour les paramètres
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            --warning-gradient: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            --accent-glow: rgba(99, 102, 241, 0.15);
        }

        body { background-color: #f8fafc; }

        .header-gradient { background: var(--primary-gradient); position: relative; }

        .glass-icon-wrapper {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            width: 64px; height: 64px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 20px; border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .btn-glass-light {
            background: rgba(255, 255, 255, 0.15);
            color: white; border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(5px);
        }

        .btn-glass-dark {
            background: rgba(0, 0, 0, 0.2);
            color: white; border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
        }

        .btn-futurist-warning {
            background: var(--warning-gradient);
            color: white; border: none;
            box-shadow: 0 10px 20px -5px rgba(245, 158, 11, 0.3);
        }
        .btn-futurist-warning:hover { color: white; transform: translateY(-2px); filter: brightness(1.1); }

        /* Futurist Inputs */
        .input-label {
            font-size: 0.75rem; font-weight: 800; text-transform: uppercase;
            letter-spacing: 0.05em; color: #64748b; margin-bottom: 0.75rem; display: block;
        }

        .input-group-futurist { position: relative; }
        .futurist-input {
            background-color: #f1f5f9 !important;
            border: 2px solid transparent !important;
            padding: 14px 16px 14px 48px !important;
            border-radius: 16px !important;
            font-weight: 600; transition: all 0.3s ease;
        }
        .futurist-input:focus {
            background-color: #fff !important;
            border-color: #f59e0b !important;
            box-shadow: 0 0 0 5px rgba(245, 158, 11, 0.1) !important;
        }
        .input-icon { position: absolute; left: 18px; top: 50%; transform: translateY(-50%); color: #64748b; z-index: 10; }

        /* Metrics & Nodes */
        .icon-node-small {
            width: 42px; height: 42px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
        }

        .badge-cyber {
            background: #fff; color: #475569; border: 1.5px solid #e2e8f0;
            padding: 6px 14px; border-radius: 50px; font-weight: 700; font-size: 0.75rem;
        }
        .badge-cyber.active { background: #eef2ff; color: #6366f1; border-color: #c7d2fe; }

        .btn-action-circle {
            width: 38px; height: 38px; border-radius: 50%; border: none;
            display: inline-flex; align-items: center; justify-content: center;
        }

        .transition-base { transition: all 0.25s ease; }
        .hover-lift:hover { transform: translateY(-5px); }
        .ls-1 { letter-spacing: 0.05em; }
        .extra-small { font-size: 0.7rem; }
        .btn-rounded { border-radius: 50px; }
    </style>
</x-layout>
