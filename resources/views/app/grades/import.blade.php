
    <div class="container-fluid py-4">
        <form action="{{ route('competences.importation') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Header & Control Panel Premium --}}
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-4">
                <div class="card-body p-0">
                    <div class="bg-primary bg-gradient p-4 text-white">
                        <div class="row align-items-center g-4">
                            {{-- Titre et Contexte --}}
                            <div class="col-xl-3 col-lg-12">
                                <div class="d-flex align-items-center">
                                    <div class="bg-white bg-opacity-20 rounded-3 p-3 me-3 shadow-sm">
                                        <i class="bi bi-mortarboard-fill fs-3 text-dark"></i>
                                    </div>
                                    <div>
                                        <h1 class="h4 fw-bold mb-1 text-white">Import Grade</h1>
                                        <p class="text-white text-opacity-75 small mb-0">DRI-Marrakech | Compétences</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Upload & Action --}}
                            <div class="col-xl-3 col-md-12">
                                <label class="form-label small fw-bold text-uppercase text-white text-opacity-75">Fichier Excel</label>
                                <div class="d-flex gap-2">
                                    <input type="file" name="file_competence" class="form-control border-0 bg-white shadow-none" required />
                                    <button type="submit" class="btn btn-white fw-bold shadow-sm px-3">
                                        <i class="bi bi-cloud-arrow-up-fill text-primary"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Guide de format & Aperçu --}}
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4">
                            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-info-circle-fill text-primary me-2"></i>Instructions Excel</h6>
                            <p class="text-muted small">Pour une importation réussie, votre fichier doit respecter l'ordre des colonnes suivant :</p>

                            <ul class="list-unstyled small">
                                <li class="d-flex align-items-center mb-2">
                                    <span class="badge bg-primary-subtle text-primary rounded-circle me-2" style="width: 20px; height: 20px; font-size: 10px;">1</span>
                                    <strong>PPR</strong> (ex: 1234567)
                                </li>
                                <li class="d-flex align-items-center mb-3">
                                    <span class="badge bg-primary-subtle text-primary rounded-circle me-2" style="width: 20px; height: 20px; font-size: 10px;">2</span>
                                    <strong>Diplôme</strong> (ex: identifiant du drade)
                                </li>
                            </ul>

                            <div class="alert alert-warning border-0 rounded-4 p-3 mb-0 extra-small">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                Les agents non-existants dans la base seront ignorés.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                        <div class="card-header bg-white py-3 px-4 border-bottom-0">
                            <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-table text-primary me-2"></i>Structure du fichier attendue</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light-subtle">
                                <tr>
                                    <th scope="col" class="text-muted small text-uppercase ls-1 fw-bold px-4 py-3 border-0">Colonne A (PPR)</th>
                                    <th scope="col" class="text-muted small text-uppercase ls-1 fw-bold px-4 py-3 border-0">Colonne B (grade)</th>
                                </tr>
                                </thead>
                                <tbody>
                                @for($i=1;$i<4;$i++)
                                    <tr class="transition-base">
                                        <td class="px-4 py-3 text-primary fw-bold">XXXXXX</td>
                                        <td class="px-4 py-3 text-muted">{{ $i }}</td>
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
        .ls-1 { letter-spacing: 0.5px; }
        .extra-small { font-size: 0.72rem; }
        .bg-light-subtle { background-color: #f8f9fa !important; }
        .form-select, .form-control { border-radius: 8px; font-size: 0.9rem; }
    </style>
