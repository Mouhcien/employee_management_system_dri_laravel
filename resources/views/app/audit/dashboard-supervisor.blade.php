<x-layout>
    {{--
    <style>
        :root {
            --primary-color: #0d6efd; /* Bootstrap blue */
            --secondary-color: #6c757d;
            --success-color: #198754;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #0dcaf0;
        }

        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .stat-card {
            transition: transform 0.2s;
            border: none;
            border-radius: 10px;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .chart-container {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .activity-feed-item {
            padding: 15px;
            border-left: 4px solid #fff;
        }

        .activity-feed-item.border-success { border-left-color: var(--success-color); }
        .activity-feed-item.border-primary { border-left-color: var(--primary-color); }
        .activity-feed-item.border-warning { border-left-color: var(--warning-color); }

    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

    <div class="container-fluid py-4">

        <div class="row align-items-center mb-4 p-3 bg-white rounded-pill shadow-sm">
            <div class="col-md-6 d-flex align-items-center">
                <div class="me-3 fs-3 text-primary"><i data-feather="monitor"></i></div>
                <h1 class="h3 mb-0">Tableau de Suivi Global</h1>
            </div>
            <div class="col-md-6 text-md-end">
                <span class="text-muted small me-2">Édité il y a 5 min</span>
                <button class="btn btn-primary rounded-pill btn-sm">Partager <i data-feather="share-2" class="ms-1"></i></button>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-3 mb-4">
            <div class="col">
                <div class="card stat-card shadow-sm h-100 bg-info text-white">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <div class="h6 card-subtitle mb-2 opacity-75">Tableaux de Suivi Actifs</div>
                            <div class="display-5 fw-bold text-white">48</div>
                        </div>
                        <div class="text-end text-white-50"><i data-feather="check-circle"></i></div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card stat-card shadow-sm h-100 bg-primary text-white">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <div class="h6 card-subtitle mb-2 opacity-75">Périodes Clôturées</div>
                            <div class="display-5 fw-bold text-white">125</div>
                        </div>
                        <div class="text-end text-white-50"><i data-feather="calendar"></i></div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card stat-card shadow-sm h-100 bg-warning text-dark">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <div class="h6 card-subtitle mb-2 opacity-75">Actions en Attente</div>
                            <div class="display-5 fw-bold text-dark">7</div>
                        </div>
                        <div class="text-end text-dark-50"><i data-feather="clock"></i></div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card stat-card shadow-sm h-100 bg-success text-white">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <div class="h6 card-subtitle mb-2 opacity-75">Score de Performance</div>
                            <div class="display-5 fw-bold text-white">92%</div>
                        </div>
                        <div class="text-end text-white-50"><i data-feather="trending-up"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="chart-container shadow-sm h-100">
                    <h5 class="card-title text-primary mb-3">Tendance de Clôture des Périodes</h5>
                    <canvas id="mainChart"></canvas>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="chart-container shadow-sm h-100">
                    <h5 class="card-title text-primary mb-3">Répartition par Statut</h5>
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Activités Récentes</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item activity-feed-item border-success bg-white">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1 text-success">Période Clôturée</h6>
                                    <small class="text-muted">Il y a 1h</small>
                                </div>
                                <p class="mb-1 small">Projet 'Phoenix' - Période Février 2026 terminée.</p>
                            </div>
                            <div class="list-group-item activity-feed-item border-primary bg-white">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1 text-primary">Nouveau Tableau Créé</h6>
                                    <small class="text-muted">Il y a 2h</small>
                                </div>
                                <p class="mb-1 small">Tableau 'Suivi RH Q2' initialisé.</p>
                            </div>
                            <div class="list-group-item activity-feed-item border-warning bg-white">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1 text-warning">Alerte Retard</h6>
                                    <small class="text-muted">Hier</small>
                                </div>
                                <p class="mb-1 small">Tableau 'Audit Interne' en retard de 2 jours.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0 text-primary">Liste des Tableaux</h5>
                            <div class="input-group input-group-sm w-25">
                                <input type="text" class="form-control" placeholder="Rechercher..." aria-label="Search">
                                <span class="input-group-text bg-white"><i data-feather="search"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-sm mb-0">
                                <thead class="table-light">
                                <tr>
                                    <th scope="col">Nom du Tableau</th>
                                    <th scope="col">Période</th>
                                    <th scope="col">Utilisateur</th>
                                    <th scope="col">Statut</th>
                                    <th scope="col" class="text-end">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Audit Interne 2026</td>
                                    <td>Jan-Mars</td>
                                    <td>Sophie Martin</td>
                                    <td><span class="badge bg-danger rounded-pill">En Retard</span></td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-outline-secondary rounded-pill"><i data-feather="eye"></i></button>
                                        <button class="btn btn-sm btn-outline-primary rounded-pill"><i data-feather="edit-2"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Suivi Projet Phoenix</td>
                                    <td>Février</td>
                                    <td>Jean Dupont</td>
                                    <td><span class="badge bg-success rounded-pill">Clôturé</span></td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-outline-secondary rounded-pill"><i data-feather="eye"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Suivi RH Q2</td>
                                    <td>Avril-Juin</td>
                                    <td>Alice Moreau</td>
                                    <td><span class="badge bg-info rounded-pill">En Cours</span></td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-outline-secondary rounded-pill"><i data-feather="eye"></i></button>
                                        <button class="btn btn-sm btn-outline-primary rounded-pill"><i data-feather="edit-2"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Campagne Marketing Q2</td>
                                    <td>Avril-Mai</td>
                                    <td>Lucas Dubois</td>
                                    <td><span class="badge bg-warning rounded-pill">En Attente</span></td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-outline-secondary rounded-pill"><i data-feather="eye"></i></button>
                                        <button class="btn btn-sm btn-outline-primary rounded-pill"><i data-feather="edit-2"></i></button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        // Initialize Feather Icons
        feather.replace();

        // Main Bar Chart
        var ctx = document.getElementById('mainChart').getContext('2d');
        var mainChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Oct', 'Nov', 'Dec', 'Jan', 'Fev', 'Mar', 'Avr'],
                datasets: [{
                    label: 'Tableaux Clôturés (Unités)',
                    data: [15, 20, 22, 18, 25, 30, 10],
                    backgroundColor: 'rgba(13, 110, 253, 0.7)', // Primary colorful
                    borderColor: 'rgba(13, 110, 253, 1)',
                    borderWidth: 1,
                    borderRadius: 5,
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { display: false },
                        ticks: { color: '#6c757d' }
                    },
                    x: {
                        grid: { color: '#e9ecef' },
                        ticks: { color: '#6c757d' }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });

        // Pie Chart
        var ctxPie = document.getElementById('pieChart').getContext('2d');
        var pieChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: ['Clôturé', 'En Cours', 'En Attente', 'En Retard'],
                datasets: [{
                    data: [35, 10, 3, 4],
                    backgroundColor: [
                        '#198754', // success
                        '#0dcaf0', // info
                        '#ffc107', // warning
                        '#dc3545'  // danger
                    ],
                    borderColor: '#ffffff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { color: '#6c757d' }
                    }
                }
            }
        });
    </script>

    </body>
    </html>
    --}}
</x-layout>
