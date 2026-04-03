<x-layout>
    @section('title', 'Détails Fonction - ' . $occupation->title)

    <div class="container-fluid py-4 px-md-5">
        {{-- Futurist Glass Header --}}
        <div class="card border-0 shadow-lg rounded-5 mb-5 overflow-hidden position-relative">
            <div class="card-body p-0">
                <div class="header-gradient p-4 p-md-5 text-white">
                    {{-- Decorative background element --}}
                    <div class="position-absolute top-0 end-0 p-5 opacity-10 d-none d-lg-block">
                        <i class="bi bi-shield-check" style="font-size: 10rem;"></i>
                    </div>

                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-4 position-relative">
                        <div class="d-flex align-items-center">
                            <div class="glass-icon-wrapper me-4">
                                <i class="bi bi-briefcase-fill fs-2"></i>
                            </div>
                            <div>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb mb-1 extra-small text-uppercase fw-bold ls-1">
                                        <li class="breadcrumb-item"><a href="{{ route('occupations.index') }}" class="text-white text-opacity-75 text-decoration-none">Répertoire</a></li>
                                        <li class="breadcrumb-item active text-white" aria-current="page">Fiche Métier</li>
                                    </ol>
                                </nav>
                                <h1 class="fw-bold mb-0 display-6">{{ $occupation->title }}</h1>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('occupations.index') }}" class="btn btn-glass-light btn-rounded px-4 py-2 fw-bold shadow-sm transition-base">
                                <i class="bi bi-arrow-left-short fs-5 me-1"></i>Retour au registre
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Left Column: Configuration --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                    <div class="card-body p-4 p-xl-5">
                        <div class="d-flex align-items-center mb-4">
                            <span class="p-2 bg-primary-subtle text-primary rounded-3 me-3">
                                <i class="bi bi-sliders"></i>
                            </span>
                            <h5 class="fw-bold text-dark mb-0">Configuration</h5>
                        </div>

                        <form action="{{ route('occupations.update', $occupation->id) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="occupationTitle" class="form-label small fw-bold text-muted text-uppercase ls-1">Intitulé Officiel</label>
                                <div class="input-group-futurist">
                                    <input
                                        type="text"
                                        id="occupationTitle"
                                        name="title"
                                        class="form-control futurist-input"
                                        value="{{ old('title', $occupation->title) }}"
                                        placeholder="Titre de la fonction..."
                                        required
                                    >
                                    <i class="bi bi-pencil-square input-icon"></i>
                                </div>
                                <div class="form-text extra-small mt-3 text-muted">
                                    <i class="bi bi-info-circle-fill me-1"></i> La modification impactera <strong>{{ $occupation->works->count() }} fiches agents</strong>.
                                </div>
                            </div>

                            <button type="submit" class="btn btn-futurist w-100 rounded-pill fw-bold py-3 transition-base">
                                <i class="bi bi-arrow-repeat me-2"></i>Synchroniser les données
                            </button>
                        </form>

                        <div class="stats-panel mt-5">
                            <div class="row g-0 rounded-4 overflow-hidden border">
                                <div class="col-6 border-end p-3 text-center">
                                    <div class="text-muted extra-small fw-bold text-uppercase mb-1">Agents</div>
                                    <div class="h4 fw-bold text-primary mb-0">{{ $occupation->works->count() }}</div>
                                </div>
                                <div class="col-6 p-3 text-center bg-light-subtle">
                                    <div class="text-muted extra-small fw-bold text-uppercase mb-1">Statut</div>
                                    <div class="h4 fw-bold text-success mb-0">Actif</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Agents List --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                    <div class="card-header bg-transparent py-4 px-4 border-bottom-0 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1 fw-bold text-dark">Titulaires Actuels</h5>
                            <p class="text-muted small mb-0">Liste des collaborateurs rattachés à ce poste</p>
                        </div>
                        <span class="badge-cyber">
                            {{ $occupation->works->count() }} Membres
                        </span>
                    </div>
                    <div class="card-body p-4">
                        @if($occupation->works->isNotEmpty())
                            <div class="row g-4">
                                @foreach($occupation->works as $work)
                                    <div class="col-xl-4 col-md-6">
                                        <div class="hover-lift transition-base h-100">
                                            <x-employee-card :employee="$work->employee" detach="false" />
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="empty-state-icon mb-3 mx-auto">
                                    <i class="bi bi-person-plus"></i>
                                </div>
                                <h5 class="text-dark fw-bold">Poste Vacant</h5>
                                <p class="text-muted small mx-auto" style="max-width: 300px;">
                                    Il n'y a actuellement aucun collaborateur affecté à cette fonction au sein de l'organisation.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            --accent-color: #6366f1;
        }

        body { background-color: #f1f5f9; }

        .header-gradient {
            background: var(--primary-gradient);
            position: relative;
        }

        .glass-icon-wrapper {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            width: 64px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 18px;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .btn-glass-light {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(5px);
        }
        .btn-glass-light:hover {
            background: rgba(255, 255, 255, 0.25);
            color: white;
            transform: translateY(-2px);
        }

        /* Futurist Inputs */
        .input-group-futurist {
            position: relative;
        }
        .futurist-input {
            background-color: #f8fafc !important;
            border: 2px solid #e2e8f0 !important;
            padding: 12px 16px 12px 45px !important;
            border-radius: 14px !important;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .futurist-input:focus {
            border-color: var(--accent-color) !important;
            background-color: #fff !important;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1) !important;
        }
        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--accent-color);
            font-size: 1.1rem;
        }

        .btn-futurist {
            background: var(--primary-gradient);
            color: white;
            border: none;
            box-shadow: 0 10px 20px -5px rgba(79, 70, 229, 0.4);
        }
        .btn-futurist:hover {
            color: white;
            filter: brightness(1.1);
            transform: translateY(-2px);
            box-shadow: 0 15px 25px -5px rgba(79, 70, 229, 0.5);
        }

        .badge-cyber {
            background: #fff;
            color: #4f46e5;
            border: 1.5px solid #e0e7ff;
            padding: 8px 16px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.85rem;
            box-shadow: 0 2px 5px rgba(0,0,0,0.02);
        }

        .empty-state-icon {
            width: 80px;
            height: 80px;
            background: #f1f5f9;
            color: #94a3b8;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
        }

        .transition-base { transition: all 0.25s ease; }
        .hover-lift:hover { transform: translateY(-8px); }
        .btn-rounded { border-radius: 50px; }
        .ls-1 { letter-spacing: 0.05em; }
        .extra-small { font-size: 0.75rem; }
    </style>
</x-layout>
