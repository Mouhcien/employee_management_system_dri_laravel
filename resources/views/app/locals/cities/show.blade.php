<x-layout>
    @section('title', 'Détails de la Ville - ' . $city->title)

    <div class="container-fluid py-4 px-md-5">
        {{-- Futurist Glass Header --}}
        <div class="card border-0 shadow-lg rounded-5 mb-5 overflow-hidden position-relative">
            <div class="card-body p-0">
                <div class="header-gradient p-4 p-md-5 text-white">
                    {{-- Filigrane Géographique --}}
                    <div class="position-absolute top-0 end-0 p-5 opacity-10 d-none d-lg-block">
                        <i class="bi bi-geo-alt-fill" style="font-size: 10rem;"></i>
                    </div>

                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-4 position-relative">
                        <div class="d-flex align-items-center">
                            <div class="glass-icon-wrapper me-4">
                                <i class="bi bi-pin-map-fill fs-2"></i>
                            </div>
                            <div>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb mb-1 extra-small text-uppercase fw-bold ls-1">
                                        <li class="breadcrumb-item"><a href="{{ route('cities.index') }}" class="text-white text-opacity-75 text-decoration-none">Réseau Géo</a></li>
                                        <li class="breadcrumb-item active text-white" aria-current="page">Hub Central</li>
                                    </ol>
                                </nav>
                                <h1 class="fw-bold mb-0 display-6">Hub : {{ $city->title }}</h1>
                                <p class="text-white text-opacity-75 mb-0 small mt-1">
                                    <i class="bi bi-activity me-1"></i> Surveillance active des infrastructures et effectifs
                                </p>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('cities.index') }}" class="btn btn-glass-light btn-rounded px-4 py-2 fw-bold shadow-sm transition-base">
                                <i class="bi bi-arrow-left-short fs-5 me-1"></i>Retour au registre
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Module 1: System Config --}}
            <div class="col-12 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                    <div class="card-body p-4 p-xl-5">
                        <div class="d-flex align-items-center mb-4">
                            <span class="p-2 bg-primary-subtle text-primary rounded-3 me-3">
                                <i class="bi bi-gear-wide-connected"></i>
                            </span>
                            <h5 class="fw-bold text-dark mb-0">Paramètres Hub</h5>
                        </div>

                        <form action="{{ route('cities.update', $city->id) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="cityTitle" class="form-label small fw-bold text-muted text-uppercase ls-1">Désignation Officielle</label>
                                <div class="input-group-futurist">
                                    <input type="text" id="cityTitle" name="title" class="form-control futurist-input" value="{{ old('title', $city->title) }}" required>
                                    <i class="bi bi-geo-alt input-icon"></i>
                                </div>
                            </div>

                            <div class="bg-primary-subtle rounded-4 p-3 mb-4 d-none" id="previewSection">
                                <div class="d-flex align-items-center text-primary">
                                    <i class="bi bi-check2-all me-2"></i>
                                    <span class="small fw-bold" id="previewTitle"></span>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-futurist w-100 rounded-pill fw-bold py-3 transition-base">
                                <i class="bi bi-save2 me-2"></i>Synchroniser Hub
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Module 2: Infrastructure Inventory --}}
            <div class="col-12 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                    <div class="card-body p-4 p-xl-5">
                        <div class="d-flex align-items-center mb-4">
                            <span class="p-2 bg-success-subtle text-success rounded-3 me-3">
                                <i class="bi bi-building"></i>
                            </span>
                            <h5 class="fw-bold text-dark mb-0">Parc Locaux</h5>
                        </div>

                        @if($city->locals->isNotEmpty())
                            <div class="d-flex flex-column gap-3">
                                @foreach($city->locals as $local)
                                    <a href="{{ route('locals.show', $local) }}" class="text-decoration-none">
                                        <div class="d-flex align-items-center p-3 bg-light rounded-4 transition-base hover-node">
                                            <div class="icon-node-small me-3">
                                                <i class="bi bi-hdd-network"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="fw-bold text-dark small mb-0">{{ $local->title }}</div>
                                                <span class="text-muted extra-small">ID-{{ str_pad($local->id, 3, '0', STR_PAD_LEFT) }}</span>
                                            </div>
                                            <i class="bi bi-chevron-right text-muted small"></i>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5 border-2 border-dashed border-light rounded-5">
                                <i class="bi bi-building-exclamation text-muted fs-2 opacity-50"></i>
                                <p class="text-muted extra-small mt-2 mb-0 fw-bold text-uppercase">Zone hors-parc</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Module 3: RH Demographics --}}
            <div class="col-12 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                    <div class="card-body p-4 p-xl-5">
                        <div class="d-flex align-items-center mb-4">
                            <span class="p-2 bg-info-subtle text-info rounded-3 me-3">
                                <i class="bi bi-bar-chart-fill"></i>
                            </span>
                            <h5 class="fw-bold text-dark mb-0">Effectifs Live</h5>
                        </div>

                        @php $totalHub = $city->locals->sum(fn($l) => $l->employees->count()); @endphp

                        @if($city->locals->isNotEmpty())
                            <div class="stats-scroll-area pe-2" style="max-height: 250px; overflow-y: auto;">
                                @foreach($city->locals as $local)
                                    <div class="d-flex justify-content-between align-items-center mb-3 p-2 border-bottom border-light">
                                        <div class="small fw-bold text-muted">{{ $local->title }}</div>
                                        <span class="badge-cyber">{{ $local->employees->count() }}</span>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-4 pt-4 border-top">
                                <div class="badge-cyber-large d-flex justify-content-between align-items-center">
                                    <div class="text-muted extra-small fw-bold text-uppercase ls-1">Population Totale</div>
                                    <div class="h4 fw-bold text-primary mb-0">{{ $totalHub }}</div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="empty-state-icon mx-auto mb-3">
                                    <i class="bi bi-people"></i>
                                </div>
                                <p class="text-muted small fw-medium">Aucune statistique disponible</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            --accent-glow: rgba(99, 102, 241, 0.15);
        }

        body { background-color: #f1f5f9; }

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

        .btn-futurist {
            background: var(--primary-gradient);
            color: white; border: none;
            box-shadow: 0 10px 20px -5px rgba(99, 102, 241, 0.3);
        }

        /* Futurist Inputs */
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
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 4px var(--accent-glow) !important;
        }
        .input-icon { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #6366f1; }

        /* Node Styling */
        .hover-node:hover { background: #eef2ff !important; transform: translateX(5px); }
        .icon-node-small {
            width: 36px; height: 36px; background: #fff; color: #6366f1;
            border-radius: 10px; display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        .badge-cyber {
            background: #fff; color: #6366f1; border: 1.5px solid #eef2ff;
            padding: 4px 12px; border-radius: 8px; font-weight: 700; font-size: 0.75rem;
        }

        .badge-cyber-large {
            background: #f8fafc; border: 2px solid #eef2ff;
            padding: 15px 20px; border-radius: 16px;
        }

        .empty-state-icon {
            width: 60px; height: 60px; background: #f1f5f9; color: #94a3b8;
            border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;
        }

        .transition-base { transition: all 0.25s ease; }
        .ls-1 { letter-spacing: 0.05em; }
        .extra-small { font-size: 0.72rem; }
    </style>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const titleInput = document.getElementById('cityTitle');
                const previewSection = document.getElementById('previewSection');
                const previewTitle = document.getElementById('previewTitle');

                titleInput.addEventListener('input', function() {
                    const value = this.value.trim();
                    previewTitle.textContent = value || 'Tapez un nom...';
                    previewSection.classList.toggle('d-none', !value);
                });
            });
        </script>
    @endpush
</x-layout>
