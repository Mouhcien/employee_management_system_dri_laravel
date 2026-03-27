<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'HR Connect - Connexion')</title>

    @vite(['resources/css/app.css', 'resources/css/toastr.min.css'])
</head>
<body class="bg-light">

<style>
    body {
        background: #f4f7f9;
        font-family: 'Inter', sans-serif;
    }
    .auth-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    }
    .btn-hr-primary {
        background-color: #2563eb;
        border: none;
        padding: 10px 20px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-hr-primary:hover {
        background-color: #1d4ed8;
        transform: translateY(-1px);
    }
    .form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.1);
    }
    .hr-logo-text {
        color: #1e293b;
        font-weight: 700;
        letter-spacing: -1px;
    }
</style>

<div class="container d-flex flex-column justify-content-center min-vh-100">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">

            <div class="text-center mb-4">
                <div class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-3 mb-3" style="width: 48px; height: 48px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <h2 class="hr-logo-text">RH<span class="text-primary">Connect</span></h2>
                <p class="text-muted small">Portail Libre-Service Employé</p>
            </div>

            <div class="card auth-card p-4">
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label fw-medium text-secondary">Adresse e-mail</label>
                        <input id="email" class="form-control @error('email') is-invalid @enderror"
                               type="email" name="email" value="{{ old('email') }}"
                               placeholder="nom@entreprise.fr" required autofocus autocomplete="username">
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <label for="password" class="form-label fw-medium text-secondary">Mot de passe</label>
                            @if (Route::has('password.request'))
                                <a class="text-decoration-none small fw-semibold" href="{{ route('password.request') }}">
                                    Oublié ?
                                </a>
                            @endif
                        </div>
                        <input id="password" class="form-control @error('password') is-invalid @enderror"
                               type="password" name="password"
                               placeholder="••••••••" required autocomplete="current-password">
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                    </div>

                    <button type="submit" class="btn btn-primary w-100 btn-hr-primary shadow-sm">
                        Se connecter au tableau de bord
                    </button>
                </form>
            </div>

            <p class="text-center mt-4 text-muted small">
                &copy; {{ date('Y') }} Système de Gestion des Ressources Humaines. Tous droits réservés.
            </p>
        </div>
    </div>
</div>

</body>
</html>
