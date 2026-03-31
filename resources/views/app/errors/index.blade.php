
@vite(['resources/css/app.css', 'resources/css/toastr.min.css'])

<div class="d-flex align-items-center justify-content-center vh-100 bg-light">
    <div class="text-center p-5 shadow-lg rounded-4 bg-white" style="max-width: 500px; border-top: 5px solid #dc3545;">
        <div class="mb-4">
            <i class="bi bi-exclamaion-octagon-fill text-danger" style="font-size: 5rem;"></i>
        </div>

        <h1 class="fw-black text-dark mb-3">Accès Restreint</h1>

        <div class="p-3 bg-danger-subtle text-danger rounded-3 mb-4">
            <i class="bi bi-shield-lock-fill me-2"></i>
            <span class="fw-bold">{{ $error }}</span>
        </div>

        <p class="text-muted mb-5">
            <strong>Attention :</strong> Vous n'avez pas les autorisations nécessaires pour accéder à cette section. Votre tentative a été enregistrée pour des raisons de sécurité.
        </p>

        <div class="d-grid gap-2">
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="bi bi-arrow-left me-2"></i>Retourner en arrière
            </a>
            <a href="{{ route('dashboard0') }}" class="btn btn-danger rounded-pill px-4 shadow-sm">
                <i class="bi bi-house-door-fill me-2"></i>Tableau de Bord
            </a>
        </div>
    </div>
</div>
