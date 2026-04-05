<x-layout>
    @section('title', 'Tableau de Bord - Administration Publique')

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 100%);
            --secondary-gradient: linear-gradient(135deg, #0d4f6b 0%, #1a7fa8 100%);
            --accent-color: #00d4aa;
            --bg-color: #f0f4f8;
            --card-bg: rgba(255, 255, 255, 0.95);
            --text-primary: #1a2a3a;
            --text-secondary: #5a6a7a;
            --border-color: rgba(30, 58, 95, 0.1);
        }

        body {
            background: var(--bg-color);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            color: var(--text-primary);
        }

        /* Glassmorphism Cards */
        .glass-card {
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(30, 58, 95, 0.08);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .glass-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 30px rgba(30, 58, 95, 0.15);
        }

        /* Header Styling */
        .page-header {
            background: var(--primary-gradient);
            color: white;
            padding: 2rem;
            border-radius: 16px;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            border-radius: 50%;
        }

        .header-title {
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .header-subtitle {
            opacity: 0.9;
            font-size: 1rem;
        }

        .date-badge {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Stats Cards */
        .stat-card {
            position: relative;
            overflow: hidden;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--accent-color);
        }

        .stat-icon-wrapper {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            background: linear-gradient(135deg, rgba(0, 212, 170, 0.1) 0%, rgba(0, 212, 170, 0.2) 100%);
            color: var(--accent-color);
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1;
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--text-secondary);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-trend {
            font-size: 0.8125rem;
            font-weight: 500;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            background: rgba(0, 212, 170, 0.1);
            color: #059669;
        }

        /* Chart Cards */
        .chart-card {
            height: 100%;
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .chart-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .chart-body {
            padding: 1.5rem;
        }

        /* Quick Actions */
        .action-btn {
            background: white;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            color: var(--text-primary);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.75rem;
            height: 100%;
        }

        .action-btn:hover {
            border-color: var(--accent-color);
            background: linear-gradient(135deg, rgba(0, 212, 170, 0.05) 0%, rgba(0, 212, 170, 0.1) 100%);
            transform: translateY(-2px);
            text-decoration: none;
            color: var(--text-primary);
        }

        .action-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            transition: all 0.3s ease;
        }

        .action-btn:hover .action-icon {
            transform: scale(1.1);
        }

        .action-icon.primary { background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); color: #2563eb; }
        .action-icon.success { background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); color: #059669; }
        .action-icon.warning { background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); color: #d97706; }
        .action-icon.info { background: linear-gradient(135deg, #cffafe 0%, #a5f3fc 100%); color: #0891b2; }

        /* Progress Bars */
        .progress-item {
            margin-bottom: 1.25rem;
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .progress-label {
            font-weight: 600;
            font-size: 0.9375rem;
            color: var(--text-primary);
        }

        .progress-value {
            font-weight: 700;
            color: var(--accent-color);
        }

        .progress {
            height: 8px;
            background: #e2e8f0;
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-bar {
            border-radius: 4px;
            transition: width 1s ease;
        }

        /* Activity Feed */
        .activity-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-color);
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .activity-icon.success { background: #d1fae5; color: #059669; }
        .activity-icon.warning { background: #fef3c7; color: #d97706; }
        .activity-icon.info { background: #dbeafe; color: #2563eb; }

        .activity-content {
            flex: 1;
        }

        .activity-text {
            font-size: 0.9375rem;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .activity-time {
            font-size: 0.8125rem;
            color: var(--text-secondary);
        }

        /* View All Link */
        .view-all {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--accent-color);
            font-weight: 600;
            font-size: 0.9375rem;
            text-decoration: none;
            transition: all 0.2s;
        }

        .view-all:hover {
            gap: 0.75rem;
            color: #059669;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-in {
            animation: fadeInUp 0.6s ease forwards;
        }

        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
    </style>

    <div class="container-fluid p-4">
        {{-- Header --}}
        <div class="page-header animate-in">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="header-title mb-2">Tableau de Bord</h1>
                    <p class="header-subtitle mb-0">Administration Publique - Gestion des Ressources Humaines</p>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <div class="date-badge">
                        <i class="bi bi-calendar3"></i>
                        {{ now()->locale('fr')->translatedFormat('l d F Y') }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="row g-4 mb-4">
            @php
                $stats = [
                    [
                        'label' => 'Total Employés',
                        'value' => $totalEmployees ?? 142,
                        'icon' => 'bi-people',
                        'color' => 'accent',
                        'trend' => '+5 ce mois',
                        'trend_icon' => 'bi-arrow-up-short',
                        'delay' => 'delay-1'
                    ],
                    [
                        'label' => 'Fonctionnaires',
                        'value' => ($employeesByCategory[0]->total ?? 98),
                        'icon' => 'bi-briefcase',
                        'color' => 'primary',
                        'trend' => 'Catégorie A',
                        'trend_icon' => null,
                        'delay' => 'delay-1'
                    ],
                    [
                        'label' => 'Contractuels',
                        'value' => ($employeesByCategory[1]->total + $employeesByCategory[2]->total ?? 44),
                        'icon' => 'bi-file-earmark-text',
                        'color' => 'warning',
                        'trend' => 'Catégorie B',
                        'trend_icon' => null,
                        'delay' => 'delay-2'
                    ],
                    [
                        'label' => 'Sites de Service',
                        'value' => $totalLocals ?? 5,
                        'icon' => 'bi-geo-alt',
                        'color' => 'info',
                        'trend' => 'Actifs',
                        'trend_icon' => null,
                        'delay' => 'delay-2'
                    ]
                ];

                $colorStyles = [
                    'accent' => ['bg' => 'rgba(0, 212, 170, 0.1)', 'bg2' => 'rgba(0, 212, 170, 0.2)', 'text' => '#00d4aa', 'trend_bg' => 'rgba(0, 212, 170, 0.1)', 'trend_text' => '#059669'],
                    'primary' => ['bg' => 'rgba(37, 99, 235, 0.1)', 'bg2' => 'rgba(37, 99, 235, 0.2)', 'text' => '#2563eb', 'trend_bg' => 'rgba(37, 99, 235, 0.1)', 'trend_text' => '#2563eb'],
                    'warning' => ['bg' => 'rgba(217, 119, 6, 0.1)', 'bg2' => 'rgba(217, 119, 6, 0.2)', 'text' => '#d97706', 'trend_bg' => 'rgba(217, 119, 6, 0.1)', 'trend_text' => '#d97706'],
                    'info' => ['bg' => 'rgba(8, 145, 178, 0.1)', 'bg2' => 'rgba(8, 145, 178, 0.2)', 'text' => '#0891b2', 'trend_bg' => 'rgba(8, 145, 178, 0.1)', 'trend_text' => '#0891b2']
                ];
            @endphp

            @foreach($stats as $stat)
                <div class="col-12 col-md-6 col-xl-3 animate-in {{ $stat['delay'] }}">
                    <div class="glass-card stat-card p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="stat-label mb-2">{{ $stat['label'] }}</p>
                                <h2 class="stat-value">{{ $stat['value'] }}</h2>
                                <span class="stat-trend mt-2 d-inline-block" style="background: {{ $colorStyles[$stat['color']]['trend_bg'] }}; color: {{ $colorStyles[$stat['color']]['trend_text'] }};">
                                    @if($stat['trend_icon'])
                                        <i class="bi {{ $stat['trend_icon'] }}"></i>
                                    @endif
                                    {{ $stat['trend'] }}
                                </span>
                            </div>
                            <div class="stat-icon-wrapper" style="background: linear-gradient(135deg, {{ $colorStyles[$stat['color']]['bg'] }} 0%, {{ $colorStyles[$stat['color']]['bg2'] }} 100%); color: {{ $colorStyles[$stat['color']]['text'] }};">
                                <i class="bi {{ $stat['icon'] }}"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Charts Row --}}
        <div class="row g-4 mb-4">
            {{-- Bar Chart --}}
            <div class="col-lg-6 animate-in delay-3">
                <div class="glass-card chart-card">
                    <div class="chart-header">
                        <h5 class="chart-title">
                            <i class="bi bi-bar-chart-line me-2 text-primary"></i>
                            Répartition par Catégorie
                        </h5>
                        <span class="badge bg-light text-dark">{{ date('Y') }}</span>
                    </div>
                    <div class="chart-body">
                        <div style="height: 280px;">
                            <canvas id="employeeComparisonChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Doughnut Chart --}}
            <div class="col-lg-6 animate-in delay-3">
                <div class="glass-card chart-card">
                    <div class="chart-header">
                        <h5 class="chart-title">
                            <i class="bi bi-pie-chart me-2 text-success"></i>
                            Distribution des Effectifs
                        </h5>
                        <span class="badge bg-light text-dark">%</span>
                    </div>
                    <div class="chart-body d-flex justify-content-center">
                        <div style="height: 280px; width: 280px;">
                            <canvas id="employeeCircleChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Actions & Structure --}}
        <div class="row g-4 mb-4">
            {{-- Quick Actions --}}
            <div class="col-lg-8 animate-in">
                <div class="glass-card h-100">
                    <div class="chart-header">
                        <h5 class="chart-title">
                            <i class="bi bi-lightning-charge me-2 text-warning"></i>
                            Actions Rapides
                        </h5>
                    </div>
                    <div class="chart-body">
                        <div class="row g-3">
                            <div class="col-6 col-md-3">
                                <a href="{{ route('employees.create') }}" class="action-btn">
                                    <div class="action-icon primary">
                                        <i class="bi bi-person-plus"></i>
                                    </div>
                                    <span class="fw-semibold">Nouvel Employé</span>
                                </a>
                            </div>
                            <div class="col-6 col-md-3">
                                <a href="#" class="action-btn">
                                    <div class="action-icon success">
                                        <i class="bi bi-file-earmark-pdf"></i>
                                    </div>
                                    <span class="fw-semibold">Générer CVs</span>
                                </a>
                            </div>
                            <div class="col-6 col-md-3">
                                <a href="#" class="action-btn">
                                    <div class="action-icon warning">
                                        <i class="bi bi-calendar-check"></i>
                                    </div>
                                    <span class="fw-semibold">Congés</span>
                                </a>
                            </div>
                            <div class="col-6 col-md-3">
                                <a href="#" class="action-btn">
                                    <div class="action-icon info">
                                        <i class="bi bi-file-earmark-excel"></i>
                                    </div>
                                    <span class="fw-semibold">Exporter</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Structure --}}
            <div class="col-lg-4 animate-in">
                <div class="glass-card h-100">
                    <div class="chart-header">
                        <h5 class="chart-title">
                            <i class="bi bi-diagram-3 me-2 text-info"></i>
                            Structure Organisationnelle
                        </h5>
                    </div>
                    <div class="chart-body">
                        @php
                            $structure = [
                                ['name' => 'Services', 'count' => $totalService ?? 0, 'color' => 'primary', 'width' => 85],
                                ['name' => 'Entités', 'count' => $totalEntity ?? 0, 'color' => 'success', 'width' => 65],
                                ['name' => 'Secteurs', 'count' => $totalSector ?? 0, 'color' => 'warning', 'width' => 75],
                                ['name' => 'Sections', 'count' => $totalSection ?? 0, 'color' => 'danger', 'width' => 90]
                            ];
                        @endphp

                        @foreach($structure as $item)
                            <div class="progress-item">
                                <div class="progress-header">
                                    <span class="progress-label">{{ $item['name'] }}</span>
                                    <span class="progress-value">{{ $item['count'] }}</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar bg-{{ $item['color'] }}" style="width: {{ $item['width'] }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Activity --}}
        <div class="row animate-in">
            <div class="col-12">
                <div class="glass-card">
                    <div class="chart-header">
                        <h5 class="chart-title">
                            <i class="bi bi-clock-history me-2 text-secondary"></i>
                            Activité Récente
                        </h5>
                        <a href="#" class="view-all">
                            Voir tout <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                    <div class="chart-body">
                        <div class="activity-item">
                            <div class="activity-icon success">
                                <i class="bi bi-person-plus-fill"></i>
                            </div>
                            <div class="activity-content">
                                <p class="activity-text">
                                    <strong>Nouveau recrutement :</strong> Sarah Johnson a rejoint l'équipe Développement en tant que Chef de Service
                                </p>
                                <span class="activity-time">
                                    <i class="bi bi-clock me-1"></i> Il y a 2 heures
                                </span>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon warning">
                                <i class="bi bi-clock-history"></i>
                            </div>
                            <div class="activity-content">
                                <p class="activity-text">
                                    <strong>Congé approuvé :</strong> La demande de congés annuels de Mike Chen a été validée par la DRH
                                </p>
                                <span class="activity-time">
                                    <i class="bi bi-clock me-1"></i> Il y a 4 heures
                                </span>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon info">
                                <i class="bi bi-file-earmark-text"></i>
                            </div>
                            <div class="activity-content">
                                <p class="activity-text">
                                    <strong>Mise à jour effectuée :</strong> Mise à jour des informations de 15 agents suite à la révision statutaire
                                </p>
                                <span class="activity-time">
                                    <i class="bi bi-clock me-1"></i> Il y a 6 heures
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart Initialization Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Chart.js Configuration
            Chart.defaults.font.family = "'Segoe UI', system-ui, sans-serif";
            Chart.defaults.color = '#5a6a7a';

            // Data from PHP
            const labels = {!! json_encode($employeesByCategory->pluck('title') ?? ['Catégorie A', 'Catégorie B', 'Catégorie C', 'Contractuels']) !!};
            const data = {!! json_encode($employeesByCategory->pluck('total') ?? [45, 53, 44, 28]) !!};

            // Professional color palette for public administration
            const colors = [
                '#1e3a5f',  // Deep blue - Primary
                '#2d5a87',  // Medium blue
                '#00d4aa',  // Teal accent
                '#0d4f6b'   // Dark cyan
            ];

            const backgroundColors = colors.map(c => c + 'CC'); // Add transparency

            // Bar Chart
            const ctxBar = document.getElementById('employeeComparisonChart').getContext('2d');
            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Nombre des agents',
                        data: data,
                        backgroundColor: backgroundColors,
                        borderColor: colors,
                        borderWidth: 2,
                        borderRadius: 8,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(30, 58, 95, 0.9)',
                            padding: 12,
                            cornerRadius: 8,
                            titleFont: { size: 14, weight: '600' },
                            bodyFont: { size: 13 }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(30, 58, 95, 0.05)',
                                drawBorder: false
                            },
                            ticks: {
                                font: { size: 12 },
                                padding: 8,
                                stepSize: 1
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: {
                                font: { size: 12, weight: '500' },
                                padding: 8
                            }
                        }
                    }
                }
            });

            /*******************************************************************************/
            // Circle Chart
            // 1. Rename the mapped variables to avoid conflicts
            const chartStatsRaw = @json($employeesByLocals);

            const chartLabels = chartStatsRaw.map(item => item.title);
            const chartDataValues = chartStatsRaw.map(item => item.total);

            // 2. Rename the color array
            const chartSegmentColors = chartStatsRaw.map((_, index) => {
                const palette = ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796'];
                return palette[index % palette.length];
            });

            const ctxDoughnut = document.getElementById('employeeCircleChart').getContext('2d');

            new Chart(ctxDoughnut, {
                type: 'doughnut',
                data: {
                    labels: chartLabels, // Updated variable name
                    datasets: [{
                        data: chartDataValues, // Updated variable name
                        backgroundColor: chartSegmentColors, // Updated variable name
                        borderWidth: 3,
                        borderColor: '#ffffff',
                        hoverOffset: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 20,
                                font: { size: 12, weight: '500' }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(30, 58, 95, 0.9)',
                            padding: 12,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(context) {
                                    const dataset = context.dataset.data;
                                    const totalSum = dataset.reduce((a, b) => a + Number(b), 0);
                                    const value = context.raw;
                                    const percentage = ((value / totalSum) * 100).toFixed(1);
                                    return ` ${context.label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-layout>
