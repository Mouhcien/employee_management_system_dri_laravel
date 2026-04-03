<x-layout>
    @section('title', 'Détails du Local - ' . $local->title)

    <div class="container-fluid py-4 px-md-5">
        {{-- Futurist Glass Header --}}
        <div class="card border-0 shadow-lg rounded-5 mb-5 overflow-hidden position-relative">
            <div class="card-body p-0">
                <div class="header-gradient p-4 p-md-5 text-white">
                    {{-- Decorative Filigree --}}
                    <div class="position-absolute top-0 end-0 p-5 opacity-10 d-none d-lg-block">
                        <i class="bi bi-building-fill" style="font-size: 10rem;"></i>
                    </div>

                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-4 position-relative">
                        <div class="d-flex align-items-center">
                            <div class="glass-icon-wrapper me-4">
                                <i class="bi bi-geo-fill fs-2"></i>
                            </div>
                            <div>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb mb-1 extra-small text-uppercase fw-bold ls-1">
                                        <li class="breadcrumb-item"><a href="{{ route('locals.index') }}" class="text-white text-opacity-75 text-decoration-none">Infrastructures</a></li>
                                        <li class="breadcrumb-item active text-white" aria-current="page">Node Details</li>
                                    </ol>
                                </nav>
                                <h1 class="fw-bold mb-0 display-6">{{ $local->title }}</h1>
                                <span class="badge bg-white text-primary rounded-pill mt-2 px-3 fw-bold small">
                                    <i class="bi bi-hdd-network me-1"></i> HUB: {{ $local->city->title }}
                                </span>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('locals.index') }}" class="btn btn-glass-light btn-rounded px-4 py-2 fw-bold shadow-sm transition-base">
                                <i class="bi bi-arrow-left-short fs-5 me-1"></i>Retour au réseau
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Column 1: Configuration Settings --}}
            <div class="col-12 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                    <div class="card-body p-4 p-xl-5">
                        <div class="d-flex align-items-center mb-4">
                            <span class="p-2 bg-primary-subtle text-primary rounded-3 me-3">
                                <i class="bi bi-gear-wide-connected"></i>
                            </span>
                            <h5 class="fw-bold text-dark mb-0">Configuration</h5>
                        </div>

                        <form action="{{ route('locals.update', $local->id) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="localTitle" class="form-label small fw-bold text-muted text-uppercase ls-1">Désignation du Site</label>
                                <div class="input-group-futurist">
                                    <input type="text" id="localTitle" name="title" class="form-control futurist-input" value="{{ old('title', $local->title) }}" required>
                                    <i class="bi bi-building input-icon"></i>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="city_id" class="form-label small fw-bold text-muted text-uppercase ls-1">Hub Régional</label>
                                <div class="input-group-futurist">
                                    <select name="city_id" id="city_id" class="form-select futurist-input fw-bold text-primary">
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}" {{ $city->id == $local->city_id ? 'selected' : '' }}>
                                                {{ $city->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <i class="bi bi-geo-alt input-icon"></i>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-futurist w-100 rounded-pill fw-bold py-3 transition-base mt-2">
                                <i class="bi bi-save2 me-2"></i>Synchroniser les Données
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Column 2: Geographic Context --}}
            <div class="col-12 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                    <div class="card-body p-4 p-xl-5 text-center">
                        <div class="d-flex align-items-center mb-4 text-start">
                            <span class="p-2 bg-success-subtle text-success rounded-3 me-3">
                                <i class="bi bi-map"></i>
                            </span>
                            <h5 class="fw-bold text-dark mb-0">Géolocalisation</h5>
                        </div>

                        <div class="bg-light-subtle rounded-5 p-5 mb-4 border border-2 border-white shadow-inner">
                            <div class="geo-pulse mb-4 mx-auto">
                                <i class="bi bi-geo-alt-fill fs-2"></i>
                            </div>
                            <h4 class="fw-bold text-dark mb-1">{{ $local->city->title }}</h4>
                            <p class="text-muted extra-small fw-bold text-uppercase ls-1 mb-0">Pôle de rattachement</p>
                        </div>

                        <a href="{{ route('cities.show', $local->city->id) }}" class="btn btn-outline-success w-100 rounded-pill py-2 fw-bold transition-base">
                            Consulter le Hub Régional
                        </a>
                    </div>
                </div>
            </div>

            {{-- Column 3: Live HR Metrics --}}
            <div class="col-12 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                    <div class="card-body p-4 p-xl-5">
                        <div class="d-flex align-items-center mb-4">
                            <span class="p-2 bg-info-subtle text-info rounded-3 me-3">
                                <i class="bi bi-people"></i>
                            </span>
                            <h5 class="fw-bold text-dark mb-0">Effectif Live</h5>
                        </div>

                        <div class="badge-cyber-large mb-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h2 class="fw-bold mb-0 text-primary">{{ $local->employees->count() }}</h2>
                                    <span class="text-muted extra-small fw-bold text-uppercase ls-1">Collaborateurs</span>
                                </div>
                                <div class="icon-node-pulse">
                                    <i class="bi bi-person-workspace fs-3"></i>
                                </div>
                            </div>
                        </div>

                        <div class="stats-breakdown p-3 bg-light rounded-4">
                            <h6 class="extra-small fw-bold text-muted text-uppercase ls-1 mb-3">Démographie du Site</h6>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between small fw-bold mb-1">
                                    <span class="text-muted">Hommes</span>
                                    <span>{{ $local->employees->where('gender', 'M')->count() }}</span>
                                </div>
                                <div class="progress rounded-pill" style="height: 6px;">
                                    <div class="progress-bar bg-primary" style="width: {{ $local->employees->count() > 0 ? ($local->employees->where('gender', 'M')->count() / $local->employees->count()) * 100 : 0 }}%"></div>
                                </div>
                            </div>

                            <div>
                                <div class="d-flex justify-content-between small fw-bold mb-1">
                                    <span class="text-muted">Femmes</span>
                                    <span>{{ $local->employees->where('gender', 'F')->count() }}</span>
                                </div>
                                <div class="progress rounded-pill" style="height: 6px;">
                                    <div class="progress-bar bg-info" style="width: {{ $local->employees->count() > 0 ? ($local->employees->where('gender', 'F')->count() / $local->employees->count()) * 100 : 0 }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #4f46e5 0%, #10b981 100%);
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

        .btn-futurist {
            background: var(--primary-gradient);
            color: white; border: none;
            box-shadow: 0 10px 20px -5px rgba(79, 70, 229, 0.3);
        }

        /* Futurist Form Controls */
        .input-group-futurist { position: relative; }
        .futurist-input {
            background-color: #f8fafc !important;
            border: 2px solid #e2e8f0 !important;
            padding: 12px 16px 12px 45px !important;
            border-radius: 14px !important;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .futurist-input:focus {
            border-color: var(--accent-color) !important;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1) !important;
        }
        .input-icon {
            position: absolute; left: 16px; top: 50%;
            transform: translateY(-50%); color: var(--accent-color);
        }

        /* Visual Effects */
        .geo-pulse {
            width: 60px; height: 60px; background: #10b981; color: white;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            animation: pulse 2s infinite;
        }

        .badge-cyber-large {
            background: #f8fafc; border: 2px solid #eef2ff;
            padding: 20px; border-radius: 20px;
        }

        .icon-node-pulse { color: #6366f1; opacity: 0.8; }

        @keyframes pulse {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 15px rgba(16, 185, 129, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        .ls-1 { letter-spacing: 0.05em; }
        .extra-small { font-size: 0.75rem; }
        .transition-base { transition: all 0.25s ease; }
        .hover-lift:hover { transform: translateY(-5px); }
    </style>
</x-layout>
