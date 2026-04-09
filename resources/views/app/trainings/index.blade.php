<x-layout>
    @section('title', 'Gestion des formations - HR Management')

    <style>
        /* Modern Scrollbar Styling */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #bbb;
        }

        .border-transparent { border-left-color: transparent !important; }

        .employee-item {
            transition: all 0.2s ease;
        }

        .employee-item:hover {
            background-color: #f8f9fa;
            transform: translateX(2px);
        }
    </style>

    <div class="container-fluid py-4 px-md-5">
        {{-- Header Professionnel --}}
        <div class="row align-items-center mb-5">
            <div class="col-md-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item small"><a href="#" class="text-muted text-decoration-none uppercase fw-bold ls-1">RH Dashboard</a></li>
                        <li class="breadcrumb-item small active text-primary fw-bold uppercase ls-1" aria-current="page">Formations</li>
                    </ol>
                </nav>
                <h1 class="h2 fw-extrabold text-dark mb-0">Catalogue des <span class="text-primary">Formations</span></h1>
                <p class="text-muted small">Pilotez les compétences et les cycles d'apprentissage de vos agents.</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a class="btn btn-primary shadow-sm rounded-3 px-4 py-2 fw-bold" href="{{ route('trainings.create') }}">
                    <i class="bi bi-plus-lg me-2"></i>Nouvelle Formation
                </a>
            </div>
        </div>

        <div class="row g-4">
            {{-- Barre Latérale de Filtres --}}
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-light border-0 py-3">
                        <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-filter-left me-2"></i>Filtres avancés</h6>
                    </div>
                    <div class="card-body p-4">
                        <form method="GET" action="{{ route('trainings.index') }}">
                            <div class="mb-4">
                                <label class="form-label text-muted small fw-bold uppercase ls-1">Recherche</label>
                                <div class="input-group border rounded-3 overflow-hidden bg-light">
                                    <span class="input-group-text border-0 bg-transparent text-primary"><i class="bi bi-search"></i></span>
                                    <input type="text" name="search" value="{{ $filter }}" class="form-control border-0 bg-transparent" placeholder="Titre, thème...">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-muted small fw-bold uppercase ls-1">Collaborateur</label>
                                <select name="agent_id" class="form-select border-0 bg-light rounded-3">
                                    <option value="-1">Tous les agents</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}" {{ $employee_id == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->lastname }} {{ $employee->firstname }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-dark w-100 rounded-3 py-2 fw-bold shadow-sm mb-2">
                                Appliquer les filtres
                            </button>
                            <a href="{{ route('trainings.index') }}" class="btn btn-link w-100 text-muted small text-decoration-none">Réinitialiser</a>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Liste Principale --}}
            <div class="col-lg-9">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="table-responsive" style="min-height: 400px">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 border-0 text-muted small uppercase ls-1 fw-bold">Formation</th>
                                <th class="py-3 border-0 text-muted small uppercase ls-1 fw-bold text-center">Durée</th>
                                <th class="py-3 border-0 text-muted small uppercase ls-1 fw-bold">Période</th>
                                <th class="py-3 border-0 text-muted small uppercase ls-1 fw-bold">Participants</th>
                                <th class="pe-4 py-3 border-0 text-muted small uppercase ls-1 fw-bold text-end">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($trainings as $training)
                                <tr class="border-bottom border-light">
                                    <td class="ps-4 py-4">
                                        <div class="fw-bold text-dark fs-6">{{ $training->title }}</div>
                                        <div class="text-muted small italic">{{ Str::limit($training->theme, 50) }}</div>
                                    </td>
                                    <td class="py-4 text-center">
                                        <span class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2 fw-bolder fs-6">
                                            {{ $training->duration }} <small>Jours</small>
                                        </span>
                                    </td>
                                    <td class="py-4">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="small fw-medium bg-light px-2 py-1 rounded border">{{ \Carbon\Carbon::parse($training->starting_date)->format('d M Y') }}</span>
                                            <i class="bi bi-arrow-right text-muted small"></i>
                                            <span class="small fw-medium bg-light px-2 py-1 rounded border">{{ \Carbon\Carbon::parse($training->ending_date)->format('d M Y') }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 text-center">
                                        <button class="btn btn-sm btn-outline-primary rounded-pill px-3 me-2"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#attendees-{{ $training->id }}"
                                                aria-expanded="false">
                                            <i class="bi bi-people me-1"></i> {{ count($training->attendences) }}
                                        </button>
                                    </td>
                                    <td class="pe-4 py-4 text-end">

                                        <div class="dropdown">
                                            <button class="btn btn-light btn-sm rounded-circle shadow-sm" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-3">
                                                <li><a class="dropdown-item py-2" href="{{ route('trainings.edit', $training) }}"><i class="bi bi-pencil me-2 text-warning"></i>Editer</a></li>
                                                <li><a class="dropdown-item py-2" href="{{ route('trainings.attendences', $training) }}"><i class="bi bi-people me-2 text-dark"></i>Partticipants</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><button class="dropdown-item py-2 text-danger fw-bold" data-bs-toggle="modal" data-bs-target="#deleteChefModal-{{ $training->id }}"><i class="bi bi-trash3 me-2"></i>Supprimer</button></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="collapse shadow-sm bg-light-subtle" id="attendees-{{ $training->id }}">
                                    <td colspan="5" class="p-0 border-0">
                                        <div class="p-4">
                                            <h6 class="fw-bold text-muted mb-3 small uppercase ls-1 d-flex align-items-center">
                                                <i class="bi bi-person-check me-2 text-primary"></i>
                                                Liste des participants inscrits
                                                <span class="badge bg-secondary ms-2 opacity-75">{{ count($training->attendences) }}</span>
                                            </h6>

                                            @if (count($training->attendences))
                                                <div class="row g-3">
                                                    @foreach($training->attendences as $attendence)
                                                        @php
                                                            $employee = $attendence->employee;
                                                            $initials = strtoupper(substr($employee->firstname, 0, 1) . substr($employee->lastname, 0, 1));
                                                        @endphp
                                                        <div class="col-md-6 col-lg-4 col-xl-3">
                                                            <div class="card border-0 shadow-sm rounded-3 hover-shadow-transition">
                                                                <div class="card-body p-2 d-flex align-items-center">

                                                                    {{-- Affichage Photo ou Initiales --}}
                                                                    <div class="me-3">
                                                                        @if($employee->photo && Storage::disk('public')->exists($employee->photo))
                                                                            <img class="rounded-circle border border-2 border-white shadow-sm object-fit-cover"
                                                                                 width="40" height="40"
                                                                                 src="{{ Storage::url($employee->photo) }}"
                                                                                 alt="{{ $employee->lastname }} {{ $employee->firstname }}">
                                                                        @else
                                                                            <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm"
                                                                                 style="width: 40px; height: 40px; font-size: 0.75rem;">
                                                                                {{ $initials }}
                                                                            </div>
                                                                        @endif
                                                                    </div>

                                                                    {{-- Infos Employé --}}
                                                                    <div class="flex-grow-1 overflow-hidden">
                                                                        <div class="fw-bold text-dark text-truncate small mb-0">
                                                                            {{ strtoupper($employee->lastname) }} {{ $employee->firstname }}
                                                                        </div>
                                                                        <div class="text-muted" style="font-size: 0.7rem;">PPR: #{{ $employee->ppr }}</div>
                                                                    </div>

                                                                    {{-- Bouton Supprimer (Correction ID Modal) --}}
                                                                    <div class="ms-2">
                                                                        <button data-bs-toggle="modal"
                                                                                data-bs-target="#deleteAttendenceModal-{{ $attendence->id }}"
                                                                                class="btn btn-link text-danger p-0"
                                                                                title="Retirer le participant">
                                                                            <i class="bi bi-x-circle-fill fs-5"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                            @else
                                                <div class="text-center py-4 border rounded-3 border-dashed bg-white bg-opacity-50">
                                                    <i class="bi bi-people text-muted opacity-25 fs-2 d-block mb-2"></i>
                                                    <span class="text-muted small fw-medium">Aucun participant enregistré pour cette session.</span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="60" class="opacity-25 mb-3">
                                        <h6 class="text-muted fw-bold">Aucun enregistrement trouvé</h6>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if($trainings->hasPages())
                        <div class="card-footer bg-white border-0 py-4 px-4">
                            {{ $trainings->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Delete --}}
    @foreach($trainings as $training)
        <x-delete-model
            href="{{ route('trainings.delete', $training->id) }}"
            message="Êtes-vous sûr de vouloir supprimer cette formation ? Cette action est irréversible."
            title="Confirmer la suppression"
            target="deleteChefModal-{{ $training->id }}" />

        {{-- Regroupement des Modals hors de la grille pour éviter les bugs de rendu --}}
        @foreach($training->attendences as $attendence)
            <x-delete-model
                href="{{ route('attendences.delete', $attendence->id) }}"
                message="Êtes-vous sûr de vouloir retirer {{ $attendence->employee->firstname }} de cette formation ?"
                title="Retirer le participant"
                target="deleteAttendenceModal-{{ $attendence->id }}" />
        @endforeach
    @endforeach



    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f4f7fe;
        }

        .fw-extrabold { font-weight: 800; }
        .ls-1 { letter-spacing: 0.05em; }
        .uppercase { text-transform: uppercase; }

        /* Custom Badges */
        .bg-primary-subtle { background-color: #eef2ff !important; }
        .text-primary { color: #4f46e5 !important; }
        .btn-primary { background-color: #4f46e5; border: none; }
        .btn-primary:hover { background-color: #4338ca; }

        /* Table Styling */
        .table thead th {
            letter-spacing: 0.1em;
            font-size: 0.65rem;
        }
        .table tbody tr {
            transition: all 0.2s ease;
        }
        .table tbody tr:hover {
            background-color: #fcfdfe !important;
            transform: scale(1.002);
            box-shadow: inset 4px 0 0 #4f46e5;
        }

        /* Form Controls */
        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
            border-color: #4f46e5;
        }
    </style>
</x-layout>
