<x-layout>
    @section('title', isset($employee) ? 'Modifier Employé' : 'Nouvel Employé')

    <form action="{{ isset($employee) ? route('employees.update', $employee->id) : route('employees.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Page Header --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="bg-primary bg-gradient p-4 text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-1">{{ isset($employee) ? 'Édition du Profil' : 'Nouvel Enregistrement' }}</h2>
                            <p class="opacity-75 mb-0 small">DRI-Marrakech | Gestion administrative du personnel</p>
                        </div>
                        <a href="{{ route('employees.index') }}" class="btn btn-white btn-rounded px-4 fw-bold">
                            <i class="bi bi-arrow-left me-2"></i>Retour
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Colonne Gauche : Formulaire Principal --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4 d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-2 me-3">
                            <i class="bi bi-person-badge fs-4"></i>
                        </div>
                        <h5 class="fw-bold mb-0 text-dark">Identité & État Civil</h5>
                    </div>

                    <div class="card-body p-4">
                        <div class="row g-3">
                            {{-- Identifiants --}}
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">Numéro PPR <span class="text-danger">*</span></label>
                                <input type="text" name="ppr" class="form-control bg-light border-0 shadow-none py-2" value="{{ old('ppr', $employee->ppr ?? '') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">N° CIN <span class="text-danger">*</span></label>
                                <input type="text" name="cin" class="form-control bg-light border-0 shadow-none py-2" value="{{ old('cin', $employee->cin ?? '') }}" required>
                            </div>

                            {{-- Bloc Noms Bilingues --}}
                            <div class="col-md-6 mt-4">
                                <label class="form-label small fw-bold text-muted text-uppercase">Nom (Fr)</label>
                                <input type="text" name="lastname" class="form-control border-0 bg-light shadow-none py-2" value="{{ old('lastname', $employee->lastname ?? '') }}">
                            </div>
                            <div class="col-md-6 mt-4">
                                <label class="form-label small fw-bold text-primary text-uppercase text-end d-block">الاسم العائلي</label>
                                <input type="text" name="lastname_arab" class="form-control border-0 bg-primary bg-opacity-10 shadow-none py-2 text-end fw-bold" dir="rtl" value="{{ old('lastname_arab', $employee->lastname_arab ?? '') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">Prénom (Fr)</label>
                                <input type="text" name="firstname" class="form-control border-0 bg-light shadow-none py-2" value="{{ old('firstname', $employee->firstname ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-primary text-uppercase text-end d-block">الاسم الشخصي</label>
                                <input type="text" name="firstname_arab" class="form-control border-0 bg-primary bg-opacity-10 shadow-none py-2 text-end fw-bold" dir="rtl" value="{{ old('firstname_arab', $employee->firstname_arab ?? '') }}">
                            </div>

                            {{-- Détails Civil --}}
                            <div class="col-md-6 mt-4">
                                <label class="form-label small fw-bold text-muted text-uppercase">Date de naissance</label>
                                <x-date-input id="birth_date" name="birth_date" value="{{ old('birth_date', $employee->birth_date ?? '') }}" />
                            </div>
                            <div class="col-md-6 mt-4">
                                <label class="form-label small fw-bold text-muted text-uppercase">Lieu de naissance</label>
                                <input type="text" name="birth_city" class="form-control border-0 bg-light shadow-none py-2" value="{{ old('birth_city', $employee->birth_city ?? '') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">Sexe</label>
                                <select class="form-select border-0 bg-light shadow-none py-2" name="gender">
                                    <option value="">Sélectionnez</option>
                                    <option value="M" {{ old('gender', $employee->gender ?? '') === 'M' ? 'selected' : '' }}>Homme</option>
                                    <option value="F" {{ old('gender', $employee->gender ?? '') === 'F' ? 'selected' : '' }}>Femme</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">Situation familiale</label>
                                <select class="form-select border-0 bg-light shadow-none py-2" name="family_status">
                                    <option value="">Sélectionnez</option>
                                    <option value="C" {{ old('family_status', $employee->family_status ?? '') === 'C' ? 'selected' : '' }}>Célibataire</option>
                                    <option value="M" {{ old('family_status', $employee->family_status ?? '') === 'M' ? 'selected' : '' }}>Marié(e)</option>
                                    <option value="D" {{ old('family_status', $employee->family_status ?? '') === 'D' ? 'selected' : '' }}>Divorcé(e)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Bloc Coordonnées --}}
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4 d-flex align-items-center">
                        <div class="bg-info bg-opacity-10 text-info rounded-3 p-2 me-3">
                            <i class="bi bi-geo-alt fs-4"></i>
                        </div>
                        <h5 class="fw-bold mb-0 text-dark">Coordonnées & Contact</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Téléphone</label>
                                <input type="tel" name="tel" class="form-control border-0 bg-light shadow-none" value="{{ old('tel', $employee->tel ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Email professionnel</label>
                                <input type="email" name="email" class="form-control border-0 bg-light shadow-none" value="{{ old('email', $employee->email ?? '') }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-muted">Adresse de résidence</label>
                                <textarea name="address" rows="2" class="form-control border-0 bg-light shadow-none">{{ old('address', $employee->address ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Colonne Droite : Photo & Affectation --}}
            <div class="col-lg-4">
                {{-- Card Photo --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                    <div class="card-header bg-white border-0 py-3 text-center">
                        <span class="fw-bold text-muted small text-uppercase ls-1">Photo de Profil</span>
                    </div>
                    <div class="card-body text-center py-4 bg-light bg-opacity-50">
                        <div class="position-relative d-inline-block mb-3">
                            <img id="photoPreview" src="{{ !empty($employee?->photo) ? $employee->photo : '' }}"
                                 class="rounded-circle shadow-sm border border-4 border-white {{ empty($employee?->photo) ? 'd-none' : '' }}"
                                 style="width: 160px; height: 160px; object-fit: cover;">

                            <div id="photoPlaceholder" class="rounded-circle bg-white shadow-xs d-flex align-items-center justify-content-center border border-dashed border-2 {{ !empty($employee?->photo) ? 'd-none' : '' }}"
                                 style="width: 160px; height: 160px;">
                                <i class="bi bi-camera fs-1 text-muted opacity-50"></i>
                            </div>
                        </div>

                        <div class="px-3">
                            <input type="file" id="photoInput" name="photo" class="form-control form-control-sm shadow-none" accept="image/*">
                            <p class="extra-small text-muted mt-2 mb-0">Recommandé : Format carré, PNG ou JPG (Max 2MB)</p>
                        </div>
                    </div>
                </div>

                {{-- Card Affectation --}}
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-success text-white py-3">
                        <h6 class="mb-0 fw-bold"><i class="bi bi-building me-2"></i>Affectation de site</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Site / Local</label>
                            <select class="form-select border-0 bg-light shadow-none" name="local_id">
                                <option value="">Choisir un local...</option>
                                @foreach($locals as $local)
                                    <option value="{{ $local->id }}" {{ old('local_id', $employee->local_id ?? '') == $local->id ? 'selected' : '' }}>
                                        {{ $local->title }} - {{ $local->city->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Catégorie</label>
                            <select class="form-select border-0 bg-light shadow-none py-2" name="category_id">
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $employee->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                    {{ $category->title }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-0">
                            <label class="form-label small fw-bold text-muted">Date de prise de service</label>
                            <x-date-input id="hiring_date" name="hiring_date" value="{{ old('hiring_date', $employee->hiring_date ?? '') }}" />
                        </div>
                    </div>
                </div>

                {{-- Boutons d'action rapides --}}
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill shadow-sm py-3 fw-bold transition-base">
                        <i class="bi {{ isset($employee) ? 'bi-pencil-square' : 'bi-check-circle' }} me-2"></i>
                        {{ isset($employee) ? 'Enregistrer les modifications' : 'Créer le profil' }}
                    </button>
                    <button type="reset" class="btn btn-outline-secondary w-100 border-0 rounded-pill mt-2">Réinitialiser</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('photoInput');
            const preview = document.getElementById('photoPreview');
            const placeholder = document.getElementById('photoPlaceholder');

            if (input) {
                input.addEventListener('change', function (e) {
                    const file = e.target.files[0];
                    if (file && file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = (event) => {
                            preview.src = event.target.result;
                            preview.classList.remove('d-none');
                            placeholder.classList.add('d-none');
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
    </script>

    <style>
        .btn-white { background: #fff; color: #4f46e5; border: none; }
        .btn-white:hover { background: #f8f9fa; color: #4338ca; }
        .transition-base { transition: all 0.2s ease-in-out; }
        .btn-rounded { border-radius: 50px; }
        .ls-1 { letter-spacing: 0.5px; }
        .extra-small { font-size: 0.7rem; }
        .shadow-xs { box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .form-control:focus, .form-select:focus { background-color: #fff !important; border: 1px solid #4f46e5 !important; }
    </style>
</x-layout>
