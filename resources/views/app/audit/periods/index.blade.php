<x-layout>
    <style>
        /* --- Spectrum UI Futurist Palette --- */
        :root {
            --primary-gradient: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            --glass-bg: rgba(255, 255, 255, 0.8);
            --border-subtle: rgba(226, 232, 240, 0.8);
            --saas-indigo: #4f46e5;
        }

        body { background-color: #f1f5f9; font-family: 'Inter', sans-serif; }

        /* Futurist Hero Header */
        .header-spectrum {
            background: radial-gradient(circle at top right, #4f46e5, #0f172a);
            border-radius: 24px;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .header-spectrum::after {
            content: ""; position: absolute; top: -20%; right: -10%; width: 300px; height: 300px;
            background: rgba(99, 102, 241, 0.2); filter: blur(80px); border-radius: 50%;
        }

        /* Technical Card Aesthetic */
        .card-futurist {
            background: white;
            border-radius: 20px;
            border: 1px solid var(--border-subtle);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-futurist:hover { box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.05); }

        /* Modern Table Styling */
        .table-technical thead th {
            background-color: #f8fafc;
            text-transform: uppercase;
            font-size: 0.65rem;
            letter-spacing: 0.05em;
            font-weight: 800;
            color: #64748b;
            padding: 1.25rem 1rem;
            border-bottom: 2px solid #f1f5f9;
        }

        .table-technical tbody tr { transition: all 0.2s; }
        .table-technical tbody tr:hover { background-color: #fcfdff; }

        /* Action Pill Buttons */
        .action-pill {
            height: 34px;
            width: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            transition: all 0.2s;
            border: 1px solid transparent;
        }
        .action-pill:hover { transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,0.1); }

        /* Spectrum Accents */
        .bg-indigo-soft { background: rgba(99, 102, 241, 0.1); color: #4f46e5; border: 1px solid rgba(99, 102, 241, 0.2); }
        .bg-rose-soft { background: rgba(244, 63, 94, 0.1); color: #e11d48; border: 1px solid rgba(244, 63, 94, 0.2); }
        .bg-sky-soft { background: rgba(14, 165, 233, 0.1); color: #0284c7; border: 1px solid rgba(14, 165, 233, 0.2); }

        /* Typography */
        .ls-caps { letter-spacing: 0.05em; font-size: 0.7rem; text-transform: uppercase; font-weight: 700; color: #64748b; }

        .form-control-futurist {
            border-radius: 12px; border: 1px solid #e2e8f0; padding: 0.75rem 1rem; transition: all 0.2s;
        }
        .form-control-futurist:focus {
            border-color: var(--saas-indigo); box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }
    </style>

    {{-- Vibrant Header --}}
    <div class="card header-spectrum border-0 shadow-lg mb-5 text-white">
        <div class="card-body p-5">
            <div class="row align-items-center">
                <div class="col-md-7 d-flex align-items-center">
                    <div class="bg-white bg-opacity-10 p-3 rounded-4 me-4 border border-white border-opacity-10">
                        <i class="bi bi-calendar-range-fill fs-2 text-info"></i>
                    </div>
                    <div>
                        <span class="ls-caps text-info opacity-75">Chronologie d'Audit</span>
                        <h2 class="fw-bold mb-0 display-6">Périodes de Suivi</h2>
                        <p class="mb-0 text-white-50 lead fs-6">Orchestration temporelle des collectes de données</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- List Section --}}
        <div class="col-lg-7">
            <div class="card card-futurist shadow-sm border-0 h-100">
                <div class="card-header bg-white py-4 px-4 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-list-nested me-2 text-primary"></i>Registre Temporel</h5>
                    <span class="badge bg-indigo-soft px-3 py-2 rounded-pill fw-bold">{{ $periods->count() }} Périodes</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-technical align-middle mb-0">
                            <thead>
                            <tr>
                                <th class="ps-4">Référence</th>
                                <th>Intitulé</th>
                                <th>Cycle</th>
                                <th>Plage Calendaire</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($periods as $period)
                                <tr>
                                    <td class="ps-4 text-muted small fw-mono">#{{ str_pad($period->id, 3, '0', STR_PAD_LEFT) }}</td>
                                    <td><span class="fw-bold text-dark">{{ $period->title }}</span></td>
                                    <td><span class="badge bg-light text-dark border px-2 py-1 rounded-3 fw-bold">{{ $period->year }}</span></td>
                                    <td>
                                        <div class="d-flex align-items-center small fw-medium text-secondary">
                                            <i class="bi bi-calendar-event text-primary me-2"></i>
                                            {{ $period->starting_date ? \Carbon\Carbon::parse($period->starting_date)->locale('fr')->translatedFormat('d M Y') : '--' }}
                                            <i class="bi bi-arrow-right mx-2 opacity-50"></i>
                                            {{ $period->end_date ? \Carbon\Carbon::parse($period->end_date)->locale('fr')->translatedFormat('d M Y') : '--' }}
                                        </div>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end gap-1">
                                            <a href="{{ route('audit.periods.show', $period) }}" class="action-pill bg-sky-soft" title="Détails"><i class="bi bi-eye"></i></a>
                                            <a href="{{ route('audit.periods.edit', $period) }}" class="action-pill bg-indigo-soft" title="Modifier"><i class="bi bi-pencil-square"></i></a>
                                            <a href="{{ route('audit.periods.delete', $period) }}" class="action-pill bg-rose-soft" title="Supprimer"><i class="bi bi-trash3"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <i class="bi bi-calendar-x text-muted opacity-25 display-1"></i>
                                        <p class="text-muted mt-3 fw-medium">Aucun cycle temporel n'a été défini pour le moment.</p>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form Section --}}
        <div class="col-lg-5">
            <div class="card card-futurist shadow-sm border-0">
                <div class="card-header border-0 py-4 px-4 {{ is_null($periodObj) ? 'bg-indigo-soft text-primary' : 'bg-warning bg-opacity-10 text-warning' }} rounded-top-4">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi {{ is_null($periodObj) ? 'bi-plus-circle-dotted' : 'bi-pencil-square' }} me-2"></i>
                        {{ is_null($periodObj) ? 'Nouvelle Configuration' : 'Édition : ' . $periodObj->title }}
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ is_null($periodObj) ? route('audit.periods.store') : route('audit.periods.update', $periodObj) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="ls-caps mb-2">Libellé de la Période</label>
                            <input type="text" name="title" class="form-control form-control-futurist fw-bold" placeholder="ex: Trimestre Q1 - 2026" value="{{ is_null($periodObj) ? '' : $periodObj->title }}" required>
                        </div>
                        <div class="mb-4">
                            <label class="ls-caps mb-2">Année Fiscale / Exercice</label>
                            <input type="number" name="year" class="form-control form-control-futurist fw-bold" placeholder="2026" value="{{ is_null($periodObj) ? '' : $periodObj->year }}" required>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label class="ls-caps mb-2">Ouverture</label>
                                <x-date-input id="starting_date" name="starting_date" value="{{ old('starting_date', $periodObj->starting_date ?? '') }}" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="ls-caps mb-2">Clôture</label>
                                <x-date-input id="end_date" name="end_date" value="{{ old('end_date', $periodObj->end_date ?? '') }}" />
                            </div>
                        </div>

                        <div class="bg-light bg-opacity-50 p-3 rounded-4 mb-4 border-dashed" style="border: 1px dashed #cbd5e1;">
                            <p class="small text-muted mb-0"><i class="bi bi-info-circle-fill text-primary me-2"></i>Cette période servira de référentiel temporel pour l'affectation des audits.</p>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('audit.periods.index') }}" class="btn btn-link ls-caps text-decoration-none text-muted"><i class="bi bi-x-circle me-1"></i> Annuler</a>
                            <button type="submit" class="btn {{ is_null($periodObj) ? 'btn-primary bg-indigo-soft text-primary' : 'btn-warning bg-warning bg-opacity-10 text-warning' }} border shadow-sm px-4 py-2 fw-bold rounded-3">
                                <i class="bi bi-cloud-arrow-up-fill me-2"></i>{{ is_null($periodObj) ? 'Générer la période' : 'Mettre à jour' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>
