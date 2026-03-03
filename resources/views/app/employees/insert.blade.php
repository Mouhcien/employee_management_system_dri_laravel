<x-layout>

    <form action="{{ isset($employee) ? route('employees.update', $employee->id) : route('employees.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">

            {{-- Informations personnelles --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header text-white d-flex align-items-center justify-content-between"
                         style="background: linear-gradient(135deg,#4f46e5,#7c3aed);">
                        <span class="fw-semibold">Informations personnelles</span>
                        <span class="badge bg-light text-primary">Employé</span>
                    </div>

                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">PPR</label>
                                <input type="text"
                                       name="ppr"
                                       class="form-control"
                                       value="{{ old('ppr', $employee->ppr ?? '') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">CIN</label>
                                <input type="text"
                                       name="cin"
                                       class="form-control"
                                       value="{{ old('cin', $employee->cin ?? '') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nom</label>
                                <input type="text"
                                       name="lastname"
                                       class="form-control"
                                       value="{{ old('lastname', $employee->lastname ?? '') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label float-end">الاسم العائلي</label>
                                <input type="text"
                                       name="lastname_arab"
                                       class="form-control text-end"
                                       value="{{ old('lastname_arab', $employee->lastname_arab ?? '') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Prénom</label>
                                <input type="text"
                                       name="firstname"
                                       class="form-control"
                                       value="{{ old('firstname', $employee->firstname ?? '') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label float-end">الاسم الشخصي</label>
                                <input type="text"
                                       name="firstname_arab"
                                       class="form-control text-end"
                                       value="{{ old('firstname_arab', $employee->firstname_arab ?? '') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Date de naissance</label>
                                <x-date-input id="birth_date"
                                              name="birth_date"
                                              value="{{ old('birth_date', $employee->birth_date ?? '') }}" />
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Ville de naissance</label>
                                <input type="text"
                                       name="birth_city"
                                       class="form-control"
                                       value="{{ old('birth_city', $employee->birth_city ?? '') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Sexe</label>
                                <select class="form-select" name="gender">
                                    <option value="">Sélectionnez</option>
                                    <option value="M" {{ old('gender', $employee->gender ?? '') === 'M' ? 'selected' : '' }}>Homme</option>
                                    <option value="F" {{ old('gender', $employee->gender ?? '') === 'F' ? 'selected' : '' }}>Femme</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Situation familiale</label>
                                <select class="form-select" name="family_status">
                                    <option value="">Sélectionnez</option>
                                    <option value="C" {{ old('family_status', $employee->family_status ?? '') === 'C' ? 'selected' : '' }}>Célibataire</option>
                                    <option value="M" {{ old('family_status', $employee->family_status ?? '') === 'M' ? 'selected' : '' }}>Marié</option>
                                    <option value="D" {{ old('family_status', $employee->family_status ?? '') === 'D' ? 'selected' : '' }}>Divorcé</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Photo + preview --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white fw-semibold">
                        Photo
                    </div>
                    <div class="card-body d-flex flex-column align-items-center justify-content-center text-center">

                        {{-- Image réelle / preview --}}
                        <img
                            id="photoPreview"
                            src="{{ !empty($employee?->photo) ? $employee->photo : '' }}"
                            alt="Photo employé"
                            class="rounded-circle mb-3 {{ empty($employee?->photo) ? 'd-none' : '' }}"
                            style="width: 140px; height: 140px; object-fit: cover;"
                        >

                        {{-- Placeholder cercle si pas de photo --}}
                        <div id="photoPlaceholder"
                             class="rounded-circle bg-light d-flex align-items-center justify-content-center mb-3
                            {{ !empty($employee?->photo) ? 'd-none' : '' }}"
                             style="width: 140px; height: 140px;">
                            <i class="bi bi-person fs-1 text-secondary"></i>
                        </div>

                        <input type="file"
                               id="photoInput"
                               name="photo"
                               class="form-control"
                               accept="image/*">
                        <small class="text-muted mt-2">
                            Formats acceptés : JPG, PNG. Taille max. 2 Mo.
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-1">

            {{-- Contact --}}
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-info text-white fw-semibold">
                        Informations de contact
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Téléphone</label>
                                <input type="tel"
                                       name="tel"
                                       class="form-control"
                                       value="{{ old('tel', $employee->tel ?? '') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email"
                                       name="email"
                                       class="form-control"
                                       value="{{ old('email', $employee->email ?? '') }}">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Adresse</label>
                                <textarea
                                    name="address"
                                    rows="3"
                                    class="form-control"
                                >{{ old('address', $employee->address ?? '') }}</textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Ville</label>
                                <input type="text"
                                       name="city"
                                       class="form-control"
                                       value="{{ old('city', $employee->city ?? '') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Affectation --}}
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-success text-white fw-semibold">
                        Informations d'affectation
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Local d'affectation</label>
                                <select class="form-select" name="local_id">
                                    <option value="">Sélectionnez un local</option>
                                    @foreach($locals as $local)
                                        <option value="{{ $local->id }}"
                                            {{ old('local_id', $employee->local_id ?? '') == $local->id ? 'selected' : '' }}>
                                            {{ $local->title }} - {{ $local->city->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Date de recrutement</label>
                                <x-date-input id="hiring_date"
                                              name="hiring_date"
                                              value="{{ old('hiring_date', $employee->hiring_date ?? '') }}" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-4">

        <div class="d-flex justify-content-end gap-2">
            <button type="reset" class="btn btn-outline-secondary">
                <i class="bi bi-x-circle me-1"></i> Annuler
            </button>

            <button type="submit" class="btn btn-primary">
                @if(isset($employee))
                    <i class="bi bi-pencil-square me-1"></i> Mettre à jour
                @else
                    <i class="bi bi-save me-1"></i> Enregistrer
                @endif
            </button>
        </div>


    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input      = document.getElementById('photoInput');
            const preview    = document.getElementById('photoPreview');
            const placeholder = document.getElementById('photoPlaceholder');

            if (!input) return;

            input.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (!file) return;

                // On accepte seulement les images
                if (!file.type.startsWith('image/')) {
                    alert('Veuillez sélectionner une image (JPG ou PNG).');
                    input.value = '';
                    return;
                }

                const reader = new FileReader();

                reader.onload = function (event) {
                    preview.src = event.target.result;
                    preview.classList.remove('d-none');
                    placeholder.classList.add('d-none');
                };

                reader.readAsDataURL(file);
            });
        });
    </script>


</x-layout>
