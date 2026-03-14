<x-layout>
    @section('title', 'Détails Filière - ' . $option->title)

    <div class="container-fluid py-4">
        <div class="card border-0 shadow-lg rounded-4 mb-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="bg-primary bg-gradient p-4 text-white position-relative">
                    {{-- Icône décorative en filigrane --}}
                    <div class="position-absolute top-0 end-0 p-4 opacity-10">
                        <i class="bi bi-layers-fill" style="font-size: 6rem;"></i>
                    </div>
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 position-relative">
                        <div class="d-flex align-items-center">
                            <div class="bg-white bg-opacity-20 rounded-3 p-3 me-3 shadow-sm">
                                <i class="bi bi-mortarboard-fill fs-3 text-dark"></i>
                            </div>
                            <div>
                                <h2 class="fw-bold mb-1">Filière : {{ $option->title }}</h2>
                                <p class="text-white text-opacity-75 mb-0 small fw-medium">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Gestion des spécialités académiques et des profils qualifiés
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('options.index') }}" class="btn btn-white btn-rounded px-4 fw-bold shadow-sm transition-base">
                            <i class="bi bi-arrow-left me-2"></i>Retour au référentiel
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                        <h6 class="fw-bold text-uppercase text-muted small mb-0 ls-1">
                            <i class="bi bi-gear-wide-connected text-primary me-2"></i>Paramètres de l'option
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('options.update', $option->id) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="serviceTitle" class="form-label small fw-bold text-dark text-uppercase ls-1">Nom de la spécialité</label>
                                <div class="input-group border rounded-3 overflow-hidden shadow-xs transition-base">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-bookmark-star text-primary"></i></span>
                                    <input
                                        type="text"
                                        id="serviceTitle"
                                        name="title"
                                        class="form-control border-0 bg-light shadow-none fw-medium py-2"
                                        value="{{ old('title', $option->title) }}"
                                        required
                                    >
                                </div>
                                <div class="form-text extra-small mt-2 text-muted">La modification affectera tous les employés rattachés à cette option.</div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold shadow-sm py-2 transition-base">
                                <i class="bi bi-check2-all me-2"></i>Mettre à jour l'intitulé
                            </button>
                        </form>

                        <div class="mt-4 p-4 bg-primary-subtle rounded-4 border border-primary-subtle border-opacity-25 text-center shadow-xs">
                            <div class="bg-white rounded-circle d-inline-flex p-3 mb-3 shadow-sm">
                                <i class="bi bi-people-fill text-primary fs-4"></i>
                            </div>
                            <h3 class="fw-bold text-primary mb-0">{{ $option->qualifications->count() }}</h3>
                            <span class="text-primary text-opacity-75 small fw-bold text-uppercase">Spécialistes</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                    <div class="card-header bg-white py-4 px-4 border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark">
                            <i class="bi bi-person-check-fill text-primary me-2"></i>
                            Employés Titulaires
                        </h5>
                        <div class="bg-light px-3 py-1 rounded-pill border small fw-bold text-muted">
                            Effectif : {{ $option->qualifications->count() }}
                        </div>
                    </div>
                    <div class="card-body p-4 bg-light-subtle">
                        @if($option->qualifications->isNotEmpty())
                            <div class="row g-3">
                                @foreach($option->qualifications as $qualification)
                                    <div class="col-xl-6 col-md-12">
                                        <div class="hover-lift transition-base h-100 shadow-sm">
                                            <x-chef-card :employee="$qualification->employee" detach="false" />
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="avatar avatar-xl bg-light rounded-circle mb-3 mx-auto d-flex align-items-center justify-content-center shadow-xs" style="width: 80px; height: 80px;">
                                    <i class="bi bi-search fs-1 text-muted"></i>
                                </div>
                                <h6 class="text-muted fw-bold">Aucun profil trouvé</h6>
                                <p class="text-muted small px-5">Aucun employé n'est actuellement rattaché à cette filière ou option.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .transition-base { transition: all 0.2s ease-in-out; }
        .hover-lift:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important; }
        .btn-white { background: #fff; color: #4f46e5; border: none; }
        .btn-white:hover { background: #f3f4f6; color: #4338ca; }
        .btn-rounded { border-radius: 50px; }
        .ls-1 { letter-spacing: 0.5px; }
        .extra-small { font-size: 0.72rem; }
        .shadow-xs { box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
        .bg-primary-subtle { background-color: #eef2ff !important; }
        .bg-light-subtle { background-color: #f9fafb !important; }
    </style>
</x-layout>
