<x-layout>
    @section('title', 'Tableau de Bord - Gestion RH')

    <div class="">
        {{-- En-tête de la page --}}
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <h1 class="h3 fw-bold mb-1">Tableau de Bord</h1>
                <p class="text-muted mb-0">Bienvenue, voici un aperçu de votre effectif aujourd'hui.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <div class="badge bg-white text-dark border p-2 px-3 shadow-sm">
                    <i class="bi bi-calendar3 me-2 text-primary"></i>
                    {{ now()->locale('fr')->translatedFormat('l d F Y') }}
                </div>
            </div>
        </div>

        {{-- Cartes de Statistiques --}}
        <div class="row g-3 mb-4">
            @php
                $stats = [
                    ['label' => 'Total Employés', 'value' => $totalEmployees ?? 142, 'icon' => 'bi-people', 'color' => 'primary', 'trend' => '+5 ce mois'],
                ];

                foreach($employeesByCategory as $item) {
                    $stats[] = [
                        'label' => $item->title,
                        'value' => $item->total,
                        'icon'  => 'bi-people', // Changed to distinguish from 'Total'
                        'color' => 'secondary', // Use a different color for categories
                        'trend' => 'Répartition par catégorie'
                    ];
                }

                $stats[] = ['label' => 'Locaux', 'value' => $totalLocals ?? 5, 'icon' => 'bi-geo-alt', 'color' => 'info', 'trend' => 'Actifs'];

            @endphp

            @foreach($stats as $stat)
                <div class="col-12 col-md-6 col-xl-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <span class="text-muted small fw-semibold uppercase">{{ $stat['label'] }}</span>
                                    <h2 class="mt-2 mb-0 fw-bold">{{ $stat['value'] }}</h2>
                                </div>
                                <div class="bg-{{ $stat['color'] }}-subtle text-{{ $stat['color'] }} rounded-3 p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="bi {{ $stat['icon'] }} fs-4"></i>
                                </div>
                            </div>
                            <div class="mt-3 small">
                            <span class="{{ str_contains($stat['trend'], '+') ? 'text-success' : 'text-muted' }}">
                                {{ $stat['trend'] }}
                            </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row col-12 mb-4">
            {{-- Comparison Chart --}}
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">Comparaison des Effectifs par Catégorie</h5>
                        <i class="bi bi-bar-chart text-muted"></i>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <div style="position: relative; height:300px;">
                            <canvas id="employeeComparisonChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Doughnut Chart: Distribution --}}
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-0">Répartition (%)</h5>
                    </div>
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <div style="height: 280px; width: 100%;">
                            <canvas id="employeeCircleChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row g-4">
            {{-- Actions Rapides --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-0">Actions Rapides</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-6 col-md-3">
                                <a href="{{ route('employees.create') }}" class="btn btn-outline-primary w-100 py-4 border-dashed d-flex flex-column align-items-center transition-all">
                                    <i class="bi bi-person-plus fs-3 mb-2"></i>
                                    <span class="small fw-bold">Nouvel Employé</span>
                                </a>
                            </div>
                            <div class="col-6 col-md-3">
                                <a href="#" class="btn btn-outline-success w-100 py-4 border-dashed d-flex flex-column align-items-center shadow-none">
                                    <i class="bi bi-file-earmark-pdf fs-3 mb-2"></i>
                                    <span class="small fw-bold">Générer CVs</span>
                                </a>
                            </div>
                            <div class="col-6 col-md-3">
                                <a href="#" class="btn btn-outline-warning w-100 py-4 border-dashed d-flex flex-column align-items-center">
                                    <i class="bi bi-calendar-check fs-3 mb-2"></i>
                                    <span class="small fw-bold">Congés</span>
                                </a>
                            </div>
                            <div class="col-6 col-md-3">
                                <a href="#" class="btn btn-outline-info w-100 py-4 border-dashed d-flex flex-column align-items-center">
                                    <i class="bi bi-file-earmark-excel fs-3 mb-2"></i>
                                    <span class="small fw-bold">Exporter Données</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Répartition par Département --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-0">Entités Structurelles</h5>
                    </div>
                    <div class="card-body px-4">
                        @php
                            $depts = [
                                ['name' => 'Services', 'count' => $totalService - 1, 'color' => 'primary'],
                                ['name' => 'Entités', 'count' => $totalEntity, 'color' => 'success'],
                                ['name' => 'Secteurs', 'count' => $totalSector, 'color' => 'warning'],
                                ['name' => 'Sections', 'count' => $totalSection, 'color' => 'danger']
                            ];
                        @endphp
                        @foreach($depts as $dept)
                            <div class="d-flex align-items-center mb-3">
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 small fw-bold">{{ $dept['name'] }}</h6>
                                    <div class="progress mt-2" style="height: 6px;">
                                        <div class="progress-bar bg-{{ $dept['color'] }}" role="progressbar" style="width: {{ ($dept['count'] / $totalEmployees) * 100 }}%"></div>
                                    </div>
                                </div>
                                <span class="ms-3 fw-bold">{{ $dept['count'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Activité Récente --}}
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-0">Activité Récente</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item px-4 py-3 border-0 border-bottom">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-success-subtle text-success rounded-circle p-2 me-3">
                                        <i class="bi bi-person-plus-fill"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0 small"><span class="fw-bold">Nouveau recrutement :</span> Sarah Johnson a rejoint l'équipe Développement</p>
                                        <span class="text-muted smaller">Il y a 2 heures</span>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item px-4 py-3 border-0 border-bottom">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-warning-subtle text-warning rounded-circle p-2 me-3">
                                        <i class="bi bi-clock-history"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0 small"><span class="fw-bold">Congé approuvé :</span> La demande de Mike Chen a été validée</p>
                                        <span class="text-muted smaller">Il y a 4 heures</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-center py-3">
                        <a href="#" class="small fw-bold text-decoration-none text-primary">Voir tout l'historique</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .border-dashed { border-style: dashed !important; border-width: 2px; }
        .transition-all { transition: all 0.3s ease; }
        .transition-all:hover { background-color: #f8f9fa; transform: translateY(-3px); }
        .smaller { font-size: 0.75rem; }
    </style>

    {{-- Chart Initialization Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('employeeComparisonChart').getContext('2d');

            // Preparing data from PHP
            const labels = {!! json_encode($employeesByCategory->pluck('title')) !!};
            const data = {!! json_encode($employeesByCategory->pluck('total')) !!};
            const dataValues = {!! json_encode($employeesByCategory->pluck('total')) !!};

            new Chart(ctx, {
                type: 'bar', // You can change this to 'doughnut' or 'line'
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Nombre d\'employés',
                        data: data,
                        backgroundColor: 'rgba(13, 110, 253, 0.2)', // Bootstrap Primary Subtille
                        borderColor: '#0d6efd', // Bootstrap Primary
                        borderWidth: 2,
                        borderRadius: 5,
                        barThickness: 40
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { display: false },
                            ticks: { stepSize: 1 }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });

            // Professional color palette
            const colors = [
                '#0d6efd', '#6610f2', '#6f42c1', '#d63384',
                '#dc3545', '#fd7e14', '#ffc107', '#198754'
            ];


            // --- Circle (Doughnut) Chart ---
            const ctxCircle = document.getElementById('employeeCircleChart').getContext('2d');
            new Chart(ctxCircle, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: dataValues,
                        backgroundColor: colors,
                        hoverOffset: 10,
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 20,
                                font: { size: 12 }
                            }
                        }
                    },
                    cutout: '70%' // Makes it a thin doughnut
                }
            });

        });
    </script>

    <style>
        /* Your existing styles... */
        .card { transition: transform 0.2s; }
    </style>

</x-layout>
