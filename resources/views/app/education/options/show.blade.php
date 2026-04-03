<x-layout>
    @section('title', 'Détails Filière - ' . $option->title)

    <div class="container-fluid py-4 px-md-5">
        {{-- Futurist Glass Header --}}
        <div class="card border-0 shadow-lg rounded-5 mb-5 overflow-hidden position-relative">
            <div class="card-body p-0">
                <div class="header-gradient p-4 p-md-5 text-white">
                    {{-- Filigrane Décoratif --}}
                    <div class="position-absolute top-0 end-0 p-5 opacity-10 d-none d-lg-block">
                        <i class="bi bi-layers-fill" style="font-size: 10rem;"></i>
                    </div>

                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-4 position-relative">
                        <div class="d-flex align-items-center">
                            <div class="glass-icon-wrapper me-4">
                                <i class="bi bi-mortarboard-fill fs-2"></i>
                            </div>
                            <div>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb mb-1 extra-small text-uppercase fw-bold ls-1">
                                        <li class="breadcrumb-item"><a href="{{ route('options.index') }}" class="text-white text-opacity-75 text-decoration-none">Référentiel</a></li>
                                        <li class="breadcrumb-item active text-white" aria-current="page">Détails Filière</li>
                                    </ol>
                                </nav>
                                <h1 class="fw-bold mb-0 display-6">{{ $option->title }}</h1>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('options.index') }}" class="btn btn-glass-light btn-rounded px-4 py-2 fw-bold shadow-sm transition-base">
                                <i class="bi bi-arrow-left-short fs-5 me-1"></i>Retour au registre
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Left Column: Settings --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                    <div class="card-body p-4 p-xl-5">
                        <div class="d-flex align-items-center mb-4">
                            <span class="p-2 bg-primary-subtle text-primary rounded-3 me-3">
                                <i class="bi bi-gear-wide-connected"></i>
                            </span>
                            <h5 class="fw-bold text-dark mb-0">Configuration</h5>
                        </div>

                        <form action="{{ route('options.update', $option->id) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="serviceTitle" class="form-label small fw-bold text-muted text-uppercase ls-1">Nom de la Spécialité</label>
                                <div class="input-group-futurist">
                                    <input
                                        type="text"
                                        id="serviceTitle"
                                        name="title"
                                        class="form-control futurist-input"
                                        value="{{ old('title', $option->title) }}"
                                        required
                                    >
                                    <i class="bi bi-bookmark-star input-icon"></i>
                                </div>
                                <div class="form-text extra-small mt-3 text-muted">
                                    <i class="bi bi-info-circle me-1"></i> Affecte <strong>{{ $option->qualifications->count() }}</strong> profils actifs.
                                </div>
                            </div>

                            <button type="submit" class="btn btn-futurist w-100 rounded-pill fw-bold py-3 transition-base">
                                <i class="bi bi-check2-all me-2"></i>Appliquer les changements
                            </button>
                        </form>

                        {{-- Metric Widget --}}
                        <div class="stats-panel mt-5">
                            <div class="row g-0 rounded-4 overflow-hidden border">
                                <div class="col-6 border-end p-4 text-center">
                                    <div class="text-muted extra-small fw-bold text-uppercase mb-1">Effectif</div>
                                    <div class="h3 fw-bold text-primary mb-0">{{ $option->qualifications->count() }}</div>
                                </div>
                                <div class="col-6 p-4 text-center bg-light-subtle">
                                    <div class="text-muted extra-small fw-bold text-uppercase mb-1">Classement</div>
                                    <div class="h3 fw-bold text-success mb-0">A1</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Holders --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 bg-white h-100 overflow-hidden">
                    <div class="card-header bg-transparent py-4 px-4 border-bottom-0 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1 fw-bold text-dark">Spécialistes Rattachés</h5>
                            <p class="text-muted small mb-0">Agents qualifiés dans cette discipline académique</p>
                        </div>
                        <span class="badge-cyber">
                            {{ $option->qualifications->count() }} Diplômés
                        </span>
                    </div>
                    <div class="card-body p-4">
                        @if($option->qualifications->isNotEmpty())
                            <div class="row g-4">
                                @foreach($option->qualifications as $qualification)
                                    <div class="col-xl-6 col-md-12">
                                        <div class="hover-lift transition-base h-100">
                                            <x-employee-card :employee="$qualification->employee" detach="false" />
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="empty-state-icon mb-3 mx-auto">
                                    <i class="bi bi-layers"></i>
                                </div>
                                <h5 class="text-dark fw-bold">Aucune Donnée</h5>
                                <p class="text-muted small mx-auto" style="max-width: 300px;">
                                    Il n'y a actuellement aucun collaborateur titulaire de cette option spécifique.
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
            --primary-gradient: linear-gradient(135deg, #4f46e5 0%, #06b6d4 100%);
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
            width: 64px; height: 64px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 18px;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .btn-glass-light {
            background: rgba(255, 255, 255, 0.15);
            color: white; border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(5px);
        }
        .btn-glass-light:hover { background: rgba(255, 255, 255, 0.25); color: white; transform: translateY(-2px); }

        /* Futurist Form Elements */
        .input-group-futurist { position: relative; }
        .futurist-input {
            background-color: #f8fafc !important;
            border: 2px solid #e2e8f0 !important;
            padding: 14px 16px 14px 45px !important;
            border-radius: 14px !important;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .futurist-input:focus {
            border-color: var(--accent-color) !important;
            background-color: #fff !important;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1) !important;
        }
        .input-icon {
            position: absolute; left: 16px; top: 50%;
            transform: translateY(-50%); color: var(--accent-color);
            font-size: 1.1rem;
        }

        .btn-futurist {
            background: var(--primary-gradient);
            color: white; border: none;
            box-shadow: 0 10px 20px -5px rgba(79, 70, 229, 0.3);
        }
        .btn-futurist:hover {
            color: white; transform: translateY(-2px);
            filter: brightness(1.1);
            box-shadow: 0 15px 25px -5px rgba(79, 70, 229, 0.4);
        }

        .badge-cyber {
            background: #f8fafc; color: #4f46e5; border: 1.5px solid #e0e7ff;
            padding: 8px 16px; border-radius: 10px; font-weight: 700; font-size: 0.85rem;
        }

        .empty-state-icon {
            width: 80px; height: 80px; background: #f1f5f9; color: #94a3b8;
            border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2.5rem;
        }

        .transition-base { transition: all 0.25s ease; }
        .hover-lift:hover { transform: translateY(-8px); }
        .btn-rounded { border-radius: 50px; }
        .ls-1 { letter-spacing: 0.05em; }
        .extra-small { font-size: 0.75rem; }
    </style>
</x-layout>
