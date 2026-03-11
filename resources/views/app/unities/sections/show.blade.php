<x-layout>
    <div class="d-flex flex-column gap-4">

        <!-- Header section with "Retour" -->
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3">
            <div>
                <h1 class="h3 fw-semibold text-dark mb-1">
                    Section :
                    <span class="text-primary">{{ $section->title }}</span>
                </h1>
                <span class="fw-semibold text-dark">{{ $section->entity->type->title ?? 'Non assignée' }}</span> :
                <span class="fw-semibold text-primary">{{ $section->entity->title ?? 'Non assignée' }}</span> <br>
                <span class="fw-semibold text-dark">Service</span> :
                <small class="text-muted">{{ $section->entity->service->title ?? 'Service non défini' }}</small>
                <p class="text-muted mb-0">
                    Gérez efficacement le service <strong class="text-primary">{{ $section->title }}</strong> et ses employées associées.
                </p>
            </div>
            <!-- Retour link -->
            <a
                href="{{ route('sections.index') }}"
                class="btn btn-outline-secondary btn-sm px-3"
            >
                <i class="bi bi-arrow-left me-1"></i>
                Retour
            </a>
        </div>

        <div class="row g-4">
            <div class="col-12 col-lg-3">
                <div class="card border-info shadow-sm h-100">
                    <div class="card-header bg-info text-white">
                        <h5 class="h6 mb-0">
                            <i class="bi bi-journal-text me-2"></i>
                            Chef
                        </h5>
                    </div>
                    <div class="card-body pt-3 px-4 pb-4">

                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="card border-success shadow-sm h-100">
                    <div class="card-header bg-success text-white">
                        <h5 class="h6 mb-0">
                            <i class="bi bi-diagram-3 me-2"></i>
                            employés
                        </h5>
                    </div>
                    <div class="card-body pt-3 px-4 pb-4">
                        @if($section->affectations->isNotEmpty())
                            <div class="row col-12">
                                @foreach($section->affectations as $affectation)
                                @if ($affectation->state)
                                    <div class="col-4">
                                        <x-employee-card :affectation="$affectation" detach="true" />
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

            <div class="col-12 col-lg-3">
                <div class="card border-info shadow-sm h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="h6 mb-0">
                            <i class="bi bi-journal-text me-2"></i>
                            Importer les employées
                        </h5>
                    </div>
                    <div class="card-body pt-3 px-4 pb-4">
                        <form action="{{ route('affectations.sections.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="section_id" value="{{ $section->id }}">
                            <label class="form-label mb-2">Fichier Excel des PPR</label>
                            <input type="file" class="form-control mb-2" name="file">
                            <button class="btn btn-primary"><i class="bi bi-save me-2"></i> Charger</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
