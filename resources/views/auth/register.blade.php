<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inscription | RH Connect</title>

    @vite(['resources/css/app.css', 'resources/css/toastr.min.css'])

    <style>
        body {
            /* Fond bleu très léger et frais */
            background-color: #f0f7ff;
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .auth-container {
            max-width: 950px;
            width: 100%;
            margin: auto;
            padding: 20px;
        }

        .auth-card {
            border: none;
            border-radius: 24px;
            overflow: hidden;
            /* Ombre douce pour un effet "clean" */
            box-shadow: 0 10px 40px rgba(29, 78, 216, 0.08);
            background: #ffffff;
        }

        /* Panneau latéral bleu professionnel */
        .auth-side-panel {
            background-color: #007bff;
            background-image: radial-gradient(circle at 0% 0%, #00a2ff 0%, #007bff 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 45px;
            color: white;
        }

        .btn-hr-primary {
            background-color: #007bff;
            border: none;
            padding: 14px;
            font-weight: 600;
            border-radius: 12px;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-hr-primary:hover {
            background-color: #0056b3;
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
            color: white;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 16px;
            border: 1px solid #dee2e6;
            background-color: #fcfdfe;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            background-color: #fff;
            border-color: #007bff;
            box-shadow: 0 0 0 4px rgba(0, 123, 255, 0.1);
        }

        .hr-badge {
            background: rgba(255, 255, 255, 0.15);
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 0.75rem;
            display: inline-block;
            margin-bottom: 24px;
            backdrop-filter: blur(5px);
        }

        .icon-box {
            background: #e7f3ff;
            color: #007bff;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 12px;
        }
    </style>
</head>
<body>

<div class="container auth-container">
    <div class="card auth-card">
        <div class="row g-0">
            <div class="col-lg-5 d-none d-lg-flex auth-side-panel">
                <div class="hr-badge text-uppercase fw-bold">Espace Recruteur & Employé</div>
                <h2 class="display-6 fw-bold mb-4">La gestion RH, simplifiée.</h2>
                <p class="opacity-90 mb-5">Centralisez vos documents, gérez les congés et suivez l'évolution de vos collaborateurs sur une plateforme unique.</p>

                <div class="features mt-2">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-white text-primary rounded-circle p-1 me-3 text-center" style="width:28px; height:28px; line-height:20px;">✓</div>
                        <span class="fw-medium">Tableaux de bord intuitifs</span>
                    </div>
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-white text-primary rounded-circle p-1 me-3 text-center" style="width:28px; height:28px; line-height:20px;">✓</div>
                        <span class="fw-medium">Coffre-fort numérique sécurisé</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="bg-white text-primary rounded-circle p-1 me-3 text-center" style="width:28px; height:28px; line-height:20px;">✓</div>
                        <span class="fw-medium">Support prioritaire 24/7</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 p-4 p-md-5">
                <div class="mb-5">
                    <h3 class="fw-bold text-dark">Créer votre compte</h3>
                    <p class="text-muted">Inscrivez-vous pour accéder à votre portail RH Connect.</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="row">

                        <div class="col-12 mb-3">
                            <label class="form-label small fw-bold text-uppercase text-muted">E-mail professionnel</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="t.martin@entreprise.com" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-grid mb-4 pt-2">
                            <label class="form-label small fw-bold text-uppercase text-muted">Profil</label>
                            <select class="form-control" name="profile_id">
                                <option value="2">Observateur</option>
                                <option value="1">Administrateur</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-uppercase text-muted">Mot de passe</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••" required>
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label small fw-bold text-uppercase text-muted">Confirmer</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••" required>
                        </div>
                    </div>

                    <div class="d-grid mb-4 pt-2">
                        <button type="submit" class="btn btn-primary btn-hr-primary shadow-sm">
                            S'inscrire et commencer
                        </button>
                    </div>

                    <div class="text-center">
                        <span class="text-muted small">Vous possédez déjà un compte ?</span>
                        <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none ms-1">Se connecter</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>
