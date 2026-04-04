<x-layout>

    <style>
        .profile-header {
            background: linear-gradient(135deg, #0061f2 0%, #0a2351 100%);
            border-radius: 15px;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.15);
        }

        .ts-wrapper.form-control {
            padding: 0; /* Let Tom Select handle the padding */
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
        }

        .ts-dropdown .active {
            background-color: #cbffc0; /* Custom highlight color */
            color: white;
        }
        /* Ensures the container takes full width of the parent column */
         .ts-wrapper {
             width: 100% !important;
         }

        /* Makes the actual input field (and its placeholder) stretch across the bar */
        .ts-control input {
            width: 100% !important;
            display: block !important;
            min-width: 300px; /* Force a minimum width for the placeholder area */
        }

        /* Optional: Adjust font size and padding to make the placeholder feel "bigger" */
        .ts-control::placeholder {
            color: #999;
            font-size: 0.95rem;
        }

        /* Makes the text inside the input look lowercase */
        .ts-control, .ts-control input {
            text-transform: lowercase;
        }

        /* Makes the options in the dropdown look lowercase */
        .ts-dropdown .option {
            text-transform: lowercase;
        }
    </style>

    <div class="card profile-header mb-4 overflow-hidden">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-7 text-white">
                    @if (is_null($user))
                    <h2 class="fw-bold mb-1">Créer un nouveau utilisateur</h2>
                    @else
                        <h2 class="fw-bold mb-1">Modifier l'utilisateur {{ $user->name }}</h2>
                    @endif
                </div>
                <div class="col-md-5 text-md-end mt-3 mt-md-0">
                    <a href="{{ route('profiles.index') }}" class="btn btn-light btn-sm fw-bold px-3 py-2 shadow-sm">
                        <i class="bi bi-arrow-left me-2"></i>Retour
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card auth-card">
        <div class="card-body p-4 p-md-5">
            <form method="POST" action="{{ is_null($user) ? route('users.store') : route('users.update', $user) }}">
                @csrf

                <div class="row">
                    <div class="col-12 mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label small fw-bold text-uppercase text-muted mb-0">E-mail professionnel</label>
                        </div>
                        <select id="employee-select" name="email" class="form-control @error('email') is-invalid @enderror" required>
                            <option value="">Select or type an email...</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->email }}"
                                    {{ (old('email') == $employee->email || ($user && $user->email == $employee->email)) ? 'selected' : '' }}>
                                    {{ $employee->email }}
                                </option>
                            @endforeach
                        </select>

                        @error('email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label small fw-bold text-uppercase text-muted">Profil</label>
                        <select class="form-select @error('profile_id') is-invalid @enderror" name="profile_id" required>
                            <option value="" selected disabled>Choisir un profil...</option>
                            @foreach($profiles as $profile)
                                @if(is_null($user))
                                <option value="{{ $profile->id }}" {{ old('profile_id') == $profile->id ? 'selected' : '' }}>
                                    {{ $profile->title }}
                                </option>
                                @else
                                    <option value="{{ $profile->id }}" {{ $user->profile_id == $profile->id ? 'selected' : '' }}>
                                        {{ $profile->title }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        @error('profile_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold text-uppercase text-muted">Mot de passe</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••" {{ is_null($user) ? 'required' : '' }}>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label small fw-bold text-uppercase text-muted">Confirmer</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••" {{ is_null($user) ? 'required' : '' }}>
                    </div>
                </div>

                <hr class="my-4 text-muted opacity-25">

                <div class="row g-2">
                    <div class="col-sm-8">
                        @if (is_null($user))
                            <button type="submit" class="btn btn-primary w-100 shadow-sm">
                                Créer le compte
                            </button>
                        @else
                            <button type="submit" class="btn btn-warning w-100 shadow-sm">
                                Mettre à jour
                            </button>
                        @endif
                    </div>
                    <div class="col-sm-4">
                        <button type="reset" class="btn btn-outline-secondary w-100">
                            Annuler
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            new TomSelect("#employee-select", {
                plugins: ['remove_button'], // This adds the 'x' to clear the selection
                persist: false,
                create: false,
                maxItems: 1,
                placeholder: "Rechercher l'agent ...",
                controlInput: '<input />',
                onItemAdd: function(value) {
                    // If a user types/creates a new email, force it to lowercase
                    const lowerValue = value.toLowerCase();
                    if (value !== lowerValue) {
                        this.updateOption(value, {value: lowerValue, text: lowerValue});
                        this.setValue(lowerValue);
                    }
                },
                onInitialize: function() {
                    this.control_input.style.width = '100%';
                },
                render: {
                    option: function(data, escape) {
                        return `<div>
                            <span class="fw-bold text-dark ms-2"><i class="bi bi-at"></i>${escape(data.text).toLowerCase()}</span>
                        </div>`;
                    },
                    item: function(data, escape) {
                        return `<div>${escape(data.text).toLowerCase()}</div>`;
                    }
                },
                shouldSort: true
            });

        });
    </script>

</x-layout>
