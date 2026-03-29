<x-layout>
    <style>
        /* Maintaining your specific SaaS colors */
        :root {
            --saas-primary: #0061f2;
            --saas-secondary: #0a2351;
            --saas-bg-soft: #f8f9fa;
        }

        /* Your original Header Gradient */
        .profile-header-custom {
            background: linear-gradient(135deg, var(--saas-primary) 0%, var(--saas-secondary) 100%);
            border-radius: 16px;
        }

        /* Table & Component Refinements */
        .table thead th {
            background-color: var(--saas-bg-soft);
            text-transform: uppercase;
            font-size: 0.7rem;
            font-weight: 700;
            color: #6c757d;
            border: none;
        }

        .card-saas {
            border: 1px solid rgba(0,0,0,.05);
            border-radius: 12px;
            transition: all 0.2s ease;
        }

        .action-btn {
            height: 30px;
            width: 30px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            transition: 0.2s;
        }

        .action-btn:hover { transform: scale(1.1); }

        .bg-warning-soft { background-color: rgba(255, 193, 7, 0.15); color: #856404; }
        .bg-danger-soft { background-color: rgba(220, 53, 69, 0.1); color: #dc3545; }
        .bg-info-soft { background-color: rgba(13, 202, 240, 0.1); color: #087990; }
    </style>

    <div class="card profile-header-custom border-0 shadow-sm mb-4 text-white">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-7 d-flex align-items-center">
                    <div class="bg-primary bg-opacity-20 p-3 rounded-3 me-3">
                        <i class="bi bi-calendar-check fs-3"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-0">Les périodes de Suivi</h3>
                        <p class="mb-0 text-white-50 small">Gestion centralisée de vos structures de données</p>
                    </div>
                </div>
                <div class="col-md-5 text-md-end mt-3 mt-md-0">

                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card card-saas shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Liste des périodes</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                            <tr>
                                <th class="ps-4">ID</th>
                                <th>Période</th>
                                <th>Dates (Début - Fin)</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($periods as $period)
                                <tr>
                                    <td class="ps-4 text-muted small">#{{ $period->id }}</td>
                                    <td><span class="fw-bold">{{ $period->title }}</span></td>
                                    <td>
                                        <div class="small">
                                            <i class="bi bi-calendar3 text-primary me-1"></i>
                                            {{ $period->starting_date ? \Carbon\Carbon::parse($period->starting_date)->locale('fr')->translatedFormat('d M Y') : '--' }}
                                            <span class="text-muted mx-1">→</span>
                                            {{ $period->end_date ? \Carbon\Carbon::parse($period->end_date)->locale('fr')->translatedFormat('d M Y') : '--' }}
                                        </div>
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('audit.periods.edit', $period) }}" class="action-btn bg-warning-soft mx-1"><i class="bi bi-pencil-square"></i></a>
                                        <a href="{{ route('audit.periods.show', $period) }}" class="action-btn bg-info-soft mx-1"><i class="bi bi-list"></i></a>
                                        <a href="{{ route('audit.periods.delete', $period) }}" class="action-btn bg-danger-soft mx-1"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center py-4 text-muted">Aucune période trouvée</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card card-saas shadow-sm border-0">
                <div class="card-header {{ is_null($periodObj) ? 'bg-success' : 'bg-warning' }} text-white py-3">
                    <h5 class="mb-0">
                        <i class="bi {{ is_null($periodObj) ? 'bi-plus-square' : 'bi-pencil-square' }} me-2"></i>
                        {{ is_null($periodObj) ? 'Nouvelle Période' : 'Modifier ' . $periodObj->title }}
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ is_null($periodObj) ? route('audit.periods.store') : route('audit.periods.update', $periodObj) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-uppercase text-muted">Nom de la Période</label>
                            <input type="text" name="title" class="form-control" placeholder="ex: Trimestre 1" value="{{ is_null($periodObj) ? '' : $periodObj->title }}">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-uppercase text-muted">Début</label>
                                <x-date-input id="starting_date" name="starting_date" value="{{ old('starting_date', $periodObj->starting_date ?? '') }}" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-uppercase text-muted">Fin</label>
                                <x-date-input id="end_date" name="end_date" value="{{ old('end_date', $periodObj->end_date ?? '') }}" />
                            </div>
                        </div>
                        <hr class="my-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('audit.periods.index') }}" class="btn btn-light btn-sm text-muted text-decoration-none"><i class="bi bi-x-lg"></i> Annuler</a>
                            <button type="submit" class="btn {{ is_null($periodObj) ? 'btn-success' : 'btn-warning' }} px-4 shadow-sm">
                                <i class="bi bi-save me-2"></i>{{ is_null($periodObj) ? 'Enregistrer' : 'Mettre à jour' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>
