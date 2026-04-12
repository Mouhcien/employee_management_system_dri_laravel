<x-layout>
    <style>
        :root {
            --bs-primary: #2563eb;
            --bs-primary-rgb: 37, 99, 235;
        }
        body { background-color: #f1f5f9; color: #334155; }

        /* Modern Card Styling */
        .card { border: none; border-radius: 1rem; transition: box-shadow 0.3s ease; }
        .card-header { background-color: transparent; border-bottom: 1px solid #e2e8f0; padding: 1.5rem 2rem; }

        /* Section Dividers */
        .section-title {
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.05rem;
            color: var(--bs-primary);
            display: flex;
            align-items: center;
            margin: 2.5rem 0 1.5rem 0;
        }
        .section-title::after { content: ""; flex: 1; height: 1px; background: #e2e8f0; margin-left: 1rem; }
        .section-title:first-of-type { margin-top: 0; }

        /* Form Controls */
        .form-label { font-weight: 500; color: #475569; margin-bottom: 0.5rem; }
        .form-control, .form-select {
            padding: 0.6rem 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            transition: all 0.2s ease-in-out;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--bs-primary);
            box-shadow: 0 0 0 4px rgba(var(--bs-primary-rgb), 0.1);
        }

        /* Search Input Group */
        .search-group .input-group-text {
            background-color: #fff;
            border-right: none;
            color: #94a3b8;
            border-radius: 0.5rem 0 0 0.5rem;
        }
        .search-group .form-control { border-left: none; }

        /* Buttons */
        .btn-primary { background-color: var(--bs-primary); border: none; border-radius: 0.5rem; padding: 0.6rem 1.5rem; }
        .btn-primary:hover { background-color: #1d4ed8; transform: translateY(-1px); }
        .btn-light { background-color: #fff; border: 1px solid #e2e8f0; border-radius: 0.5rem; }
    </style>

    <div class="container py-5">
        {{-- Page Header --}}
        <div class="row mb-4">
            <div class="col-md-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Ressources Humaines</a></li>
                        @if (is_null($demand))
                            <li class="breadcrumb-item active">Nouvelle Demande</li>
                        @else
                            <li class="breadcrumb-item active">Mettre à jour la demande</li>
                        @endif
                    </ol>
                </nav>
                <h1 class="h3 fw-bold text-dark">
                    @if (is_null($demand))
                        <i class="bi bi-person-plus me-2 text-primary">
                        </i>Nouvelle Demande <span class="text-muted fw-normal small">Personnel</span>
                    @else
                        <i class="bi bi-pencil-square me-2 text-primary">
                        </i>Mettre à jour la demande
                    @endif
                </h1>
            </div>
            <div class="col-md-4 text-md-end align-self-end">
                <a href="{{ route('demands.index') }}" class="btn btn-light btn-sm px-3 shadow-sm">
                    <i class="bi bi-arrow-left me-1"></i> Retour à la liste
                </a>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4 p-lg-5">
                <form action="{{ is_null($demand) ? route('demands.store') : route('demands.update', $demand) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Section 1: Agent --}}
                    <div class="section-title fw-bold">
                        <i class="bi bi-person-badge me-2"></i>Identification de l'Agent
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="txt_employee_mutation" class="form-label">Rechercher un agent</label>
                            <div class="input-group search-group shadow-sm">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <input type="text" id="txt_employee_mutation" class="form-control" placeholder="Nom, prénom ou matricule..."
                                       value="{{ is_null($demand) ? '' : $demand->employee->lastname }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="employee_id" class="form-label text-danger-emphasis">Agent à muter *</label>
                            <select name="employee_id" id="employee_id" class="form-select shadow-sm" required>
                                <option value="" selected disabled>Sélectionner l'agent...</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}" data-full-name="{{ strtolower($employee->lastname . ' ' . $employee->firstname) }}"
                                    {{ !is_null($demand) && $demand->employee_id == $employee->id ? 'selected' : '' }}>
                                        {{ strtoupper($employee->lastname) }} {{ $employee->firstname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Section 2: Details --}}
                    <div class="section-title fw-bold">
                        <i class="bi bi-info-circle me-2"></i>Détails de la demande
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">Entité d'accueil / Titre</label>
                            <input type="text" name="title" class="form-control" placeholder="ex: Direction Financière"
                            value="{{ is_null($demand) ? '' : $demand->title }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Type de demande</label>
                            <select name="type" class="form-select">
                                <option value="M" {{ !is_null($demand) && $demand->type == 'M' ? 'selected' : '' }}>🔄 Mutation</option>
                                <option value="C" {{ !is_null($demand) && $demand->type == 'C' ? 'selected' : '' }}>📅 Congé</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Objet / Motifs</label>
                            <textarea name="object" class="form-control" rows="3" placeholder="Description détaillée...">{{ is_null($demand) ? '' : $demand->object }}</textarea>
                        </div>
                    </div>

                    {{-- Section 3: Timeline & Files --}}
                    <div class="section-title fw-bold">
                        <i class="bi bi-paperclip me-2"></i>Pièces jointes & Dates
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">Date de demande</label>
                            <x-date-input name="demand_date" id="starting_date" value="{{ is_null($demand) ? '' : $demand->demand_date }}" />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Document justificatif (PDF, JPG)</label>
                            <div class="input-group">
                                <input type="file" name="file" class="form-control" id="inputGroupFile02">
                                <label class="input-group-text" for="inputGroupFile02 px-3"><i class="bi bi-upload"></i></label>
                            </div>
                            @if (!is_null($demand))
                                <a href="{{ Storage::url($demand->file) }}" target="_blank" class="text-decoration-none" >Copie de la demande</a>
                            @endif
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="d-flex justify-content-end gap-3 mt-5 pt-4 border-top">
                        <button type="reset" class="btn btn-light px-4 fw-medium text-muted">Réinitialiser</button>
                        <button type="submit" class="btn btn-primary px-5 fw-bold shadow">
                            <i class="bi bi-check2-circle me-1"></i> Enregistrer la demande
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('txt_employee_mutation');
            const employeeSelect = document.getElementById('employee_id');
            const originalOptions = Array.from(employeeSelect.options);

            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase().trim();
                employeeSelect.innerHTML = '';

                const filteredOptions = originalOptions.filter(option => {
                    if (option.disabled) return true;
                    const fullName = option.getAttribute('data-full-name');
                    return fullName.includes(searchTerm);
                });

                filteredOptions.forEach(option => employeeSelect.add(option));
            });
        });
    </script>
</x-layout>
