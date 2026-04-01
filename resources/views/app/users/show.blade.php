<x-layout>
    <style>
        :root {
            --ent-primary: #0061f2;
            --ent-dark: #0a2351;
            --ent-bg: #f8f9fc;
        }

        .profile-header {
            background: linear-gradient(135deg, var(--ent-primary) 0%, var(--ent-dark) 100%);
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 97, 242, 0.2);
        }

        .card {
            border: none;
            border-radius: 0.75rem;
            transition: transform 0.2s ease;
        }

        .card-header {
            background-color: #fff !important;
            border-bottom: 1px solid #edf2f9;
            padding: 1.25rem;
        }

        .card-header h5 {
            font-size: 1.1rem;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .text-label {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.025em;
            color: #6e7e91;
            font-weight: 600;
        }

        .text-value {
            font-weight: 500;
            color: #2d3748;
        }

        .table thead th {
            background-color: #f8f9fc;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            color: #6e7e91;
            border-top: none;
        }

        .btn-action {
            border-radius: 6px;
            padding: 0.4rem 0.6rem;
        }

        .empty-state {
            padding: 3rem;
            text-align: center;
            color: #a0aec0;
        }
    </style>

    <div class="card profile-header mb-4 mt-2">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="text-white">
                    <h2 class="fw-bold mb-1">Détails du Compte</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item text-white-50 small">Administration</li>
                            <li class="breadcrumb-item text-white-50 small">Utilisateurs</li>
                            <li class="breadcrumb-item active text-white small" aria-current="page">{{ $user->name }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex gap-2 mt-3 mt-md-0">
                    <a href="{{ route('profiles.index') }}" class="btn btn-outline-light btn-sm px-3 shadow-sm">
                        <i class="bi bi-arrow-left me-2"></i>Retour
                    </a>

                    @if ($user->profile_id == 1)
                    <a href="#" class="btn btn-white btn-sm fw-bold px-3 shadow-sm bg-white text-primary" data-bs-toggle="modal" data-bs-target="#affectHabilitationModal">
                        <i class="bi bi-shield-lock me-2"></i>Gérer les accès
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-xl-5">
            <div class="card shadow-sm h-100">
                <div class="card-header">
                    <h5 class="text-primary"><i class="bi bi-person-badge-fill me-2"></i>Identité de l'Agent</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3 pb-3 border-bottom border-light">
                        <div class="col-sm-4 text-label">Nom Complet</div>
                        <div class="col-sm-8 text-value">{{ $user->name }}</div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-4 text-label">Profil Système</div>
                        <div class="col-sm-8">
                            <span class="badge bg-soft-primary text-primary px-3 py-2" style="background-color: #e0e7ff;">
                                {{ $user->profile->title }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-4 pt-2">
                        <x-employee-card :employee="$employee" />
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-7">
            <div class="card shadow-sm h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="text-warning text-dark"><i class="bi bi-shield-check me-2 text-warning"></i>Habilitations Actives</h5>
                    <span class="badge bg-light text-dark border">{{ count($user->profile->habilitations) }} total</span>
                </div>
                <div class="card-body p-0">
                    @if (count($user->profile->habilitations) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                <tr>
                                    <th class="ps-4">Règle d'accès</th>
                                    <th>Attribution</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($user->profile->habilitations as $habilitation)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold text-dark">
                                                @if($habilitation->rule->title == '*')
                                                    <span class="text-danger"><i class="bi bi-stars me-1"></i>Contrôle Total</span>
                                                @else
                                                    {{ $habilitation->rule->title }}
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-muted small">
                                            <i class="bi bi-calendar3 me-1"></i>
                                            {{ \Carbon\Carbon::parse($habilitation->rule->created_at)->locale('fr')->translatedFormat('d F Y') }}
                                        </td>
                                        <td class="text-end pe-4">
                                            <button class="btn btn-action btn-outline-danger btn-sm" title="Révoquer">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="bi bi-shield-slash fs-1 mb-3 d-block opacity-25"></i>
                            <p class="mb-0 small fw-medium">Aucune habilitation associée à ce profil.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <x-affect-habiliation-modal :rules="$rules" :profiles="$profiles" />
</x-layout>
