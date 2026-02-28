<x-layout>
    <div class="d-flex flex-column gap-4">

        <!-- Header section with "Retour" -->
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3">
            <div>
                <h1 class="h3 fw-semibold text-dark mb-1">
                    {{ $entity->type->title }} :
                    <span class="text-primary">{{ $entity->title }}</span>
                </h1>
                <p class="text-muted mb-0">
                    Gérez efficacement le service <strong class="text-primary">{{ $entity->title }}</strong> et ses entités associées.
                </p>
            </div>
            <!-- Retour link -->
            <a
                href="{{ route('entities.index') }}"
                class="btn btn-outline-secondary btn-sm px-3"
            >
                <i class="bi bi-arrow-left me-1"></i>
                Retour
            </a>
        </div>

        <div class="row g-4">
            <div class="col-12 col-lg-6">
                <div class="card border-success shadow-sm h-100">
                    <div class="card-header bg-success text-white">
                        <h5 class="h6 mb-0">
                            <i class="bi bi-diagram-3 me-2"></i>
                            Secteurs
                        </h5>
                    </div>
                    <div class="card-body pt-3 px-4 pb-4">
                        @php
                            $sectors = $entity
                                ->sectors
                                ->flatMap(fn($e) => $e->sectors)
                                ->unique('id');
                        @endphp
                        @if($entity->sectors->isNotEmpty())
                            <ul class="list-unstyled mb-0">
                                @foreach($entity->sectors as $sector)
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

            <div class="col-12 col-lg-6">
                <div class="card border-info shadow-sm h-100">
                    <div class="card-header bg-info text-white">
                        <h5 class="h6 mb-0">
                            <i class="bi bi-journal-text me-2"></i>
                            Sections
                        </h5>
                    </div>
                    <div class="card-body pt-3 px-4 pb-4">
                        @if($entity->sections->isNotEmpty())
                            <ul class="list-unstyled mb-0">
                                @foreach($entity->sections as $section)
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
