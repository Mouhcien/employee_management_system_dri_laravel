<x-layout>
    @section('title', isset($section) ? "Modifier la Section" : "Nouvelle Section")

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
                                <i class="bi {{ isset($section) ? 'bi-pencil-square' : 'bi-plus-circle-dotted' }} me-2"></i>
                                {{ isset($section) ? "Modifier la Section" : "Nouvelle Section" }}
                            </h4>
                            <p class="text-white text-opacity-75 mb-0 small">
                                {{ isset($section) ? "Mise à jour de l'unité opérationnelle" : "Création d'une nouvelle unité terminale" }}
                            </p>
                        </div>

                        <a href="{{ route('sections.index') }}" class="btn btn-white btn-sm rounded-pill px-3 fw-bold shadow-sm transition-base">
                            <i class="bi bi-arrow-left me-1"></i>
                            Retour
                        </a>
                    </div>

                    <div class="card-body bg-white p-4 p-md-5">
                        <form
                            action="{{ isset($section) ? route('sections.update', $section->id) : route('sections.store') }}"
                            method="POST"
                            class="needs-validation"
                            novalidate
                        >
                            @csrf

                            {{-- Hierarchy Block --}}
                            <div class="bg-light-subtle rounded-4 p-4 mb-4 border border-light-subtle">
                                <h6 class="fw-bold text-dark mb-3 small text-uppercase ls-1">Rattachement Organisationnel</h6>

                                <div class="row g-3">
                                    {{-- Service Selection --}}
                                    <div class="col-md-6">
                                        <label for="sect_service_id" class="form-label small fw-bold text-muted">Service Parent</label>
                                        <select
                                            id="sect_service_id"
                                            name="service_id"
                                            class="form-select border-0 bg-white shadow-sm rounded-3 py-2 @error('service_id') is-invalid @enderror"
                                            {{ isset($section) ? 'ident='.$section->id : '' }}
                                            {{ isset($section) ? 'opt=edit' : 'opt=create' }}
                                            required
                                        >
                                            <option value="">Choisir un service...</option>
                                            @foreach($services as $service)
                                                <option value="{{ $service->id }}"
                                                    {{ (isset($section) && $service->id == $section->entity->service_id) || (isset($service_id) && $service->id == $service_id) || old('service_id') == $service->id ? 'selected' : '' }}
                                                >
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
                                        <label for="entity_id" class="form-label small fw-bold text-muted">Entité Directe</label>
                                        <select
                                            id="entity_id"
                                            name="entity_id"
                                            class="form-select border-0 bg-white shadow-sm rounded-3 py-2 @error('entity_id') is-invalid @enderror"
                                            required
                                        >
                                            <option value="">Choisir l'entité...</option>
                                            @foreach($entities as $entity)
                                                <option value="{{ $entity->id }}"
                                                    {{ (isset($section) && $entity->id == $section->entity_id) || old('entity_id') == $entity->id ? 'selected' : '' }}
                                                >
                                                    {{ $entity->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('entity_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Section Identity --}}
                            <div class="mb-5">
                                <label for="title" class="form-label small fw-bold text-uppercase text-muted ls-1">Désignation de la Section</label>
                                <div class="input-group input-group-lg border rounded-3 overflow-hidden shadow-sm transition-base">
                                    <span class="input-group-text bg-white border-0"><i class="bi bi-grid-fill text-primary"></i></span>
                                    <input
                                        type="text"
                                        id="title"
                                        name="title"
                                        value="{{ old('title', $section->title ?? '') }}"
                                        class="form-control border-0 bg-white shadow-none @error('title') is-invalid @enderror"
                                        placeholder="Saisissez le nom de la section..."
                                        required
                                    >
                                </div>
                                @error('title')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                <div class="form-text mt-2 small">
                                    <i class="bi bi-info-circle me-1"></i> La section est le niveau terminal de votre structure organisationnelle.
                                </div>
                            </div>

                            {{-- Form Actions --}}
                            <div class="d-flex flex-column flex-md-row justify-content-end gap-3 pt-4 border-top">
                                <button type="reset" class="btn btn-light btn-rounded px-4 fw-semibold text-muted order-2 order-md-1">
                                    <i class="bi bi-x-circle me-1"></i> Annuler
                                </button>
                                <button type="submit" class="btn btn-primary btn-rounded px-5 fw-bold shadow-sm order-1 order-md-2">
                                    <i class="bi bi-check-lg me-1"></i>
                                    {{ isset($section) ? 'Mettre à jour' : 'Enregistrer la section' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Security/Info Badge --}}
                <div class="text-center mt-4 opacity-50 small">
                    <p><i class="bi bi-shield-check me-1"></i> Validation des données RH active</p>
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
