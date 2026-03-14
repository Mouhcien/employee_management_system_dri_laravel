<x-layout>
    <div class="container-fluid py-4">
        <div class="card border-0 shadow-sm mb-4 rounded-4 overflow-hidden">
            <div class="card-header bg-gradient bg-primary py-3 px-4 border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-white">
                        <i class="bi bi-person-badge-fill me-2"></i>
                        Gestion du Profil Chef
                    </h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('chefs.index') }}" class="btn btn-light btn-sm rounded-pill px-3 shadow-sm">
                            <i class="bi bi-arrow-left me-1"></i> Retour
                        </a>
                        <div class="dropdown">
                            <button class="btn btn-dark btn-sm rounded-pill px-3 dropdown-toggle shadow-sm" data-bs-toggle="dropdown">
                                <i class="bi bi-cloud-download me-1"></i> Exporter
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3">
                                <li><a href="#" class="dropdown-item py-2"><i class="bi bi-file-earmark-excel text-success me-2"></i>Données Excel</a></li>
                                <li><a href="#" class="dropdown-item py-2"><i class="bi bi-bar-chart text-info me-2"></i>Rapport Statistique</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a href="#" class="dropdown-item py-2 text-danger"><i class="bi bi-file-earmark-pdf me-2"></i>Document PDF</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body bg-light-subtle p-4">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm h-100 rounded-4">
                            <div class="card-body">
                                <div class="text-center mb-4">
                                    <x-employee-card :employee="$chef->employee" detach="false" />
                                </div>

                                <div class="list-group list-group-flush border-top">
                                    <div class="list-group-item d-flex justify-content-between align-items-center py-3 bg-transparent border-0">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-box bg-primary-subtle text-primary rounded-3 p-2 me-3">
                                                <i class="bi bi-calendar-check"></i>
                                            </div>
                                            <span class="fw-semibold text-secondary">Date de nomination</span>
                                        </div>
                                        <span class="badge rounded-pill bg-primary px-3 py-2">
                                            {{ \Carbon\Carbon::parse($chef->starting_date)->format('d/m/Y') }}
                                        </span>
                                    </div>

                                    <div class="list-group-item d-flex justify-content-between align-items-center py-3 bg-transparent border-0">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-box bg-warning-subtle text-warning rounded-3 p-2 me-3">
                                                <i class="bi bi-hourglass-split"></i>
                                            </div>
                                            <span class="fw-semibold text-secondary">Ancienneté</span>
                                        </div>
                                        @php
                                            $date1 = \Carbon\Carbon::parse($chef->starting_date);
                                            $date2 = now();
                                            $interval = $date1->diff($date2);
                                        @endphp
                                        <span class="fw-bold text-dark">
                                            {{ $interval->y }} <small>Ans</small>, {{ $interval->m }} <small>Mois</small>
                                        </span>
                                    </div>

                                    <div class="list-group-item d-flex justify-content-between align-items-center py-3 bg-transparent border-0">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-box bg-danger-subtle text-danger rounded-3 p-2 me-3">
                                                <i class="bi bi-file-pdf-fill"></i>
                                            </div>
                                            <span class="fw-semibold text-secondary">Document de Décision</span>
                                        </div>
                                        <a href="{{ Storage::url($chef->decision_file) }}" target="_blank" class="btn btn-outline-danger btn-sm rounded-circle p-2">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                            <div class="card-header bg-white border-0 py-3 px-4">
                                <h6 class="mb-0 fw-bold"><i class="bi bi-pencil-square text-warning me-2"></i>Mettre à jour les données</h6>
                            </div>
                            <div class="card-body px-4 pb-4">
                                <form action="{{ route('chefs.update', $chef) }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="mb-4">
                                        <label class="form-label small fw-bold text-uppercase text-muted">Date de Commencement</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0"><i class="bi bi-calendar3 text-primary"></i></span>
                                            <x-date-input id="starting_date" name="starting_date" value="null" class="form-control border-0 bg-light" />
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label small fw-bold text-uppercase text-muted">Nouvelle Décision (PDF)</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0"><i class="bi bi-cloud-upload text-primary"></i></span>
                                            <input type="file" name="decision_file" class="form-control border-0 bg-light shadow-none" id="decision_file">
                                        </div>
                                        <div class="form-text small">Laissez vide pour conserver le fichier actuel.</div>
                                    </div>

                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-5">
                                        <button type="button" class="btn btn-light px-4 rounded-pill">Annuler</button>
                                        <button type="submit" class="btn btn-warning px-4 rounded-pill fw-bold shadow-sm">
                                            <i class="bi bi-check-lg me-1"></i> Enregistrer les modifications
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .icon-box {
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .bg-gradient-primary {
            background: linear-gradient(45deg, #4e73df 0%, #224abe 100%);
        }
        .form-control:focus {
            background-color: #fff !important;
            border: 1px solid #ffc107 !important;
            box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.15);
        }
    </style>
</x-layout>
