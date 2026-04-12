<x-layout>
    @section('title', 'Gestion des mutations - HR Management')

    <style>
        body { font-family: 'Inter', 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        .fw-extrabold { font-weight: 800; }
        .ls-1 { letter-spacing: 0.05em; }

        /* Clean Table Styles */
        .table thead th {
            background-color: #f8fafc;
            text-transform: uppercase;
            font-size: 0.65rem;
            letter-spacing: 0.05rem;
            color: #64748b;
            padding: 16px;
            border-top: 1px solid #e2e8f0;
        }
        .table tbody tr { transition: all 0.2s; border-bottom: 1px solid #f1f5f9; }
        .table tbody tr:hover { background-color: #ffffff; box-shadow: 0 4px 12px rgba(0,0,0,0.03); }

        /* Hierarchy Text */
        .text-hierarchy-top { font-size: 0.65rem; letter-spacing: 0.03rem; font-weight: 700; }
        .text-hierarchy-mid { font-size: 0.85rem; font-weight: 600; color: #1e293b; }
        .text-hierarchy-sub { font-size: 0.75rem; color: #64748b; }

        /* Transfer Arrow */
        .transfer-icon {
            width: 28px;
            height: 28px;
            background: #f1f5f9;
            color: #94a3b8;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }

        .avatar-sq { width: 38px; height: 38px; object-fit: cover; border-radius: 8px; }

        /* Filter Bar Styling */
        .filter-bar {
            background: white;
            border-radius: 12px 12px 0 0;
            border-bottom: 1px solid #e2e8f0;
            padding: 1.25rem;
        }
    </style>

    <div class="container-fluid py-4 px-md-5">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 fw-extrabold text-dark mb-1"><i class="bi bi-shuffle me-1"></i>Mutations <span class="text-primary text-opacity-75">du Personnel</span></h1>
                <p class="text-muted small mb-0">Pilotage des mouvements et affectations de service.</p>
            </div>
            <a class="btn btn-primary rounded-3 px-4 fw-bold shadow-sm" href="{{ route('mutations.create') }}">
                <i class="bi bi-plus-lg me-2"></i>Nouvelle Mutation vers une structure externe
            </a>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

                    {{-- Horizontal Search & Filter Bar --}}
                    <div class="filter-bar">
                        <form method="GET" action="{{ route('mutations.index') }}" class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <label class="small fw-bold text-uppercase text-muted mb-2 d-block">Recherche</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-light border-light text-muted"><i class="bi bi-search"></i></span>
                                    <input type="text" name="fltr" value="{{ $emp ?? '' }}" class="form-control border-light bg-light" placeholder="Nom de l'agent ou PPR...">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="small fw-bold text-uppercase text-muted mb-2 d-block">Type de Mutation</label>
                                <select name="type" class="form-select form-select-sm border-light bg-light">
                                    <option value="">Tous les types</option>
                                    <option value="I" {{ (request()->has('type') && request()->query('type') == 'I') ? 'selected' : ''}}>Interne</option>
                                    <option value="E" {{ (request()->has('type') && request()->query('type') == 'E') ? 'selected' : ''}}>Externe</option>
                                </select>
                            </div>

                            <div class="col-md-5 text-md-end">
                                <button type="submit" class="btn btn-dark btn-sm px-4 rounded-3 fw-bold">
                                    <i class="bi bi-filter me-2"></i>Appliquer les filtres
                                </button>
                                <a href="{{ route('mutations.index') }}" class="btn btn-link btn-sm text-muted text-decoration-none ms-2">Réinitialiser</a>
                            </div>
                        </form>
                    </div>

                    {{-- Table --}}
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                            <tr>
                                <th class="ps-4">Agent & Détails</th>
                                <th>Origine (Ancienne Affectation)</th>
                                <th class="text-center" style="width: 60px;"></th>
                                <th>Destination (Nouvelle Affectation)</th>
                                <th>Date Effective</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($mutations as $mutation)
                                <tr>
                                    {{-- Agent --}}
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="position-relative">
                                                @if($mutation->employee->photo)
                                                    <img src="{{ Storage::url($mutation->employee->photo) }}"
                                                         class="avatar-sq me-3 border hover-trigger"
                                                         data-photo="{{ Storage::url($mutation->employee->photo) }}">
                                                @else
                                                    <div class="avatar-sq me-3 bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center fw-bold hover-trigger"
                                                         data-photo="NONE">
                                                        {{ strtoupper(substr($mutation->employee->firstname, 0, 1) . substr($mutation->employee->lastname, 0, 1)) }}
                                                    </div>
                                                @endif
                                            </div>

                                            <div>
                                                <div class="fw-bold text-dark mb-0" style="font-size: 0.85rem;">
                                                    <a href="{{ route('employees.show', $mutation->employee->id) }}" class="text-decoration-none" target="_blank">
                                                        {{ strtoupper($mutation->employee->lastname) }} {{ $mutation->employee->firstname }}
                                                    </a>
                                                </div>
                                                <span class="text-muted" style="font-size: 0.7rem;">PPR: #{{ $mutation->employee->ppr }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Source Hierarchy --}}
                                    <td class="py-3">
                                        <div class="d-flex flex-column">
                                            @if (!is_null($mutation->fromAffectation->sector))
                                                <span class="text-uppercase fw-bold text-primary mb-1" style="font-size: 0.65rem; letter-spacing: 0.05rem;">
                                                    <i class="bi bi-geo-alt-fill me-1"></i>
                                                    {{ $mutation->fromAffectation->sector->title ?? 'Secteur Non Défini' }}
                                                </span>
                                            @endif
                                            @if (!is_null($mutation->fromAffectation->section))
                                                <span class="text-uppercase fw-bold text-primary mb-1" style="font-size: 0.65rem; letter-spacing: 0.05rem;">
                                                    <i class="bi bi-layers me-1"></i>
                                                    {{ $mutation->fromAffectation->section->title ?? 'Secteur Non Défini' }}
                                                </span>
                                            @endif
                                            @if ( !is_null($mutation->fromAffectation->entity))
                                                <span class="fw-semibold text-dark mb-0" style="font-size: 0.85rem;">
                                                    <i class="bi bi-diagram-2-fill me-1"></i>
                                                    {{ $mutation->fromAffectation->entity->title }}
                                                </span>
                                            @endif
                                            <span class="text-muted" style="font-size: 0.75rem;">
                                                <i class="bi bi-diagram-3-fill me-1"></i>
                                                Section: {{ $mutation->fromAffectation->service->title ?? 'N/A' }}
                                            </span>
                                        </div>
                                    </td>
                                    {{-- Icon --}}
                                    <td class="text-center px-0">
                                        <div class="transfer-icon shadow-sm border">
                                            <i class="bi bi-arrow-right-short fs-5"></i>
                                        </div>
                                    </td>

                                    {{-- Destination Hierarchy --}}
                                    <td class="py-3">

                                        <div class="d-flex flex-column">
                                            @if (!is_null($mutation->toAffectation))
                                                @if (!is_null($mutation->toAffectation->sector))
                                                    <span class="text-uppercase fw-bold text-primary mb-1" style="font-size: 0.65rem; letter-spacing: 0.05rem;">
                                                    <i class="bi bi-layers me-1"></i>
                                                    {{ $mutation->toAffectation->sector->title ?? 'Secteur Non Défini' }}
                                                    </span>
                                                @endif
                                                @if (!is_null($mutation->toAffectation->section))
                                                    <span class="text-uppercase fw-bold text-primary mb-1" style="font-size: 0.65rem; letter-spacing: 0.05rem;">
                                                        <i class="bi bi-layers me-1"></i>
                                                        {{ $mutation->toAffectation->section->title ?? 'Secteur Non Défini' }}
                                                    </span>
                                                @endif
                                                @if ( !is_null($mutation->toAffectation->entity))
                                                    <span class="fw-semibold text-dark mb-0" style="font-size: 0.85rem;">
                                                        <i class="bi bi-diagram-2-fill me-1"></i>
                                                        {{ $mutation->toAffectation->entity->title }}
                                                    </span>
                                                @endif
                                                <span class="text-muted" style="font-size: 0.75rem;">
                                                    <i class="bi bi-diagram-3-fill me-1"></i>
                                                    Section: {{ $mutation->toAffectation->service->title ?? 'N/A' }}
                                                </span>
                                            @else
                                                @if (!is_null($mutation->entity_name))
                                                    <span class="text-uppercase fw-bold text-primary mb-1" style="font-size: 0.65rem; letter-spacing: 0.05rem;">
                                                    <i class="bi bi-layers me-1"></i>
                                                    {{ $mutation->entity_name ?? 'N/A' }}
                                                    </span>
                                                @endif
                                                @if (!is_null($mutation->direction_name))
                                                    <span class="text-uppercase fw-bold text-primary mb-1" style="font-size: 0.65rem; letter-spacing: 0.05rem;">
                                                        <i class="bi bi-layers me-1"></i>
                                                        {{ $mutation->direction_name ?? 'N/A' }}
                                                    </span>
                                                @endif
                                                @if ( !is_null($mutation->city_name))
                                                    <span class="fw-semibold text-dark mb-0" style="font-size: 0.85rem;">
                                                        <i class="bi bi-diagram-2-fill me-1"></i>
                                                        {{ $mutation->city_name ?? 'N/A' }}
                                                    </span>
                                                @endif
                                            @endif
                                        </div>
                                    </td>

                                    {{-- Date --}}
                                    <td>
                                        <span class="badge bg-white text-dark border px-2 py-1 fw-semibold" style="font-size: 0.75rem;">
                                            <i class="bi bi-calendar3 me-1 text-primary"></i>
                                            {{ \Carbon\Carbon::parse($mutation->createdAt)->format('d/m/Y') }}
                                        </span>
                                    </td>

                                    {{-- Actions --}}
                                    <td class="pe-4 text-end">
                                        <div class="btn-group border rounded-2 bg-white">
                                            <a href="{{ route('mutations.decision', $mutation) }}" target="_blank" class="btn btn-white btn-sm px-3 border-start text-danger" title="Décision">
                                                <i class="bi bi-file-earmark-pdf small"></i></a>
                                            @if (!is_null($mutation->demand))
                                            <a href="{{ Storage::url($mutation->demand->file)  }}" target="_blank" class="btn btn-white btn-sm px-3 border-start text-primary" title="Demande">
                                                <i class="bi bi-filetype-doc small"></i></a>
                                            @endif
                                        </div>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <p class="text-muted mb-0 small">Aucune mutation trouvée pour ces critères.</p>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="photo-preview"
         style="display: none;
                position: fixed;
                z-index: 9999;
                width: 250px;
                height: 250px;
                border-radius: 12px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.2);
                border: 5px solid white;
                background-size: cover;
                background-position: center;
                pointer-events: none;"></div>


    <script>
        document.querySelectorAll('.hover-trigger').forEach(item => {
            const preview = document.getElementById('photo-preview');

            item.addEventListener('mouseenter', (e) => {
                const photoUrl = item.getAttribute('data-photo');
                if (photoUrl !== "NONE") {
                    preview.style.backgroundImage = `url('${photoUrl}')`;
                    preview.style.display = 'block';
                }
            });

            item.addEventListener('mousemove', (e) => {
                // Offset by 20px so it doesn't flicker under the cursor
                preview.style.left = (e.clientX + 20) + 'px';
                preview.style.top = (e.clientY - 200) + 'px'; // Centered vertically
            });

            item.addEventListener('mouseleave', () => {
                preview.style.display = 'none';
            });
        });
    </script>

</x-layout>
