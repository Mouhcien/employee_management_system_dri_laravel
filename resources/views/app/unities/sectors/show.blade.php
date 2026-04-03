<x-layout>
    @section('title', 'Détails du Secteur - ' . $sector->title)

    <div class="container-fluid py-4 px-md-5">
        {{-- Futurist Glass Header --}}
        <div class="card border-0 shadow-lg rounded-5 mb-5 overflow-hidden position-relative">
            <div class="card-body p-0">
                <div class="header-gradient p-4 p-md-5 text-white">
                    {{-- Decorative Filigree --}}
                    <div class="position-absolute top-0 end-0 p-5 opacity-10 d-none d-lg-block">

                    </div>

                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-4 position-relative">
                        <div class="d-flex align-items-center">
                            <div class="glass-icon-wrapper me-4">
                                <i class="bi bi-grid-1x2-fill fs-2"></i>
                            </div>
                            <div>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb mb-1 extra-small text-uppercase fw-bold ls-1">
                                        <li class="breadcrumb-item"><a href="{{ route('sectors.index') }}" class="text-white text-opacity-75 text-decoration-none">Architecture</a></li>
                                        <li class="breadcrumb-item active text-white" aria-current="page">Sector Node</li>
                                    </ol>
                                </nav>
                                <h1 class="fw-bold mb-0 display-6">{{ $sector->title }}</h1>

                                {{-- Logic Path Badges --}}
                                <div class="d-flex flex-wrap gap-2 mt-3">
                                    <span class="badge-cyber-light active">
                                        <i class="bi bi-building me-1"></i> {{ $sector->entity->service->title ?? 'Service Global' }}
                                    </span>
                                    <span class="badge-cyber-light">
                                        <i class="bi bi-diagram-3 me-1"></i> {{ $sector->entity->title ?? 'Entité Racine' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('sectors.index') }}" class="btn btn-glass-light btn-rounded px-4 py-2 fw-bold shadow-sm transition-base">
                                <i class="bi bi-arrow-left-short fs-5 me-1"></i>Retour
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Left Column: Management & Tools --}}
            <div class="col-lg-4 order-2 order-lg-1">
                {{-- Leadership Module --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white overflow-hidden">
                    <div class="card-header bg-dark p-4 border-0 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 text-white fw-bold"><i class="bi bi-shield-lock me-2 text-primary"></i>Résponsable</h6>
                        <span class="badge bg-primary text-white extra-small fw-bold px-2 py-1">LEAD</span>
                    </div>
                    <div class="card-body p-4">
                        @if($sector->chefs->where('state', true)->isNotEmpty())
                            @foreach($sector->chefs->where('state', true) as $chef)
                                <div class="hover-lift transition-base">
                                    <x-chef-card :employee="$chef->employee" detach="true" :chef="$chef" />
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-4 border-2 border-dashed border-light rounded-5 bg-light-subtle">
                                <div class="icon-node-vacant mb-2 mx-auto">
                                    <i class="bi bi-person-x"></i>
                                </div>
                                <p class="text-muted extra-small fw-bold text-uppercase ls-1 mb-0">Direction Vacante</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Data Injection Module --}}
                <div class="card border-0 shadow-sm rounded-4 bg-primary text-white overflow-hidden">
                    <div class="card-body p-4 p-xl-5">
                        <h6 class="fw-bold mb-3 d-flex align-items-center">
                            <i class="bi bi-cloud-arrow-up-fill me-2"></i>
                            Importation PPR
                        </h6>
                        <p class="text-white text-opacity-75 extra-small mb-4">Chargez l'effectif directement via flux Excel.</p>

                        <form action="{{ route('affectations.sectors.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="sector_id" value="{{ $sector->id }}">
                            <div class="mb-4">
                                <div class="input-group-futurist glass">
                                    <input type="file" class="form-control futurist-input" name="file" required>
                                    <i class="bi bi-file-earmark-excel input-icon"></i>
                                </div>
                            </div>
                            <button class="btn btn-white w-100 rounded-pill py-2 fw-bold shadow-sm">
                                <i class="bi bi-cpu me-2"></i>Lancer le traitement
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Right Column: Employee Grid --}}
            <div class="col-lg-8 order-1 order-lg-2">
                <div class="card border-0 shadow-lg rounded-4 h-100 bg-white">
                    <div class="card-header bg-transparent py-4 px-4 border-bottom-0 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1 fw-bold text-dark">Effectif Affecté</h5>
                            <p class="text-muted small mb-0">Ressources humaines actives sur ce secteur</p>
                        </div>
                        <span class="badge-cyber">
                            {{ $sector->affectations->where('state', true)->count() }} Agents
                        </span>
                    </div>
                    <div class="card-body p-4">
                        @if($sector->affectations->where('state', true)->isNotEmpty())
                            <div class="row g-4">
                                @foreach($sector->affectations as $affectation)
                                    @if ($affectation->state)
                                        <div class="col-xl-4 col-md-6">
                                            <div class="employee-node-wrapper h-100 transition-base hover-lift">
                                                <x-employee-card :employee="$affectation->employee" detach="true" unity_type="sector" unity_id="{{ $sector->id }}" unity_name="{{ $sector->title }}" />
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="empty-state-icon mx-auto mb-3">
                                    <i class="bi bi-grid-3x3"></i>
                                </div>
                                <h6 class="text-muted fw-bold">Registre Node Vide</h6>
                                <p class="small text-muted px-5">Aucun agent n'est actuellement détecté dans ce secteur opérationnel.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            --accent-glow: rgba(99, 102, 241, 0.1);
        }

        body { background-color: #f1f5f9; }

        .header-gradient { background: var(--primary-gradient); position: relative; }

        .glass-icon-wrapper {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            width: 64px; height: 64px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 18px; border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .btn-glass-light {
            background: rgba(255, 255, 255, 0.15);
            color: white; border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(5px);
        }

        .btn-white { background: #fff; color: #4f46e5; border: none; }
        .btn-white:hover { background: #f8fafc; transform: translateY(-2px); }

        /* Futurist Inputs */
        .input-group-futurist { position: relative; }
        .futurist-input {
            background-color: #f8fafc !important;
            border: 2px solid #e2e8f0 !important;
            padding: 12px 16px 12px 45px !important;
            border-radius: 14px !important;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .input-group-futurist.glass .futurist-input {
            background-color: rgba(255, 255, 255, 0.1) !important;
            border-color: rgba(255, 255, 255, 0.2) !important;
            color: white !important;
        }
        .input-icon { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #6366f1; }
        .input-group-futurist.glass .input-icon { color: white; }

        /* Badges & Metrics */
        .badge-cyber {
            background: #f8fafc; color: #4f46e5; border: 1.5px solid #e0e7ff;
            padding: 8px 16px; border-radius: 10px; font-weight: 700; font-size: 0.85rem;
        }
        .badge-cyber-light {
            background: rgba(255, 255, 255, 0.1); color: white;
            padding: 4px 12px; border-radius: 50px; font-size: 0.65rem; font-weight: 700; text-transform: uppercase;
        }
        .badge-cyber-light.active { background: #10b981; }

        /* Nodes */
        .icon-node-vacant {
            width: 50px; height: 50px; background: #f8fafc; color: #cbd5e1;
            border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;
        }
        .empty-state-icon {
            width: 80px; height: 80px; background: #f8fafc; color: #cbd5e1;
            border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2.5rem;
        }

        .transition-base { transition: all 0.25s ease; }
        .hover-lift:hover { transform: translateY(-5px); }
        .ls-1 { letter-spacing: 0.05em; }
        .extra-small { font-size: 0.72rem; }
    </style>
</x-layout>
