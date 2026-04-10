<x-layout>
    @push('styles')
        <style>
            :root {
                --glass-bg: rgba(255, 255, 255, 0.7);
                --glass-border: rgba(255, 255, 255, 0.2);
                --accent-indigo: #6366f1;
                --sidebar-width: 260px;
            }

            body {
                background-color: #f8fafc;
                color: #1e293b;
                font-family: 'Inter', system-ui, -apple-system, sans-serif;
            }

            /* Sleek Glass Effect */
            .glass-card {
                background: var(--glass-bg);
                backdrop-filter: blur(12px);
                border: 1px solid var(--glass-border);
                box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.05);
            }

            /* Professional Typography */
            .text-display {
                letter-spacing: -0.02em;
                font-weight: 700;
            }

            /* Sublte Row Hover */
            .hover-row-highlight {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                border-left: 3px solid transparent;
            }

            .hover-row-highlight:hover {
                background-color: #f1f5f9 !important;
                border-left: 3px solid var(--accent-indigo) !important;
                transform: translateX(4px);
            }

            /* Modern Inputs */
            .form-control-futurist {
                border: 1px solid #e2e8f0;
                background: #ffffff;
                padding: 0.6rem 1rem;
                transition: all 0.2s;
            }

            .form-control-futurist:focus {
                border-color: var(--accent-indigo);
                box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
            }

            /* Action Badge */
            .badge-soft {
                padding: 0.5em 0.8em;
                font-weight: 600;
                border-radius: 6px;
            }
            .badge-soft-info { background: #e0f2fe; color: #0369a1; }
        </style>
    @endpush

    @section('title', 'Agents Non Actifs | HR Insight')

    <div class="container-fluid py-4 px-lg-5">

        {{-- Header Section: Professional & Concise --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-end mb-5">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item small text-uppercase fw-bold text-muted">DRI-Marrakech</li>
                        <li class="breadcrumb-item small text-uppercase fw-bold text-primary active">Administration</li>
                    </ol>
                </nav>
                <h1 class="text-display h2 mb-0">Répertoire des Agents <span class="text-primary">Non Actifs</span></h1>
            </div>

            <div class="d-flex gap-2 mt-3 mt-md-0">
                <div class="btn-group shadow-sm rounded-3 overflow-hidden">
                    <button class="btn btn-white border-end" title="Exporter Excel"><i class="bi bi-file-earmark-excel"></i></button>
                    <button class="btn btn-white" onclick="window.print()" title="Imprimer"><i class="bi bi-printer"></i></button>
                </div>
                <div class="btn-group shadow-sm rounded-3 overflow-hidden">
                    <a href="?opt=list" class="btn {{ (session('opt') == 'list' || !session('opt')) ? 'btn-dark' : 'btn-white border' }}"><i class="bi bi-list"></i></a>
                    <a href="?opt=cards" class="btn {{ session('opt') == 'cards' ? 'btn-dark' : 'btn-white border' }}"><i class="bi bi-grid"></i></a>
                    <a href="?opt=empcrd" class="btn {{ session('opt') == 'empcrd' ? 'btn-dark' : 'btn-white border' }}"><i class="bi bi-person-badge"></i></a>
                </div>
            </div>
        </div>

        @if(session('opt') != 'empcrd')
            {{-- Advanced Filter Panel --}}
            <div class="glass-card rounded-4 p-4 mb-4 border-0">
                <form method="GET" action="{{ route('employees.status') }}" class="row g-3 align-items-end">
                    <div class="col-xl-5 col-lg-6">
                        <label class="small fw-bold text-muted mb-2"><i class="bi bi-search me-2"></i>RECHERCHE GLOBALE</label>
                        <input type="text" name="flt" value="{{ $filter_val ?? '' }}"
                               class="form-control form-control-futurist rounded-3"
                               placeholder="Rechercher par Nom, PPR ou Email...">
                    </div>
                    <div class="col-xl-4 col-lg-6">
                        <label class="small fw-bold text-muted mb-2"><i class="bi bi-funnel me-2"></i>SITUATION ADMINISTRATIVE</label>
                        <select class="form-select form-control-futurist rounded-3" name="state" id="sl_agent_status">
                            <option value="" selected disabled>Tous les états...</option>
                            <option value="0" {{ $state == "0" ? 'selected' : '' }}>Mise à disposition</option>
                            <option value="-1" {{ $state == "-1" ? 'selected' : '' }}>Mise à la retraite</option>
                            <option value="-2" {{ $state == "-2" ? 'selected' : '' }}>Suspension immédiate</option>
                            <option value="2" {{ $state == "2" ? 'selected' : '' }}>Réintégration</option>
                        </select>
                    </div>
                    <div class="col-xl-3 col-lg-12 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100 rounded-3 py-2 fw-bold">
                            Appliquer le filtre
                        </button>
                        <a href="{{ route('employees.status') }}" class="btn btn-outline-secondary rounded-3">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>
                </form>
            </div>
        @endif

        {{-- Main Data Display --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                @if (session('opt') == 'cards')
                    <div class="p-4">@include('app.employees._cards')</div>
                @elseif(session('opt') == 'empcrd')
                    @include('app.employees._employee_card')
                @else
                    @include('app.employees._list')
                @endif
            </div>

            {{-- Smart Pagination --}}
            @if($employees instanceof \Illuminate\Pagination\AbstractPaginator && $employees->hasPages())
                <div class="card-footer bg-white border-top py-3 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="small text-muted">
                            Affichage <span class="text-dark fw-bold">{{ $employees->firstItem() }}</span> à <span class="text-dark fw-bold">{{ $employees->lastItem() }}</span> sur <span class="badge badge-soft-info">{{ $employees->total() }}</span> agents
                        </span>
                        <div>
                            {{ $employees->appends(request()->query())->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layout>
