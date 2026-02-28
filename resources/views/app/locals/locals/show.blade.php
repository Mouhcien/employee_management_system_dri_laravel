<x-layout>
    <div class="d-flex flex-column gap-4">

        <!-- Header section with "Retour" -->
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3">
            <div>
                <h1 class="h3 fw-semibold text-dark mb-1">
                    Local :
                    <span class="text-primary">{{ $local->title }}</span>
                </h1>
                <p class="text-muted mb-0">
                    Gérez efficacement le local <strong class="text-primary">{{ $local->title }}</strong> et ses locaux associés.
                </p>
            </div>
            <!-- Retour link -->
            <a
                href="{{ route('locals.index') }}"
                class="btn btn-outline-secondary btn-sm px-3"
            >
                <i class="bi bi-arrow-left me-1"></i>
                Retour
            </a>
        </div>

        <!-- Three colored cards -->
        <div class="row g-4">
            <!-- Card: Edit city (primary-themed) -->
            <div class="col-12 col-lg-4">
                <div class="card border-primary shadow-sm h-100">
                    <div class="card-header bg-primary text-white pb-3">
                        <h5 class="h6 mb-0">
                            <i class="bi bi-pencil-fill me-2"></i>
                            Éditer le local
                        </h5>
                        <small class="text-light">
                            Modifier les informations du local liées à votre structure.
                        </small>
                    </div>
                    <div class="card-body pt-4 px-4 pb-4">
                        <form action="{{ route('locals.update', $local->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="cityTitle" class="form-label fw-semibold text-dark mb-1">
                                    Nom de la ville <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-primary text-white">
                                        <i class="bi bi-geo-alt"></i>
                                    </span>
                                    <input
                                        type="text"
                                        class="form-control @error('title') is-invalid @enderror"
                                        id="cityTitle"
                                        name="title"
                                        placeholder="Casablanca, Marrakech, Rabat..."
                                        value="{{ old('title', $local->title) }}"
                                        required
                                    >
                                    @error('title')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted mt-1 d-block">
                                    Le nom doit être unique et descriptif.
                                </small>
                                <hr>
                                <label for="cityTitle" class="form-label fw-semibold text-dark mb-2">
                                    Ville <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-lg">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="bi bi-geo-alt text-primary"></i>
                                </span>
                                    <select name="city_id" class="form-select">
                                        <option value="">Toutes les villes</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}" {{ $city->id == $local->city_id ? 'selected' : '' }}>
                                                {{ $city->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="bg-light rounded-3 p-2 mb-3 d-none" id="previewSection">
                                <small class="text-muted mb-1 d-block">Aperçu:</small>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 p-1 rounded-circle me-2">
                                        <i class="bi bi-geo-alt-fill text-primary"></i>
                                    </div>
                                    <span class="fw-semibold text-dark" id="previewTitle">
                                        Tapez un nom...
                                    </span>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-3">
                                <button type="submit" class="btn btn-primary btn-sm px-3">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Mettre à jour
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Card: Locaux (success-themed) -->
            <div class="col-12 col-lg-4">
                <div class="card border-success shadow-sm h-100">
                    <div class="card-header bg-success text-white pb-3">
                        <h5 class="h6 mb-0">
                            <i class="bi bi-building-fill me-2"></i>
                            Ville de {{ $local->title }}
                        </h5>
                    </div>
                    <div class="card-body pt-4 px-4 pb-4">
                        {{ $local->city->title }}
                    </div>
                </div>
            </div>

            <!-- Card: Functionnaires stats (info-themed) -->
            <div class="col-12 col-lg-4">
                <div class="card border-info shadow-sm h-100">
                    <div class="card-header bg-info text-white pb-3">
                        <h5 class="h6 mb-0">
                            <i class="bi bi-people-fill me-2"></i>
                            Statistiques des fonctionnaires
                        </h5>
                    </div>
                    <div class="card-body pt-4 px-4 pb-4">

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
