<x-layout>
    @section('title', isset($temp) ? "Modifier l'Intérim" : "Nouvelle Nomination par Intérim")

    <div class="container py-5 px-md-5">
        <div class="row justify-content-center">
            <div class="col-xl-11 col-lg-12">

                <div class="card border-0 shadow-2xl rounded-5 overflow-hidden bg-white">
                    {{-- Header Aero-Dynamique --}}
                    <div class="card-header border-0 py-4 px-4 p-md-5 d-flex justify-content-between align-items-center"
                         style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);">
                        <div>
                            <nav aria-label="breadcrumb" class="mb-2">
                                <ol class="breadcrumb mb-0 extra-small text-uppercase fw-bold ls-1">
                                    <li class="breadcrumb-item"><a href="{{ route('temps.index') }}" class="text-white text-opacity-75 text-decoration-none">Gouvernance</a></li>
                                    <li class="breadcrumb-item active text-white" aria-current="page">{{ isset($temp) ? 'Update Interim' : 'System Initialize' }}</li>
                                </ol>
                            </nav>
                            <h3 class="mb-0 text-white fw-bold">
                                <i class="bi {{ isset($temp) ? 'bi-cpu-fill' : 'bi-person-plus-fill' }} me-2"></i>
                                {{ isset($temp) ? "Révision de l'Intérim" : "Nomination Chef par Intérim" }}
                            </h3>
                        </div>

                        <a href="{{ route('temps.index') }}" class="btn btn-glass-light btn-rounded px-4 fw-bold shadow-sm transition-base">
                            <i class="bi bi-x-lg me-1"></i> Annuler
                        </a>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <form
                            action="{{ isset($temp) ? route('temps.update', $temp->id) : route('temps.store') }}"
                            method="POST"
                            class="needs-validation"
                            novalidate
                            enctype="multipart/form-data"
                        >
                            @csrf

                            <div class="row g-5">
                                {{-- Colonne 1 : Acteurs du Node --}}
                                <div class="col-lg-6">
                                    <h6 class="fw-bold text-dark mb-4 small text-uppercase ls-1 d-flex align-items-center">
                                        <i class="bi bi-people-fill me-2 text-primary"></i> Configuration des Acteurs
                                    </h6>

                                    {{-- Sélection Employé --}}
                                    <div class="mb-4">
                                        <label for="employee_id" class="input-label">Employé à Nommer</label>
                                        <div class="input-group-futurist search-node mb-2">
                                            <input type="text" id="employee_search" class="form-control futurist-input"
                                                   placeholder="Rechercher par nom ou PPR..." onkeyup="filterEmployees()">
                                            <i class="bi bi-search input-icon"></i>
                                        </div>
                                        <div class="input-group-futurist">
                                            <select class="form-select futurist-input select-custom" name="employee_id" id="employee_id" required>
                                                <option value="" disabled selected>Sélectionner le profil...</option>
                                                @foreach($employees->sortBy('lastname') as $employee)
                                                    <option value="{{ $employee->id }}"
                                                        {{ (isset($temp) && $employee->id == $temp->employee_id) ? 'selected' : '' }}>
                                                        {{ strtoupper($employee->lastname) }} {{ $employee->firstname }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <i class="bi bi-person-badge input-icon"></i>
                                        </div>
                                    </div>

                                    {{-- Sélection Responsable Cible --}}
                                    <div class="mb-4">
                                        <label for="chef_id" class="input-label">Poste à Remplacer (Chef titulaire)</label>
                                        <div class="input-group-futurist search-node mb-2">
                                            <input type="text" id="chef_search" class="form-control futurist-input"
                                                   placeholder="Filtrer le responsable..." onkeyup="filterChefs()">
                                            <i class="bi bi-funnel input-icon"></i>
                                        </div>
                                        <div class="input-group-futurist">
                                            <select class="form-select futurist-input select-custom" name="chef_id" id="chef_id" required>
                                                <option value="" disabled selected>Cibler le poste...</option>
                                                @foreach($chefs->sortBy(fn($chef) => $chef->employee->lastname ?? '') as $chef)
                                                    @if($chef->employee)
                                                        <option value="{{ $chef->id }}"
                                                            {{ (isset($temp) && $chef->id == $temp->chef_id) ? 'selected' : '' }}>
                                                            {{ strtoupper($chef->employee->lastname) }} {{ $chef->employee->firstname }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <i class="bi bi-shield-shaded input-icon"></i>
                                        </div>
                                    </div>
                                </div>

                                {{-- Colonne 2 : Données Logistiques --}}
                                <div class="col-lg-6">
                                    <h6 class="fw-bold text-dark mb-4 small text-uppercase ls-1 d-flex align-items-center">
                                        <i class="bi bi-calendar-range me-2 text-primary"></i> Paramètres Temporels & Actes
                                    </h6>

                                    <div class="row g-3">
                                        <div class="col-md-6 mb-4">
                                            <label for="starting_date" class="input-label">Prise de Fonction</label>
                                            <div class="input-group-futurist">
                                                <x-date-input id="starting_date" name="starting_date"
                                                              class="form-control futurist-input"
                                                              value="{{ isset($temp) && $temp->starting_date ? $temp->starting_date : '' }}" required />
                                                <i class="bi bi-play-circle input-icon"></i>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-4">
                                            <label for="finished_date" class="input-label">Fin d'Intérim</label>
                                            <div class="input-group-futurist">
                                                <x-date-input id="finished_date" name="finished_date"
                                                              class="form-control futurist-input"
                                                              value="{{ isset($temp) && $temp->finished_date ? $temp->finished_date : '' }}" />
                                                <i class="bi bi-stop-circle input-icon"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="decision_file" class="input-label">Acte de Nomination (PDF)</label>
                                        <div class="input-group-futurist dark-file">
                                            <input type="file" name="decision_file" class="form-control futurist-input"
                                                   id="decision_file" accept=".pdf" {{ isset($temp) ? '' : 'required' }}>
                                            <i class="bi bi-file-earmark-pdf-fill input-icon text-danger"></i>
                                        </div>
                                        <div class="form-text extra-small mt-3 d-flex align-items-center">
                                            <i class="bi bi-info-circle-fill me-2 text-primary"></i>
                                            L'archive doit être au format PDF numérisé haute définition.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Actions de Validation --}}
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 pt-5 mt-4 border-top border-light">
                                <button type="reset" class="btn btn-link text-decoration-none text-muted fw-bold extra-small text-uppercase ls-1">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i> Réinitialiser
                                </button>

                                <button type="submit" class="btn btn-futurist px-5 py-3 rounded-pill fw-bold shadow-lg transition-base">
                                    <i class="bi bi-shield-check me-2"></i>
                                    {{ isset($temp) ? 'Mettre à jour le Registre' : 'Valider la Nomination' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Sécurité --}}
                <div class="text-center mt-5 opacity-50">
                    <p class="extra-small fw-bold text-uppercase ls-1">
                        <i class="bi bi-cpu-fill me-1 text-primary"></i> Gouvernance v4.0 - Système d'Intégrité RH
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function filterEmployees() {
            const input = document.getElementById('employee_search');
            const filter = input.value.toLowerCase();
            const select = document.getElementById('employee_id');
            const options = select.getElementsByTagName('option');
            for (let i = 1; i < options.length; i++) {
                const txtValue = options[i].textContent || options[i].innerText;
                options[i].style.display = txtValue.toLowerCase().indexOf(filter) > -1 ? "" : "none";
            }
        }

        function filterChefs() {
            const input = document.getElementById('chef_search');
            const filter = input.value.toLowerCase();
            const select = document.getElementById('chef_id');
            const options = select.getElementsByTagName('option');
            for (let i = 1; i < options.length; i++) {
                const text = options[i].textContent || options[i].innerText;
                options[i].style.display = text.toLowerCase().indexOf(filter) > -1 ? "" : "none";
            }
        }
    </script>

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

        .btn-futurist {
            background: var(--primary-gradient);
            color: white; border: none;
            box-shadow: 0 10px 20px -5px rgba(79, 70, 229, 0.4);
        }
        .btn-futurist:hover { transform: translateY(-3px); filter: brightness(1.1); box-shadow: 0 15px 30px -5px rgba(79, 70, 229, 0.5); }

        /* Futurist Inputs */
        .input-label {
            font-size: 0.72rem; font-weight: 800; text-transform: uppercase;
            letter-spacing: 0.05em; color: #64748b; margin-bottom: 0.75rem; display: block;
        }

        .input-group-futurist { position: relative; }
        .futurist-input {
            background-color: #f1f5f9 !important;
            border: 2px solid transparent !important;
            padding: 12px 16px 12px 48px !important;
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
            font-size: 1.1rem; z-index: 10;
        }

        .search-node .futurist-input {
            background-color: #fff !important;
            border: 1px dashed #cbd5e1 !important;
            font-size: 0.85rem; padding: 8px 12px 8px 40px !important;
        }

        .transition-base { transition: all 0.25s ease; }
        .shadow-2xl { box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.12); }
        .ls-1 { letter-spacing: 0.05em; }
        .extra-small { font-size: 0.7rem; }
    </style>
</x-layout>
