<x-layout>
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="page-header d-flex align-items-center p-3 bg-white border-bottom shadow-sm rounded">
                    <div class="icon-shape bg-soft-primary text-primary me-3 p-3 rounded">
                        <i class="bi bi-shield-check fs-2"></i>
                    </div>
                    <div>
                        <h3 class="mb-1 fw-bold text-dark">Module de Contrôle et Vérification</h3>
                        <p class="mb-0 text-muted">
                            Cet espace vous permet d'analyser l'intégrité des données, d'identifier les incohérences administratives et de valider l'état des affectations de vos agents.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="card-title mb-0"><i class="bi bi-filter-square me-2"></i>Critères de Vérification</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('employees.verification.execute') }}" method="POST">
                            @csrf
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="verif_affectation" id="v1" checked>
                                <label class="form-check-label" for="v1">Vérifier les affectations</label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="verif_info_personnel" id="v2" checked>
                                <label class="form-check-label" for="v2">Vérifier les informations personnelles</label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="verif_info_professionnel" id="v3" checked>
                                <label class="form-check-label" for="v3">Vérifier les informations professionnels</label>
                            </div>
                            <hr class="text-muted">
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" name="verif_data" id="v4" checked>
                                <label class="form-check-label" for="v4">Vérifier la situation des données</label>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 shadow-sm">
                                <i class="bi bi-shield-check me-2"></i>Lancer la vérification
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                @if (!is_null($result))
                    <h4 class="mb-4 text-secondary border-bottom pb-2">Résultats de l'analyse</h4>

                    @php
                        // On sépare les définitions en deux tableaux
                        $missingData = [
                            'employeesWithoutAffectation'    => ['title' => 'Agents sans affectation', 'icon' => 'bi-diagram-3'],
                            'employeesWithoutPPR'            => ['title' => 'Agents sans PPR', 'icon' => 'bi-hash'],
                            'employeesWithoutCIN'            => ['title' => 'Agents sans CIN', 'icon' => 'bi-person-badge'],
                            'employeesWithoutEmail'          => ['title' => 'Agents sans Email', 'icon' => 'bi-envelope'],
                            'employeesWithoutCommissionCard' => ['title' => 'Agents sans carte de commission', 'icon' => 'bi-card-list'],
                            'employeesWithoutGrade'          => ['title' => 'Agents sans grade', 'icon' => 'bi-award'],
                            'employeesWithoutDiploma'        => ['title' => 'Agents sans diplôme', 'icon' => 'bi-journal-bookmark'],
                        ];

                        $duplicateData = [
                            'duplicatePPR'            => ['title' => 'Doublons de PPR', 'icon' => 'bi-layers-half'],
                            'duplicateCIN'            => ['title' => 'Doublons de CIN', 'icon' => 'bi-layers-half'],
                            'duplicateEmail'          => ['title' => 'Doublons d\'Email', 'icon' => 'bi-layers-half'],
                            'duplicateCommissionCard' => ['title' => 'Doublons de Carte Commission', 'icon' => 'bi-layers-half'],
                        ];
                    @endphp

                    @foreach($missingData as $key => $info)
                        @if(isset($result[$key]) && count($result[$key]) > 0)
                            <div class="card shadow-sm mb-3 border-0">
                                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 clickable-header"
                                     onclick="toggleCardBody('body-{{ $key }}', 'icon-{{ $key }}')">
                                    <h6 class="mb-0 fw-bold">
                                        <i class="bi {{ $info['icon'] }} text-warning me-2"></i>
                                        {{ $info['title'] }}
                                        <span class="badge rounded-pill bg-danger ms-2">{{ count($result[$key]) }}</span>
                                    </h6>
                                    <i id="icon-{{ $key }}" class="bi bi-chevron-down text-muted"></i>
                                </div>
                                <div id="body-{{ $key }}" class="card-body d-none border-top">
                                    <div class="row g-3">
                                        @foreach($result[$key] as $employee)
                                            <div class="col-md-6 col-xl-4">
                                                @include('app.employees.partials.employee_panel', ['employee' => $employee])
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach

                    <div class="mt-5 mb-3 p-3 bg-danger-subtle rounded border border-danger-subtle">
                        <h5 class="text-danger mb-0 fw-bold">
                            <i class="bi bi-exclamation-octagon-fill me-2"></i>
                            Conflits de données (Doublons détectés)
                        </h5>
                    </div>

                    @foreach($duplicateData as $key => $info)
                        @if(isset($result[$key]) && $result[$key]->count() > 0) {{-- Utiliser ->count() sur la collection --}}
                        <div class="card shadow-sm mb-4 border-start border-danger border-4">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 clickable-header"
                                 onclick="toggleCardBody('body-{{ $key }}', 'icon-{{ $key }}')">
                                <h6 class="mb-0 fw-bold text-danger">
                                    <i class="bi {{ $info['icon'] }} me-2"></i>
                                    {{ $info['title'] }}
                                    {{-- On compte le nombre total d'employés dans tous les groupes --}}
                                    <span class="badge rounded-pill bg-danger ms-2">{{ $result[$key]->flatten()->count() }}</span>
                                </h6>
                                <i id="icon-{{ $key }}" class="bi bi-chevron-down text-muted"></i>
                            </div>

                            <div id="body-{{ $key }}" class="card-body d-none border-top bg-light">
                                {{-- $group est une collection d'employés partageant la même valeur --}}
                                @foreach($result[$key] as $identifier => $group) {{-- $group est une COLLECTION d'employés --}}
                                <div class="group-container mb-4 p-3 bg-white border rounded shadow-sm">
                                    <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                                        <span class="badge bg-secondary">Valeur en conflit : <strong>{{ $identifier }}</strong></span>
                                        <span class="text-muted small">{{ $group->count() }} agents concernés</span>
                                    </div>

                                    <div class="row g-3">
                                        @foreach($group as $employee) {{-- C'est ICI que $employee devient un OBJET --}}
                                        <div class="col-md-6 col-xl-4">
                                            {{-- Assurez-vous de passer explicitement la variable --}}
                                            @include('app.employees.partials.employee_panel', ['employee' => $employee])
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    @endforeach

                @else
                    <div class="text-center py-5 bg-light rounded shadow-sm border">
                        <i class="bi bi-search d-block display-4 text-muted mb-3"></i>
                        <p class="text-muted">Aucun résultat à afficher. Veuillez lancer une vérification.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function toggleCardBody(bodyId, iconId) {
            const body = document.getElementById(bodyId);
            const icon = document.getElementById(iconId);

            if (body.classList.contains('d-none')) {
                body.classList.remove('d-none');
                icon.classList.replace('bi-chevron-down', 'bi-chevron-up');
            } else {
                body.classList.add('d-none');
                icon.classList.replace('bi-chevron-up', 'bi-chevron-down');
            }
        }
    </script>

    <style>
        .clickable-header:hover {
            background-color: #f8f9fa !important;
        }
        .badge.rounded-pill {
            font-size: 0.8rem;
        }
    </style>
</x-layout>
