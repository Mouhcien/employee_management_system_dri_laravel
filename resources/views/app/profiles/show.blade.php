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
                    <h2 class="fw-bold mb-1">Gestion du Profil</h2>
                    <p class="mb-0 text-white-50">
                        <i class="bi bi-person-badge me-2"></i>Consultez et mettez à jour vos informations personnelles
                    </p>
                </div>
                <div class="col-md-5 text-md-end mt-3 mt-md-0">
                    <a href="#" class="btn btn-light btn-sm fw-bold px-3 py-2 shadow-sm">
                        <i class="bi bi-people-fill me-2"></i>Liste des profils
                    </a>
                    <button class="btn btn-info btn-sm text-white ms-2 shadow-sm">
                        <i class="bi bi-download"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header bg-primary">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informations Générales</h5>
                        <a href="{{ route('profiles.edit', auth()->user()->id) }}" class="text-white">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-borderless align-middle mb-0">
                        <tbody>
                        <tr>
                            <td class="info-label text-secondary">Utilisateur</td>
                            <td class="fw-bold">{{ auth()->user()->name }}</td>
                        </tr>
                        <tr>
                            <td class="info-label text-secondary">Email</td>
                            <td><span class="badge bg-light text-dark border">{{ auth()->user()->email }}</span></td>
                        </tr>
                        <tr>
                            <td class="info-label text-secondary">Profil</td>
                            <td><span class="text-primary fw-bold">{{ auth()->user()->profile->title ?? 'Non défini' }}</span></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-success">
                    <h5 class="mb-0 text-white"><i class="bi bi-shield-lock me-2"></i>Vos Habilitations</h5>
                </div>
                <div class="card-body">
                    @forelse(auth()->user()->profile->habilitations ?? [] as $habilitation)
                        <div class="badge-habilitation border me-2">
                            <i class="bi bi-check-circle-fill me-2 text-success"></i>{{ $habilitation->title }}
                        </div>
                    @empty
                        <div class="text-center py-3">
                            <i class="bi bi-exclamation-triangle text-warning display-6"></i>
                            <p class="text-muted mt-2">Aucune habilitation attribuée</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header bg-danger">
                    <h5 class="mb-0 text-white"><i class="bi bi-key me-2"></i>Sécurité du compte</h5>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted small mb-4">Nous vous recommandons d'utiliser un mot de passe robuste comprenant des lettres, des chiffres et des symboles.</p>

                    <form action="#" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Ancien mot de passe</label>
                            <input type="password" name="old_password" class="form-control" placeholder="Entrez votre mot de passe actuel">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-primary">Nouveau mot de passe</label>
                            <input type="password" name="password" class="form-control" placeholder="Minimum 8 caractères">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Confirmer le nouveau mot de passe</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Répétez le mot de passe">
                        </div>

                        <hr class="my-4">

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success fw-bold py-2 shadow-sm">
                                <i class="bi bi-save me-2"></i> Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>
