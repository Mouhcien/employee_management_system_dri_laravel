
    <div class="container-fluid py-4">
        <form action="{{ route('employees.importation') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Header & Control Panel Premium --}}
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-4">
                <div class="card-body p-0">
                    <div class="bg-primary bg-gradient p-4 text-white">
                        <div class="row align-items-center g-4">
                            {{-- Titre et Contexte --}}
                            <div class="col-xl-4 col-lg-12">
                                <div class="d-flex align-items-center">
                                    <div class="bg-white bg-opacity-20 rounded-3 p-3 me-3 shadow-sm">
                                        <i class="bi bi-file-earmark-spreadsheet-fill fs-3 text-dark"></i>
                                    </div>
                                    <div>
                                        <h1 class="h4 fw-bold mb-1 text-white">Importation Massive</h1>
                                        <p class="text-white text-opacity-75 small mb-0">
                                            <i class="bi bi-geo-alt-fill me-1"></i>DRI-Marrakech | Administration
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Sélection du Local --}}
                            <div class="col-xl-3 col-md-6">
                                <label class="form-label small fw-bold text-uppercase text-white text-opacity-75">Local de destination</label>
                                <div class="input-group border-0 shadow-sm rounded-3 overflow-hidden">
                                    <span class="input-group-text bg-white border-0 text-primary"><i class="bi bi-building"></i></span>
                                    <select name="local_id" class="form-select border-0 bg-white shadow-none" required>
                                        <option value="-1">Sélectionner le local...</option>
                                        @foreach($locals as $local)
                                            <option value="{{ $local->id }}">{{ $local->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Upload de fichier --}}
                            <div class="col-xl-3 col-md-6">
                                <label class="form-label small fw-bold text-uppercase text-white text-opacity-75">Fichier Excel / CSV</label>
                                <input type="file" name="file" class="form-control border-0 bg-white shadow-none py-2" required />
                            </div>

                            {{-- Bouton d'action --}}
                            <div class="col-xl-2 col-md-12 text-xl-end">
                                <button type="submit" class="btn btn-white btn-rounded shadow-sm fw-bold px-4 py-2 w-100 transition-base">
                                    <i class="bi bi-cloud-arrow-up-fill me-2 text-primary"></i>Lancer l'import
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Guide de Structure & Aperçu --}}
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-table text-primary me-2"></i>Structure du fichier attendue</h6>
                        <small class="text-muted">Assurez-vous que l'ordre des colonnes correspond exactement à ce modèle.</small>
                    </div>
                    <span class="badge bg-info-subtle text-info rounded-pill px-3 py-2 fw-bold">
                        <i class="bi bi-info-circle me-1"></i> 14 Colonnes requises
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="table table-sm table-hover align-middle mb-0">
                        <thead class="bg-light-subtle">
                        <tr>
                            @php
                                $headers = ['PPR','CIN','Naissance','Lieu','Genre','Situation','Recrutement','Adresse','Tel','Email','Nom (FR)','Prénom (FR)','Nom (AR)','Prénom (AR)'];
                            @endphp
                            @foreach($headers as $header)
                                <th class="text-muted extra-small fw-bold text-uppercase ls-1 px-3 py-3 border-0">{{ $header }}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody class="bg-white border-top-0">
                        @for($i=0;$i<2;$i++)
                            <tr class="opacity-50">
                                @foreach($headers as $h)
                                    <td class="px-3 py-3 small text-muted border-0">Exemple</td>
                                @endforeach
                            </tr>
                        @endfor
                        </tbody>
                    </table>
                </div>

                <div class="card-footer bg-light border-0 p-3">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center small text-muted">
                                <i class="bi bi-check-circle-fill text-success me-2"></i> Formats acceptés: .xlsx, .xls, .csv
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-center small text-muted">
                                <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i> Taille max: 5 Mo
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <a href="#" class="text-primary fw-bold text-decoration-none small">
                                <i class="bi bi-download me-1"></i> Télécharger le modèle vide
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <style>
        .transition-base { transition: all 0.2s ease-in-out; }
        .btn-white { background: #fff; color: #4f46e5; border: none; }
        .btn-white:hover { background: #f8f9fa; color: #3730a3; transform: translateY(-2px); }
        .btn-rounded { border-radius: 50px; }
        .ls-1 { letter-spacing: 0.5px; }
        .extra-small { font-size: 0.65rem; }
        .bg-light-subtle { background-color: #f8f9fa !important; }
        .form-select, .form-control { border-radius: 8px; font-size: 0.9rem; }
        .table th { white-space: nowrap; }
    </style>
