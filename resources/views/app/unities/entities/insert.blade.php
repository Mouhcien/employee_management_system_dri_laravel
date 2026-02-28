<x-layout>
    <div class="container py-5">
        <div class="row justify-content-center">
            {{-- Wider card: 9/12 on lg, 8/12 on md --}}
            <div class="col-lg-9 col-md-8">

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header border-0 rounded-top-4
                        text-white d-flex justify-content-between align-items-center"
                         style="background: linear-gradient(135deg,#4f46e5,#7c3aed);">
                        <h4 class="mb-0">
                            {{ isset($entity) ? "Modifier l'entité ".$entity->title : 'Nouvelle entité' }}
                        </h4>

                        <a href="{{ route('entities.index') }}" class="btn btn-sm btn-light text-primary">
                            <i class="bi bi-arrow-left-circle me-1"></i>
                            Retour
                        </a>
                    </div>


                    <div class="card-body bg-light p-4">
                        <form
                            action="{{ isset($entity) ? route('entities.update', $entity->id) : route('entities.store') }}"
                            method="POST"
                            class="needs-validation"
                            novalidate
                        >
                            @csrf

                            {{-- Entité --}}
                            <div class="mb-4">
                                <label for="title" class="form-label fw-semibold">
                                    Entité
                                </label>
                                <input
                                    type="text"
                                    id="title"
                                    name="title"
                                    value="{{ old('title', $entity->title ?? '') }}"
                                    class="form-control form-control-lg rounded-3 @error('title') is-invalid @enderror"
                                    placeholder="Saisissez le nom de l'entité"
                                    required
                                >
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Catégorie --}}
                            <div class="mb-4">
                                <label for="type_id" class="form-label fw-semibold">
                                    Catégorie
                                </label>
                                <select
                                    id="type_id"
                                    name="type_id"
                                    class="form-select form-select-lg rounded-3 @error('type_id') is-invalid @enderror"
                                    required
                                >
                                    <option value="">
                                        Séléctionnez la catégorie d'entité
                                    </option>
                                    @foreach($types as $type)
                                        <option
                                            value="{{ $type->id }}"
                                            {{ isset($entity) && $type->id == $entity->type_id ? 'selected' : (old('type_id') == $type->id ? 'selected' : '') }}
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
                            <div class="mb-5">
                                <label for="service_id" class="form-label fw-semibold">
                                    Service
                                </label>
                                <select
                                    id="service_id"
                                    name="service_id"
                                    class="form-select form-select-lg rounded-3 @error('service_id') is-invalid @enderror"
                                    required
                                >
                                    <option value="">
                                        Séléctionnez le service d'entité
                                    </option>
                                    @foreach($services as $service)
                                        <option
                                            value="{{ $service->id }}"
                                            {{ isset($entity) && $service->id == $entity->service_id ? 'selected' : (old('service_id') == $service->id ? 'selected' : '') }}
                                        >
                                            {{ $service->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('service_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Actions --}}
                            <div class="d-flex justify-content-end gap-3 border-top pt-4">
                                <button type="reset" class="btn btn-outline-secondary btn-lg rounded-3">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i>
                                    Annuler
                                </button>

                                <button type="submit" class="btn btn-primary btn-lg rounded-3">
                                    <i class="bi bi-save me-1"></i>
                                    {{ isset($entity) ? 'Mettre à jour' : 'Enregistrer' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-layout>
