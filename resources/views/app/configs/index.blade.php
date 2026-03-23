<x-layout>

    @section('title', 'Gestion des chefs - HR Management')

    <div class="container-fluid py-4">
        {{-- Glassmorphic Page Header --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="bg-primary bg-gradient p-4 text-white">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="fw-bold mb-1"> <i class="bi bi-tools me-2"></i> Paramètres Globale</h2>
                            <p class="opacity-75 mb-0">Supervision et suivi les paramètres globale de l'application</p>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <a class="btn btn-danger btn-rounded shadow-sm" href="{{ route('chefs.download') }}" >
                                <i class="bi bi-download"></i>
                            </a>
                            <a href="{{ route('configs.index') }}" class="btn btn-light btn-rounded"><i class="bi bi-arrow-clockwise"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row col-12">
        @foreach($configs as $config)
        <div class="col-4">
            <div class="card">
                <form action="{{ route('configs.update', $config->id) }}" method="POST">
                    @csrf
                    <div class="card-header"> {{ $config->title }}</div>
                    <div class="card-body">
                        <select class="form-control" name="value">
                            <option value="Vertical" {{ $config->value == 'Vertical' ? 'selected' : '' }} >Vertical</option>
                            <option value="Horizontal" {{ $config->value == 'Horizontal' ? 'selected' : '' }}>Horizontal</option>
                        </select>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success"> Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>
        @endforeach
    </div>


</x-layout>
