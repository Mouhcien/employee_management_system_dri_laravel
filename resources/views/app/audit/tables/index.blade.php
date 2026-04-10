<x-layout>
    <style>
        /* --- Spectrum UI Futurist Palette --- */
        :root {
            --primary-gradient: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            --info-gradient: linear-gradient(135deg, #0ea5e9 0%, #2dd4bf 100%);
            --success-gradient: linear-gradient(135deg, #22c55e 0%, #10b981 100%);
            --surface-700: #0f172a;
            --glass-white: rgba(255, 255, 255, 0.03);
        }

        body { background-color: #f0f4f9; font-family: 'Inter', sans-serif; }

        /* Dynamic Header */
        .header-spectrum {
            background: var(--surface-700);
            background-image:
                radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.15) 0, transparent 50%),
                radial-gradient(at 100% 100%, rgba(168, 85, 247, 0.15) 0, transparent 50%);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            position: relative;
            overflow: hidden;
        }

        /* Abstract Glow Orbs */
        .orb {
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            filter: blur(80px);
            z-index: 0;
            opacity: 0.4;
        }
        .orb-1 { background: #6366f1; top: -100px; right: -50px; }

        /* Card Aesthetics */
        .card-glass-premium {
            background: white;
            border-radius: 22px;
            border: 1px solid #e2e8f0;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.1);
        }

        .card-glass-premium:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
            border-color: #6366f1;
        }

        /* Colorful Typography Labels */
        .ls-caps {
            letter-spacing: 0.08em;
            font-size: 0.65rem;
            text-transform: uppercase;
            font-weight: 800;
        }

        /* Vibrant Badges */
        .badge-colorful {
            background: var(--primary-gradient);
            color: white;
            border: none;
            box-shadow: 0 4px 10px rgba(99, 102, 241, 0.3);
        }

        .badge-soft-emerald {
            background: rgba(16, 185, 129, 0.1);
            color: #059669;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        /* Technical Grid Enhancements */
        .table-vibrant thead th {
            background: #f8fafc;
            color: #475569;
            border-bottom: 2px solid #6366f1;
            padding: 1.25rem;
            font-size: 0.75rem;
        }

        .btn-action-gradient {
            background: var(--primary-gradient);
            border: none;
            color: white;
            transition: 0.3s;
        }
        .btn-action-gradient:hover {
            box-shadow: 0 8px 20px rgba(168, 85, 247, 0.4);
            color: white;
            transform: scale(1.05);
        }

        /* Shimmer Skeleton */
        .shimmer-bar {
            height: 10px;
            background: #f1f5f9;
            background-image: linear-gradient(to right, #f1f5f9 0%, #e2e8f0 20%, #f1f5f9 40%, #f1f5f9 100%);
            background-repeat: no-repeat;
            background-size: 800px 100%;
            display: inline-block;
            position: relative;
            animation: shimmer 1.5s infinite linear;
            border-radius: 4px;
        }

        @keyframes shimmer {
            0% { background-position: -468px 0; }
            100% { background-position: 468px 0; }
        }

        .row-vibrant {
            transition: all 0.2s;
            border-bottom: 1px solid #f1f5f9;
        }
        .row-vibrant:hover {
            background-color: #fcfdff;
        }
    </style>

    {{-- Header Section --}}
    <div class="card header-spectrum border-0 shadow-lg mb-5 text-white">
        <div class="orb orb-1"></div>
        <div class="card-body p-5 position-relative">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <div class="d-flex align-items-center mb-3">
                        <span class="badge rounded-pill bg-white bg-opacity-10 text-info ls-caps px-3 py-2 border border-info border-opacity-25">
                            <i class="bi bi-shield-check me-2"></i>Infrastructure Audit
                        </span>
                    </div>
                    <h1 class="fw-bold mb-2 display-5 text-white">Tableaux de <span class="text-info">Suivi</span></h1>
                    <p class="mb-0 text-white-50 lead fs-6 fw-medium">Monitorisez et orchestrez vos structures de données en temps réel.</p>
                </div>
                <div class="col-md-5 text-md-end mt-4 mt-md-0">
                    <div class="btn-group rounded-4 overflow-hidden shadow-lg p-1 bg-white bg-opacity-5">
                        <a href="{{ route('audit.tables.create') }}" class="btn btn-action-gradient fw-bold px-4 rounded-3 py-2">
                            <i class="bi bi-plus-circle-fill me-2"></i>Nouveau Schéma
                        </a>
                    </div>
                    <div class="btn-group rounded-4 overflow-hidden shadow-lg p-1 bg-white bg-opacity-5">
                        <button class="btn btn-info fw-bold px-4 rounded-3 py-2" data-bs-toggle="modal" data-bs-target="#importTableModal">
                            <i class="bi bi-upload me-2"></i>Importer Schéma
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-import-table />

    {{-- Registry Card --}}
    <div class="card card-glass-premium">
        <div class="card-header bg-white py-4 px-4 d-flex justify-content-between align-items-center border-0">
            <div>
                <span class="ls-caps text-primary mb-1 d-block">Data Repository</span>
                <h4 class="mb-0 fw-bold text-dark font-inter">Répertoire des Structures</h4>
            </div>
            <div class="text-end">
                <span class="badge badge-colorful px-4 py-2 rounded-pill fw-bold">
                    <i class="bi bi-layers me-2"></i>{{ $tables->total() }} Tables
                </span>
            </div>
        </div>

        <div class="card-body p-0">
            @forelse($tables as $table)
                <div class="p-4 row-vibrant">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="d-flex align-items-center">
                            <div class="me-4">
                                <div class="bg-primary bg-opacity-10 text-primary rounded-4 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; border: 1px dashed rgba(99, 102, 241, 0.4);">
                                    <i class="bi bi-table fs-4"></i>
                                </div>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-1 d-flex align-items-center">
                                    {{ $table->title }}
                                    <span class="badge badge-soft-emerald rounded-pill ms-2 ls-caps">Stable</span>
                                </h6>
                                <p class="text-muted small mb-0 fw-medium">
                                    {{ $table->description ?: 'Aucune métadonnée renseignée pour cette structure.' }}
                                </p>
                            </div>
                        </div>

                        <div class="dropdown">
                            <button class="btn btn-light btn-sm border-0 bg-transparent rounded-3 p-2" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical fs-5 text-muted"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 p-2">
                                <li><a class="dropdown-item rounded-3 py-2 fw-bold" href="{{ route('audit.tables.edit', $table) }}"><i class="bi bi-vector-pen me-2 text-primary"></i>Designer</a></li>
                                <li><a class="dropdown-item rounded-3 py-2 fw-bold" href="#"><i class="bi bi-cloud-arrow-down me-2 text-success"></i>Exporter</a></li>
                                <li><hr class="dropdown-divider opacity-50"></li>
                                <li><a class="dropdown-item rounded-3 py-2 text-danger fw-bold" href="#"><i class="bi bi-trash3 me-2"></i>Supprimer</a></li>
                            </ul>
                        </div>
                    </div>

                    @if ($table->relations->count() != 0)
                        <div class="table-responsive rounded-4 border-0 shadow-sm overflow-hidden mb-2">
                            <table class="table table-vibrant mb-0 align-middle bg-white">
                                <thead>
                                <tr>
                                    @foreach($table->relations->unique('column_id') as $relation)
                                        <th class="ls-caps">
                                            <i class="bi bi-record-circle-fill text-info me-2"></i>{{ $relation->column->title }}
                                        </th>
                                    @endforeach
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    @foreach($table->relations->unique('column_id') as $relation)
                                        <td class="px-4 py-4">
                                            <div class="shimmer-bar w-100"></div>
                                        </td>
                                    @endforeach
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="py-5 px-4 rounded-4 text-center border-dashed bg-light bg-opacity-30" style="border: 2px dashed #cbd5e1;">
                            <div class="mb-3">
                                <i class="bi bi-plus-square-dotted text-muted fs-1"></i>
                            </div>
                            <h6 class="text-dark fw-bold mb-1">Architecture Vide</h6>
                            <p class="text-muted small mb-3">Aucune colonne n'a été mappée sur ce schéma.</p>
                            <a href="{{ route('audit.tables.edit', $table) }}" class="btn btn-sm btn-white border rounded-pill px-4 fw-bold shadow-sm">
                                <i class="bi bi-plus-lg me-2"></i>Ajouter des attributs
                            </a>
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center py-5">
                    <img src="https://illustrations.popsy.co/gray/data-report.svg" style="width: 200px; filter: grayscale(1) opacity(0.5);" alt="Empty" class="mb-4">
                    <h4 class="text-dark fw-bold">Aucune structure</h4>
                    <p class="text-muted mb-4">Initialisez votre environnement d'audit maintenant.</p>
                    <a href="{{ route('audit.tables.create') }}" class="btn btn-action-gradient rounded-pill px-5 py-2 fw-bold">Démarrer</a>
                </div>
            @endforelse
        </div>

        {{-- Footer Pagination --}}
        @if($tables instanceof \Illuminate\Pagination\AbstractPaginator && $tables->hasPages())
            <div class="card-footer bg-transparent border-top py-4 px-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                    <div class="text-muted small fw-bold">
                        <i class="bi bi-info-circle me-1"></i> Éléments <span class="text-primary">{{ $tables->firstItem() }}</span> à <span class="text-primary">{{ $tables->lastItem() }}</span> sur <span class="text-primary">{{ $tables->total() }}</span> au total
                    </div>
                    <div class="modern-pagination">
                        {{ $tables->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-layout>
