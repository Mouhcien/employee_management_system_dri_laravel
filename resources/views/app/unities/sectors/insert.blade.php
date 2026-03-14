<x-layout>
    @section('title', isset($sector) ? "Modifier le Secteur" : "Nouveau Secteur")

    <div class="container py-5">
        <div class="row justify-content-center">
            {{-- Optimized width for form focus --}}
            <div class="col-xl-7 col-lg-9">

                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    {{-- Premium Header --}}
                    <div class="card-header border-0 py-4 px-4 d-flex justify-content-between align-items-center"
                         style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);">
                        <div>
                            <h4 class="mb-1 text-white fw-bold">
                                <i class="bi {{ isset($sector) ? 'bi-pencil-square' : 'bi-plus-circle-dotted' }} me-2"></i>
                                {{ isset($sector) ? "Modifier le Secteur" : 'Nouveau Secteur' }}
                            </h4>
                            <p class="text-white text-opacity-75 mb-0 small">
                                {{ isset($sector) ? "Mise à jour des informations de l'unité" : 'Définition d\'une nouvelle unité structurelle' }}
                            </p>
                        </div>

                        <a href="{{ route('sectors.index') }}" class="btn btn-white btn-sm rounded-pill px-3 fw-bold shadow-sm">
                            <i class="bi bi-arrow-left me-1"></i>
                            Retour
                        </a>
                    </div>

                    <div class="card-body bg-white p-4 p-md-5">
                        <form
                            action="{{ isset($sector) ? route('sectors.update', $sector->id) : route('sectors.store') }}"
                            method="POST"
                            class="needs-validation"
                            novalidate
                        >
                            @csrf

                            {{-- Hierarchy Information --}}
                            <div class="row g-4 mb-4">
                                {{-- Service Selection --}}
                                <div class="col-md-6">
                                    <label for="service_id" class="form-label small fw-bold text-uppercase text-muted">
                                        <i class="bi bi-building me-1 text-primary"></i> Service Parent
                                    </label>
                                    <select
                                        id="service_id"
                                        name="service_id"
                                        class="form-select border-0 bg-light rounded-3 shadow-none @error('service_id') is-invalid @enderror"
                                        style="height: 50px;"
                                        required
                                    >
                                        <option value="">Sélectionnez le service</option>
                                        @foreach($services as $service)
                                            <option value="{{ $service->id }}"
                                                {{ (isset($sector) && $service->id == $sector->entity->service_id) || (isset($service_id) && $service->id == $service_id) || old('service_id') == $service->id ? 'selected' : '' }}>
                                                {{ $service->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('service_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Entity Selection --}}
                                <div class="col-md-6">
                                    <label for="entity_id" class="form-label small fw-bold text-uppercase text-muted">
                                        <i class="bi bi-diagram-3 me-1 text-primary"></i> Entité Rattachée
                                    </label>
                                    <select
                                        id="entity_id"
                                        name="entity_id"
                                        class="form-select border-0 bg-light rounded-3 shadow-none @error('entity_id') is-invalid @enderror"
                                        style="height: 50px;"
                                        required
                                    >
                                        <option value="">Sélectionnez l'entité</option>
                                        @foreach($entities as $entity)
                                            <option value="{{ $entity->id }}"
                                                {{ (isset($sector) && $entity->id == $sector->entity_id) || old('entity_id') == $entity->id ? 'selected' : '' }}>
                                                {{ $entity->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('entity_id')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Title Field --}}
                            <div class="mb-5">
                                <label for="title" class="form-label small fw-bold text-uppercase text-muted">
                                    <i class="bi bi-tag me-1 text-primary"></i> Nom du Secteur
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-grid-3x3 text-muted"></i></span>
                                    <input
                                        type="text"
                                        id="title"
                                        name="title"
                                        value="{{ old('title', $sector->title ?? '') }}"
                                        class="form-control border-0 bg-light rounded-end-3 shadow-none py-3 @error('title') is-invalid @enderror"
                                        placeholder="Ex: Secteur Technique Nord"
                                        required
                                    >
                                </div>
                                @error('title')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Dynamic Instruction Note --}}
                            <div class="alert alert-primary-subtle border-0 rounded-4 d-flex align-items-center p-3 mb-5">
                                <i class="bi bi-info-circle-fill fs-4 me-3 text-primary"></i>
                                <div class="small">
                                    <strong>Conseil :</strong> Assurez-vous que la hiérarchie est correcte. Les employés du secteur seront automatiquement liés au service parent sélectionné.
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="row g-3">
                                <div class="col-6 col-md-4">
                                    <button type="reset" class="btn btn-light btn-lg rounded-pill w-100 fw-semibold text-muted">
                                        Effacer
                                    </button>
                                </div>
                                <div class="col-6 col-md-8">
                                    <button type="submit" class="btn btn-primary btn-lg rounded-pill w-100 fw-bold shadow-sm">
                                        <i class="bi bi-check-lg me-2"></i>
                                        {{ isset($sector) ? 'Mettre à jour le secteur' : 'Enregistrer le secteur' }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Visual Footer Helper --}}
                <div class="text-center mt-4">
                    <p class="text-muted small">
                        <i class="bi bi-shield-lock me-1"></i> Données sécurisées - Système de gestion RH v3.0
                    </p>
                </div>

            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .btn-white { background: #fff; color: #4f46e5; border: none; }
            .btn-white:hover { background: #f8faff; color: #3730a3; }
            .alert-primary-subtle { background-color: #eef2ff; color: #3730a3; }

            /* Input focus effects */
            .form-control:focus, .form-select:focus {
                background-color: #fff !important;
                border: 1px solid #4f46e5 !important;
                box-shadow: 0 0 0 0.25rem rgba(79, 70, 229, 0.1) !important;
            }

            /* Rounded pills for standard UI buttons */
            .btn-rounded { border-radius: 50px; }
            .ls-1 { letter-spacing: 0.5px; }
        </style>
    @endpush
</x-layout>
