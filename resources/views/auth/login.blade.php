<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'HR Connect - Connexion')</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/css/toastr.min.css'])

    <style>
        :root {
            --glass-bg: rgba(255, 255, 255, 0.7);
            --glass-border: rgba(255, 255, 255, 0.4);
            --primary-gradient: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            --accent-glow: rgba(99, 102, 241, 0.3);
        }

        body {
            background: radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.15) 0px, transparent 50%),
            radial-gradient(at 100% 100%, rgba(168, 85, 247, 0.15) 0px, transparent 50%),
            #f8fafc;
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .auth-card {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.04);
        }

        .hr-logo-icon {
            background: var(--primary-gradient);
            box-shadow: 0 8px 20px var(--accent-glow);
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 54px;
            height: 54px;
            transition: transform 0.3s ease;
        }

        .hr-logo-icon:hover {
            transform: rotate(-5deg) scale(1.05);
        }

        .form-control {
            background: rgba(255, 255, 255, 0.5);
            border: 1.5px solid #e2e8f0;
            padding: 12px 16px;
            border-radius: 12px;
            transition: all 0.2s ease-in-out;
        }

        .form-control:focus {
            background: #fff;
            border-color: #6366f1;
            box-shadow: 0 0 0 4px var(--accent-glow);
        }

        .btn-futurist {
            background: var(--primary-gradient);
            border: none;
            padding: 12px;
            border-radius: 12px;
            font-weight: 600;
            color: white;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 15px -3px var(--accent-glow);
        }

        .btn-futurist:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 25px -5px var(--accent-glow);
            filter: brightness(1.1);
            color: white;
        }

        .input-label {
            font-size: 0.875 guest;
            font-weight: 600;
            color: #475569;
            margin-bottom: 8px;
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .auth-card {
                padding: 1.5rem !important;
                margin: 0 10px;
            }
        }
    </style>
</head>
<body>

<div class="container d-flex flex-column justify-content-center min-vh-100 py-5">
    <div class="row justify-content-center">
        <div class="col-11 col-sm-8 col-md-6 col-lg-5 col-xl-4">

            <div class="text-center mb-5">
                <div class="hr-logo-icon mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <h2 class="fw-bold tracking-tight text-dark mb-1">RH<span style="color: #6366f1;">Connect</span></h2>
                <p class="text-muted small fw-medium">Administration & Management v2.0</p>
            </div>

            <div class="card auth-card p-4 p-md-5">
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="input-label">Identifiant Business</label>
                        <input id="email" class="form-control @error('email') is-invalid @enderror"
                               type="email" name="email" value="{{ old('email') }}"
                               placeholder="nom@entreprise.fr" required autofocus autocomplete="username">
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label for="password" class="input-label mb-0">Mot de passe</label>
                            @if (Route::has('password.request'))
                                <a class="text-decoration-none small fw-bold" href="{{ route('password.request') }}" style="color: #6366f1;">
                                    Réinitialiser ?
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

                    <button type="submit" class="btn btn-futurist w-100 mt-2">
                        Accéder au Dashboard
                    </button>
                </form>
            </div>

            <div class="text-center mt-5">
                <p class="text-muted small opacity-75">
                    &copy; {{ date('Y') }} HR Management System <br>
                    <span class="badge bg-white text-dark border mt-2 fw-normal">Secured Connection</span>
                </p>
            </div>

        </div>
    </div>
</div>

</body>
</html>
