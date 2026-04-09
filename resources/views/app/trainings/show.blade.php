<x-layou>

    <div class="container-fluid py-4 px-md-5">
        {{-- Header Professionnel --}}
        <div class="row align-items-center mb-5">
            <div class="col-md-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item small"><a href="#" class="text-muted text-decoration-none uppercase fw-bold ls-1">RH Dashboard</a></li>
                        <li class="breadcrumb-item small active text-primary fw-bold uppercase ls-1" aria-current="page">Formation : {{ $training->title }}</li>
                    </ol>
                </nav>
                <h1 class="h2 fw-extrabold text-dark mb-0">Formation : <span class="text-primary">{{ $training->title }}</span></h1>
                <p class="text-muted small">{{ $training->theme }}</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a class="btn btn-primary shadow-sm rounded-3 px-4 py-2 fw-bold" href="{{ route('trainings.create') }}">
                    <i class="bi bi-plus-lg me-2"></i>Nouvelle Formation
                </a>
            </div>
        </div>

    </div>
</x-layou>
