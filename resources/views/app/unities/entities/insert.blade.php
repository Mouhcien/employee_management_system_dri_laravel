<x-layout>
    @section('title', isset($entity) ? "Modifier l'Entité" : "Nouvelle Entité")

    <div class="container py-5">
        <div class="row justify-content-center">
            {{-- Focused width for administrative forms --}}
            <div class="col-xl-7 col-lg-9 col-md-10">

                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    {{-- Vibrant Gradient Header --}}
                    <div class="card-header border-0 py-4 px-4 d-flex justify-content-between align-items-center"
                         style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);">
                        <div>
                            <h4 class="mb-1 text-white fw-bold">
                                <i class="bi {{ isset($entity) ? 'bi-pencil-square' : 'bi-plus-circle-dotted' }} me-2"></i>
                                {{ isset($entity) ? "Modifier l'Entité" : 'Nouvelle Entité' }}
                            </h4>
                            <p class="text-white text-opacity-75 mb-0 small">
                                {{ isset($entity) ? "Mise à jour des paramètres de l'unité administrative" : "Définition d'une nouvelle composante de la structure" }}
                            </p>
                        </div>

                        <a href="{{ route('entities.index') }}" class="btn btn-white btn-sm rounded-pill px-3 fw-bold shadow-sm transition-base">
                            <i class="bi bi-arrow-left me-1"></i>
                            Retour
                        </a>
                    </div>

                    <div class="card-body bg-white p-4 p-md-5">
                        <form
                            action="{{ isset($entity) ? route('entities.update', $entity->id) : route('entities.store') }}"
                            method="POST"
                            class="needs-validation"
                            novalidate
                        >
                            @csrf

                            {{-- Section 1: Identity --}}
                            <div class="mb-4">
                                <label for="title" class="form-label small fw-bold text-uppercase text-muted ls-1">
                                    Désignation de l'Entité <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-lg border rounded-3 overflow-hidden shadow-sm transition-base">
                                    <span class="input-group-text bg-white border-0"><i class="bi bi-tag-fill text-primary"></i></span>
                                    <input
                                        type="text"
                                        id="title"
                                        name="title"
                                        value="{{ old('title', $entity->title ?? '') }}"
                                        class="form-control border-0 bg-white shadow-none @error('title') is-invalid @enderror"
                                        placeholder="Ex: Direction des Ressources Humaines"
                                        required
                                    >
                                </div>
                                @error('title')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Section 2: Classification Block --}}
                            <div class="bg-light-subtle rounded-4 p-4 mb-5 border border-light-subtle shadow-xs">
                                <h6 class="fw-bold text-dark mb-3 small text-uppercase ls-1">Classement & Rattachement</h6>

                                <div class="row g-4">
                                    {{-- Catégorie --}}
                                    <div class="col-md-6">
                                        <label for="type_id" class="form-label small fw-bold text-muted">Catégorie d'entité</label>
                                        <select
                                            id="type_id"
                                            name="type_id"
                                            class="form-select border-0 bg-white shadow-sm rounded-3 py-2 @error('type_id') is-invalid @enderror"
                                            required
                                        >
                                            <option value="">Choisir un type...</option>
                                            @foreach($types as $type)
                                                <option value="{{ $type->id }}"
                                                    {{ (isset($entity) && $type->id == $entity->type_id) || old('type_id') == $entity->id ? 'selected' : '' }}
                                                >
                                                    {{ $type->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('type_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Service --}}
                                    <div class="col-md-6">
                                        <label for="service_id" class="form-label small fw-bold text-muted">Service de tutelle</label>
                                        <select
                                            id="service_id"
                                            name="service_id"
                                            class="form-select border-0 bg-white shadow-sm rounded-3 py-2 @error('service_id') is-invalid @enderror"
                                            required
                                        >
                                            <option value="">Choisir le service...</option>
                                            @foreach($services as $service)
                                                <option value="{{ $service->id }}"
                                                    {{ (isset($entity) && $service->id == $entity->service_id) || old('service_id') == $service->id ? 'selected' : '' }}
                                                >
                                                    {{ $service->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('service_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="d-flex flex-column flex-md-row justify-content-end gap-3 pt-4 border-top">
                                <button type="reset" class="btn btn-light btn-rounded px-4 fw-semibold text-muted order-2 order-md-1">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i> Annuler
                                </button>
                                <button type="submit" class="btn btn-primary btn-rounded px-5 fw-bold shadow-sm order-1 order-md-2">
                                    <i class="bi bi-save me-2"></i>
                                    {{ isset($entity) ? 'Mettre à jour l\'entité' : 'Enregistrer l\'entité' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Security/Info Footer --}}
                <div class="text-center mt-4 opacity-50 small">
                    <p><i class="bi bi-lock-fill me-1"></i> Accès sécurisé au registre organisationnel</p>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .transition-base { transition: all 0.2s ease-in-out; }
            .bg-light-subtle { background-color: #f9fafb !important; }
            .btn-white { background: #fff; color: #4f46e5; border: none; }
            .btn-white:hover { background: #f0f4ff; color: #3730a3; }
            .btn-rounded { border-radius: 50px; }
            .ls-1 { letter-spacing: 0.5px; }
            .shadow-xs { box-shadow: 0 2px 4px rgba(0,0,0,0.03); }

            /* Premium Input Focus States */
            .form-select:focus, .input-group:focus-within {
                border: 1px solid #4f46e5 !important;
                box-shadow: 0 0 0 0.25rem rgba(79, 70, 229, 0.1) !important;
            }
            .form-control:focus {
                box-shadow: none !important;
            }
        </style>
    @endpush
</x-layout>
