<div class="row g-4">
    <!-- Card: List of entity levels -->
    <div class="col-12 col-md-6">
        <div class="card border-primary shadow-sm h-100">
            <div class="card-header bg-primary text-white pb-3">
                <h5 class="h6 mb-0">
                    <i class="bi bi-list me-2"></i>
                    Liste des niveaux d'éducation
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive rounded-2 overflow-hidden">
                    <table class="table table-sm table-hover align-middle mb-0">
                        <thead class="table-light">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Niveau</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($levels as $level)
                            <tr>
                                <td class="text-muted">{{ $level->id }}</td>
                                <td class="fw-semibold text-dark">{{ $level->title }}</td>
                                <td>
                                    <a
                                        href="{{ route('settings.edit.level', $level->id) }}"
                                        class="btn btn-sm btn-outline-primary me-1"
                                    >
                                        <i class="bi bi-pencil me-1"></i>
                                        Éditer
                                    </a>
                                    <button data-bs-toggle="modal" data-bs-target="#deleteTypeEntityModal"
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
                    @if($levels->isEmpty())
                        <div class="text-center text-muted p-4 border-top">
                            Aucun éducation défini.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @foreach($levels as $level)
        <x-delete-model
            href="{{ route('settings.levels.delete', $level->id) }}"
            message="Voulez-vous vraiment supprimer ce niveau d'éducation ?"
            title="Confiramtion"
            target="deleteTypeEntityModal" />
    @endforeach

    <!-- Card: Create new entity level -->
    <div class="col-12 col-md-6">
        <div class="card border-success shadow-sm h-100">
            <div class="card-header bg-success text-white pb-3">
                <h5 class="h6 mb-0">
                    <i class="bi bi-plus-circle me-2"></i>
                    Nouveau Niveau d'éducation
                </h5>
            </div>
            <div class="card-body p-4 pt-3">
                <form action="{{ is_null($levelObj) ? route('settings.levels.store') : route('settings.levels.update', $levelObj->id) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="levelTitle" class="form-label fw-semibold text-dark">
                            Niveau d'éducation
                        </label>
                        <input
                            level="text"
                            class="form-control form-control-lg"
                            id="levelTitle"
                            name="title"
                            placeholder="Ex: Administrateur, Technicien..."
                            value="{{ is_null($levelObj) ? '' : $levelObj->title }}"
                        >
                        @error('title')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="card-footer bg-white border-0 px-0 pt-3 pb-0">
                        <button level="submit" class="btn btn-success px-4 rounded-pill">
                            <i class="bi bi-save me-2"></i>
                            {{ is_null($levelObj) ? 'Enregistrer' : 'Mettre à jour' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
