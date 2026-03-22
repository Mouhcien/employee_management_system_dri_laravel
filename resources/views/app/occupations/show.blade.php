<x-layout>
    @section('title', 'Détails Fonction - ' . $occupation->title)

    <div class="container-fluid py-4">
        <div class="card border-0 shadow-lg rounded-4 mb-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="bg-primary bg-gradient p-4 text-white position-relative">
                    <div class="position-absolute top-0 end-0 p-4 opacity-10">
                        <i class="bi bi-journal-bookmark-fill" style="font-size: 6rem;"></i>
                    </div>
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 position-relative">
                        <div class="d-flex align-items-center">
                            <div class="bg-white bg-opacity-20 rounded-3 p-3 me-3 shadow-sm">
                                <i class="bi bi-briefcase-fill fs-3 text-dark"></i>
                            </div>
                            <div>
                                <h2 class="fw-bold mb-1">Fonction : {{ $occupation->title }}</h2>
                                <p class="text-white text-opacity-75 mb-0 small">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Gestion du titre professionnel et des agents titulaires
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('occupations.index') }}" class="btn btn-white btn-rounded px-4 fw-bold shadow-sm transition-base">
                            <i class="bi bi-arrow-left me-2"></i>Retour à la liste
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
                            <i class="bi bi-gear-fill text-primary me-2"></i>Configuration du titre
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('occupations.update', $occupation->id) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="occupationTitle" class="form-label small fw-bold text-dark">Intitulé de l'occupation</label>
                                <div class="input-group border rounded-3 overflow-hidden shadow-xs transition-base">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-tag text-primary"></i></span>
                                    <input
                                        type="text"
                                        id="occupationTitle"
                                        name="title"
                                        class="form-control border-0 bg-light shadow-none"
                                        value="{{ old('title', $occupation->title) }}"
                                        required
                                    >
                                </div>
                                <div class="form-text extra-small mt-2">Ce nom sera reflété sur toutes les fiches agents liées.</div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold shadow-sm py-2 transition-base">
                                <i class="bi bi-check2-circle me-2"></i>Mettre à jour l'intitulé
                            </button>
                        </form>

                        <hr class="my-4 opacity-50">

                        <div class="bg-primary-subtle rounded-4 p-3 border border-primary-subtle">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-graph-up-arrow text-primary me-2"></i>
                                <span class="small fw-bold text-primary">Statistiques</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small">Agents affectés :</span>
                                <span class="badge bg-primary rounded-pill px-3">{{ $occupation->works->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white py-4 px-4 border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark">
                            <i class="bi bi-people-fill text-primary me-2"></i>
                            Titulaires de la fonction
                        </h5>
                        <span class="badge bg-light text-dark border rounded-pill px-3 py-2 fw-bold small">
                            {{ $occupation->works->count() }} Agents
                        </span>
                    </div>
                    <div class="card-body p-4">
                        @if($occupation->works->isNotEmpty())
                            <div class="row g-3">
                                @foreach($occupation->works as $work)
                                    <div class="col-xl-4 col-md-6">
                                        <div class="hover-lift transition-base h-100">
                                            <x-employee-card :employee="$work->employee" detach="false" />
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="avatar avatar-xl bg-light rounded-circle mb-3 mx-auto d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <i class="bi bi-person-x fs-1 text-muted"></i>
                                </div>
                                <h6 class="text-muted fw-bold">Aucun agent affecté</h6>
                                <p class="text-muted small">Aucun titulaire n'est actuellement rattaché à cette fonction.</p>
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
        .border-primary-subtle { border-color: #dbeafe !important; }
        /* Correction pour l'affichage des cards chefs dans la grille */
        .col-xl-4 .employee-card { margin-bottom: 0 !important; }
    </style>
</x-layout>
