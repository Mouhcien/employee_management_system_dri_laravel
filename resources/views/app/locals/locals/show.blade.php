<x-layout>
    @section('title', 'Détails du Local - ' . $local->title)

    <div class="container-fluid py-4">
        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="bg-primary bg-gradient p-4 text-white">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-white bg-opacity-20 rounded-3 p-3 me-3 shadow-sm text-dark">
                                <i class="bi bi-building-fill fs-3"></i>
                            </div>
                            <div>
                                <h2 class="fw-bold mb-1">Local : {{ $local->title }}</h2>
                                <p class="opacity-75 mb-0 small d-flex align-items-center">
                                    <i class="bi bi-geo-alt-fill me-2"></i>
                                    Rattaché à la ville de <span class="fw-bold ms-1 text-white">{{ $local->city->title }}</span>
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('locals.index') }}" class="btn btn-white btn-rounded px-4 fw-bold shadow-sm transition-base">
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
                            <i class="bi bi-gear-fill text-primary me-2"></i>Paramètres du Local
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('locals.update', $local->id) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="localTitle" class="form-label small fw-bold text-dark">Désignation du local</label>
                                <div class="input-group border rounded-3 overflow-hidden shadow-xs transition-base">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-building text-primary"></i></span>
                                    <input
                                        type="text"
                                        id="localTitle"
                                        name="title"
                                        class="form-control border-0 bg-light shadow-none @error('title') is-invalid @enderror"
                                        value="{{ old('title', $local->title) }}"
                                        required
                                    >
                                </div>
                                @error('title')
                                <div class="text-danger extra-small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="city_id" class="form-label small fw-bold text-dark">Ville de rattachement</label>
                                <div class="input-group border rounded-3 overflow-hidden shadow-xs transition-base">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-geo-alt text-primary"></i></span>
                                    <select name="city_id" id="city_id" class="form-select border-0 bg-light shadow-none">
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}" {{ $city->id == $local->city_id ? 'selected' : '' }}>
                                                {{ $city->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold shadow-sm py-2 mt-2 transition-base">
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
                            <i class="bi bi-map text-success me-2"></i>Géolocalisation
                        </h6>
                    </div>
                    <div class="card-body p-4 text-center">
                        <div class="bg-success-subtle bg-opacity-10 rounded-4 p-5 mb-3 border border-success-subtle border-dashed">
                            <div class="bg-success text-white rounded-circle p-3 d-inline-flex align-items-center justify-content-center shadow-lg mb-4" style="width: 64px; height: 64px;">
                                <i class="bi bi-geo-alt-fill fs-3"></i>
                            </div>
                            <h5 class="fw-bold text-success mb-1">{{ $local->city->title }}</h5>
                            <p class="text-muted small mb-0 fw-medium">Pôle régional de rattachement</p>
                        </div>
                        <a href="{{ route('cities.show', $local->city->id) }}" class="btn btn-outline-success btn-sm rounded-pill px-4">
                            Voir la fiche ville
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                        <h6 class="fw-bold text-uppercase text-muted small mb-0 ls-1">
                            <i class="bi bi-people text-info me-2"></i>Effectif Localisé
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between p-4 bg-info-subtle bg-opacity-10 border border-info-subtle rounded-4 mb-4 transition-base hover-lift">
                            <div class="d-flex align-items-center">
                                <div class="bg-info text-white rounded-3 p-3 me-3">
                                    <i class="bi bi-person-workspace fs-4"></i>
                                </div>
                                <div>
                                    <h4 class="fw-bold text-dark mb-0">{{ $local->employees->count() }}</h4>
                                    <span class="text-muted extra-small fw-bold text-uppercase ls-1">Fonctionnaires</span>
                                </div>
                            </div>
                            <i class="bi bi-arrow-up-right-circle text-info fs-3"></i>
                        </div>

                        <div class="bg-light rounded-4 p-3">
                            <h6 class="small fw-bold text-muted mb-3"><i class="bi bi-info-circle me-2"></i>Répartition</h6>
                            <div class="d-flex justify-content-between mb-2 small px-1">
                                <span class="text-muted">Hommes</span>
                                <span class="fw-bold">{{ $local->employees->where('gender', 'M')->count() }}</span>
                            </div>
                            <div class="d-flex justify-content-between small px-1">
                                <span class="text-muted">Femmes</span>
                                <span class="fw-bold">{{ $local->employees->where('gender', 'F')->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .transition-base { transition: all 0.2s ease-in-out; }
        .hover-lift:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important; }
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
