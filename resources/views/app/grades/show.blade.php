<x-layout>
    <div class="d-flex flex-column gap-4">

        <!-- Header section with "Retour" -->
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3">
            <div>
                <h1 class="h3 fw-semibold text-dark mb-1">
                    Grade :
                    <span class="text-primary">{{ $grade->title }}</span>
                </h1>
                <p class="text-muted mb-0">
                    Gérez efficacement le occupation <strong class="text-primary">{{ $grade->title }}</strong> et ses employés associées.
                </p>
            </div>
            <!-- Retour link -->
            <a
                href="{{ route('grades.index') }}"
                class="btn btn-outline-secondary btn-sm px-3"
            >
                <i class="bi bi-arrow-left me-1"></i>
                Retour
            </a>
        </div>

        <!-- Edit form section -->
        <div class="bg-light rounded-3 border p-4 shadow-sm">
            <form action="{{ route('grades.update', $grade->id) }}" method="POST">
                @csrf
                <div class="row g-3">
                    <!-- Service title -->
                    <div class="col-12 col-lg-12">
                        <div class="row g-3 align-items-center">
                            <div class="col-8 col-md-4">
                                <label for="serviceTitle" class="form-label fw-semibold text-dark mb-1">
                                    Nom du occupation
                                </label>
                                <input
                                    type="text"
                                    id="serviceTitle"
                                    name="title"
                                    class="form-control form-control-lg"
                                    value="{{ old('title', $grade->title) }}"
                                    required
                                />
                            </div>
                            <div class="col-4 col-md-4">
                                <label for="serviceTitle" class="form-label fw-semibold text-dark mb-1">
                                    Echelle
                                </label>
                                <select
                                    class="form-control form-control-lg border-start-0 shadow-sm @error('title') is-invalid @enderror"
                                    id="cityTitle"
                                    name="scale"
                                    required>
                                    <option value="12" {{ $grade->scale == 12 ? 'selected' : '' }}>12</option>
                                    <option value="11" {{ $grade->scale == 11 ? 'selected' : '' }}>11</option>
                                    <option value="10" {{ $grade->scale == 10 ? 'selected' : '' }}>10</option>
                                    <option value="9" {{ $grade->scale == 9 ? 'selected' : '' }}>9</option>
                                    <option value="8" {{ $grade->scale == 8 ? 'selected' : '' }}>8</option>
                                    <option value="7" {{ $grade->scale == 7 ? 'selected' : '' }}>7</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-4">
                                <label></label>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-save me-1"></i>
                                    Mettre à jour
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>


        <div class="row g-4">
            <div class="col-12 col-lg-12">
                <div class="card border-primary shadow-sm h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="h6 mb-0">
                            <i class="bi bi-people-fill me-2"></i>
                            Fonctionnaires
                        </h5>
                    </div>
                    <div class="card-body pt-3 px-4 pb-4">
                        @if($grade->classements->isNotEmpty())
                            <ul class="list-unstyled mb-0">
                                @foreach($grade->classements as $classement)
                                    <li class="border-bottom pb-1 mb-1 text-dark">
                                        {{ $classement->employee->lastname }} {{ $classement->employee->firstname }}
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <small class="text-muted">Aucune fonctionnaires associée à cette occupation.</small>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-layout>
