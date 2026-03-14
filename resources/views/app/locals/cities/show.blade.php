<x-layout>
    @section('title', 'Détails de la Ville - ' . $city->title)

    <div class="container-fluid py-4">
        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="bg-primary bg-gradient p-4 text-white">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-white bg-opacity-20 rounded-3 p-3 me-3 shadow-sm text-dark">
                                <i class="bi bi-geo-alt-fill fs-3"></i>
                            </div>
                            <div>
                                <h2 class="fw-bold mb-1">Ville : {{ $city->title }}</h2>
                                <p class="opacity-75 mb-0 small">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Gestion des infrastructures et de l'effectif local
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('cities.index') }}" class="btn btn-white btn-rounded px-4 fw-bold shadow-sm transition-base">
                            <i class="bi bi-arrow-left me-2"></i>Retour à la liste
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                        <h6 class="fw-bold text-uppercase text-muted small mb-0 ls-1">
                            <i class="bi bi-pencil-square text-primary me-2"></i>Configuration
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('cities.update', $city->id) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="cityTitle" class="form-label small fw-bold text-dark">Nom officiel de la ville</label>
                                <div class="input-group border rounded-3 overflow-hidden shadow-xs transition-base">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-geo-alt text-primary"></i></span>
                                    <input
                                        type="text"
                                        id="cityTitle"
                                        name="title"
                                        class="form-control border-0 bg-light shadow-none @error('title') is-invalid @enderror"
                                        value="{{ old('title', $city->title) }}"
                                        required
                                    >
                                </div>
                                @error('title')
                                <div class="text-danger extra-small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="bg-primary-subtle rounded-4 p-3 mb-4 d-none" id="previewSection">
                                <div class="d-flex align-items-center text-primary">
                                    <i class="bi bi-check2-circle me-2"></i>
                                    <span class="small fw-bold" id="previewTitle"></span>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold shadow-sm py-2">
                                <i class="bi bi-save me-2"></i>Mettre à jour
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                        <h6 class="fw-bold text-uppercase text-muted small mb-0 ls-1">
                            <i class="bi bi-building text-success me-2"></i>Parc Immobilier
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        @if($city->locals->isNotEmpty())
                            <div class="d-flex flex-column gap-2">
                                @foreach($city->locals as $local)
                                    <div class="d-flex align-items-center p-3 bg-success-subtle bg-opacity-10 border border-success-subtle rounded-3 transition-base hover-lift">
                                        <div class="bg-success text-white rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                            <i class="bi bi-house-door small"></i>
                                        </div>
                                        <span class="fw-semibold text-success small text-truncate">{{ $local->title }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5 border border-dashed rounded-4">
                                <i class="bi bi-building-exclamation text-muted fs-2"></i>
                                <p class="text-muted small mt-2 mb-0">Aucun local rattaché</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                        <h6 class="fw-bold text-uppercase text-muted small mb-0 ls-1">
                            <i class="bi bi-people text-info me-2"></i>Répartition RH
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        @if($city->locals->isNotEmpty())
                            <div class="list-group list-group-flush">
                                @foreach($city->locals as $local)
                                    <div class="list-group-item border-0 px-0 d-flex justify-content-between align-items-center mb-2">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-info-subtle text-info rounded-3 p-2 me-3">
                                                <i class="bi bi-person-badge small"></i>
                                            </div>
                                            <span class="text-dark small fw-medium">{{ $local->title }}</span>
                                        </div>
                                        <span class="badge bg-info rounded-pill px-3">{{ $local->employees->count() }}</span>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-4 pt-3 border-top">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-dark">Effectif Total</span>
                                    <span class="badge bg-dark rounded-pill px-3 py-2 fs-6">
                                        {{ $city->locals->sum(fn($l) => $l->employees->count()) }}
                                    </span>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-5 border border-dashed rounded-4">
                                <i class="bi bi-graph-down text-muted fs-2"></i>
                                <p class="text-muted small mt-2 mb-0">Pas de données statistiques</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const titleInput = document.getElementById('cityTitle');
                const previewSection = document.getElementById('previewSection');
                const previewTitle = document.getElementById('previewTitle');

                titleInput.addEventListener('input', function() {
                    const value = this.value.trim();
                    previewTitle.textContent = value || 'Tapez un nom...';
                    previewSection.classList.toggle('d-none', !value);
                });
            });
        </script>
    @endpush

    <style>
        .transition-base { transition: all 0.2s ease-in-out; }
        .hover-lift:hover { transform: translateY(-3px); }
        .btn-white { background: #fff; color: #0d6efd; border: none; }
        .btn-white:hover { background: #f8f9fa; color: #0056b3; }
        .btn-rounded { border-radius: 50px; }
        .ls-1 { letter-spacing: 0.5px; }
        .extra-small { font-size: 0.72rem; }
        .shadow-xs { box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
        .border-dashed { border-style: dashed !important; border-width: 2px !important; }
        .bg-primary-subtle { background-color: #eef2ff !important; }
        .bg-success-subtle { background-color: #f0fdf4 !important; }
        .bg-info-subtle { background-color: #ecfeff !important; }
    </style>
</x-layout>
