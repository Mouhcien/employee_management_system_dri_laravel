<x-layout>
    <div class="d-flex flex-column gap-4">

        <!-- Header section with "Retour" -->
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3">
            <div>
                <h1 class="h3 fw-semibold text-dark mb-1">
                    {{ $entity->type->title }} :
                    <span class="text-primary">{{ $entity->title }}</span>
                </h1>
                <span class="fw-semibold text-dark">Service</span> :
                <small class="text-muted">{{ $entity->service->title ?? 'Service non défini' }}</small>
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
                    <div class="card border-info shadow-sm mb-2">
                        <div class="card-header bg-info text-white">
                            <h5 class="h6 mb-0">
                                <i class="bi bi-journal-text me-2"></i>
                                Chef
                            </h5>
                        </div>
                        <div class="card-body pt-3 px-4 pb-4">
                            @if($entity->chefs->isNotEmpty())
                                <div class="row col-12">
                                    @foreach($entity->chefs as $chef)
                                        @if($chef->state)
                                            @php $employee = $chef->employee; @endphp
                                            <x-chef-card :employee="$employee" detach="true" :chef="$chef" />
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                <small class="text-muted">Aucun chef associé à cette entité.</small>
                            @endif
                        </div>
                    </div>

                    @if (count($entity->sectors) != 0)
                        <div class="card border-secondary shadow-sm">
                            <div class="card-header bg-secondary text-white">
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
                                                <a class="text-decoration-none text-dark" href="{{ route('sectors.show', $sector->id) }}" >{{ $sector->title }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <small class="text-muted">Aucun secteur associé à ce service.</small>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if (count($entity->sections) != 0)
                    <div class="card border-secondary shadow-sm">
                        <div class="card-header bg-secondary text-white">
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
                                            <a class="text-decoration-none text-dark" href="{{ route('sections.show', $section->id) }}" > {{ $section->title }} </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <small class="text-muted">Aucune section associée à ce service.</small>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>

                <div class="col-12 col-lg-6">
                <div class="card border-info shadow-sm mb-2">
                    <div class="card-header bg-primary text-white">
                        <h5 class="h6 mb-0">
                            <i class="bi bi-journal-text me-2"></i>
                            Importer les employées
                        </h5>
                    </div>
                    <div class="card-body pt-3 px-4 pb-4">
                        <form action="{{ route('affectations.entities.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="entity_id" value="{{ $entity->id }}">
                            <label class="form-label mb-2">Fichier Excel des PPR</label>
                            <input type="file" class="form-control mb-2" name="file">
                            <button class="btn btn-primary"><i class="bi bi-save me-2"></i> Charger</button>
                        </form>
                    </div>
                </div>

                <div class="card border-success shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="h6 mb-0">
                                <i class="bi bi-diagram-3 me-2"></i>
                                employés
                            </h5>
                        </div>
                        <div class="card-body pt-3 px-4 pb-4">
                            @if($entity->affectations->isNotEmpty())
                                <div class="row col-12">
                                    @foreach($entity->affectations as $affectation)
                                        @if ($affectation->state)
                                            <div class="col-4">
                                                @php $employee = $affectation->employee; @endphp
                                                <x-employee-card :employee="$employee" detach="true" unity_type="entity" unity_id="{{ $entity->id }}" unity_name="{{ $entity->title }}" />
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <x-delete-model
                                    href="{{ route('employees.delete', $affectation->employee->id) }}"
                                    message="Voulez-vous vraiment supprimer ce agent ?"
                                    title="Confiramtion"
                                    target="deleteEmployeeModal" />
                            @else
                                <small class="text-muted">Aucun employés associé à ce service.</small>
                            @endif
                        </div>
                    </div>

            </div>
        </div>
    </div>
</x-layout>
