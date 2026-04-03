<x-layout>
    @section('title', isset($section) ? "Modifier la Section" : "Nouvelle Section")

    <div class="container py-5 px-md-5">
        <div class="row justify-content-center">
            {{-- Professional Centered Framework --}}
            <div class="col-xl-7 col-lg-9">

                <div class="card border-0 shadow-2xl rounded-5 overflow-hidden bg-white">
                    {{-- Futurist Gradient Header --}}
                    <div class="card-header border-0 py-4 px-4 p-md-5 d-flex justify-content-between align-items-center"
                         style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);">
                        <div>
                            <nav aria-label="breadcrumb" class="mb-2">
                                <ol class="breadcrumb mb-0 extra-small text-uppercase fw-bold ls-1">
                                    <li class="breadcrumb-item"><a href="{{ route('sections.index') }}" class="text-white text-opacity-75 text-decoration-none">Architecture</a></li>
                                    <li class="breadcrumb-item active text-white" aria-current="page">{{ isset($section) ? 'Update Terminal' : 'Initialize Node' }}</li>
                                </ol>
                            </nav>
                            <h3 class="mb-0 text-white fw-bold">
                                <i class="bi {{ isset($section) ? 'bi-cpu-fill' : 'bi-plus-square-fill' }} me-2"></i>
                                {{ isset($section) ? "Modifier la Section" : "Nouvelle Section" }}
                            </h3>
                        </div>

                        <a href="{{ route('sections.index') }}" class="btn btn-glass-light btn-rounded px-4 fw-bold shadow-sm transition-base">
                            <i class="bi bi-x-lg me-1"></i> Annuler
                        </a>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <form
                            action="{{ isset($section) ? route('sections.update', $section->id) : route('sections.store') }}"
                            method="POST"
                            class="needs-validation"
                            novalidate
                        >
                            @csrf

                            {{-- Module 1: Parent Hub Metadata --}}
                            <div class="bg-light-subtle rounded-5 p-4 p-md-5 mb-5 border border-light shadow-inner">
                                <h6 class="fw-bold text-dark mb-4 small text-uppercase ls-1 d-flex align-items-center">
                                    <i class="bi bi-diagram-3-fill me-2 text-primary"></i>Ligne Hiérarchique
                                </h6>

                                <div class="row g-4">
                                    {{-- Service Hub Selection --}}
                                    <div class="col-md-6">
                                        <label for="sect_service_id" class="input-label">Service Racine</label>
                                        <div class="input-group-futurist">
                                            <select
                                                name="service_id"
                                                class="form-select futurist-input @error('service_id') is-invalid @enderror"
                                                {{ isset($section) ? 'ident='.$section->id : '' }}
                                                required
                                            >
                                                <option value="" disabled selected>Service...</option>
                                                @foreach($services as $service)
                                                    <option value="{{ $service->id }}"
                                                        {{ (isset($section) && $service->id == $section->entity->service_id) || (isset($service_id) && $service->id == $service_id) || old('service_id') == $service->id ? 'selected' : '' }}
                                                    >
                                                        {{ $service->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <i class="bi bi-diagram-3 input-icon"></i>
                                        </div>
                                    </div>

                                    {{-- Entity Segment Selection --}}
                                    <div class="col-md-6">
                                        <label for="entity_id" class="input-label">Entité Parente</label>
                                        <div class="input-group-futurist">
                                            <select name="entity_id" class="form-select futurist-input @error('entity_id') is-invalid @enderror" required>
                                                <option value="" disabled selected>Entité...</option>
                                                @foreach($entities as $entity)
                                                    <option value="{{ $entity->id }}"
                                                        {{ (isset($section) && $entity->id == $section->entity_id) || old('entity_id') == $entity->id ? 'selected' : '' }}
                                                    >
                                                        {{ $entity->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <i class="bi bi-diagram-2 input-icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Module 2: Terminal Identification --}}
                            <div class="mb-5">
                                <label for="title" class="input-label">Désignation de la Section</label>
                                <div class="input-group-futurist">
                                    <input
                                        type="text"
                                        id="title"
                                        name="title"
                                        value="{{ old('title', $section->title ?? '') }}"
                                        class="form-control futurist-input @error('title') is-invalid @enderror"
                                        placeholder="Ex: Section Maintenance Réseau"
                                        required
                                    >
                                    <i class="bi bi-grid-fill input-icon"></i>
                                </div>
                                @error('title')
                                <div class="text-danger extra-small mt-2 fw-bold"><i class="bi bi-exclamation-triangle me-1"></i>{{ $message }}</div>
                                @enderror
                                <div class="form-text mt-3 extra-small text-muted d-flex align-items-center">
                                    <i class="bi bi-info-circle-fill me-2 text-primary"></i>
                                    La section constitue l'unité opérationnelle terminale du système.
                                </div>
                            </div>

                            {{-- Futurist Action Bar --}}
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 pt-5 border-top border-light">
                                <button type="reset" class="btn btn-link text-decoration-none text-muted fw-bold extra-small text-uppercase ls-1">
                                    <i class="bi bi-eraser-fill me-1"></i> Réinitialiser
                                </button>

                                <button type="submit" class="btn btn-futurist px-5 py-3 rounded-pill fw-bold shadow-lg transition-base">
                                    <i class="bi bi-shield-check me-2"></i>
                                    {{ isset($section) ? 'Mettre à jour la Section' : 'Enregistrer la Section' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Integrity Footer --}}
                <div class="text-center mt-5 opacity-50">
                    <p class="extra-small fw-bold text-uppercase ls-1">
                        <i class="bi bi-cpu-fill me-1 text-primary"></i> RH Architecture Integrity System v4.0
                    </p>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            :root {
                --primary-gradient: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
                --accent-glow: rgba(99, 102, 241, 0.15);
            }

            body { background-color: #f8fafc; }

            .btn-glass-light {
                background: rgba(255, 255, 255, 0.15);
                color: white; border: 1px solid rgba(255, 255, 255, 0.3);
                backdrop-filter: blur(5px);
            }
            .btn-glass-light:hover { background: rgba(255, 255, 255, 0.25); color: white; transform: translateY(-2px); }

            .btn-futurist {
                background: var(--primary-gradient);
                color: white; border: none;
                box-shadow: 0 10px 20px -5px rgba(79, 70, 229, 0.4);
            }
            .btn-futurist:hover { color: white; transform: translateY(-3px); filter: brightness(1.1); box-shadow: 0 15px 30px -5px rgba(79, 70, 229, 0.5); }

            /* Futurist Inputs */
            .input-label {
                font-size: 0.75rem; font-weight: 800; text-transform: uppercase;
                letter-spacing: 0.05em; color: #64748b; margin-bottom: 0.75rem; display: block;
            }

            .input-group-futurist { position: relative; }
            .futurist-input {
                background-color: #f1f5f9 !important;
                border: 2px solid transparent !important;
                padding: 14px 16px 14px 48px !important;
                border-radius: 16px !important;
                font-weight: 600; color: #1e293b; transition: all 0.3s ease;
            }
            .futurist-input:focus {
                background-color: #fff !important;
                border-color: #6366f1 !important;
                box-shadow: 0 0 0 5px var(--accent-glow) !important;
            }
            .input-icon {
                position: absolute; left: 18px; top: 50%;
                transform: translateY(-50%); color: #6366f1;
                font-size: 1.2rem; z-index: 10;
            }

            .transition-base { transition: all 0.25s ease; }
            .shadow-2xl { box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.12); }
            .shadow-inner { box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.05); }
            .ls-1 { letter-spacing: 0.05em; }
            .extra-small { font-size: 0.7rem; }
            .btn-rounded { border-radius: 50px; }
        </style>
    @endpush
</x-layout>
