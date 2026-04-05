<x-layout>

    @section('title', 'Gestion des Agents - HR Management')

    <style>
        :root {
            --admin-indigo: #6366f1;
            --surface-glass: rgba(255, 255, 255, 0.8);
            --border-subtle: #f1f5f9;
        }

        body { background-color: #f8fafc; font-family: 'Inter', system-ui, sans-serif; }

        /* Professional Typography */
        .text-display { letter-spacing: -0.02em; font-weight: 800; }
        .ls-caps { letter-spacing: 0.05em; font-size: 0.7rem; text-transform: uppercase; }

        /* Surface Depth */
        .glass-card {
            background: var(--surface-glass);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        /* Metric Cards: The "Futurist" Look */
        .metric-card {
            border: 1px solid var(--border-subtle);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .metric-card:hover {
            transform: translateY(-4px);
            border-color: var(--admin-indigo);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
        }

        /* Sleek Input Fields */
        .form-control-futurist {
            background: #f1f5f9;
            border: 1px solid transparent;
            padding: 0.6rem 1rem;
            transition: 0.2s;
        }
        .form-control-futurist:focus {
            background: #fff;
            border-color: var(--admin-indigo);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        /* View Switcher Refinement */
        .view-switcher {
            background: #f1f5f9;
            padding: 4px;
            border-radius: 12px;
        }
        .view-switcher .btn {
            border: none;
            padding: 6px 12px;
            border-radius: 8px;
        }
        .view-switcher .btn-active {
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            color: var(--admin-indigo) !important;
            padding-top: 6px;
        }

        /* Hover Row with Side Indicator */
        .hover-row-highlight {
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }
        .hover-row-highlight:hover {
            background-color: #f8fafc !important;
            border-left: 3px solid var(--admin-indigo) !important;
        }
    </style>

    <div class="container-fluid py-4 px-lg-5">

        {{-- Header: Professional & Clean --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-end mb-5">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item ls-caps fw-bold text-muted">DRI-Marrakech</li>
                        <li class="breadcrumb-item ls-caps fw-bold text-primary active">Administration</li>
                    </ol>
                </nav>
                <h1 class="text-display h2 mb-0">Répertoire des <span class="text-primary">Agents</span></h1>
            </div>

            <div class="d-flex gap-2 mt-3 mt-md-0">
                <a href="{{ route('employees.advance') }}" class="btn btn-light border px-4 rounded-3 fw-bold shadow-sm">
                    <i class="bi bi-search me-2"></i>Avancé
                </a>
                <a href="{{ route('employees.create') }}" class="btn btn-dark px-4 rounded-3 fw-bold shadow-sm">
                    <i class="bi bi-plus-lg me-2"></i>Nouvel Employé
                </a>
            </div>
        </div>

        {{-- Metrics Row --}}
        <div class="row g-4 mb-5">
            @php
                $metrics = [
                    ['label' => 'Effectif Global', 'count' => $total_employee, 'trend' => 'Actif', 'color' => 'indigo', 'icon' => 'bi-people'],
                    ['label' => 'Personnel Féminin', 'count' => $femaleCount, 'trend' => 'Diversité', 'color' => 'pink', 'icon' => 'bi-gender-female'],
                    ['label' => 'Personnel Masculin', 'count' => $maleCount, 'trend' => 'Diversité', 'color' => 'blue', 'icon' => 'bi-gender-male'],
                    ['label' => 'Sites Opérationnels', 'count' => $locals->count(), 'trend' => 'Infrastructure', 'color' => 'amber', 'icon' => 'bi-building']
                ];
            @endphp
            @foreach($metrics as $metric)
                <div class="col-xl-3 col-sm-6">
                    <div class="card metric-card border-0 rounded-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between mb-3">
                                <div class="ls-caps fw-bold text-muted">{{ $metric['label'] }}</div>
                                <i class="bi {{ $metric['icon'] }} text-{{ $metric['color'] }}"></i>
                            </div>
                            <div class="h2 fw-bold mb-1">{{ $metric['count'] }}</div>
                            <div class="extra-small fw-bold text-{{ $metric['color'] }} opacity-75">{{ $metric['trend'] }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if(session('opt') != 'empcrd')
            {{-- Advanced Filter: Glass Effect --}}
            <div class="glass-card rounded-4 p-4 mb-4">
                <form method="GET" action="{{ route('employees.search') }}" class="row g-3 align-items-end">

                    {{-- Search Input --}}
                    <div class="col-xl-4">
                        <label class="ls-caps fw-bold text-muted mb-2">Recherche intelligente</label>
                        <input type="text"
                               name="employee_search"
                               id="employee_search"
                               value="{{ $filter_val }}"
                               class="form-control form-control-futurist rounded-3"
                               placeholder="Nom, PPR, Email...">
                    </div>

                    {{-- Local Select (Restored ID & Selection Logic) --}}
                    <div class="col-xl-3">
                        <label class="ls-caps fw-bold text-muted mb-2">Localisation</label>
                        <select name="local_id"
                                id="sl_employee_local"
                                class="form-select form-control-futurist rounded-3 border-0 shadow-none">
                            <option value="-1">Tous les locaux</option>
                            @foreach($locals as $local)
                                <option value="{{ $local->id }}" {{ $local_id == $local->id ? 'selected' : '' }}>
                                    {{ $local->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- City Select (Restored ID & Selection Logic) --}}
                    <div class="col-xl-3">
                        <label class="ls-caps fw-bold text-muted mb-2">Ville</label>
                        <select name="city_id"
                                id="sl_employee_city"
                                class="form-select form-control-futurist rounded-3 border-0 shadow-none">
                            <option value="-1">Toutes les villes</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}" {{ $city_id == $city->id ? 'selected' : '' }}>
                                    {{ $city->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Actions --}}
                    <div class="col-xl-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100 rounded-3 py-2 fw-bold shadow-sm">
                            <i class="bi bi-filter me-1"></i>Filtrer
                        </button>
                        <button type="button"
                                class="btn btn-outline-secondary rounded-3 px-3"
                                data-bs-toggle="modal"
                                data-bs-target="#sortEmployeeOptionsModal"
                                title="Options de tri">
                            <i class="bi bi-sliders"></i>
                        </button>
                    </div>
                </form>
            </div>
        @endif

        <x-sort-employee-options />

        {{-- Table Container --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white py-4 px-4 border-bottom-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">Effectif Actif
                    @if($employees instanceof \Illuminate\Pagination\AbstractPaginator)
                        <span class="badge bg-light text-dark ms-2">
                           {{ $employees->total() }}
                        </span>
                    @endif
                </h5>

                <div class="d-flex align-items-center gap-3">
                <div class="btn-group shadow-xs rounded-3 overflow-hidden border">
                   <button class="btn btn-white border-end" title="Imprimer"><i class="bi bi-printer text-muted"></i></button>
                   <a class="btn btn-white" href="{{ route('employees.download') }}" title="Exporter Excel"><i class="bi bi-file-earmark-excel text-success"></i></a>
                </div>

                <div class="view-switcher d-flex shadow-xs">
                   <a href="?opt=list" class="btn {{ (!session('opt') || session('opt') == 'list') ? 'btn-active' : ' text-muted' }}"><i class="bi bi-list"></i></a>
                   <a href="?opt=cards" class="btn {{ session('opt') == 'cards' ? 'btn-active' : 'text-muted' }}"><i class="bi bi-grid"></i></a>
                   <a href="?opt=empcrd" class="btn {{ session('opt') == 'empcrd' ? 'btn-active' : 'text-muted' }}"><i class="bi bi-person-badge"></i></a>
                </div>
            </div>
        </div>

<div class="table-responsive" style="min-height: 500px">
    @if (session('opt') == 'cards')
        <div class="p-4">@include('app.employees._cards')</div>
    @elseif(session('opt') == 'empcrd')
        @include('app.employees._employee_card')
    @else
        @include('app.employees._list')
    @endif
</div>

            {{-- Modals de suppression --}}

            @foreach($employees as $employee)

                <x-delete-model

                    href="{{ route('employees.delete', $employee->id) }}"

                    message="Attention : La suppression de l'agent #{{ $employee->ppr }} est irréversible."

                    title="Confirmation de Suppression"

                    target="deleteEmployeeModal" />

            @endforeach

        </div>

{{-- Smart Pagination --}}
@if($employees instanceof \Illuminate\Pagination\AbstractPaginator && $employees->hasPages())
<div class="card-footer bg-white border-top py-4 px-4">
<div class="d-flex justify-content-between align-items-center">
   <div class="text-muted small fw-medium">
       Affichage <span class="text-dark fw-bold">{{ $employees->firstItem() }}</span> - <span class="text-dark fw-bold">{{ $employees->lastItem() }}</span> sur <span class="text-dark fw-bold">{{ $employees->total() }}</span> agents
   </div>
   <div>{{ $employees->appends(request()->query())->links() }}</div>
</div>
</div>
@endif
</div>
</div>
</x-layout>
