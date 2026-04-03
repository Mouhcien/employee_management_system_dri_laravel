<x-layout>
    @section('title', 'Détails du Service - ' . $service->title)

    <div class="container-fluid py-4 px-md-5">
        {{-- Futurist Glass Header --}}
        <div class="card border-0 shadow-lg rounded-5 mb-5 overflow-hidden position-relative">
            <div class="card-body p-0">
                <div class="header-gradient p-4 p-md-5 text-white">
                    <div class="position-absolute top-0 end-0 p-5 opacity-10 d-none d-lg-block">

                    </div>

                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-4 position-relative">
                        <div class="d-flex align-items-center">
                            <div class="glass-icon-wrapper me-4">
                                <i class="bi bi-diagram-3-fill fs-2"></i>
                            </div>
                            <div>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb mb-1 extra-small text-uppercase fw-bold ls-1">
                                        <li class="breadcrumb-item"><a href="{{ route('services.index') }}" class="text-white text-opacity-75 text-decoration-none">Architecture</a></li>
                                        <li class="breadcrumb-item active text-white" aria-current="page">Service Node</li>
                                    </ol>
                                </nav>
                                <h1 class="fw-bold mb-0 display-6">{{ $service->title }}</h1>
                                <div class="d-flex gap-2 mt-2">
                                    <span class="badge-cyber-light">ID: #0{{ $service->id }}</span>
                                    <span class="badge-cyber-light active">Opérationnel</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('services.index') }}" class="btn btn-glass-light btn-rounded px-4 py-2 fw-bold shadow-sm transition-base">
                                <i class="bi bi-arrow-left-short fs-5 me-1"></i>Retour
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Main Content Column --}}
            <div class="col-lg-8">
                {{-- Configuration Node --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
                    <div class="card-body p-4 p-xl-5">
                        <div class="d-flex align-items-center mb-4">
                            <span class="p-2 bg-primary-subtle text-primary rounded-3 me-3">
                                <i class="bi bi-gear-wide-connected"></i>
                            </span>
                            <h5 class="fw-bold text-dark mb-0">Configuration Structurelle</h5>
                        </div>

                        <form action="{{ route('services.update', $service->id) }}" method="POST">
                            @csrf
                            <div class="row g-3 align-items-end">
                                <div class="col-md-9">
                                    <label class="form-label small fw-bold text-muted text-uppercase ls-1">Libellé Officiel</label>
                                    <div class="input-group-futurist">
                                        <input type="text" name="title" class="form-control futurist-input" value="{{ old('title', $service->title) }}" required>
                                        <i class="bi bi-pencil-square input-icon"></i>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-futurist w-100 rounded-pill py-3 fw-bold transition-base">
                                        <i class="bi bi-arrow-repeat me-2"></i>Mettre à jour
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Employee Grid --}}
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white">
                    <div class="card-header bg-transparent py-4 px-4 border-bottom-0 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1 fw-bold text-dark">Effectif du Service</h5>
                            <p class="text-muted small mb-0">Agents rattachés à ce segment administratif</p>
                        </div>
                        <span class="badge-cyber">
                            {{ $service->affectations->count() }} Agents
                        </span>
                    </div>
                    <div class="card-body p-4">
                        @if($service->affectations->where('state', true)->isNotEmpty())
                            <div class="row g-4">
                                @foreach($service->affectations as $affectation)
                                    @if ($affectation->state)
                                        <div class="col-xl-4 col-md-6">
                                            @php $employee = $affectation->employee; @endphp
                                            <div class="hover-lift h-100 transition-base">
                                                <x-employee-card :employee="$employee" detach="true" unity_type="service" unity_id="{{ $service->id }}" unity_name="{{ $service->title }}" />
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="empty-state-icon mx-auto mb-3">
                                    <i class="bi bi-people"></i>
                                </div>
                                <h6 class="text-muted fw-bold">Unité Vacante</h6>
                                <p class="text-muted small px-5">Aucun agent n'est actuellement déployé sur ce service.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Sidebar Column --}}
            <div class="col-lg-4">
                {{-- Leadership Module --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white overflow-hidden">
                    <div class="card-header bg-dark p-4 border-0">
                        <h6 class="mb-0 text-white fw-bold"><i class="bi bi-shield-check me-2 text-primary"></i>Management Node</h6>
                    </div>
                    <div class="card-body p-4">
                        @if($service->chefs->where('state', true)->isNotEmpty())
                            @foreach($service->chefs->where('state', true) as $chef)
                                <div class="mb-3 hover-lift transition-base">
                                    <x-chef-card :employee="$chef->employee" detach="true" :chef="$chef" />
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-4">
                                <div class="icon-node-vacant mb-3 mx-auto">
                                    <i class="bi bi-person-x"></i>
                                </div>
                                <p class="text-muted extra-small fw-bold text-uppercase ls-1 mb-3">Poste de Direction Vacant</p>
                                <button class="btn btn-outline-primary w-100 rounded-pill fw-bold">Désigner un Responsable</button>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Import Module --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4 bg-light bg-opacity-50">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3 d-flex align-items-center">
                            <i class="bi bi-cloud-arrow-up-fill text-success me-2"></i>Flux de Données
                        </h6>
                        <form action="{{ route('affectations.services.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="service_id" value="{{ $service->id }}">
                            <div class="mb-3">
                                <div class="input-group-futurist">
                                    <input type="file" class="form-control futurist-input" name="file" required>
                                    <i class="bi bi-file-earmark-excel input-icon"></i>
                                </div>
                            </div>
                            <button class="btn btn-dark w-100 rounded-pill py-2 fw-bold shadow-sm">
                                <i class="bi bi-upload me-2"></i>Lancer l'Importation
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Hierarchy Module --}}
                <div class="card border-0 shadow-sm rounded-4 bg-white">
                    <div class="card-body p-4 p-xl-5">
                        <h6 class="fw-bold mb-4 text-uppercase ls-1 small text-muted">Architecture Hiérarchique</h6>

                        <div class="hierarchy-item mb-4">
                            <div class="d-flex align-items-center justify-content-between p-3 bg-primary-subtle rounded-4 mb-2">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-diagram-2-fill text-primary me-3"></i>
                                    <span class="fw-bold small">Entités Rattachées</span>
                                </div>
                                <span class="badge-cyber-mini">{{ $service->entities->count() }}</span>
                            </div>
                            <div class="ps-4">
                                @foreach($service->entities as $entity)
                                    <a href="{{ route('entities.show', $entity->id) }}" class="d-flex align-items-center text-decoration-none py-1 hover-node-link">
                                        <i class="bi bi-arrow-return-right me-2 opacity-50"></i>
                                        <span class="text-muted extra-small fw-medium">{{ $entity->title }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between p-3 bg-success-subtle rounded-4 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-grid-1x2-fill text-success me-3"></i>
                                <span class="fw-bold small text-success">Secteurs</span>
                            </div>
                            @php $sectors = $service->entities->flatMap(fn($e) => $e->sectors)->unique('id'); @endphp
                            <span class="badge-cyber-mini success">{{ $sectors->count() }}</span>
                        </div>

                        <div class="d-flex align-items-center justify-content-between p-3 bg-info-subtle rounded-4">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-layers text-info me-3"></i>
                                <span class="fw-bold small text-info">Sections</span>
                            </div>
                            @php $sections = $service->entities->flatMap(fn($e) => $e->sections)->unique('id'); @endphp
                            <span class="badge-cyber-mini info">{{ $sections->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modals & Components logic preserved --}}
    @if($service->affectations->where('state', true)->isNotEmpty())
        @foreach($service->affectations as $affectation)
            @if ($affectation->state)
                @php $employee = $affectation->employee; @endphp
                <x-affect-chef-modal :employee="$employee" unity_type="service" unity_id="{{ $service->id }}" unity_name="{{ $service->title }}" />
            @endif
        @endforeach
    @endif

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
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

        .btn-futurist {
            background: var(--primary-gradient);
            color: white; border: none;
            box-shadow: 0 10px 20px -5px rgba(79, 70, 229, 0.4);
        }

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
        .futurist-input:focus {
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 4px var(--accent-glow) !important;
        }
        .input-icon { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #6366f1; }

        /* Badges & Metrics */
        .badge-cyber {
            background: #fff; color: #4f46e5; border: 1.5px solid #e0e7ff;
            padding: 8px 16px; border-radius: 10px; font-weight: 700; font-size: 0.85rem;
        }
        .badge-cyber-light {
            background: rgba(255, 255, 255, 0.2); color: white;
            padding: 4px 12px; border-radius: 50px; font-size: 0.7rem; font-weight: 600;
        }
        .badge-cyber-light.active { background: #10b981; }

        .badge-cyber-mini {
            background: #fff; color: #4f46e5; border: 1px solid #e2e8f0;
            padding: 2px 10px; border-radius: 6px; font-weight: 800; font-size: 0.75rem;
        }
        .badge-cyber-mini.success { color: #10b981; }
        .badge-cyber-mini.info { color: #0ea5e9; }

        /* Visual Nodes */
        .icon-node-vacant {
            width: 60px; height: 60px; background: #f1f5f9; color: #94a3b8;
            border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem;
        }
        .empty-state-icon {
            width: 80px; height: 80px; background: #f8fafc; color: #cbd5e1;
            border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2.5rem;
        }

        .hover-node-link:hover { transform: translateX(5px); color: #6366f1 !important; }
        .transition-base { transition: all 0.25s ease; }
        .hover-lift:hover { transform: translateY(-5px); }
        .ls-1 { letter-spacing: 0.05em; }
        .extra-small { font-size: 0.75rem; }
    </style>
</x-layout>
