<x-layout>
    <div class="d-flex flex-column gap-4">

        <!-- Header section with "Retour" -->
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3">
            <div>
                <h1 class="h3 fw-semibold text-dark mb-1">
                    Service :
                    <span class="text-primary">{{ $service->title }}</span>
                </h1>
                <p class="text-muted mb-0">
                    Gérez efficacement le service <strong class="text-primary">{{ $service->title }}</strong> et ses entités associées.
                </p>
            </div>
            <!-- Retour link -->
            <a
                href="{{ route('services.index') }}"
                class="btn btn-outline-secondary btn-sm px-3"
            >
                <i class="bi bi-arrow-left me-1"></i>
                Retour
            </a>
        </div>

        <!-- Edit form section -->
        <div class="bg-light rounded-3 border p-4 shadow-sm">
            <form action="{{ route('services.update', $service->id) }}" method="POST">
                @csrf
                <div class="row g-3">
                    <!-- Service title -->
                    <div class="col-12 col-lg-8">
                        <div class="row g-3 align-items-center">
                            <div class="col-12 col-md-8">
                                <label for="serviceTitle" class="form-label fw-semibold text-dark mb-1">
                                    Nom du service
                                </label>
                                <input
                                    type="text"
                                    id="serviceTitle"
                                    name="title"
                                    class="form-control form-control-lg"
                                    value="{{ old('title', $service->title) }}"
                                    required
                                />
                            </div>
                            <div class="col-12 col-md-4">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-save me-1"></i>
                                    Mettre à jour
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Chef info on the right -->
                    <div class="col-12 col-lg-4">
                        <div class="bg-white border border-primary rounded-3 p-3 text-center shadow-sm">
                            <h6 class="fw-semibold text-primary mb-1">
                                Chef du service
                            </h6>
                            <p class="text-dark m-0">
                                {{ $service->chef?->name ?? 'Non défini' }}
                            </p>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Three colored cards: Entités, Secteurs, Sections -->
        <div class="row g-4">
            <!-- Entités (primary) -->
            <div class="col-12 col-lg-4">
                <div class="card border-primary shadow-sm h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="h6 mb-0">
                            <i class="bi bi-archive me-2"></i>
                            Entités
                        </h5>
                    </div>
                    <div class="card-body pt-3 px-4 pb-4">
                        @if($service->entities->isNotEmpty())
                            <ul class="list-unstyled mb-0">
                                @foreach($service->entities as $entity)
                                    <li class="border-bottom pb-1 mb-1 text-dark">
                                        {{ $entity->title }}
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <small class="text-muted">Aucune entité associée à ce service.</small>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Secteurs (success) -->
            <div class="col-12 col-lg-4">
                <div class="card border-success shadow-sm h-100">
                    <div class="card-header bg-success text-white">
                        <h5 class="h6 mb-0">
                            <i class="bi bi-diagram-3 me-2"></i>
                            Secteurs
                        </h5>
                    </div>
                    <div class="card-body pt-3 px-4 pb-4">
                        @php
                            $sectors = $service
                                ->entities
                                ->flatMap(fn($e) => $e->sectors)
                                ->unique('id');
                        @endphp
                        @if($sectors->isNotEmpty())
                            <ul class="list-unstyled mb-0">
                                @foreach($sectors as $sector)
                                    <li class="border-bottom pb-1 mb-1 text-success">
                                        {{ $sector->title }}
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <small class="text-muted">Aucun secteur associé à ce service.</small>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sections (info) -->
            <div class="col-12 col-lg-4">
                <div class="card border-info shadow-sm h-100">
                    <div class="card-header bg-info text-white">
                        <h5 class="h6 mb-0">
                            <i class="bi bi-journal-text me-2"></i>
                            Sections
                        </h5>
                    </div>
                    <div class="card-body pt-3 px-4 pb-4">
                        @php
                            $sections = $service
                                ->entities
                                ->flatMap(fn($e) => $e->sections)
                                ->unique('id');
                        @endphp
                        @if($sections->isNotEmpty())
                            <ul class="list-unstyled mb-0">
                                @foreach($sections as $section)
                                    <li class="list-group-item border-bottom pb-1 mb-1 text-info">
                                        {{ $section->title }}
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <small class="text-muted">Aucune section associée à ce service.</small>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
