<x-layout>
    @section('title', 'Tableau de Bord - Gestion RH')

    <div class="container-fluid py-4">
        {{-- En-tête de la page --}}
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <h1 class="h3 fw-bold mb-1">Tableau de Bord</h1>
                <p class="text-muted mb-0">Bienvenue, voici un aperçu de votre effectif aujourd'hui.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <div class="badge bg-white text-dark border p-2 px-3 shadow-sm">
                    <i class="bi bi-calendar3 me-2 text-primary"></i>
                    {{ now()->translatedFormat('l d F Y') }}
                </div>
            </div>
        </div>

        {{-- Cartes de Statistiques --}}
        <div class="row g-3 mb-4">
            @php
                $stats = [
                    ['label' => 'Total Employés', 'value' => $totalEmployees ?? 142, 'icon' => 'bi-people', 'color' => 'primary', 'trend' => '+5 ce mois'],
                    ['label' => 'Présents Aujourd\'hui', 'value' => $presentToday ?? 128, 'icon' => 'bi-check2-circle', 'color' => 'success', 'trend' => '90% de présence'],
                    ['label' => 'En Congé', 'value' => $onLeave ?? 12, 'icon' => 'bi-door-open', 'color' => 'warning', 'trend' => '8 en attente'],
                    ['label' => 'Locaux', 'value' => $totalLocals ?? 5, 'icon' => 'bi-geo-alt', 'color' => 'info', 'trend' => 'Actifs']
                ];
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
                        <h5 class="fw-bold mb-0">Départements</h5>
                    </div>
                    <div class="card-body px-4">
                        @php
                            $depts = [
                                ['name' => 'Ingénierie', 'count' => 45, 'color' => 'primary'],
                                ['name' => 'Ventes & Marketing', 'count' => 32, 'color' => 'success'],
                                ['name' => 'Opérations', 'count' => 28, 'color' => 'warning'],
                                ['name' => 'RH & Finance', 'count' => 18, 'color' => 'danger']
                            ];
                        @endphp
                        @foreach($depts as $dept)
                            <div class="d-flex align-items-center mb-3">
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 small fw-bold">{{ $dept['name'] }}</h6>
                                    <div class="progress mt-2" style="height: 6px;">
                                        <div class="progress-bar bg-{{ $dept['color'] }}" role="progressbar" style="width: {{ ($dept['count'] / 142) * 100 }}%"></div>
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
</x-layout>
