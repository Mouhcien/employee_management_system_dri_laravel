<x-layout>
    <form action="{{ is_null($training) ? route('trainings.store') : route('trainings.update', $training->id) }}" method="POST">
        @csrf

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="bi {{ is_null($training) ? 'bi-plus-circle' : 'bi-pencil-square' }} me-2"></i>
                    {{ is_null($training) ? "Nouvelle Formation" : "Mise à jour de la formation" }}
                </h5>
            </div>

            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label fw-bold">Titre de la formation</label>
                        <input type="text" name="title" required value="{{ old('title', $training->title ?? '') }}"
                               class="form-control" placeholder="Ex: Développement Web">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Thème</label>
                        <textarea name="theme" class="form-control" rows="3" required placeholder="Description du thème...">{{ old('theme', $training->theme ?? '') }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Date de commencement</label>
                        <x-date-input id="starting_date" name="starting_date"
                                      value="{{ old('starting_date', $training->starting_date ?? '') }}" />
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Date de fin</label>
                        <x-date-input id="ending_date" name="end_date"
                                      value="{{ old('end_date', $training->end_date ?? '') }}" />
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold d-block">Localisation</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input location-radio" type="radio" name="local_type" id="marrakech" value="Marrakech"
                                {{ (old('local_type', $training->local ?? '') == 'Marrakech' || is_null($training)) ? 'checked' : '' }}>
                            <label class="form-check-label" for="marrakech">Marrakech</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input location-radio" type="radio" name="local_type" id="hors_marrakech" value="Hors Marrakech"
                                {{ (old('local_type', $training->local ?? '') != 'Marrakech' && !is_null($training)) ? 'checked' : '' }}>
                            <label class="form-check-label" for="hors_marrakech">Hors Marrakech</label>
                        </div>

                        <div id="extra-location" class="mt-3 {{ (old('local_type', $training->local ?? '') != 'Marrakech' && !is_null($training)) ? '' : 'd-none' }}">
                            <label class="form-label small text-muted">Précisez la ville ou le lieu :</label>
                            <input type="text" id="local_input" name="local" class="form-control"
                                   value="{{ old('local', $training->local ?? '') }}" placeholder="Ex: Casablanca">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer text-end bg-light">
                <button type="reset" class="btn btn-light border">Annuler</button>
                <button type="submit" class="btn btn-success px-4">
                    <i class="bi bi-save me-2"></i> {{ is_null($training) ? 'Enregistrer' : 'Mettre à jour' }}
                </button>
            </div>
        </div>
    </form>

    <script>
        document.querySelectorAll('.location-radio').forEach((radio) => {
            radio.addEventListener('change', function() {
                const extraLocationDiv = document.getElementById('extra-location');
                const localInput = document.getElementById('local_input');

                if (this.id === 'hors_marrakech') {
                    extraLocationDiv.classList.remove('d-none');
                    localInput.setAttribute('required', 'required');
                    localInput.focus();
                } else {
                    extraLocationDiv.classList.add('d-none');
                    localInput.removeAttribute('required');
                    localInput.value = 'Marrakech'; // Optionnel : réinitialise la valeur
                }
            });
        });
    </script>
</x-layout>
