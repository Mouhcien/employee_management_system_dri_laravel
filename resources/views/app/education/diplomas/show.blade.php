<x-layout>
    <div class="d-flex flex-column gap-4">

        <!-- Header section with "Retour" -->
        <div class="bg-gradient-primary-to-secondary rounded-4 p-4 mb-4 text-white shadow-lg" >
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3">
            <div>
                <h1 class="h3 fw-semibold text-dark mb-1">
                    Diplôme :
                    <span class="text-primary">{{ $diploma->title }}</span>
                </h1>
                <p class="text-muted mb-0">
                    Gérez efficacement la filière <strong class="text-primary">{{ $diploma->title }}</strong>
                </p>
            </div>
            <!-- Retour link -->
            <a
                href="{{ route('diplomas.index') }}"
                class="btn btn-outline-secondary btn-sm px-3"
            >
                <i class="bi bi-arrow-left me-1"></i>
                Retour
            </a>
        </div>
        </div>
        <!-- Edit form section -->
        <div class="bg-light rounded-3 border p-4 shadow-sm">
            <form action="{{ route('diplomas.update', $diploma->id) }}" method="POST">
                @csrf
                <div class="row g-3">
                    <!-- Service title -->
                    <div class="col-12 col-lg-12">
                        <div class="row g-3 align-items-center">
                            <div class="col-12 col-md-8">
                                <label for="serviceTitle" class="form-label fw-semibold text-dark mb-1">
                                    Nom du diplôme
                                </label>
                                <input
                                    type="text"
                                    id="serviceTitle"
                                    name="title"
                                    class="form-control form-control-lg"
                                    value="{{ old('title', $diploma->title) }}"
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

                </div>
            </form>
        </div>


        <div class="row g-4">
            <div class="col-12 col-lg-12">
                <div class="card border-primary shadow-sm h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="h6 mb-0">
                            <i class="bi bi-people-fill me-2"></i>
                            Employés
                        </h5>
                    </div>
                    <div class="card-body pt-3 px-4 pb-4">
                        @if($diploma->qualifications->isNotEmpty())
                            <ul class="list-unstyled mb-0">
                                @foreach($diploma->qualifications as $qualification)
                                    <li class="border-bottom pb-1 mb-1 text-dark">
                                        {{ $qualification->employee->lastname }} {{ $qualification->employee->firstname }}
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <small class="text-muted">Aucune fonctionnaires associée à cette filière.</small>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-layout>
