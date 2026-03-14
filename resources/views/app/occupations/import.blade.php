
    <div class="container-fluid py-4">
        <form action="{{ route('works.importation') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Header & Control Panel --}}
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-4">
                <div class="card-body p-0">
                    <div class="bg-primary bg-gradient p-4 text-white">
                        <div class="row align-items-center g-4">
                            {{-- Titre et Contexte --}}
                            <div class="col-xl-4 col-lg-12">
                                <div class="d-flex align-items-center">
                                    <div class="bg-white bg-opacity-20 rounded-3 p-3 me-3 shadow-sm">
                                        <i class="bi bi-file-earmark-excel-fill fs-3 text-dark"></i>
                                    </div>
                                    <div>
                                        <h1 class="h4 fw-bold mb-1">Importation d'Agents</h1>
                                        <p class="text-white text-opacity-75 small mb-0">
                                            <i class="bi bi-geo-alt-fill me-1"></i>DRI-Marrakech | Gestion des Fonctions
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Sélection de la Fonction --}}
                            <div class="col-xl-3 col-md-6">
                                <label class="form-label small fw-bold text-uppercase text-white text-opacity-75">Cible de la fonction</label>
                                <div class="input-group border-0 shadow-sm rounded-3 overflow-hidden">
                                    <span class="input-group-text bg-white border-0 text-primary"><i class="bi bi-briefcase"></i></span>
                                    <select name="occupation_id" class="form-select border-0 bg-white shadow-none" required>
                                        <option value="-1">Sélectionner une fonction...</option>
                                        @foreach($occupations as $occupation)
                                            <option value="{{ $occupation->id }}">{{ $occupation->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Upload de fichier --}}
                            <div class="col-xl-3 col-md-6">
                                <label class="form-label small fw-bold text-uppercase text-white text-opacity-75">Fichier Excel (PPR)</label>
                                <div class="input-group border-0 shadow-sm rounded-3 overflow-hidden">
                                    <input type="file" name="file" class="form-control border-0 bg-white shadow-none" required />
                                </div>
                            </div>

                            {{-- Action --}}
                            <div class="col-xl-2 col-md-12 text-xl-end">
                                <button type="submit" class="btn btn-white btn-rounded px-4 fw-bold shadow-sm transition-base w-100 py-2">
                                    <i class="bi bi-cloud-arrow-up-fill me-2"></i>Importer
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Guide & Preview --}}
            <div class="row g-4 mb-4">
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4">
                            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-info-circle text-primary me-2"></i>Format requis</h6>
                            <p class="text-muted small">Le fichier Excel doit contenir une colonne unique nommée <strong>"PPR"</strong>. Assurez-vous que les numéros PPR correspondent à des agents déjà existants dans la base.</p>
                            <div class="bg-light rounded-3 p-3">
                                <div class="d-flex align-items-center text-success fw-bold small">
                                    <i class="bi bi-check-circle-fill me-2"></i>Modèle accepté (.xlsx, .csv)
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                        <div class="card-header bg-white py-3 px-4 border-bottom-0 d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-layout-text-window-reverse me-2"></i>Aperçu de la structure</h6>
                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3">Colonnes attendues</span>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light-subtle">
                                <tr>
                                    <th scope="col" class="text-muted small text-uppercase ls-1 fw-bold px-4 py-3 border-0">PPR</th>
                                    <th scope="col" class="text-muted small text-uppercase ls-1 fw-bold px-4 py-3 border-0">Exemple de données</th>
                                </tr>
                                </thead>
                                <tbody>
                                @for($i=1;$i<4;$i++)
                                    <tr class="transition-base">
                                        <td class="px-4 py-3 fw-bold text-primary">XXXXXX</td>
                                        <td class="px-4 py-3 text-muted">Agent #{{ $i }}</td>
                                    </tr>
                                @endfor
                                </tbody>
                            </table>
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
        .bg-light-subtle { background-color: #f9fafb !important; }
        .input-group-text { font-size: 1.1rem; }
        .form-select, .form-control { height: auto; }
    </style>
