<x-layout>

    <style>
        /* Styles personnalisés pour un aspect "Enterprise" */
        .profile-header {
            background: linear-gradient(135deg, #0061f2 0%, #0a2351 100%);
            border-radius: 15px;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.15);
        }
        .card-header {
            font-weight: 700;
            border-bottom: 2px solid rgba(0,0,0,0.05);
            color: #fff;
        }
        .info-label {
            color: #6c757d;
            font-weight: 600;
            width: 35%;
        }
        .badge-habilitation {
            background-color: #e0e7ff;
            color: #4338ca;
            padding: 8px 12px;
            border-radius: 8px;
            display: inline-block;
            margin-bottom: 5px;
            font-weight: 500;
        }
    </style>

    <div class="card profile-header mb-4 overflow-hidden">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-7 text-white">
                    <h2 class="fw-bold mb-1">Gestion des utilisateurs</h2>
                    <p class="mb-0 text-white-50">
                        <i class="bi bi-person-badge me-2"></i>Consultez et mettez à jour vos informations des utilisateurs
                    </p>
                </div>
                <div class="col-md-5 text-md-end mt-3 mt-md-0">
                    <a href="{{ route('users.create') }}" class="btn btn-light btn-sm fw-bold px-3 py-2 shadow-sm">
                        <i class="bi bi-people-fill me-2"></i>Nouveau Utilisateur
                    </a>
                    <button class="btn btn-info btn-sm text-white ms-2 shadow-sm">
                        <i class="bi bi-download"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-success d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 text-white">
                <i class="bi bi-people-fill me-2"></i>Liste des utilisateurs
            </h5>
            <span class="badge bg-white text-success rounded-pill">{{ count($users ?? []) }} Total</span>
        </div>
        <div class="card-body p-0"> <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Utilisateur</th>
                        <th>E-mail</th>
                        <th>Profil</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($users ?? [] as $user)
                        <tr>
                            <td class="ps-4">
                                <span class="text-muted fw-bold">#{{ $user->id }}</span>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $user->name }}</div>
                            </td>
                            <td>
                                <span class="text-muted small">{{ $user->email }}</span>
                            </td>
                            <td>
                                <span class="badge bg-light text-success border border-success-subtle px-3 py-2">
                                    <i class="bi bi-shield-check me-1"></i>{{ $user->profile->title }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group shadow-sm">
                                    <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-outline-info" title="Détails">
                                        <i class="bi bi-list"></i>
                                    </a>
                                    <form action="#" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer cet utilisateur ?')" title="Supprimer">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="bi bi-person-x text-muted display-4 d-block mb-3"></i>
                                <span class="text-muted">Aucun utilisateur trouvé dans la base de données.</span>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</x-layout>
