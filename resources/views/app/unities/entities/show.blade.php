<x-layout>
    @section('title', 'Détails de l\'Entité - ' . $entity->title)

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
                                <i class="bi bi-diagram-2-fill fs-2"></i>
                            </div>
                            <div>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb mb-1 extra-small text-uppercase fw-bold ls-1">
                                        <li class="breadcrumb-item"><a href="{{ route('entities.index') }}" class="text-white text-opacity-75 text-decoration-none">Architecture</a></li>
                                        <li class="breadcrumb-item active text-white" aria-current="page">Entité</li>
                                    </ol>
                                </nav>
                                <h1 class="fw-bold mb-0 display-6">
                                    <span class="text-white-50 fs-4 fw-medium text-uppercase ls-1 d-block mb-1">{{ $entity->type->title }}</span>
                                    {{ $entity->title }}
                                </h1>
                                <div class="d-flex align-items-center mt-2">
                                    <span class="badge-cyber-light active me-2">Service: {{ $entity->service->title ?? 'N/A' }}</span>
                                    <span class="badge-cyber-light">Entité-{{ $entity->id }}</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('entities.index') }}" class="btn btn-glass-light btn-rounded px-4 py-2 fw-bold shadow-sm transition-base">
                                <i class="bi bi-arrow-left-short fs-5 me-1"></i>Retour
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Left Column: Management & Infrastructure --}}
            <div class="col-lg-5 col-xl-4">
                {{-- Leadership Module --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white overflow-hidden">
                    <div class="card-header bg-dark p-4 border-0">
                        <h6 class="mb-0 text-white fw-bold"><i class="bi bi-shield-check me-2 text-primary"></i>Management Node</h6>
                    </div>
                    <div class="card-body p-4">
                        @if($entity->chefs->where('state', true)->isNotEmpty())
                            @foreach($entity->chefs->where('state', true) as $chef)
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

                {{-- Hierarchy Tree Module --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
                    <div class="card-body p-4 p-xl-5">
                        <h6 class="fw-bold mb-4 text-uppercase ls-1 small text-muted">Structure Inférieure</h6>

                        @if ($entity->sectors->isNotEmpty())
                            <div class="hierarchy-section mb-4">
                                <div class="d-flex align-items-center mb-3">
                                    <span class="p-2 bg-success-subtle text-success rounded-3 me-2">
                                        <i class="bi bi-grid-3x3-gap-fill"></i>
                                    </span>
                                    <span class="fw-bold text-dark small">Secteurs Actifs</span>
                                </div>
                                <div class="ps-3 border-start border-2 border-success border-opacity-25 ms-3">
                                    @foreach($entity->sectors as $sector)
                                        <a href="{{ route('sectors.show', $sector->id) }}" class="d-flex align-items-center text-decoration-none py-2 hover-node-link">
                                            <i class="bi bi-chevron-right me-2 opacity-50"></i>
                                            <span class="text-muted extra-small fw-medium">{{ $sector->title }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if ($entity->sections->isNotEmpty())
                            <div class="hierarchy-section">
                                <div class="d-flex align-items-center mb-3">
                                    <span class="p-2 bg-info-subtle text-info rounded-3 me-2">
                                        <i class="bi bi-journal-text"></i>
                                    </span>
                                    <span class="fw-bold text-dark small">Sous-Sections</span>
                                </div>
                                <div class="ps-3 border-start border-2 border-info border-opacity-25 ms-3">
                                    @foreach($entity->sections as $section)
                                        <a href="{{ route('sections.show', $section->id) }}" class="d-flex align-items-center text-decoration-none py-2 hover-node-link">
                                            <i class="bi bi-chevron-right me-2 opacity-50"></i>
                                            <span class="text-muted extra-small fw-medium">{{ $section->title }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($entity->sectors->isEmpty() && $entity->sections->isEmpty())
                            <div class="text-center py-3">
                                <p class="text-muted extra-small fw-bold text-uppercase opacity-50 mb-0">Unité Terminale (Fin d'arborescence)</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Data Injection --}}
                <div class="card border-0 shadow-sm rounded-4 bg-dark text-white overflow-hidden">
                    <div class="card-body p-4 p-xl-5">
                        <h6 class="fw-bold mb-3 d-flex align-items-center text-success">
                            <i class="bi bi-cloud-arrow-up-fill me-2"></i>
                            Importation PPR
                        </h6>
                        <p class="text-white-50 extra-small mb-4">Synchronisez les affectations via flux Excel.</p>
                        <form action="{{ route('affectations.entities.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="entity_id" value="{{ $entity->id }}">
                            <div class="mb-4">
                                <div class="input-group-futurist dark">
                                    <input type="file" class="form-control futurist-input" name="file" required>
                                    <i class="bi bi-file-earmark-excel input-icon"></i>
                                </div>
                            </div>
                            <button class="btn btn-futurist w-100 rounded-pill py-3 fw-bold shadow-sm">
                                <i class="bi bi-cpu me-2"></i>Lancer le traitement
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Right Column: Employee Grid --}}
            <div class="col-lg-7 col-xl-8">
                <div class="card border-0 shadow-lg rounded-4 h-100 bg-white">
                    <div class="card-header bg-transparent py-4 px-4 border-bottom-0 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1 fw-bold text-dark">Effectif Déployé</h5>
                            <p class="text-muted small mb-0">Agents actifs rattachés au  Entité</p>
                        </div>
                        <span class="badge-cyber">
                            {{ $entity->affectations->where('state', true)->count() }} Agents
                        </span>
                    </div>
                    <div class="card-body p-4">
                        @if($entity->affectations->where('state', true)->isNotEmpty())
                            <div class="row g-4">
                                @foreach($entity->affectations as $affectation)
                                    @if ($affectation->state)
                                        <div class="col-xl-4 col-md-6">
                                            <div class="hover-lift h-100 transition-base">
                                                <x-employee-card :employee="$affectation->employee" detach="true" unity_type="entity" unity_id="{{ $entity->id }}" unity_name="{{ $entity->title }}" />
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
                                <h6 class="text-muted fw-bold">Aucun Agent Détecté</h6>
                                <p class="small text-muted px-5">Le registre de cette entité est actuellement vide. Procédez à une importation ou une affectation manuelle.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Components & Modals Preservation --}}
    @if($entity->affectations->where('state', true)->isNotEmpty())
        @foreach($entity->affectations as $affectation)
            @if ($affectation->state)
                @php $employee = $affectation->employee; @endphp
                <x-affect-chef-modal :employee="$employee" unity_type="entity" unity_id="{{ $entity->id }}" unity_name="{{ $entity->title }}" />
            @endif
        @endforeach
    @endif

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
        .input-group-futurist.dark .futurist-input {
            background-color: rgba(255, 255, 255, 0.05) !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            color: white !important;
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
            background: rgba(255, 255, 255, 0.15); color: white;
            padding: 4px 12px; border-radius: 50px; font-size: 0.65rem; font-weight: 700; text-uppercase: uppercase;
        }
        .badge-cyber-light.active { background: #10b981; }

        /* Visual Nodes */
        .icon-node-vacant {
            width: 50px; height: 50px; background: #f8fafc; color: #cbd5e1;
            border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;
        }
        .empty-state-icon {
            width: 80px; height: 80px; background: #f8fafc; color: #cbd5e1;
            border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2.5rem;
        }

        .hover-node-link:hover { transform: translateX(8px); color: #6366f1 !important; }
        .transition-base { transition: all 0.25s ease; }
        .hover-lift:hover { transform: translateY(-5px); }
        .ls-1 { letter-spacing: 0.05em; }
        .extra-small { font-size: 0.72rem; }
        .bg-light-subtle { background-color: #fafbfc !important; }
    </style>
</x-layout>
