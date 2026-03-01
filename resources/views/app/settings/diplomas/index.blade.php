<div class="row g-4">
    <!-- Card: List of entity diplomas -->
    <div class="col-12 col-md-6">
        <div class="card border-primary shadow-sm h-100">
            <div class="card-header bg-primary text-white pb-3">
                <h5 class="h6 mb-0">
                    <i class="bi bi-list me-2"></i>
                    Liste des diplômes
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive rounded-2 overflow-hidden">
                    <table class="table table-sm table-hover align-middle mb-0">
                        <thead class="table-light">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Diplôme</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($diplomas as $diploma)
                            <tr>
                                <td class="text-muted">{{ $diploma->id }}</td>
                                <td class="fw-semibold text-dark">{{ $diploma->title }}</td>
                                <td>
                                    <a
                                        href="{{ route('settings.edit.diploma', $diploma->id) }}"
                                        class="btn btn-sm btn-outline-primary me-1"
                                    >
                                        <i class="bi bi-pencil me-1"></i>
                                        Éditer
                                    </a>
                                    <button data-bs-toggle="modal" data-bs-target="#deleteDiplomaModal"
                                        class="btn btn-sm btn-outline-danger"
                                    >
                                        <i class="bi bi-trash me-1"></i>
                                        Supprimer
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @if($diplomas->isEmpty())
                        <div class="text-center text-muted p-4 border-top">
                            Aucun diplôme défini.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @foreach($diplomas as $diploma)
        <x-delete-model
            href="{{ route('settings.diplomas.delete', $diploma->id) }}"
            message="Voulez-vous vraiment supprimer ce diplôme ?"
            title="Confiramtion"
            target="deleteDiplomaModal" />
    @endforeach

    <!-- Card: Create new entity diploma -->
    <div class="col-12 col-md-6">
        <div class="card border-success shadow-sm h-100">
            <div class="card-header bg-success text-white pb-3">
                <h5 class="h6 mb-0">
                    <i class="bi bi-plus-circle me-2"></i>
                    Nouveau diplôme
                </h5>
            </div>
            <div class="card-body p-4 pt-3">
                <form action="{{ is_null($diplomaObj) ? route('settings.diplomas.store') : route('settings.diplomas.update', $diplomaObj->id) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="diplomaTitle" class="form-label fw-semibold text-dark">
                            Diplôme
                        </label>
                        <input
                            diploma="text"
                            class="form-control form-control-lg"
                            id="diplomaTitle"
                            name="title"
                            placeholder="Ex: DEUG, LICENCE, MASTER..."
                            value="{{ is_null($diplomaObj) ? '' : $diplomaObj->title }}"
                        >
                        @error('title')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="card-footer bg-white border-0 px-0 pt-3 pb-0">
                        <button diploma="submit" class="btn btn-success px-4 rounded-pill">
                            <i class="bi bi-save me-2"></i>
                            {{ is_null($diplomaObj) ? 'Enregistrer' : 'Mettre à jour' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
